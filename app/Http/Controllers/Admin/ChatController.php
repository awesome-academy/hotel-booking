<?php

namespace App\Http\Controllers\Admin;

use App\Events\Admin\Chat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function index()
    {
        return view('admin.chat.index');
    }

    public function send(Request $request)
    {
        $now = date('H:i d-m-Y');
        $request->time = $now;
        $data = $request->all();
        $rules = [
            'message' => 'required',
        ];
        $messages = [
            'message.required' => __('messages.Validate_required'),
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $data_response = [
                'messages' => 'Validation_fails',
                'data' => $validator->messages(),
            ];
        } else {
            event(new Chat($request));
            $data_response = [
                'messages' => 'success',
                'data' => $data
            ];
        }

        return response()->json($data_response, 200);
    }
}
