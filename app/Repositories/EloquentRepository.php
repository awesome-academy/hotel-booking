<?php

namespace App\Repositories;

abstract class EloquentRepository
{
    protected $_model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract function getModel();

    public function setModel()
    {
        $this->_model = app()->make($this->getModel());
    }

    public function all()
    {
        return $this->_model->orderBy('id', 'desc')->get();
    }

    public function getAllByLang($lang_id)
    {
        return $this->_model->where('lang_id', $lang_id)->get();
    }

    public function paginate($per_page)
    {
        return $this->_model->orderBy('id', 'desc')->paginate($per_page);
    }

    public function paginateByLang($lang_id, $per_page)
    {
        return $this->_model->where('lang_id', $lang_id)->orderBy('id', 'desc')->paginate($per_page);
    }

    public function search($column, $keyword, $per_page)
    {
        return $this->_model->where($column, 'LIKE', '%' . $keyword . '%')->orderBy('id', 'desc')->paginate($per_page);
    }

    public function searchByLang($column, $keyword, $per_page, $lang_id)
    {
        return $this->_model->where('lang_id', $lang_id)->where($column, 'LIKE', '%' . $keyword . '%')->orderBy('id', 'desc')->paginate($per_page);
    }

    public function find($id)
    {
        return $this->_model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->_model > $this->findOrFail($id);
    }

    public function first()
    {
        return $this->_model->first();
    }

    public function whereFirst($object, $column)
    {
        return $this->_model->where($object, '=', $column)->first();
    }

    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function whereDelete($column, $object)
    {
        $result = $this->_model->where($column, '=', $object)->get();
        foreach ($result as $item) {
            $item->delete();
        }
    }

    public function limit($limit)
    {
        return $this->_model->orderBy('id', 'desc')->limit($limit)->get();
    }

    public function whereall($column, $object)
    {
        return $this->_model->where($column, '=', $object)->orderBy('id', 'desc')->get();
    }
    
    public function wherewhere($column1, $object1, $column2, $object2)
    {
        return $this->_model->where($column1, '=', $object1)->where($column2, '=', $object2)->get();
    }

    public function pluck($colum, $object, $id)
    {
        return $this->_model->where($colum, '=', $object)->pluck($id)->toArray();
    }

    public function whereIn($colum, $object)
    {
        return $this->_model->whereIn($colum, $object);
    }

    public function lang_map($id)
    {
        $post = $this->_model->find($id);
        if(is_null($post)) {
            return response()->json(['error' => __('messages.Notfound')]);
        }
        $posts = $this->_model->where('lang_map', $post['lang_map'])->get();
        $array = explode(',', $post['lang_map']);
        $pos = array_search($post['id'], $array);
        unset($array[$pos]);
        $lang_map = implode(',', $array);
        foreach ($posts as $key => $value) {
            $this->_model->find($value['id'])->update(['lang_map' => $lang_map]);
        }
    }
    
    public function paginateByLangCate($lang_id, $per_page, $cate_id)
    {
        return $this->_model->where('lang_id', $lang_id)->where('cate_id', $cate_id)->orderBy('id', 'desc')->paginate($per_page);
    }

    public function limitByLang($lang_id, $limit)
    {
        return $this->_model->where('lang_id', $lang_id)->orderBy('id', 'desc')->limit($limit)->get();
    }
}
