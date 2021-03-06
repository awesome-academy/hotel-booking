<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Image\ImageRepository;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\Location\LocationRepository;
use App\Repositories\Post\PostRepository;
use App\Repositories\Room\RoomRepository;
use App\Repositories\RoomDetail\RoomDetailRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $roomRepository = new RoomRepository();
        $roomDetailRepository = new RoomDetailRepository();
        $locationRepository = new LocationRepository();
        $languageRepository = new LanguageRepository();
        $imageRepository = new ImageRepository();
        $postRepository = new PostRepository();
        $this->locationRepository = $locationRepository;
        $this->roomRepository = $roomRepository;
        $this->roomDetailRepository = $roomDetailRepository;
        $this->languageRepository = $languageRepository;
        $this->imageRepository = $imageRepository;
        $this->base_lang_id = $this->languageRepository->getBaseId();
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $locations = $this->locationRepository->limit(config('pagination.limit_home'));
        $base_lang_id = $this->base_lang_id;
        $images = $this->imageRepository->limit(config('pagination.limit_home'));
        if (\session('locale')) {
            $posts = $this->postRepository->limitByLang(\session('locale'), config('pagination.limit_home'));
        } else {
            $posts = $this->postRepository->limitByLang($this->base_lang_id, config('pagination.limit_home'));
        }
        $data = compact(
            'locations',
            'base_lang_id',
            'images',
            'posts'
        );

        return view('client.index', $data);
    }
}
