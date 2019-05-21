<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreRoomRequest;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\Location\LocationRepository;
use App\Repositories\Room\RoomRepository;
use App\Repositories\RoomDetail\RoomDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class RoomController extends Controller
{
    public function __construct(RoomRepository $roomRepository, RoomDetailRepository $roomDetailRepository, LocationRepository $locationRepository, LanguageRepository $languageRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->roomDetailRepository = $roomDetailRepository;
        $this->locationRepository = $locationRepository;
        $this->languageRepository = $languageRepository;
        $this->base_lang_id = $languageRepository->getBaseId();
    }

    public function index($location_id)
    {
        $location = $this->locationRepository->find($location_id);
        if (is_null($location)) {
            abort('404');
        }
        $rooms = $location->rooms()->orderBy('id', 'desc')->paginate(Config::get('paginate.default'));
        $data = compact(
            'rooms',
            'location',
            'base_lang_id'
        );

        return view('admin.rooms.index', $data);
    }

    public function create($location_id)
    {
        $location = $this->locationRepository->find($location_id);
        if (is_null($location)) {
            abort('404');
        }
        $data = compact(
            'location'
        );

        return view('admin.rooms.create', $data);
    }

    public function store($location_id, StoreRoomRequest $request)
    {
        $data = $request->all();
        $data['base_id'] = $this->base_lang_id;
        $checkName = $this->roomDetailRepository->checkName($request->name, $this->base_lang_id);
        if (!$checkName) {
            $request->session()->flash('name_used');

            return redirect()->back();

        }
        $dataRoom = $this->roomRepository->getDataStore($data, $location_id);
        $dataRoomDetail = $this->roomDetailRepository->getDataStore($data);
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $dataRoom['image'] = uploadImage(Config::get('upload.rooms'), $request->image);
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
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
            $request->session()->flash('errors');
        }

        return redirect(route('admin.rooms.index', $location_id));
    }

    public function edit($location_id, $room_id)
    {
        $location = $this->locationRepository->find($location_id);
        $room = $location->rooms()->findOrFail($room_id);
        if (session('locale')) {
            $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
        } else {
            $roomDetail = $room->roomDetails()->where('lang_id', $this->base_lang_id)->first();
        }
        if (is_null($roomDetail)) {
            abort(404);
        }
        $data = compact(
            'location',
            'roomDetail',
            'room'
        );

        return view('admin.rooms.edit', $data);
    }

    public function update(Request $request)
    {
    }
}
