<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Repositories\Location\LocationRepository;
use App\Repositories\Province\ProvinceRepository;
use App\Repositories\Contact\ContactRepository;
use Yajra\Datatables\Datatables;

class ContactController extends Controller
{
	public function __construct(LocationRepository $locaRepository, ProvinceRepository $provinceRepository, ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
        $this->locaRepository = $locaRepository;
        $this->provinceRepository = $provinceRepository;
    }

    public function index()
    {
    	return view('admin.contact.contact');
    }

    public function anyway()
    {
    	$contacts = $this->contactRepository->all();
    	foreach ($contacts as $key => $value) {
    		$location = $this->locaRepository->find($value['location_id']);
            if (is_null($location)) {
                abort('404');
            }
            $contacts[$key]['loca_name'] = $location['name'];
    		$contacts[$key]['province_name'] = $location->province()->first()['name'];
    	}

    	return Datatables::of($contacts)
    	->addColumn('action', function($contact) {
 
            return '<button class="btn btn-sm btn-danger" contact_id="' . $contact->id . '" data-toggle="modal" id="deleteContact"><i class="far fa-trash-alt"></i></button>';
        })
        ->rawColumns(['action'])
        ->toJson();
    }

    public function delete($id)
    {
    	$this->contactRepository->delete($id);
    }
}
