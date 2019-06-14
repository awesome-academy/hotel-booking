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
use App\Notifications\ContactNotification;
use App\Repositories\User\UserRepository;

class ContactController extends Controller
{
    public function __construct(LocationRepository $loRepo, ProvinceRepository $proRepo, ContactRepository $contactRepo, UserRepository $userRepo)
    {
        $this->loRepo = $loRepo;
        $this->proRepo = $proRepo;
        $this->contactRepo = $contactRepo;
        $this->userRepo = $userRepo;
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
        if ($input['user_id'] == 'undefined') {
            $input['user_id'] = 0;
        }
        $contact_send = $this->contactRepo->create($input);
        $user = $this->userRepo->userNotifi($input['user_id']);
        \Notification::send($user, new ContactNotification($contact_send));

        return response()->json(['success' => __('messages.Successfully'), 'error' => false]);
    }
}
