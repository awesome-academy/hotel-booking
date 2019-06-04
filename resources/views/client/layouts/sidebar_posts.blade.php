<div class="col-lg-3 col-sm-4 margint60"><!-- Sidebar -->
    <div class="luxen-widget news-widget">
        <div class="title">
            <h5>{{ __('messages.recentNew') }}</h5>
        </div>
        <ul class="sidebar-recent">
            @if (isset($new_posts))
                @foreach ($new_posts as $new)
                    <li class="clearfix">
                        <h6><a href="{{ route('client.blog.detail', $new->id) }}">{{ $new->title }}</a></h6>
                        <div class="pull-left blg-img margint20">
                            <img src="{{ asset(config('upload.default')) }}/{{ $new->image }}" class="img-responsive img1">
                        </div>
                        <div class="pull-left blg-txt">
                            <p class="news-short-description">
                                <a href="{{ route('client.blog.detail', $new->id) }}">
                                    {{ $new->description }}[...]
                                </a>
                            </p>
                        </div>
                    </li>
                @endforeach
            @else
                <p>{{ __('messages.NoPost') }}</p>
            @endif
        </ul>
    </div>
    <div class="luxen-widget news-widget">
        <div class="title">
            <h5>{{ __('messages.HOTEL INFORMATION') }}</h5>
        </div>
        <p>{{ __('messages.About_us_content') }}</p>
    </div>
    <div class="luxen-widget news-widget">
        <div class="title">
            <h5>{{ __('messages.SOCIAL MEDIA') }}</h5>
        </div>
        <ul class="social-links">
            <li><a href="{{ $web_setting->facebook }}"><i class="fa fa-facebook"></i></a></li>
            <li><a href="{{ $web_setting->twitter }}"><i class="fa fa-twitter"></i></a></li>
            <li><a href="{{ $web_setting->instagram }}"><i class="fa fa-instagram"></i></a></li>
            <li><a href="{{ $web_setting->linkedin }}"><i class="fa fa-linkedin"></i></a></li>
        </ul>
    </div>
</div>
