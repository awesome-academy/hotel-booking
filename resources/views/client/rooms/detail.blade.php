@extends('client.layouts.master')
@section('breadcumb')
    {{ $roomDetail->name }}
@endsection
@section('content')
    @include('client.layouts.page-breadcumb')
    <div class="content"><!-- Content Section -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12"><!-- Room Gallery Slider -->
                    <div class="room-gallery">
                        <div class="margint40 marginb20"><h4>{{ __('messages.Gallery') }}</h4></div>
                        <div class="flexslider-thumb falsenav">
                            <ul class="slides">
                                <li data-thumb="{{ asset(config('upload.rooms')) }}/{{ $room->image }}">
                                    <img class="img-responsive main-flex-image"
                                         src="{{ asset(config('upload.rooms')) }}/{{ $room->image}}"/>
                                </li>
                                @foreach ($images as $image)
                                    <li data-thumb="{{ asset(config('upload.images')) }}/{{ $image->name }}">
                                        <img class="img-responsive main-flex-image"
                                             src="{{ asset(config('upload.images')) }}/{{ $image->name }}"/>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 clearfix"><!-- Room Information -->
                    <div class="col-lg-8 clearfix col-sm-8">
                        <h4>{{ __('messages.Short_description') }}</h4>
                        <p class="margint30">{{ $roomDetail->short_description }}</p>
                        <div class="button-style-3">
                            <button data-toggle="modal" data-target="#myModal">{{ __('messages.Book_now') }}</button>
                        </div>
                    </div>
                    <div class="col-lg-4 clearfix col-sm-4">
                        <div class="room-services"><!-- Room Services -->
                            <h4>{{ __('messages.Properties_table') }}</h4>
                            <ul class="room-services">
                                @foreach ($properties as $property)
                                    @if (session('locale') && session('locale') != $base_lang_id)
                                        @php($property = $property->where('lang_id', session('locale'))->where('lang_parent_id', $property->id)->first())
                                    @endif
                                    @if(!is_null($property))
                                        <li>{{ $property->name }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12 clearfix margint40 room-single-tab"><!-- Room Tab -->
                        <div class="tab-style-2 ">
                            <ul class="tabbed-area tab-style-nav clearfix">
                                <li class="active"><h6><a href="#tab1s">{{ __('messages.Description') }}</a></h6></li>
                                <li class=""><h6><a href="#tab2s">{{ __('messages.Comment') }}</a></h6></li>
                                <li class=""><h6><a href="#tab3s">{{ __('messages.List_comments') }}</a></h6></li>
                            </ul>
                            <div class="tab-content tab-style-content">
                                <div class="tab-pane fade active in" id="tab1s">
                                    <div class="col-lg-9 margint30 description-scroll">
                                        {!! $roomDetail->description !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab2s">
                                    <div class="col-lg-9 margint30">
                                        <div class="contact-form"><!-- Contact Form -->
                                            <form id="comment-form">
                                                @csrf
                                                <section class='rating-widget'>
                                                    <div class='rating-stars text-center'>
                                                        <ul id='stars'>
                                                            <li class='star' data-value='1'>
                                                                <i class='fa fa-star fa-fw'></i>
                                                            </li>
                                                            <li class='star' data-value='2'>
                                                                <i class='fa fa-star fa-fw'></i>
                                                            </li>
                                                            <li class='star' data-value='3'>
                                                                <i class='fa fa-star fa-fw'></i>
                                                            </li>
                                                            <li class='star' data-value='4'>
                                                                <i class='fa fa-star fa-fw'></i>
                                                            </li>
                                                            <li class='star' data-value='5'>
                                                                <i class='fa fa-star fa-fw'></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </section>
                                                <div class="margint20">
                                                    <input type="hidden" id="rating-room" name="rating"
                                                           class="success-box">
                                                    <input type="hidden" id="object_id" name="object_id"
                                                           value="{{ $room->id }}">
                                                    <input type="hidden" name="url" id="url-comment"
                                                           value="{{ route('client.rooms.comment') }}">
                                                    @if ($errors->has('rating'))
                                                        <p class="text-danger">{{ $errors->first('rating') }}</p>
                                                    @endif
                                                    <input type="text" placeholder="{{ __('messages.Enter_Email') }}"
                                                           id="email-comment-room">
                                                    @if ($errors->has('email'))
                                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                                    @endif
                                                    <textarea placeholder="{{ __('messages.Write_your_comment') }}"
                                                              id="body-room" name="body"></textarea>
                                                    @if ($errors->has('body'))
                                                        <p class="text-danger">{{ $errors->first('body') }}</p>
                                                    @endif
                                                    <input class="pull-right margint10 btn-comment-room" type="submit"
                                                           value="{{ __('messages.Send') }}">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab3s">
                                    <div class="col-lg-9 margint30">
                                        <div class="comments-container">
                                            <ul id="comments-list" class="comments-list description-scroll">
                                                @foreach ($comments as $comment)
                                                    <li>
                                                        <div class="comment-main-level">
                                                            <div class="comment-avatar"><img
                                                                        src="{{ config('upload.avatar_comment') }}">
                                                            </div>
                                                            <div class="comment-box">
                                                                <div class="comment-head">
                                                                    <h6 class="comment-name">{{ $comment->email }}</h6>
                                                                    <div class="room-rating">
                                                                        <ul>
                                                                            @for ($i = 0; $i < $comment->rating; $i++)
                                                                                <li><i class="fa fa-star"></i></li>
                                                                            @endfor
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="comment-content">
                                                                    {{ $comment->body }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('client.layouts.sidebar_rooms')
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <input type="hidden" id="booking_room_id" name="room_id" value="{{ $room->id }}">
                        <input type="hidden" id="booking_price" name="price"
                               value="{{ ($room->sale_status == 1) ? $roomDetail->sale_price : $roomDetail->price }}">
                        <input type="hidden" id="booking-url" value="{{ route('client.booking.detailBooking') }}">
                        <div class="custom-quick-reservation-container">
                            <div class="custom-quick-reservation clearfix">
                                <div class="reserve-form-area">
                                    <label class="my-label">{{ trans('messages.Check_in_day') }}</label>
                                    <input type="text" id="detail_check_in" name="check_in"
                                           data-date-format="mm/dd/yyyy"
                                           class="date-selector" placeholder="&#xf073;" autocomplete="off"/>
                                    <label class="my-label">{{ trans('messages.Check_out_day') }}</label>
                                    <input type="text" id="detail_check_out" name="check_out"
                                           data-date-format="mm/dd/yyyy"
                                           class="date-selector" placeholder="&#xf073;" autocomplete="off"/>
                                    <div class="button-style-3">
                                        <button type="submit" class="btn-book">{{ trans('messages.Book_now') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('bower_components/bower/js/comment.js') }}"></script>
    <script src="{{ asset('bower_components/bower/js/room.js') }}"></script>
@endsection
