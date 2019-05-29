<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Client\SearchHomeRequest;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\Location\LocationRepository;
use App\Repositories\Room\RoomRepository;
use App\Repositories\RoomDetail\RoomDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function __construct()
    {
        $locationRepository = new LocationRepository();
        $roomRepository = new RoomRepository();
        $roomDetailRepository = new RoomDetailRepository();
        $languageRepository = new LanguageRepository();
        $commentRepository = new CommentRepository();
        $this->locationRepository = $locationRepository;
        $this->roomRepository = $roomRepository;
        $this->roomDetailRepository = $roomDetailRepository;
        $this->languageRepository = $languageRepository;
        $this->commentRepository = $commentRepository;
        $this->baseLangId = $languageRepository->getBaseId();
    }

    public function location($location_id)
    {
        $base_lang_id = $this->baseLangId;
        $location = $this->locationRepository->find($location_id);
        if (is_null($location)) {
            abort(404);
        }
        $data = compact(
            'location',
            'base_lang_id'
        );

        return view('client.rooms.location', $data);

    }

    public function detail($id)
    {
        $room = $this->roomRepository->find($id);
        if (is_null($room)) {
            abort(404);
        }
        if (session('locale')) {
            $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
        } else {
            $roomDetail = $room->roomDetails()->where('lang_id', $this->baseLangId)->first();
        }
        if (is_null($roomDetail)) {
            abort(404);
        }
        $properties = $room->properties()->get();
        $comments = $room->comments()->where('object', 'room')->where('object_id', $id)->orderBy('id', 'desc')->get();
        $images = $room->images()->get();
        $data = compact(
            'room',
            'roomDetail',
            'images',
            'properties',
            'comments'
        );

        return view('client.rooms.detail', $data);

    }

    public function comment(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'rating' => 'required',
            'email' => 'required|email|max:191',
            'body' => 'required',
        );
        $messages = array(
            'rating.required' => __('messages.Validate_rating_required'),
            'email.required' => __('messages.Validate_email_required'),
            'email.email' => __('messages.Validate_email_email'),
            'email.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'body.required' => __('messages.Validate_body_required'),
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['messages' => 'errors', 'data' => $validator->messages()], 200);
        }
        $data['object'] = 'room';
        DB::beginTransaction();
        try {
            $this->roomRepository->updateRating($data['rating'], $data['object_id']);
            $this->commentRepository->create($data);
            DB::commit();

            return response()->json(['messages' => 'success', 'data' => $data], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function index(SearchHomeRequest $request)
    {
        $base_lang_id = $this->baseLangId;
        if (isset($_GET['check_in']) && isset($_GET['check_out']) && isset($_GET['location'])) {
            $data = $this->roomRepository->roomAvailable($_GET['check_in'], $_GET['check_out'], $_GET['location']);
            if (!$data) {
                $request->session()->flash('notification', 'no_room_found');

                return redirect(route('client.index'));
            }
            $rooms = $this->roomRepository->filter($data);
            $data = compact(
                'rooms',
                'base_lang_id'
            );

            return view('client.rooms.index', $data);
        } else {
            return redirect(route('client.index'));
        }

    }
}
