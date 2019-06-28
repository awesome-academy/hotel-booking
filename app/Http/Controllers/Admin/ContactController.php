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
        $contacts = auth()->user()->notifications;
        foreach ($contacts as $key => $value) {
            $location = $this->locaRepository->find($value['data']['contact']['location_id']);
            if (is_null($location)) {
                abort('404');
            }
            $contacts[$key]['loca_name'] = $location['name'];
            $contacts[$key]['province_name'] = $location->province()->first()['name'];
        }

        return Datatables::of($contacts)
        ->addColumn('action', function($contact) {
            return '<button class="btn btn-sm btn-success" noti_id="' . $contact['id'] . '" data-toggle="modal" id="showContact" data-target="#ShowContact"><i class="far fa-eye"></i></button> <button class="btn btn-sm btn-danger" contact_id="' . $contact['data']['contact']['id'] . '" data-toggle="modal" id="deleteContact" noti_id="' . $contact['id'] . '"><i class="far fa-trash-alt"></i></button>';
        })
        ->editColumn('subject', function($contact) {

            return '<p class="truncate1">' . $contact['data']['contact']['subject'] . '</p>';
        })
        ->editColumn('id', function($contact) {
            if ($contact['read_at'] == null) {
                return '<span class="noti-unread"></span><p>' . $contact['data']['contact']['id'] . '</p>';
            } else {
                return '<p>' . $contact['data']['contact']['id'] . '</p>';
            }
        })
        ->editColumn('email', function($contact) {

            return '<a href="mailto:' . $contact['data']['contact']['email'] . '" >' . $contact['data']['contact']['email'] . '</a>';
        })
        ->rawColumns(['action', 'subject', 'read_at', 'id', 'email'])
        ->toJson();
    }

    public function delete(Request $request, $id)
    {   
        $this->contactRepository->delete($id);
        auth()->user()->notifications->find($request->noti_id)->delete();

        return count(auth()->user()->unreadNotifications);
    }

    public function notification()
    {
        return auth()->user()->unreadNotifications;
    }

    public function show($id)
    {
        $noti = auth()->user()->notifications->find($id);
        $noti->markAsRead();

        return response()->json(['noti' => $noti['data']['contact']]);
    }
}
