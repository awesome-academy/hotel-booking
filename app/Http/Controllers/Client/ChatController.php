<?php

namespace App\Http\Controllers\Client;

use App\Events\Admin\ShowNewChat;
use App\Events\Chat;
use App\Events\ShowUnread;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
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
            $history = [
                'id' => uniqid(),
                'body' => $data['message'],
                'time' => $now,
                'type' => 'client',
                'status' => 0,
            ];
            if (Redis::exists('chat_log:' . $data['email'])) {
                $log = Redis::get('chat_log:' . $data['email']);
                $arr_log = json_decode($log, true);
                array_push($arr_log, $history);
                Redis::getSet('chat_log:' . $data['email'], json_encode($arr_log));
            } else {
                $log = json_encode(array($history));
                Redis::set('chat_log:' . $data['email'], $log);
                event(new ShowNewChat($request));
            }
            event(new Chat($request));
            event(new ShowUnread($data));
            $data_response = [
                'messages' => 'success',
                'data' => $data
            ];
        }

        return response()->json($data_response, 200);
    }
}
