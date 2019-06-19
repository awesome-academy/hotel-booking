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
                                                            <input type="text"
                                                                   placeholder="{{ __('messages.Search_contacts') }}"/>
                                                        </div>
                                                        <div id="contacts">
                                                            <ul class="list-contacts" id="list-contacts">
                                                                @foreach ($contacts as $contact)
                                                                    <a href="{{ route('admin.chat.index', $contact['email']) }}">
                                                                        <li class="contact @if ($user_email == $contact['email']) {{ 'active' }} @endif">
                                                                            <div class="wrap">
                                                                                <div class="meta">
                                                                                    <p class="name">{{ $contact['email'] }}</p>
                                                                                    <p class="preview">{{ $contact['new_message'] }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </a>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="content">
                                                        <div class="contact-profile">
                                                            <p class="m--margin-left-20">{{ $user_email }}</p>
                                                        </div>
                                                        <div class="messages">
                                                            <ul>
                                                                @foreach ($logs as $log)
                                                                    @if ($log['type'] == 'client')
                                                                        <li class="sent">
                                                                            <p>{{ $log['body'] }}</p>
                                                                            <br>
                                                                            <span class="message-time">{{ $log['time'] }} </span>
                                                                        </li>
                                                                    @else
                                                                        <li class="replies">
                                                                            <p>{{ $log['body'] }}</p>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="message-input">
                                                            <div class="wrap">
                                                                <input type="text" id="admin-chat-input">
                                                                <input type="hidden" id="admin-url-chat"
                                                                       value="{{ route('admin.chat.send') }}">
                                                                <input type="hidden" id="admin-chat-email"
                                                                       value="{{ $admin->email }}">
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
    <input type="hidden" id="channel-chat" value="{{ $user_email }}">
    <input type="hidden" id="url-channel" value="{{ route('admin.chat.index', '') }}">
@endsection
@section('script')
    <script src="{{ asset('bower_components/bower/admin/custom/js/chat.js') }}"></script>
@endsection
