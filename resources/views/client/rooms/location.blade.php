@extends('client.layouts.master')
@section('breadcumb')
    {{ $location->name }}
@endsection
@section('content')
    @include('client.layouts.page-breadcumb')
    <div class="content"><!-- Content Section -->
        <div class="container margint60">
            <div class="row">
                <div class="col-lg-9"><!-- Explore Rooms -->
                    <table>
                        <tr class="products-title">
                            <td class="table-products-image pos-center"><h6>{{ __('messages.Feature_image') }}</h6></td>
                            <td class="table-products-name pos-center"><h6>{{ __('messages.Name') }}</h6></td>
                            <td class="table-products-price pos-center"><h6>{{ __('messages.Price') }}</h6></td>
                            <td class="table-products-total pos-center"><h6>{{ __('messages.See_more') }}</h6></td>
                        </tr>
                        <?php
                        $rooms = $location->rooms()->orderBy('id', 'desc')->paginate(config('pagination.default'));
                        ?>
                        @foreach ($rooms as $room)
                            <?php
                            $rating = $room->rating;
                            if (session('locale')) {
                                $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
                            } else {
                                $roomDetail = $room->roomDetails()->where('lang_id', $base_lang_id)->first();
                            }
                            ?>
                            @if (!is_null($roomDetail))
                                <tr class="table-products-list pos-center">
                                    <td class="products-image-table">
                                        <img alt="Products Image 1"
                                             src="{{ asset(config('upload.rooms')) }}/{{ $room->image }}"
                                             class="img-responsive"></td>
                                    <td class="title-table">
                                        <div class="room-details-list clearfix">
                                            <div class="pull-left">
                                                <h5>{{ $roomDetail->name }}</h5>
                                            </div>
                                            <div class="pull-left room-rating">
                                                <ul>
                                                    @for ($i = 0; $i < floor($rating); $i++)
                                                        <li><i class="fa fa-star"></i></li>
                                                    @endfor
                                                        <li>({{ $room->rating }})</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p>{{ $roomDetail->short_description }}</p>
                                    </td>
                                    <td>
                                        @if ($room->sale_start == 1)
                                            <del class="text-danger price">{{ $roomDetail->price }} {{ __('messages.currency') }}</del>
                                            <p class="text-success price">{{ $roomDetail->sale_price }} {{ __('messages.currency') }}</p>
                                        @else
                                            <p class="text-success price">{{ $roomDetail->price }} {{ __('messages.currency') }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="button-style-1">
                                            <a href="{{ route('client.rooms.detail', $room->id) }}">
                                                <span class="mobile-visibility">{{ __('messages.See_more') }}</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                    {{ $rooms->links() }}
                </div>
                @include('client.layouts.sidebar_rooms')
            </div>
        </div>
    </div>
@endsection
