<div class="slider slider-home"><!-- Slider Section -->
    <div class="flexslider slider-loading falsenav">
        <ul class="slides">
            <li>
                <div class="slider-textbox clearfix">
                    <div class="container">
                        <div class="row">
                            <div class="slider-bar pull-left">{{ trans('messages.Coming soon') }}</div>
                            <div class="slider-triangle pull-left"></div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="slider-bar-under pull-left">{{ trans('messages.Coming soon') }}</div>
                            <div class="slider-triangle-under pull-left"></div>
                        </div>
                    </div>
                </div>
                <img class="img-responsive" src="{{ asset(config('upload.sliders')) }}/sliderr-1.jpg"/>
            </li>
            <li>
                <div class="slider-textbox clearfix">
                    <div class="container">
                        <div class="row">
                            <div class="slider-bar pull-left">{{ trans('messages.Coming soon') }}</div>
                            <div class="slider-triangle pull-left"></div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="slider-bar-under pull-left">{{ trans('messages.Coming soon') }}</div>
                            <div class="slider-triangle-under pull-left"></div>
                        </div>
                    </div>
                </div>
                <img class="img-responsive" src="{{ asset(config('upload.sliders')) }}/sliderr-2.jpg"/>
            </li>
        </ul>
    </div>
    <div class="book-slider">
        <div class="container">
            <div class="row pos-center">
                <div class="reserve-form-area">
                    <form action="{{ route('client.rooms.index') }}" method="get">
                        <ul class="clearfix">
                            <li class="li-input">
                                <label>{{ trans('messages.Check_in_day') }}</label>
                                <input type="text" id="dpd1" name="check_in" data-date-format="mm/dd/yyyy"
                                       class="date-selector" placeholder="&#xf073;" autocomplete="off"/>
                                @if ($errors->has('check_in'))
                                    <p class="text-danger">{{ $errors->first('check_in') }}</p>
                                @endif
                            </li>
                            <li class="li-input">
                                <label>{{ trans('messages.Check_out_day') }}</label>
                                <input type="text" id="dpd2" name="check_out" data-date-format="mm/dd/yyyy"
                                       class="date-selector" placeholder="&#xf073;" autocomplete="off"/>
                                @if ($errors->has('check_out'))
                                    <p class="text-danger">{{ $errors->first('check_out') }}</p>
                                @endif
                            </li>
                            <li class="li-select">
                                <label>{{ trans('messages.Coming soon') }}</label>
                                <select name="location" class="pretty-select">
                                    @foreach ($locations_for_nav as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li>
                                <div class="button-style-1">
                                    <button><i class="fa fa-search"></i>{{ trans('messages.Search') }}</button>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-book-slider">
        <div class="container">
            <div class="row pos-center">
                <ul>
                    <li><i class="fa fa-shopping-cart"></i>{{ trans('messages.Coming soon') }}</li>
                    <li><i class="fa fa-globe"></i>{{ trans('messages.Coming soon') }}</li>
                    <li><i class="fa fa-coffee"></i>{{ trans('messages.Coming soon') }}</li>
                    <li><i class="fa fa-windows"></i>{{ trans('messages.Coming soon') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
