<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Client\BookingRequest;
use App\Models\Room;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\Location\LocationRepository;
use App\Repositories\Room\RoomRepository;
use App\Repositories\RoomDetail\RoomDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function __construct()
    {
        $roomRepository = new RoomRepository();
        $roomDetailRepository = new RoomDetailRepository();
        $locationRepository = new LocationRepository();
        $languageRepository = new LanguageRepository();
        $invoiceRepository = new InvoiceRepository();
        $this->invoiceRepository = $invoiceRepository;
        $this->roomRepository = $roomRepository;
        $this->roomDetailRepository = $roomDetailRepository;
        $this->locationRepostiory = $locationRepository;
        $this->languageRepository = $languageRepository;
        $this->baseLangId = $this->languageRepository->getBaseId();
    }

    public function index(Request $request)
    {
        if (!session('booking')) {
            return redirect(route('client.index'));
        }
        $info = session('booking');
        $room = $this->roomRepository->find($info['room_id']);
        if (is_null($room)) {
            $request->session()->flash('notification', 'no_room_found');

            return redirect(route('client.index'));
        }
        $location = $this->locationRepostiory->find($room->location_id);
        if (session('locale')) {
            $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
            if (is_null($roomDetail)) {
                $roomDetail = $room->roomDetails()->where('lang_id', $this->baseLangId)->first();
            }
        } else {
            $roomDetail = $room->roomDetails()->where('lang_id', $this->baseLangId)->first();
        }
        $data = compact(
            'room',
            'roomDetail',
            'info',
            'location'
        );

        return view('client.booking.index', $data);
    }

    public function submit(Request $request)
    {
        if (session('booking')) {
            $request->session()->forget('booking');
        }
        $data = $request->all();
        $request->session()->put('booking', $data);

        return redirect(route('client.booking.index'));
    }

    public function detailBooking(Request $request)
    {
        if (session('booking')) {
            $request->session()->forget('booking');
        }
        $data = $request->all();
        $check = $this->roomRepository->roomDetailAvailable($data['check_in'], $data['check_out'], $data['room_id']);
        $rules = [
            'check_in' => 'required',
            'check_out' => 'required',
        ];
        $messages = [
            'check_in.required' => __('messages.Require_check_in'),
            'check_out.required' => __('messages.Require_check_out'),
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $data_response = [
                'messages' => 'validation_fails',
                'data' => $validator->messages(),
            ];
        } else {
            if (!$check) {
                $data_response = [
                    'messages' => 'no_available_room',
                ];
            } else {
                $request->session()->put('booking', $data);
                $data_response = [
                    'messages' => 'success',
                    'data' => [
                        'url' => route('client.booking.index')
                    ]
                ];
            }
        }

        return response()->json($data_response, 200);
    }

    public function checkout(BookingRequest $request)
    {
        $data = $request->all();
        $data['invoice_code'] = uniqid();
        $dataRoomInvoice = $this->invoiceRepository->getDataRoomInvoice($data);
        $dataInvoice = $this->invoiceRepository->getDataInvoice($data);
        $booking = $this->invoiceRepository->insert($dataRoomInvoice, $dataInvoice);
        if ($booking) {
            $request->session()->flash('notification', 'booking-success');
        } else {
            $request->session()->flash('notification', 'booking-errors');
        }
        $request->session()->forget('booking');

        return redirect(route('client.index'));
    }
}
