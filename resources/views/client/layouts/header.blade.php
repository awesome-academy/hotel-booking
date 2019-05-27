<div class="header">
    <div class="pre-header">
        <div class="container">
            <div class="row">
                <div class="pull-left pre-address-b"><p><i
                                class="fa fa-map-marker"></i>{{ trans('messages.Coming soon') }}</p></div>
                <div class="pull-right">
                    <div class="pull-left">
                        <ul class="pre-link-box">
                            <li><a href="about.html">{{ trans('messages.Coming soon') }}</a></li>
                            <li><a href="contact.html">{{ trans('messages.Coming soon') }}</a></li>
                            <li><a href="#">{{ trans('messages.Coming soon') }}</a></li>
                        </ul>
                    </div>
                    <div class="pull-right">
                        <div class="language-box">
                            <ul>
                                @foreach ($header_languages as $header_language)
                                    <li><a href="{{ route('client.changeLanguage', $header_language->id) }}"><img
                                                    class="header-flag"
                                                    src="{{ config('upload.default') }}/{{ $header_language->frag }}"><span
                                                    class="language-text">{{ $header_language->name }}</span></a></li>
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
                                <li class="active">
                                    <a href="{{ url('/') }}">{{ trans('messages.HOMEPAGE') }}</a>
                                </li>
                                <li class="parent-menu"><a href="#">{{ __('messages.Locations') }}</a>
                                    <ul>
                                        @foreach ($locations_for_nav as $location)
                                            <li><a href="#">{{ $location->name }}</a></li>
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
