<?php
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
?>
<div class="header">
    <div class="pre-header">
        <div class="container">
            <div class="row">
                <div class="pull-right">
                    <div class="pull-left">
                        <ul class="pre-link-box">
                            @if (Auth::check() || Cookie::get('remember_token'))
                                <div class="btn-group">
                                    <li class="dropdown" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ $user->full_name }} <i class="fa fa-angle-down"></i>
                                    </li>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="{{ route('client.users.profile', $user->id) }}">{{ __('messages.Profile') }}</a>
                                        <div class="dropdown-divider"></div>
                                        <form id="logout-form" action="{{ route('client.logout') }}" method="POST">
                                            @csrf
                                            <button class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">{{ __('messages.Log_out') }}</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <li><a href="javascript:;" data-toggle="modal"
                                       data-target="#exampleModal">{{ __('messages.Register') }}</a></li>
                                <li><a href="{{ route('client.login_form') }}">{{ __('messages.Login') }}</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="pull-right">
                        <div class="language-box">
                            <ul class="ul-header-flag">
                                <li>
                                    <a href="javascript:;">
                                        <img class="header-flag"
                                             src="{{ asset(config('upload.default')) }}/{{ $current_language->frag }}">
                                        <span class="language-text">{{ $current_language->name }}</span>
                                    </a>
                                </li>
                                @foreach ($header_languages as $header_language)
                                    <li>
                                        <a href="{{ route('client.changeLanguage', $header_language->id) }}">
                                            <img class="header-flag"
                                                 src="{{ asset(config('upload.default')) }}/{{ $header_language->frag }}">
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
                                <li @if (Request::is('/')) class="active" @endif>
                                    <a href="{{ url('/') }}">{{ trans('messages.HOMEPAGE') }}</a>
                                </li>
                                <li @if (Request::is('rooms*')) class="active parent-menu"
                                    @else class="parent-menu" @endif><a
                                            href="javascript:;">{{ __('messages.Locations') }}</a>
                                    <ul>
                                        @foreach ($locations_for_nav as $location)
                                            <li>
                                                <a href="{{ route('client.rooms.location', $location->id) }}">{{ $location->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li @if (Request::is('blog*'))  class="active" @else class="" @endif>
                                    <a href="{{ asset('blog') }}">{{ trans('messages.NEWS') }}</a>
                                </li>
                                <li @if (Request::is('contact*')) class="active parent-menu oppa" @else class="parent-menu oppa" @endif><a href="javascript:;">{{ __('messages.Contact') }}</a>
                                    <ul>
                                        @foreach ($provinces as $province)
                                            <li class="parent-menu">{{ $province->name }}
                                                <ul>
                                                    @foreach( $province['pro_loca'] as $loca)
                                                    <li><a href="{{ route('client.contact.index', $loca->id) }}">{{ $loca->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="pull-right">
                        <div class="button-style-1 margint45">
                            <a href=""><i class="fa fa-calendar"></i>{{ trans('messages.Coming soon') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.Register') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label my-label">{{ __('messages.Fullname') }}<b class="text-danger">*</b></label>
                        <input type="text" class="form-control" id="full_name" name="full_name"
                               value="{{ old('full_name') }}" placeholder="{{ __('messages.Enter_fullname') }}">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label my-label">{{ __('messages.Email') }}<b
                                    class="text-danger">*</b></label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"
                               placeholder="{{ __('messages.Enter_Email') }}">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label my-label">{{ __('messages.Phone') }}</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"
                               placeholder="{{ __('messages.Enter_phone') }}">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label my-label">{{ __('messages.Address') }}</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}"
                               placeholder="{{ __('messages.Enter_address') }}">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label my-label">{{ __('messages.Password') }}<b class="text-danger">*</b></label>
                        <input type="password" class="form-control" id="password" name="password"
                               value="{{ old('password') }}" placeholder="{{ __('messages.Enter_password') }}">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label my-label">{{ __('messages.Re-Password') }}<b
                                    class="text-danger">*</b></label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation" value="{{ old('password_confirmation') }}"
                               placeholder="{{ __('messages.Re-Password') }}">
                    </div>
                    <input type="hidden" id="url" value="{{ route('client.register') }}">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-register">{{ __('messages.Register') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
