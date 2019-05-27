<?php

namespace App\Repositories\Room;

use App\Models\Location;
use App\Models\Room;
use App\Models\RoomDetail;
use App\Repositories\EloquentRepository;
use http\Env\Request;
use Carbon\Carbon;

class RoomRepository extends EloquentRepository
{
    public function getModel()
    {
        return Room::class;
    }

    public function getDataStore($data, $location_id)
    {
        $now = date('m/d/Y');
        $end_available = '12/31/2100';
        $available_rooms = explode(',', $data['list_room_number']);
        $now_to_end = Carbon::parse($now)->diff(Carbon::parse($end_available))->days;
        $available_arr = array(
            '0' => [
                'check_in' => $now,
                'check_out' => $end_available,
                'length' => $now_to_end,
                'available_rooms' => $available_rooms,

            ]);
        $data['available_time'] = json_encode($available_arr, true);
        $dataRoom = array(
            'location_id' => $location_id,
            'sale_start_at' => $data['sale_start_at'],
            'sale_end_at' => $data['sale_end_at'],
            'list_room_number' => $data['list_room_number'],
            'available_time' => $data['available_time'],
            'rating' => 5,
        );

        return $dataRoom;
    }

    public function getDataUpdate($data)
    {
        $dataRoom = array(
            'sale_start_at' => $data['sale_start_at'],
            'sale_end_at' => $data['sale_end_at'],
            'list_room_number' => $data['list_room_number'],
        );

        return $dataRoom;
    }

    public function checkListRoom($list_room, $location_id)
    {
        $list_room = explode(',', $list_room);
        $location = Location::find($location_id);
        if (is_null($location)) {
            return false;
        }
        $check = [];
        $rooms = $location->rooms()->get();
        foreach ($rooms as $key => $room) {
            $same = array_intersect($list_room, explode(',', $room->list_room_number));
            if (count($same) > 0) {
                $check = $same;
            }
        }
        if (count($check) == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkListRoomUpdate($list_room, $location_id, $id)
    {
        $list_room = explode(',', $list_room);
        $location = Location::find($location_id);
        if (is_null($location)) {
            return false;
        }
        $roomDetail = RoomDetail::find($id);
        if (is_null($roomDetail)) {
            return false;
        }
        $room = $roomDetail->room()->first();
        if (is_null($room)) {
            return false;
        }
        $rooms = $location->rooms()->whereNotIn('id', [$room->id])->get();
        $check = [];
        if (count($rooms) == 0) {
            return true;
        } else {
            foreach ($rooms as $room) {
                $same = array_intersect($list_room, explode(',', $room->list_room_number));
                if (count($same) > 0) {
                    $check = $same;
                }
            }
        }
        if (count($check) == 0) {
            return true;
        } else {
            return false;
        }
    }
}
