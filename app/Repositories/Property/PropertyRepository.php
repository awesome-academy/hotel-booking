<?php

namespace App\Repositories\Property;

use App\Models\Language;
use App\Models\Property;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PropertyRepository extends EloquentRepository
{
    public function getModel()
    {
        return Property::class;
    }

    public function getNotUse($arr_id, $lang_id)
    {
        return $this->_model->whereNotIn('id', $arr_id)->where('lang_id', $lang_id)->get();
    }

    public function getLanguage($lang_parent_id)
    {
        $vi = Language::where('name', Config::get('language.name'))->where('short', Config::get('language.short'))->first()->id;
        $translated = $this->_model->where('lang_parent_id', $lang_parent_id)->pluck('lang_id')->toArray();
        array_push($translated, $vi);
        $languages = Language::whereNotIn('id', $translated)->get();

        return $languages;
    }

    public function getLangMap($id)
    {
        $property = $this->_model->find($id);
        if (is_null($property)) {
            return false;
        }
        $lang_map = explode(',', $property->lang_map);

        return $lang_map;
    }

    public function updateLangMap($id, $lang_map_arr)
    {
        $lang_map = implode(',', $lang_map_arr);
        $parent_property = $this->_model->find($id);
        if (is_null($parent_property)) {
            return false;
        }
        $child_properties = $this->_model->where('lang_parent_id', $id)->get();
        DB::beginTransaction();
        try {
            $parent_property->lang_map = $lang_map;
            $parent_property->save();
            if (count($child_properties) > 0) {
                foreach ($child_properties as $child_property) {
                    $child_property->lang_map = $lang_map;
                    $child_property->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteProperty($id)
    {
        $property = $this->_model->find($id);
        if (is_null($property)) {
            return false;
        }
        $lang_map = $this->getLangMap($id);
        $key = array_search($id, $lang_map);
        unset($lang_map[$key]);
        DB::beginTransaction();
        try {
            if ($property->lang_parent_id != 0) {
                $this->updateLangMap($property->lang_parent_id, $lang_map);
            } else {
                $this->_model->where('lang_parent_id', $id)->delete();
            }
            $property->rooms()->detach($this->getRoomId($id));
            $this->delete($id);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function getRoomId($id)
    {
        $property = $this->_model->find($id);
        if (is_null($property)) {
            return false;
        }
        $room_id = $property->rooms()->pluck('rooms.id')->toArray();

        return $room_id;
    }
}
