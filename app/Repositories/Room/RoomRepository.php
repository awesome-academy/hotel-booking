<?php

namespace App\Repositories\Room;

use App\Models\Invoice;
use App\Models\Location;
use App\Models\Room;
use App\Models\RoomDetail;
use App\Repositories\EloquentRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function updateRating($rating, $id)
    {
        $room = $this->_model->find($id);
        if (is_null($room)) {
            return false;
        }
        $old_rating = $room->rating;
        $total_rating = $rating + $old_rating;
        $new_rating = roundRating($total_rating);
        $data = ['rating' => $new_rating];
        $room->update($data);
    }

    public function roomAvailable($check_in, $check_out, $location)
    {
        $check_in_day = Carbon::parse($check_in);
        $check_out_day = Carbon::parse($check_out);
        $location = Location::find($location);
        if (is_null($location)) {
            return false;
        }
        $rooms = $location->rooms()->get();
        foreach ($rooms as $room) {
            if ($room->available_time != null) {
                $available_times = json_decode($room->available_time, true);
                foreach ($available_times as $available_time) {
                    $check_in_available = Carbon::parse($available_time['check_in']);
                    $check_out_available = Carbon::parse($available_time['check_out']);
                    $between_checkin = $check_in_available->diff($check_in_day);
                    $between_checkin_checkout = $check_in_day->diff($check_out_day);
                    $between_checkout = $check_out_day->diff($check_out_available);
                    if ($between_checkin->invert == 0 && $between_checkin_checkout->days <= $available_time['length'] && $between_checkout->invert == 0) {
                        if (isset($available_rooms)) {
                            $arr_push = array(
                                'room_id' => $room->id,
                                'room_number' => $available_time['available_rooms'],
                            );
                            array_push($available_rooms, $arr_push);
                        } else {
                            $available_rooms = [];
                            $available_rooms = array(
                                array(
                                    'room_id' => $room->id,
                                    'room_number' => $available_time['available_rooms'],
                                ),
                            );
                        };
                    }
                }
            };
        }
        if (!isset($available_rooms)) {
            return false;
        }
        $rooms_id = [];
        $i = 0;
        foreach ($available_rooms as $available_room) {
            $rooms_id[$i] = $available_room['room_id'];
            $i++;
        }
        $rooms_id = array_unique($rooms_id);
        $result = array(
            'available_rooms' => $available_rooms,
            'room_id' => $rooms_id,
            'location_id' => $location->id,
        );

        return $result;
    }

    public function filter($data)
    {
        $paginate = $this->_model->whereIn('id', $data['room_id'])->orderBy('id', 'desc')->paginate(config('pagination.default'));
        $roomsPaginate = collect($paginate->items());
        $url = route('client.rooms.index') . '?check_in=' . $_GET['check_in'] . '&check_out=' . $_GET['check_out'] . '&location=' . $_GET['location'];
        $rooms = new LengthAwarePaginator(
            $roomsPaginate,
            $paginate->total(),
            $paginate->perPage(),
            $paginate->currentPage(),
            ['path' => $url]);

        return $rooms;
    }

    public function updateAvailableTime($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        if (is_null($invoice)) {
            return false;
        } else {
            $room = $invoice->rooms()->first();
            $pivot = $room->pivot;
            $check_in = Carbon::parse($pivot->check_in_date);
            $check_out = Carbon::parse($pivot->check_out_date);
            $length = $check_in->diff($check_out)->days;
            $room_number = $pivot->room_number;
            $arr = array(
                'check_in' => $pivot->check_in_date,
                'check_out' => $pivot->check_out_date,
                'length' => $length,
                'available_rooms' => array($room_number),
            );
            $available_times = json_decode($room->available_time, true);
            array_push($available_times, $arr);
            $data = array(
                'available_time' => json_encode($available_times, true),
            );
            $room->update($data);
            $room->save();
        }
    }
}
