<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreRoomRequest;
use App\Http\Requests\Admin\TranslateRoomRequest;
use App\Http\Requests\Admin\UpdateRoomRequest;
use App\Models\Property;
use App\Models\Room;
use App\Models\RoomDetail;
use App\Repositories\Image\ImageRepository;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\Location\LocationRepository;
use App\Repositories\Property\PropertyRepository;
use App\Repositories\Room\RoomRepository;
use App\Repositories\RoomDetail\RoomDetailRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function __construct(RoomRepository $roomRepository, RoomDetailRepository $roomDetailRepository, LocationRepository $locationRepository, LanguageRepository $languageRepository)
    {
        $propertyRepository = new PropertyRepository();
        $imageRepository = new ImageRepository();
        $this->imageRepository = $imageRepository;
        $this->propertyRepository = $propertyRepository;
        $this->roomRepository = $roomRepository;
        $this->roomDetailRepository = $roomDetailRepository;
        $this->locationRepository = $locationRepository;
        $this->languageRepository = $languageRepository;
        $this->base_lang_id = $languageRepository->getBaseId();
    }

    public function index($location_id)
    {
        $single_room = new Room();
        $base_lang_id = $this->base_lang_id;
        $location = $this->locationRepository->find($location_id);
        if (is_null($location)) {
            abort('404');
        }
        $rooms = $location->rooms()->orderBy('id', 'desc')->paginate(Config::get('paginate.default'));
        $properties = $this->propertyRepository;
        $data = compact(
            'rooms',
            'location',
            'base_lang_id',
            'properties',
            'single_room'
        );

        return view('admin.rooms.index', $data);
    }

    public function create($location_id)
    {
        $location = $this->locationRepository->find($location_id);
        if (is_null($location)) {
            abort('404');
        }
        $properties = $this->propertyRepository->getAllByLang($this->base_lang_id);
        $data = compact(
            'location',
            'properties'
        );

        return view('admin.rooms.create', $data);
    }

    public function store($location_id, StoreRoomRequest $request)
    {
        $data = $request->all();
        $data['list_room_number'] = implode(',', $request->list_room_number);
        $data['base_id'] = $this->base_lang_id;
        $checkName = $this->roomDetailRepository->checkName($request->name, $location_id, $this->base_lang_id);
        if (!$checkName) {
            $request->session()->flash('name_used');

            return redirect()->back();
        }
        $checkListRoom = $this->roomRepository->checkListRoom($data['list_room_number'], $location_id);
        if (!$checkListRoom) {
            $request->session()->flash('room_number_used');

            return redirect()->back();
        }
        $dataRoom = $this->roomRepository->getDataStore($data, $location_id);
        $dataRoomDetail = $this->roomDetailRepository->getDataStore($data);
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $dataRoom['image'] = uploadImage(Config::get('upload.rooms'), $request->image);
            }
            if ($data['sale_price'] != null && $data['sale_start_at'] == null && $data['sale_end_at'] == null) {
                $dataRoom['sale_status'] = 1;
            }
            $room = $this->roomRepository->create($dataRoom);
            $dataRoomDetail['room_id'] = $room->id;
            $roomDetail = $this->roomDetailRepository->create($dataRoomDetail);
            $lang_map = array(
                'lang_map' => $roomDetail->id,
            );
            $this->roomDetailRepository->update($roomDetail->id, $lang_map);
            DB::commit();
            $request->session()->flash('notification', 'store');
            Session::put('locale', $this->base_lang_id);

            return redirect(route('admin.rooms.index', $location_id));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function edit($location_id, $id)
    {
        $location = $this->locationRepository->find($location_id);
        if (is_null($location)) {
            abort(404);
        }
        $roomDetail = $this->roomDetailRepository->find($id);
        if (is_null($roomDetail)) {
            abort(404);
        }
        $room = $this->roomRepository->find($roomDetail->room_id);
        if (is_null($room)) {
            abort(404);
        }
        if (Session::get('locale')) {
            $roomDetail = $room->roomDetails()->where('room_id', $room->id)->where('lang_id', \session('locale'))->first();
            if (!$roomDetail) {
                abort(404);
            }
        }
        $images = $this->imageRepository->getImageByRoom($room->id);
        $list_room_number = explode(',', $room->list_room_number);
        $data = compact(
            'location',
            'roomDetail',
            'room',
            'images',
            'list_room_number'
        );

        return view('admin.rooms.edit', $data);
    }

    public function update(UpdateRoomRequest $request, $location_id, $id)
    {
        $data = $request->all();
        $old_list_room = explode(',', $data['old_list_room_number']);
        $room = $this->roomRepository->find($data['room_id']);
        $checkName = $this->roomDetailRepository->checkNameUpdate($request->name, $location_id, $this->base_lang_id, $id);
        $status = 0;
        if (!isset($data['list_room_number'])) {
            $data['list_room_number'] = $old_list_room;
        } else {
            $new_list_room = $data['list_room_number'];
            $status = 1;
            $data['list_room_number'] = array_unique(array_merge($old_list_room, $data['list_room_number']));
        }
        $data['list_room_number'] = implode(',', $data['list_room_number']);
        $dataRoom = $this->roomRepository->getDataUpdate($data);
        $dataRoomDetail = $this->roomDetailRepository->getDataUpdate($data);
        if (!$checkName) {
            $request->session()->flash('name_used');

            return redirect()->back();
        }
        $checkListRoom = $this->roomRepository->checkListRoomUpdate($data['list_room_number'], $location_id, $id);
        if (!$checkListRoom) {
            $request->session()->flash('room_number_used');

            return redirect()->back();
        }
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $dataRoom['image'] = uploadImage(Config::get('upload.rooms'), $request->image);
            } else {
                $dataRoom['image'] = $data['old_image'];
            }
            if ($status == 1) {
                $this->roomRepository->updateRoomNumberAvailableTime($room, $new_list_room);
            }
            if ($data['sale_price'] != null && $data['sale_start_at'] == null && $data['sale_end_at'] == null) {
                $dataRoom['sale_status'] = 1;
            } else if($data['sale_price'] == null && $data['sale_start_at'] == null && $data['sale_end_at'] == null) {
                $dataRoom['sale_status'] = 0;
            }
            $this->roomRepository->update($data['room_id'], $dataRoom);
            $this->roomDetailRepository->update($id, $dataRoomDetail);
            DB::commit();
            $request->session()->flash('notification', 'update');

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function translate(Request $request, $location_id, $parent_id)
    {
        $location = $this->locationRepository->find($location_id);
        if (is_null($location)) {
            abort(404);
        }
        $parent = $this->roomDetailRepository->find($parent_id);
        if (is_null($parent)) {
            abort(404);
        }
        $room = $this->roomRepository->find($parent->room_id);
        if (is_null($room)) {
            abort(404);
        }
        $languages = $this->roomDetailRepository->getTranslateId($parent_id);
        if (count($languages) == 0) {
            $request->session()->flash('notification', 'full_lang');

            return redirect()->back();
        }
        $data = compact(
            'location',
            'parent',
            'room',
            'languages'
        );

        return view('admin.rooms.translate', $data);
    }

    public function translateStore(TranslateRoomRequest $request, $location_id)
    {
        $data = $request->all();
        $checkName = $this->roomDetailRepository->checkName($data['name'], $location_id, $data['lang_id']);
        if (!$checkName) {
            $request->session()->flash('name_used');

            return redirect()->back();
        }
        $lang_map_arr = $this->roomDetailRepository->getLangMap($data['lang_parent_id']);
        DB::beginTransaction();
        try {
            $new_room = $this->roomDetailRepository->create($data);
            array_push($lang_map_arr, $new_room->id);
            $this->roomDetailRepository->updateLangMap($data['lang_parent_id'], $lang_map_arr);
            DB::commit();
            $request->session()->flash('notification', 'store');
            Session::put('locale', $data['lang_id']);

            return redirect(route('admin.rooms.index', $location_id));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function showOriginal($location_id, $id)
    {
        Session::put('locale', $this->base_lang_id);

        return redirect(route('admin.rooms.edit', [$location_id, $id]));
    }

    public function delete(Request $request, $location_id, $id)
    {
        $delete = $this->roomDetailRepository->delete($id);
        if ($delete) {
            $request->session()->flash('notification', 'delete');
        } else {
            $request->session()->flash('notification', 'errors-delete');
        }

        return redirect(route('admin.rooms.index', $location_id));
    }

    public function addProperties(Request $request)
    {
        $data = $request->all();
        $room = $this->roomRepository->find($data['room_id']);
        $property = $this->propertyRepository->find($data['id']);
        if (is_null($room) || is_null($property)) {
            return response()->json(['messages' => 'errors'], 200);
        }
        $data['property_name'] = $property->name;
        $room->properties()->attach($data['id']);

        return response()->json(['messages' => 'success', 'data' => $data], 200);
    }

    public function deleteProperties(Request $request)
    {
        $data = $request->all();
        $room = $this->roomRepository->find($data['room_id']);
        $property = $this->propertyRepository->find($data['id']);
        if (is_null($room) || is_null($property)) {
            return response()->json(['messages' => 'errors'], 200);
        }
        $data['property_name'] = $property->name;
        $room->properties()->detach($data['id']);

        return response()->json(['messages' => 'success', 'data' => $data], 200);
    }

    public function uploadImage(Request $request, $id)
    {
        $this->imageRepository->uploadImage($request, $id);
        $request->session()->flash('image_active');
    }

    public function destroyImage(Request $request)
    {
        $this->imageRepository->destroyImage($request);
        $request->session()->flash('image_active');
    }

    public function deleteImage(Request $request, $id)
    {
        $this->imageRepository->deleteImage($id);
        $request->session()->flash('image_active');

        return redirect()->back();
    }

    public function deleteRoomNumber(Request $request)
    {
        $data = $request->all();
        $room = $this->roomRepository->find($data['room_id']);
        if (is_null($room)) {
            return response()->json(['messages' => 'errors', 'data' => __('messages.room_not_found')], 200);
        }
        $list_room_number = explode(',', $room->list_room_number);
        $key = array_search($data['room_number'], $list_room_number);
        $check = $this->roomRepository->checkRoomNumberInvoice($data['room_id'], $data['room_number']);
        if ($check) {
            unset($list_room_number[$key]);
            if ($list_room_number == null) {
                return response()->json(['messages' => 'errors_null', 'data' => __('messages.room_number_errors_null')], 200);
            }
            $list_room_number = implode(',', $list_room_number);
            $dataUpdate = array('list_room_number' => $list_room_number);
            $this->roomRepository->deleteRoomNumberFromAvailableTime($room, $data['room_number']);
            $this->roomRepository->update($data['room_id'], $dataUpdate);

            return response()->json(['messages' => 'success'], 200);
        } else {
            return response()->json(['messages' => 'errors_invoice', 'data' => __('messages.room_number_in_invoice')], 200);
        }
    }
}
