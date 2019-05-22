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
                                    {{ __('messages.Room_table') }} - {{ $location->name }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <div class="m-section__content">
                                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8 order-2 order-xl-1">
                                            <div class="form-group m-form__group row align-items-center">
                                                <div class="col-md-4">
                                                    <div class="m-input-icon m-input-icon--left">
                                                        <form method="get"
                                                              action="{{ route('admin.rooms.index', $location->id) }}">
                                                            <input type="text" class="form-control m-input"
                                                                   name="keyword"
                                                                   placeholder="{{ __('messages.Search') }}">
                                                        </form>
                                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                                            <span><i class="la la-search"></i></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                            <a href="{{ route('admin.rooms.create', $location->id) }}"
                                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                                <span><i class="la la-plus"></i>{{ __('messages.Create_room') }}</span>
                                            </a>
                                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('messages.Feature_image') }}</th>
                                        <th>{{ __('messages.Room_name') }}</th>
                                        <th>{{ __('messages.Price') }}</th>
                                        <th>{{ __('messages.Rating') }}</th>
                                        <th>{{ __('messages.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php ($i = 1)
                                    @foreach($rooms as $room)
                                        <?php
                                        if (session('locale')) {
                                            $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
                                        } else {
                                            $roomDetail = $room->roomDetails()->where('lang_id', $base_lang_id)->first();
                                        }
                                        ?>
                                        @if ($roomDetail != null)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>
                                                    <img src="{{ asset(config('upload.rooms')) }}/{{ $room->image }}"
                                                         class="image_table"></td>
                                                <td>{{ $roomDetail->name }}</td>
                                                <td class="price">{{ $roomDetail->price }} {{ __('messages.currency') }}</td>
                                                <td>{{ $room->rating }} {{ __('messages.star') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.rooms.edit', [$location->id, $room->id]) }}"
                                                       class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                                       title="{{ __('messages.Edit') }}"><i class="la la-edit"></i></a>
                                                    <form method="post" action=""
                                                          class="form_content" id="form-delete-{{ $roomDetail->id }}">
                                                        {{ method_field('DELETE') }}
                                                        @csrf
                                                        <button id="{{ $roomDetail->id }}" type="submit"
                                                                class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-delete"
                                                                title="{{ __('messages.Delete') }}">
                                                            <i class="la la-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @php($i++)
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $rooms->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
