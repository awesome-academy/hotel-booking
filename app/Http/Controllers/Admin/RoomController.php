<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreRoomRequest;
use App\Repositories\Location\LocationRepository;
use App\Repositories\Room\RoomRepository;
use App\Repositories\RoomDetail\RoomDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class RoomController extends Controller
{
    public function __construct(RoomRepository $roomRepository, RoomDetailRepository $roomDetailRepository, LocationRepository $locationRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->roomDetailRepository = $roomDetailRepository;
        $this->locationRepository = $locationRepository;
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
            'location'
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
        $dataRoom = $this->roomRepository->getDataStore($request, $location_id);
        $dataRoomDetail = $this->roomDetailRepository->getDataStore($request);
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $dataRoom['image'] = uploadImage(Config::get('upload.default'), $request->image);
            }
            $room = $this->roomRepository->create($dataRoom);
            $dataRoomDetail['room_id'] = $room->id;
            $roomDetail = $this->roomDetailRepository->create($dataRoomDetail);
            $lang_map = array(
                'lang_map' => $roomDetail->id,
            );
            $this->roomDetailRepository->update($roomDetail->id, $lang_map);
            DB::commit();
            $request->session()->flash('store');
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
        $room = $location->rooms()->find($room_id);
        if (session('locale')) {
            $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
        } else {
            $roomDetail = $room->roomDetails()->where('lang_id', 1)->first();
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
