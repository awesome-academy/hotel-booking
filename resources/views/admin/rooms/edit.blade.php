@extends('admin.layouts.master')
@section('content')
    <div class="m-content">
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{ $location->name }} - {{ $roomDetail->name }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <div class="m-section__content">
                                <form method="post" action="{{ route('admin.rooms.update', [$location->id, $roomDetail->id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group m-form__group m--margin-top-10">
                                        <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                            {{ __('messages.must_fill_*') }}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Feature_image') }}</label>
                                        <br>
                                        <img id="is_image"
                                             src="{{ asset(config('upload.rooms')) }}/{{ $room->image }}"
                                             class="admin-image-500">
                                        <div></div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="select_image" name="image"
                                                   accept="image/*">
                                            <label class="custom-file-label" for="selectImage">{{ __('messages.Select_image') }}</label>
                                        </div>
                                        @if ($errors->has('image'))
                                            <p class="text-danger">{{$errors->first('image')}}</p>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Room_name') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="name"
                                               placeholder="{{ __('messages.Enter_room_name') }}"
                                               value="{{ old('name', $roomDetail->name) }}">
                                        @if ($errors->has('name'))
                                            <b class="text-danger">{{ $errors->first('name') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.List_room_number') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="list_room_number"
                                               placeholder="{{ __('messages.Enter_list_room_number') }}"
                                               value="{{ old('list_room_number', $room->list_room_number) }}">
                                        @if ($errors->has('list_room_number'))
                                            <b class="text-danger">{{ $errors->first('list_room_number') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label>{{ __('messages.Price') }}</label>
                                            <div class="m-input-icon m-input-icon--right">
                                                <input type="text" class="form-control m-input" name="price"
                                                       placeholder="{{ __('messages.Enter_price') }}" value="{{ old('price', $roomDetail->price) }}">
                                            </div>
                                            @if ($errors->has('price'))
                                                <b class="text-danger">{{ $errors->first('price') }}</b>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="">{{ __('messages.Sale_price') }}</label>
                                            <div class="m-input-icon m-input-icon--right">
                                                <input type="text" class="form-control m-input" name="sale_price"
                                                       placeholder="{{ __('messages.Enter_sale_price') }}" value="{{ old('sale_price', $roomDetail->sale_price) }}">
                                            </div>
                                            @if ($errors->has('sale_price'))
                                                <b class="text-danger">{{ $errors->first('sale_price') }}</b>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label>{{ __('messages.Sale_start_at') }}</label>
                                            <div class="m-input-icon m-input-icon--right">
                                                <input type="text" class="form-control m-input my-datepicker" value="{{ old('sale_start_at', $room->sale_start_at) }}" name="sale_start_at" autocomplete="off">
                                            </div>
                                            @if ($errors->has('sale_start_at'))
                                                <b class="text-danger">{{ $errors->first('sale_start_at') }}</b>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="">{{ __('messages.Sale_price') }}</label>
                                            <div class="m-input-icon m-input-icon--right">
                                                <input type="text" class="form-control m-input my-datepicker" value="{{ old('sale_end_at', $room->sale_end_at) }}" name="sale_end_at" autocomplete="off">
                                            </div>
                                            @if ($errors->has('sale_end_at'))
                                                <b class="text-danger">{{ $errors->first('sale_end_at') }}</b>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Short_description') }} <b class="text-danger">*</b></label>
                                        <textarea class="form-control" name="short_description" rows="10">{{ old('short_description', $roomDetail->short_description) }}</textarea>
                                        @if ($errors->has('short_description'))
                                            <b class="text-danger">{{ $errors->first('short_description') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Description') }} <b class="text-danger">*</b></label>
                                        <textarea class="form-control" name="description" id="description">{{ old('description', $roomDetail->description) }}</textarea>
                                        @if ($errors->has('description'))
                                            <b class="text-danger">{{ $errors->first('description') }}</b>
                                        @endif
                                    </div>
                                    <input type="hidden" name="old_image" value="{{ $room->image }}">
                                    <div class="form-group m-form__group">
                                        <button class="btn btn-primary">{{ __('messages.Edit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
