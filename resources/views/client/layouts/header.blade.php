<?php
use Illuminate\Support\Facades\Request;
?>
<div class="header">
    <div class="pre-header">
        <div class="container">
            <div class="row">
                <div class="pull-left pre-address-b"><p><i
                                class="fa fa-map-marker"></i>{{ trans('messages.Coming soon') }}</p></div>
                <div class="pull-right">
                    <div class="pull-right">
                        <div class="language-box">
                            <ul class="ul-header-flag">
                                <li>
                                    <a href="javascript:;">
                                        <img class="header-flag" src="{{ asset(config('upload.default')) }}/{{ $current_language->frag }}">
                                        <span class="language-text">{{ $current_language->name }}</span>
                                    </a>
                                </li>
                                @foreach ($header_languages as $header_language)
                                    <li>
                                        <a href="{{ route('client.changeLanguage', $header_language->id) }}">
                                            <img class="header-flag" src="{{ asset(config('upload.default')) }}/{{ $header_language->frag }}">
                                            <span class="language-text">{{ $header_language->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="pull-left">
                    <div class="logo">
                        <a href=""><img src="" class="img-responsive"/></a>
                    </div>
                </div>
                <div class="pull-right">
                    <div class="pull-left">
                        <nav class="nav">
                            <ul id="navigate" class="sf-menu navigate">
                                <li @if (Request::is('/')) {{'class=active'}} @endif>
                                    <a href="{{ url('/') }}">{{ trans('messages.HOMEPAGE') }}</a>
                                </li>
                                <li @if (Request::is('rooms/*')) {{'class=active'}} @endif class="parent-menu"><a href="javascript:;">{{ __('messages.Locations') }}</a>
                                    <ul>
                                        @foreach ($locations_for_nav as $location)
                                            <li><a href="{{ route('client.rooms.location', $location->id) }}">{{ $location->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="pull-right">
                        <div class="button-style-1 margint45">
                            <a href=""><i
                                        class="fa fa-calendar"></i>{{ trans('messages.Coming soon') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
