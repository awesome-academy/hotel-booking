<?php

namespace App\Repositories\Room;

use App\Models\Room;
use App\Repositories\EloquentRepository;
use http\Env\Request;
use Carbon\Carbon;

class RoomRepository extends EloquentRepository
{
    public function getModel()
    {
        return Room::class;
    }

    public function getDataStore($request, $location_id)
    {
        $data = $request->all();
        $now = date('m/d/Y');
        $end_available = '12/31/2100';
        $available_rooms = explode(',', $data['list_room_number']);
        $now_to_end = Carbon::parse($now)->diff(Carbon::parse($end_available))->days;
        $available_arr = array(
            'check_in' => $now,
            'check_out' => $end_available,
            'length' => $now_to_end,
            'available_rooms' => $available_rooms,
        );
        $data['available_time'] = json_encode($available_arr, true);
        $dataRoom = array(
            'location_id' => $location_id,
            'price' => $data['price'],
            'sale_price' => $data['sale_price'],
            'sale_start_at' => $data['sale_start_at'],
            'sale_end_at' => $data['sale_end_at'],
            'list_room_number' => $data['list_room_number'],
            'available_time' => $data['available_time'],
            'rating' => 5,
        );

        return $dataRoom;
    }
}
