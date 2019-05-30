<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Repositories\Location\LocationRepository;
use App\Repositories\Province\ProvinceRepository;
use Mail;
use App\Repositories\Contact\ContactRepository;
use App\Http\Requests\Client\StoreContact;

class ContactController extends Controller
{
    public function __construct(LocationRepository $loRepo, ProvinceRepository $proRepo, ContactRepository $contactRepo)
    {
        $this->loRepo = $loRepo;
        $this->proRepo = $proRepo;
        $this->contactRepo = $contactRepo;
    }

    public function index($loca_id)
    {
        $location = $this->loRepo->find($loca_id);
        if (is_null($location)) {
        	abort('404');
        }

        return view('client.contact.contact', compact('location'));
    }

    public function send(StoreContact $request)
    {
    	$input = $request->all();
        $contact_send = $this->contactRepo->create($input);

        return response()->json(['success' => __('messages.Successfully'), 'error' => false]);
    }
}
