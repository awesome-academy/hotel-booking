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
