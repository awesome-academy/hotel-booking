<?php
use Illuminate\Support\Facades\Config;
?>
@extends('admin.layouts.login')
@section('content')
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3"
             id="m_login">
            <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a href="javascript:;">
                            <img src="{{ asset(Config::get('upload.logo_admin')) }}">
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <form class="m-login__form m-form" action="{{ route('client.forgetPasswordSubmit') }}" method="post">
                            @csrf
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text"
                                       placeholder="{{ __('messages.Enter_Email') }}" name="email"
                                       value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="row m-login__form-sub">
                            </div>
                            <div class="m-login__form-action">
                                <button id="m_login_signin_submit"
                                        class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">{{ __('messages.Send_request') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
