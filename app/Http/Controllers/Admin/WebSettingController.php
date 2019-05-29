<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\WebSettingRequest;
use App\Repositories\WebSetting\WebSettingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebSettingController extends Controller
{
    public function __construct(WebSettingRepository $webSettingRepository)
    {
        $this->webSettingRepository = $webSettingRepository;
    }

    public function index()
    {
        $web = $this->webSettingRepository->getData();
        $data = compact(
            'web'
        );

        return view('admin.webSetting.index', $data);
    }

    public function update(WebSettingRequest $request, $id)
    {
        $data = $request->all();
        if ($request->hasFile('logo')) {
            $data['logo'] = uploadImage(config('upload.logo'), $request->logo);
        } else {
            $data['logo'] = $request->old_logo;
        }
        $this->webSettingRepository->update($id, $data);
        $request->session()->flash('notification', 'update');

        return redirect(route('admin.web-setting.index'));
    }
}
