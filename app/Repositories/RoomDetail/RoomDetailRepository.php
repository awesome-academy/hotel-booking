<?php

namespace App\Repositories\RoomDetail;

use App\Models\RoomDetail;
use App\Repositories\EloquentRepository;

class RoomDetailRepository extends EloquentRepository
{
    public function getModel()
    {
        return RoomDetail::class;
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

    public function checkName($name, $lang_id)
    {
        $checkName = RoomDetail::where('lang_id', $lang_id)->where('name', $name)->first();
        if (is_null($checkName)) {
            return true;
        } else {
            return false;
        }
    }
}
