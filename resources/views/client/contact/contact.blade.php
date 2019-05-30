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
                    <input type="text" id="cname" placeholder="Name" >
                    <h6 id="errorname" class="error"></h6>
                    <input type="text" id="csubject" placeholder="Subject">
                    <h6 id="errorsubject" class="error"></h6>
                    <input type="text" id="cmail" placeholder="E-Mail">
                    <h6 id="erroremail" class="error"></h6>
                    <textarea placeholder="Write what do you want..." id="ctext"></textarea>
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
