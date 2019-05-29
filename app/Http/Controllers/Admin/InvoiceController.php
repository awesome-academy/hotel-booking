<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\Room\RoomRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $invoiceRepository = new InvoiceRepository();
        $languageRepository = new LanguageRepository();
        $roomRepository = new RoomRepository();
        $this->invoiceReposiory = $invoiceRepository;
        $this->languageRepository = $languageRepository;
        $this->roomRepository = $roomRepository;
        $this->base_lang_id = $languageRepository->getBaseId();
    }

    public function index()
    {
        $base_lang_id = $this->base_lang_id;
        $invoices = $this->invoiceReposiory->paginate(config('pagination.default'));
        $data = compact(
            'base_lang_id',
            'invoices'
        );

        return view('admin.invoices.index', $data);
    }

    public function show($id)
    {
        $invoice = $this->invoiceReposiory->find($id);
        if (is_null($invoice)) {
            abort(404);
        }
        $room = $invoice->rooms()->first();
        if (is_null($room)) {
            abort(404);
        }
        if (session('locale')) {
            $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
            if (is_null($roomDetail)) {
                $roomDetail = $room->roomDetails()->where('lang_id', $this->base_lang_id)->first();
            }
        } else {
            $roomDetail = $room->roomDetails()->where('lang_id', $this->base_lang_id)->first();
        }
        $pivot = $room->pivot;
        $data = compact(
            'invoice',
            'roomDetail',
            'pivot',
            'room'
        );

        return view('admin.invoices.detail', $data);
    }

    public function delete(Request $request, $id)
    {
        $invoice = $this->invoiceReposiory->find($id);
        if (is_null($invoice)) {
            $request->session()->flash('notification' , 'delete-errors');

            return redirect(route('admin.invoices.index'));
        }
        DB::beginTransaction();
        try {
            $this->roomRepository->updateAvailableTime($id);
            $invoice->rooms()->detach();
            $invoice->delete();
            DB::commit();
            $request->session()->flash('notification' , 'delete');

            return redirect(route('admin.invoices.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
