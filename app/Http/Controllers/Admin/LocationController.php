<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LocationRequest;
use App\Repositories\Location\LocationRepository;
use App\Repositories\Province\ProvinceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class LocationController extends Controller
{
    public function __construct(provinceRepository $provinceRepository, locationRepository $locationRepository)
    {
        $this->provinceRepository = $provinceRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['keyword'])) {
            $locations = $this->locationRepository->search('name', $_GET['keyword'], Config::get('paginate.default'));
        } else {
            $locations = $this->locationRepository->paginate(Config::get('paginate.default'));
        }
        $data = compact('locations');

        return view('admin.locations.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = $this->provinceRepository->all();
        $data = compact('provinces');

        return view('admin.locations.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationRequest $request)
    {
        $data = $request->all();
        $this->locationRepository->create($data);
        $request->session()->flash('store');

        return redirect(route('admin.locations.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(route('admin.locations.edit', $id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = $this->locationRepository->find($id);
        if (is_null($location)) {
            abort('404');
        }
        $provinces = $this->provinceRepository->all();
        $data = compact(
            'location',
            'provinces'
        );

        return view('admin.locations.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(LocationRequest $request, $id)
    {
        $data = $request->all();
        $this->locationRepository->update($id, $data);
        $request->session()->flash('update');

        return redirect(route('admin.locations.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->locationRepository->delete($id);
        $request->session()->flash('delete');

        return redirect(route('admin.locations.index'));
    }
}
