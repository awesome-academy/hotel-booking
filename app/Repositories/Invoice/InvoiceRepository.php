<?php

namespace App\Repositories\Invoice;

use App\Models\Invoice;
use App\Models\Room;
use App\Repositories\EloquentRepository;
use App\Repositories\Room\RoomRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceRepository extends EloquentRepository
{
    public function getModel()
    {
        return Invoice::class;
    }

    public function getDataRoomInvoice($data)
    {
        $array = array(
            'room_id' => $data['room_id'],
            'invoice_code' => $data['invoice_code'],
            'price' => $data['price'],
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
            'currency' => $data['currency'],
        );

        return $array;
    }

    public function getDataInvoice($data)
    {
        $array = array(
            'code' => $data['invoice_code'],
            'user_id' => $data['user_id'],
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'customer_address' => $data['customer_address'],
            'total' => $data['price'],
        );

        return $array;
    }

    public function checkAvailableRoom($check_in, $check_out, $room_id)
    {
        $check_in_day = Carbon::parse($check_in);
        $check_out_day = Carbon::parse($check_out);
        $room = Room::find($room_id);
        if (is_null($room)) {
            return false;
        }
        $available_times = json_decode($room->available_time, true);
        foreach ($available_times as $available_time) {
            $check_in_available = Carbon::parse($available_time['check_in']);
            $check_out_available = Carbon::parse($available_time['check_out']);
            $between_checkin = $check_in_available->diff($check_in_day);
            $between_checkin_checkout = $check_in_day->diff($check_out_day);
            $between_checkout = $check_out_day->diff($check_out_available);
            if ($between_checkin->invert == 0 && $between_checkin_checkout->days <= $available_time['length'] && $between_checkout->invert == 0) {
                if (isset($available_rooms)) {
                    $arr_push = array(
                        'room_id' => $room->id,
                        'room_number' => $available_time['available_rooms'],
                    );
                    array_push($available_rooms, $arr_push);
                } else {
                    $available_rooms = [];
                    $available_rooms = array(
                        array(
                            'room_id' => $room->id,
                            'room_number' => $available_time['available_rooms'],
                        ),
                    );
                };
            }
        }
        if (!isset($available_rooms)) {
            return false;
        }

        return $available_rooms;
    }

    public function updateAvailableTime($room_id, $check_in, $check_out)
    {
        $room = Room::find($room_id);
        if (is_null($room)) {
            return false;
        }
        $check_arr = json_decode($room->available_time, true);
        foreach ($check_arr as $key => $item) {
            $checkin = Carbon::parse($check_in);
            $checkout = Carbon::parse($check_out);
            $check_in_available = Carbon::parse($item['check_in']);
            $check_out_available = Carbon::parse($item['check_out']);
            $diff = $check_in_available->diff($checkin);
            $diff2 = $check_in_available->diff($check_out_available);
            $diff3 = $checkin->diff($checkout);
            if ($diff->invert == 0 && $diff2->days >= $diff3->days) {
                $new = [];
                $new['check_in'] = $item['check_in'];
                $new['check_out'] = $check_in;
                $new_check_in = Carbon::parse($item['check_in']);
                $new_check_out = Carbon::parse($check_in);
                $new['length'] = $new_check_in->diff($new_check_out)->days;
                $new2 = [];
                $new2['check_in'] = $check_out;
                $new2['check_out'] = $item['check_out'];
                $new_check_in = Carbon::parse($check_out);
                $new_check_out = Carbon::parse($item['check_out']);
                $new2['length'] = $new_check_in->diff($new_check_out)->days;
                if (count($item['available_rooms']) == 1) {
                    if ($new['length'] > 0) {
                        $new['available_rooms'] = $item['available_rooms'];
                        array_push($check_arr, $new);
                    }
                    if ($new2['length'] > 0) {
                        $new2['available_rooms'] = $item['available_rooms'];
                        array_push($check_arr, $new2);
                    }
                    unset($check_arr[$key]);
                } else {
                    if ($new['length'] > 0) {
                        $available_rooms = $item['available_rooms'];
                        $first = key($available_rooms);
                        $new['available_rooms'] = array($available_rooms[$first]);
                        array_push($check_arr, $new);
                    }
                    if ($new2['length'] > 0) {
                        $available_rooms = $item['available_rooms'];
                        $first = key($available_rooms);
                        $new2['available_rooms'] = array($available_rooms[$first]);
                        array_push($check_arr, $new2);
                    }
                    $first = key($item['available_rooms']);
                    unset($check_arr[$key]['available_rooms'][$first]);
                }
            };
        }
        $room->available_time = json_encode($check_arr, true);
        $room->save();
    }

    public function insert($dataRoomInvoice, $dataInvoice)
    {
        $room = Room::find($dataRoomInvoice['room_id']);
        if (is_null($room)) {
            return false;
        }
        $checkRoom = $this->checkAvailableRoom($dataRoomInvoice['check_in_date'], $dataRoomInvoice['check_out_date'], $room->id);
        $roomNumber = reset($checkRoom);
        $this->updateAvailableTime($room->id, $dataRoomInvoice['check_in_date'], $dataRoomInvoice['check_out_date']);
        if ($checkRoom) {
            DB::beginTransaction();
            try {
                $dataRoomInvoice['room_number'] = reset($roomNumber['room_number']);
                $room->invoices()->attach($room->id, $dataRoomInvoice);
                $this->_model->create($dataInvoice);
                DB::commit();

                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                throw new \Exception($e->getMessage());
            }
        } else {
            return false;
        }
    }

    public function checkDateForUpdate($invoice)
    {
        $now = Carbon::parse(date('m/d/Y'));
        $invoice_info = $invoice->rooms()->first();
        $check_in = Carbon::parse($invoice_info->pivot->check_in_date);
        $diff = $check_in->diff($now);
        if ($diff->invert == 0) {
            return false;
        } else {
            return true;
        }
    }
}
