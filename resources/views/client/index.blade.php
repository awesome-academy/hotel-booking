@extends('client.layouts.master')
@section('content')
    @include('client.layouts.slider')
    <div class="content"><!-- Content Section -->
        <div class="about clearfix"><!-- About Section -->
            <div class="container">
                <div class="row">
                    <div class="about-title pos-center">
                        <h2>{{ trans('messages.Welcome') }}</h2>
                        <div class="title-shape"><img src="{{ config('upload.client_static') }}{{ __('shape.png') }}">
                        </div>
                        <p>{{ __('messages.Greeting_content') }}</p>
                    </div>
                    <div class="otel-info margint60">
                        <div class="col-lg-4 col-sm-12">
                            <div class="title-style-1 marginb40">
                                <h5>{{ trans('messages.Gallery') }}</h5>
                                <hr>
                            </div>
                            <div class="flexslider">
                                <ul class="slides">
                                    @if ($images)
                                        @foreach ($images as $image)
                                            <li>
                                                <img class="img-responsive client-image-gallery"
                                                     src="{{ config('upload.images') }}{{ $image->name }}"/>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="title-style-1 marginb40">
                                <h5>{{ trans('messages.About_us') }}</h5>
                                <hr>
                            </div>
                            <p>{{ trans('messages.About_us_content') }}</p>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="title-style-1 marginb40">
                                <h5>{{ trans('messages.New_posts') }}</h5>
                                <hr>
                            </div>
                            <div class="home-news">
                                @foreach ($posts as $post)
                                    <div class="news-box clearfix">
                                        <div class="news-time pull-left">
                                            <div class="news-date pos-center">
                                                <div class="date-day">{{ $post->created_at->format('d') }}
                                                    <hr/>
                                                </div>{{ $post->created_at->format('M') }}</div>
                                        </div>
                                        <div class="news-content pull-left">
                                            <h6><a href="#">{{ $post->title }}</a></h6>
                                            <p class="news-short-description margint10">{{ $post->description }}</p>
                                            <a class="active-color" href="{{ route('client.blog.detail', $post->id) }}">[...]</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="explore-rooms margint30 clearfix"><!-- Explore Rooms Section -->
            <div class="container">
                <div class="row">
                    <div class="title-style-2 marginb40 pos-center">
                        <h3>{{ trans('messages.Rooms_at_location') }}</h3>
                        <hr>
                    </div>
                    @foreach ($locations as $location)
                        @php
                            $room = $location->rooms()->first();
                            if (session('locale') && !is_null($room)) {
                                $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
                            } elseif (!is_null($room)) {
                                $roomDetail = $room->roomDetails()->where('lang_id', $base_lang_id)->first();
                            }
                        @endphp
                        @if (!is_null($room) && !is_null($roomDetail))
                            <div class="col-lg-4 col-sm-6">
                                <div class="home-room-box">
                                    <div class="room-image">
                                        <div class="room-features">{{ $location->name }}</div>
                                        <img class="img-responsive home-location-image"
                                             src="{{ asset(config('upload.rooms')) }}/{{ $room->image }}">
                                        <div class="home-room-details">
                                            <h5><a href="#">{{ $roomDetail->name }}</a></h5>
                                            <div class="pull-right room-rating">
                                                <ul>
                                                    @for ($i = 0; $i < $room->rating; $i++)
                                                        <li><i class="fa fa-star"></i></li>
                                                    @endfor
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="room-details">
                                        <p>{{ $roomDetail->short_description }}</p>
                                    </div>
                                    <div class="room-bottom">
                                        <div class="pull-left">
                                            @if ($room->sale_status == 0)
                                                <h4 class="price">{{ $roomDetail->price }} {{ __('messages.currency') }}
                                                    <span class="room-bottom-time">/ {{ trans('messages.Day') }}</span>
                                                </h4>
                                            @else
                                                <del class="price">{{ $roomDetail->price }} {{ __('messages.currency') }}</del>
                                                <h4 class="price">{{ $roomDetail->sale_price }} {{ __('messages.currency') }}
                                                    <span class="room-bottom-time">/ {{ trans('messages.Day') }}</span>
                                                </h4>
                                            @endif
                                        </div>
                                        <div class="pull-right">
                                            <div class="button-style-1">
                                                <a href="{{ route('client.rooms.detail', [$room->id] ) }}">{{ trans('messages.See_more') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div id="parallax123" class="parallax parallax-one clearfix margint60"><!-- Parallax Section -->
            <div class="support-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-sm-4">
                            <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                                <div class="flipper">
                                    <div class="support-box pos-center front">
                                        <div class="support-box-title"><i class="fa fa-phone"></i></div>
                                        <h4>{{ trans('messages.Call_us') }}</h4>
                                        <p class="margint20">{{ trans('messages.Call_us_content') }}</p>
                                    </div>
                                    <div class="support-box pos-center back">
                                        <div class="support-box-title"><i class="fa fa-phone"></i></div>
                                        @foreach ($locations_for_nav as $item)
                                            <p class="margint20">
                                                <b>{{ $item->name }}</b>
                                                <br/>
                                                {{ $item->phone }}
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                                <div class="flipper">
                                    <div class="support-box pos-center front">
                                        <div class="support-box-title"><i class="fa fa-envelope"></i></div>
                                        <h4>{{ trans('messages.Email_us') }}</h4>
                                        <p class="margint20">{{ trans('messages.Email_us_content') }}</p>
                                    </div>
                                    <div class="support-box pos-center back">
                                        <div class="support-box-title"><i class="fa fa-envelope"></i></div>
                                        @foreach ($locations_for_nav as $item)
                                            <p class="margint20">
                                                <b>{{ $item->name }}</b>
                                                <br/>
                                                {{ $item->email }}
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                                <div class="flipper">
                                    <div class="support-box pos-center front">
                                        <div class="support-box-title"><i class="fa fa-home"></i></div>
                                        <h4>{{ trans('messages.Visit_us') }}</h4>
                                        <p class="margint20">{{ trans('messages.Visit_us_content') }}</p>
                                    </div>
                                    <div class="support-box pos-center back">
                                        <div class="support-box-title"><i class="fa fa-home"></i></div>
                                        @foreach ($locations_for_nav as $item)
                                            <p class="margint20">
                                                <b>{{ $item->name }}</b>
                                                <br/>
                                                {{ $item->address }}
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="newsletter-section"><!-- Newsletter Section -->
            <div class="container">
                <div class="row">
                    <div class="newsletter-top pos-center margint30">
                        <img src="{{ config('upload.client_static') }}{{ __('shape.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
