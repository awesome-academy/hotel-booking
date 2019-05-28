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
                                    {{ __('messages.Create_translate_from') }} <b
                                            class="text-danger">{{ $parent->name }}</b> - {{ __('messages.location') }}
                                    : {{ $location->name }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <div class="m-section__content">
                                <form method="post" action="{{ route('admin.rooms.translate.store', [$location->id]) }}">
                                    @csrf
                                    <div class="form-group m-form__group m--margin-top-10">
                                        <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                            {{ __('messages.must_fill_*') }}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Select_languages') }} <b
                                                    class="text-danger">*</b></label>
                                        <select class="form-control m-input" name="lang_id">
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Room_name') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="name"
                                               placeholder="{{ __('messages.Enter_room_name') }}"
                                               value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                            <b class="text-danger">{{ $errors->first('name') }}</b>
                                        @endif
                                        @if (session('name_used'))
                                            <b class="text-danger">{{ __('messages.Name_used') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label>{{ __('messages.Price') }}</label>
                                            <div class="m-input-icon m-input-icon--right">
                                                <input type="text" class="form-control m-input" name="price"
                                                       placeholder="{{ __('messages.Enter_price') }}"
                                                       value="{{ old('price') }}">
                                            </div>
                                            @if ($errors->has('price'))
                                                <b class="text-danger">{{ $errors->first('price') }}</b>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="">{{ __('messages.Sale_price') }}</label>
                                            <div class="m-input-icon m-input-icon--right">
                                                <input type="text" class="form-control m-input" name="sale_price"
                                                       placeholder="{{ __('messages.Enter_sale_price') }}"
                                                       value="{{ old('sale_price') }}">
                                            </div>
                                            @if ($errors->has('sale_price'))
                                                <b class="text-danger">{{ $errors->first('sale_price') }}</b>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Short_description') }} <b
                                                    class="text-danger">*</b></label>
                                        <textarea class="form-control" name="short_description"
                                                  rows="10">{{ old('short_description') }}</textarea>
                                        @if ($errors->has('short_description'))
                                            <b class="text-danger">{{ $errors->first('short_description') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Description') }} <b class="text-danger">*</b></label>
                                        <textarea class="form-control" name="description"
                                                  id="description">{{ old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <b class="text-danger">{{ $errors->first('description') }}</b>
                                        @endif
                                    </div>
                                    <input type="hidden" name="lang_parent_id" value="{{ $parent->id }}">
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                    <div class="form-group m-form__group">
                                        <button class="btn btn-primary">{{ __('messages.Create') }}</button>
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
@section('script')
    <script type="text/javascript" src="{{ asset('bower_components/bower/admin/custom/js/room.js') }}"></script>
@endsection
