<?php

namespace App\Repositories\RoomDetail;

use App\Models\Language;
use App\Models\Location;
use App\Models\Room;
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
        $roomDetail = $this->_model->where('lang_id', $lang_id)->where('lang_parent_id', $lang_parent_id)->first();
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
        $room_id = $location->rooms()->pluck('id');
        if (count($room_id) > 0) {
            $checkName = $this->_model->whereIn('room_id', $room_id)->where('lang_id', $lang_id)->where('name', $name)->get();
            if (count($checkName) == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function checkNameUpdate($name, $location_id, $lang_id, $id)
    {
        $location = Location::find($location_id);
        if (is_null($location)) {
            return false;
        }
        $room_id = $location->rooms()->pluck('id');
        if (count($room_id) > 0) {
            $checkName = $this->_model->whereIn('room_id', $room_id)->where('lang_id', $lang_id)->where('name', $name)->whereNotIn('id', [$id])->get();
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
        $translated = $this->_model->where('lang_parent_id', $parent_id)->pluck('lang_id')->toArray();
        array_push($translated, $vi);
        $needTranslate = Language::whereNotIn('id', $translated)->get();

        return $needTranslate;
    }

    public function getLangMap($id)
    {
        $room = $this->_model->find($id);
        if (is_null($room)) {
            return false;
        }
        $lang_map = explode(',', $room->lang_map);

        return $lang_map;
    }

    public function updateLangMap($id, $lang_map_arr)
    {
        $lang_map = implode(',', $lang_map_arr);
        $parent_room = $this->_model->find($id);
        if (is_null($parent_room)) {
            return false;
        }
        $child_rooms = $this->_model->where('lang_parent_id', $id)->get();
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

    public function checkOriginal($id)
    {
        $room = $this->_model->find($id);
        if (is_null($room)) {
            return false;
        }
        if ($room->lang_parent_id == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $checkOriginal = $this->checkOriginal($id);
        $roomDetail = $this->_model->find($id);
        if (is_null($roomDetail)) {
            return false;
        }
        $room_id = $roomDetail->room_id;
        $lang_map = explode(',', $roomDetail->lang_map);
        $key = array_search($id, $lang_map);
        unset($lang_map[$key]);
        if ($checkOriginal) {
            $room = Room::find($room_id);
            if (is_null($room)) {
                return false;
            }
            $properties_id = $this->getRoomPropertiesId($room->id);
            DB::beginTransaction();
            try {
                $room->roomDetails()->delete();
                $room->properties()->detach($properties_id);
                $room->delete();
                DB::commit();

                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                throw new \Exception($e->getMessage());
            }
        } else {
            $room = $this->_model->find($id);
            if (is_null($room)) {
                return false;
            }
            $this->updateLangMap($roomDetail->lang_parent_id, $lang_map);
            $room->delete();

            return true;
        }
    }

    public function getRoomPropertiesId($room_id)
    {
        $room = Room::find($room_id);
        $properties_id = $room->properties()->pluck('properties.id')->toArray();

        return $properties_id;
    }
}
