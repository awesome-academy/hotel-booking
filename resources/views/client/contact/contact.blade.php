@extends('client.layouts.master')
@section('content')
<div class="breadcrumb breadcrumb-1 pos-center">
    <h1>{{ __('messages.CONTACT') }}</h1>
</div>
<div class="content"><!-- Content Section -->
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-4 margint60"><!-- Sidebar -->
                <div class="luxen-widget news-widget">
                    <div class="title">
                        <h5>{{ __('messages.HOTEL INFORMATION') }}</h5>
                    </div>
                    <p>{{ __('messages.lorem') }}</p>
                </div>
                <div class="luxen-widget news-widget">
                    <div class="title">
                        <h5>{{ __('messages.CONTACT') }}</h5>
                    </div>
                    <ul class="footer-links">
                        <li><p><i class="fa fa-map-marker"></i>{{ $location->address }}</p></li>
                        <li><p><i class="fa fa-phone"></i>{{ $location->phone }}</p></li>
                        <li><p><i class="fa fa-envelope"></i>{{ $location->email }}</p></li>
                    </ul>
                </div>
                <div class="luxen-widget news-widget">
                    <div class="title">
                        <h5>{{ __('messages.SOCIAL MEDIA') }}</h5>
                    </div>
                    <ul class="social-links">
                        <li><a href=""><i class="fa fa-facebook"></i></a></li>
                        <li><a href=""><i class="fa fa-twitter"></i></a></li>
                        <li><a href=""><i class="fa fa-vine"></i></a></li>
                        <li><a href=""><i class="fa fa-foursquare"></i></a></li>
                        <li><a href=""><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 col-sm-8"><!-- Contact -->
                <div class="contact-form margint60">
                    <p id="successcontact"></p><!-- Contact Form -->
                    @if (auth()->user())
                    <input type="hidden" name="" id="hiddenuser" value="{{auth()->user()->id}}">
                    <h6 id="errorname" class="error"></h6>
                    <label class="labelContact">{{ __('messages.Name' )}}</label>
                    <input type="text" id="cname" placeholder="{{ __('messages.Name' )}}" value="{{auth()->user()->full_name}}">
                    <label class="labelContact">{{ __('messages.Email' )}}</label>
                    <input type="text" id="cmail" placeholder="{{ __('messages.Email' )}}" value="{{auth()->user()->email}}">
                    <h6 id="erroremail" class="error"></h6>
                    @else
                    <label class="labelContact">{{ __('messages.Name' )}}</label>
                    <input type="text" id="cname" placeholder="{{ __('messages.Name' )}}" >
                    <h6 id="errorname" class="error"></h6>
                    <label class="labelContact">{{ __('messages.Email' )}}</label>
                    <input type="text" id="cmail" placeholder="{{ __('messages.Email' )}}">
                    <h6 id="erroremail" class="error"></h6>
                    @endif
                    <label class="labelContact">{{ __('messages.Subject' )}}</label>
                    <input type="text" id="csubject" placeholder="{{ __('messages.Subject' )}}" >
                    <h6 id="errorsubject" class="error"></h6>
                    <label class="labelContact">{{ __('messages.Body' )}}</label>
                    <textarea placeholder="{{ __('messages.Body' )}}" id="ctext"></textarea>
                    <h6 id="errortext" class="error"></h6>
                    <button class="pull-right margint10 submit btn btn-primary" >{{ __('messages.Submit') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="" class="location" value="{{ $location->id }}">
<input type="hidden" name="" id="hiddenasset" value="{{ asset('') }}">
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('') }}bower_components/bower/js/contact.js"></script>
@endsection
