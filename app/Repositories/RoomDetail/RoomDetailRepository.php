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

    public function getDataStore($request)
    {
        $data = $request->all();
        $dataRoomDetail = array(
            'name' => $data['name'],
            'short_description' => $data['short_description'],
            'description' => $data['description'],
            'lang_id' => 1,
            'lang_parent_id' => 0,
            'lang_map' => '1',
        );

        return $dataRoomDetail;
    }
}
