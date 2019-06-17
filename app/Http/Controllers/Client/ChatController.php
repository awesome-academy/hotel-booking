<?php

namespace App\Http\Controllers\Client;

use App\Events\Chat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function submitEmail(Request $request)
    {
        $data = $request->all();
        $rules = [
            'email' => 'required|email|max:191',
        ];
        $messages = [
            'email.required' => __('messages.Validate_email_required'),
            'email.email' => __('messages.Validate_email'),
            'email.max' => __('messages.Validate_max'),
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $data_response = [
                'messages' => 'Validation_fails',
                'data' => $validator->messages(),
            ];
        } else {
            Session::put('chat_with_admin_email', $data['email']);
            $data_response = [
                'messages' => 'success',
            ];
        }

        return response()->json($data_response, 200);
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
