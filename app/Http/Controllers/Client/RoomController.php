<?php

namespace App\Http\Controllers\Client;

use App\Repositories\Language\LanguageRepository;
use App\Repositories\Location\LocationRepository;
use App\Repositories\Room\RoomRepository;
use App\Repositories\RoomDetail\RoomDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function __construct()
    {
        $locationRepository = new LocationRepository();
        $roomRepository = new RoomRepository();
        $roomDetailRepository = new RoomDetailRepository();
        $languageRepository = new LanguageRepository();
        $this->locationRepository = $locationRepository;
        $this->roomRepository = $roomRepository;
        $this->roomDetailRepository = $roomDetailRepository;
        $this->languageRepository = $languageRepository;
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
}
