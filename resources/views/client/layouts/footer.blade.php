<div class="footer margint40">
    <div class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-2 footer-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset(config('upload.logo')) }}/{{$web_setting->logo}}" class="img-responsive"/>
                    </a>
                </div>
                <div class="col-lg-10 col-sm-10">
                    <div class="col-lg-4 col-sm-4">
                        <h6>{{ trans('messages.Locations') }}</h6>
                        <ul class="footer-links">
                            @foreach ($locations_for_nav as $item)
                                <li><a href="{{ route('client.rooms.location', $item->id) }}">{{ $item->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <h6>{{ trans('messages.NEW_POSTS') }}</h6>
                        <ul class="footer-links">
                            @foreach ($new_posts as $new_post)
                                <li><a href="{{ route('client.blog.detail', $new_post->id) }}">{{ $new_post->title }}</a></li>
                                <hr>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <h6>{{ trans('messages.Contact') }}</h6>
                        <ul id="accordion" class="accordion">
                            @foreach ($provinces as $province)
                            <li>
                                <div class="link">
                                    {{ $province->name }}
                                    <i class="fa fa-chevron-down"></i>
                                </div>
                                <ul class="submenu">
                                    @foreach ($province['pro_loca'] as $loca)
                                    <li>
                                        <a href="{{ route('client.contact.index', $loca->id) }}">{{ $loca->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pre-footer">
        <div class="container">
            <div class="row">
                <div class="pull-right">
                    <ul>
                        <li><a href="{{ $web_setting->facebook }}"><i class="fa fa-facebook-square fa-2x"></i></a></li>
                        <li><a href="{{ $web_setting->twitter }}"><i class="fa fa-twitter-square fa-2x"></i></a></li>
                        <li><a href="{{ $web_setting->instagram }}"><i class="fa fa-instagram fa-2x"></i></a></li>
                        <li><a href="{{ $web_setting->linkedin }}"><i class="fa fa-linkedin-square fa-2x"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<a id="back-to-top"></a>
