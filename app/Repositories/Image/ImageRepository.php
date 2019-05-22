<?php

namespace App\Repositories\Image;

use App\Models\Image;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Config;

class ImageRepository extends EloquentRepository
{
    public function getModel()
    {
        return Image::class;
    }

    public function uploadImage($request, $id)
    {
        $image = $request->file('file');
        $imageName = uploadImageDrop(Config::get('upload.images'), $image);
        $data['room_id'] = $id;
        $data['name'] = $imageName;
        $this->_model->create($data);

        $request->session()->flash('image_active');

        return response()->json(['success' => $imageName]);
    }

    public function destroyImage($request)
    {
        $filename = $request->get('filename');
        $this->_model->where('name', $filename)->delete();
        $path = Config::get('upload.images') . '/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function getImageByRoom($room_id)
    {
        return $this->_model->where('room_id', $room_id)->orderBy('id', 'desc')->get();
    }

    public function deleteImage($id)
    {
        $name = $this->_model->find($id)->name;
        $this->_model->where('id', $id)->delete();
        $path = Config::get('upload.images') . '/' . $name;
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
