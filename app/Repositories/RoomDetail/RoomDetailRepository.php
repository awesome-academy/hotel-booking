<?php

namespace App\Repositories\RoomDetail;

use App\Models\Language;
use App\Models\Location;
use App\Models\RoomDetail;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class RoomDetailRepository extends EloquentRepository
{
    public function getModel()
    {
        return RoomDetail::class;
    }

    public function getByLang($lang_parent_id, $lang_id)
    {
        $roomDetail = RoomDetail::where('lang_id', $lang_id)->where('lang_parent_id', $lang_parent_id)->first();
        if (is_null($roomDetail)) {
            return false;
        }

        return $roomDetail;
    }

    public function getDataStore($data)
    {
        $dataRoomDetail = array(
            'name' => $data['name'],
            'price' => $data['price'],
            'sale_price' => $data['sale_price'],
            'short_description' => $data['short_description'],
            'description' => $data['description'],
            'lang_id' => $data['base_id'],
            'lang_parent_id' => 0,
        );

        return $dataRoomDetail;
    }

    public function getDataUpdate($data)
    {
        $dataRoomDetail = array(
            'name' => $data['name'],
            'price' => $data['price'],
            'sale_price' => $data['sale_price'],
            'short_description' => $data['short_description'],
            'description' => $data['description'],
        );

        return $dataRoomDetail;
    }

    public function checkName($name, $location_id, $lang_id)
    {
        $location = Location::find($location_id);
        if (is_null($location)) {
            return false;
        }
        $rooms = $location->rooms()->get();
        $room_id = [];
        $i = 0;
        if (count($rooms) > 0) {
            foreach ($rooms as $room) {
                $room_id[$i] = $room->id;
                $i++;
            }
            $checkName = RoomDetail::whereIn('room_id', $room_id)->where('lang_id', $lang_id)->where('name', $name)->get();
            if (count($checkName) == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function getTranslateId($parent_id)
    {
        $vi = Language::where('name', Config::get('language.name'))->where('short', Config::get('language.short'))->first()->id;
        $rooms = RoomDetail::where('lang_parent_id', $parent_id)->get();
        $translated[0] = $vi;
        $i = 1;
        if (count($rooms) > 0) {
            foreach ($rooms as $room) {
                $translated[$i] = $room->lang_id;
                $i++;
            }
        }
        $needTranslate = Language::whereNotIn('id', $translated)->get();

        return $needTranslate;
    }

    public function getLangMap($id)
    {
        $room = RoomDetail::find($id);
        if (is_null($room)) {
            return false;
        }
        $lang_map = explode(',', $room->lang_map);

        return $lang_map;
    }

    public function updateLangMap($id, $lang_map_arr)
    {
        $lang_map = implode(',', $lang_map_arr);
        $parent_room = RoomDetail::find($id);
        if (is_null($parent_room)) {
            return false;
        }
        $child_rooms = RoomDetail::where('lang_parent_id', $id)->get();
        DB::beginTransaction();
        try {
            $parent_room->lang_map = $lang_map;
            $parent_room->save();
            if (count($child_rooms) > 0) {
                foreach ($child_rooms as $child_room) {
                    $child_room->lang_map = $lang_map;
                    $child_room->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

        return true;
    }
}
