@extends('admin.layouts.master')
@section('content')
    <div class="m-content">
        <div class="row">
            <div class="col-xl-12">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{ __('messages.Chat') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <div class="m-section__content">
                                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                    <div class="row align-items-center">
                                        <div class="col-2"></div>
                                        <div class="col-8">
                                            <div class="form-group m-form__group row align-items-center">
                                                <div id="frame">
                                                    <div id="sidepanel">
                                                        <div id="profile">
                                                        </div>
                                                        <div id="search">
                                                            <label>
                                                                <i class="fa fa-search" aria-hidden="true"></i>
                                                            </label>
                                                            <input type="text" placeholder="{{ __('messages.Search_contacts') }}"/>
                                                        </div>
                                                        <div id="contacts">
                                                            <ul>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="content">
                                                        <div class="contact-profile">
                                                            <p class="m--margin-left-20">{{ __('messages.Name') }}</p>
                                                        </div>
                                                        <div class="messages">
                                                            <ul>
                                                            </ul>
                                                        </div>
                                                        <div class="message-input">
                                                            <div class="wrap">
                                                                <input type="text" id="admin-chat-input">
                                                                <input type="hidden" id="admin-url-chat" value="{{ route('admin.chat.send') }}">
                                                                <input type="hidden" id="admin-chat-email" value="{{ $admin->email }}">
                                                                <button class="submit" id="admin-chat-submit">
                                                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('bower_components/bower/admin/custom/js/chat.js') }}"></script>
@endsection
