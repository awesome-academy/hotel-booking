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

    public function paginate($per_page)
    {
        return $this->_model->orderBy('id', 'desc')->paginate($per_page);
    }

    public function search($column, $keyword, $per_page)
    {
        return $this->_model->where($column, 'LIKE', '%' . $keyword . '%')->orderBy('id', 'desc')->paginate($per_page);
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
}
