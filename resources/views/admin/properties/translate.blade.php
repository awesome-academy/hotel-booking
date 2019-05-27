@extends('admin.layouts.master')
@section('content')
    <div class="m-content">
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{ __('messages.Create_translate') }} - {{ $property->name }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <div class="m-section__content">
                                <form method="post" action="{{ route('admin.properties.translateStore', $property->id) }}">
                                    @csrf
                                    <div class="form-group m-form__group m--margin-top-10">
                                        <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                            {{ __('messages.must_fill_*') }}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Select_languages') }} <b
                                                    class="text-danger">*</b></label>
                                        <select name="lang_id" class="form-control">
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Name') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="name"
                                               value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                            <b class="text-danger">{{ $errors->first('name') }}</b>
                                        @endif
                                    </div>
                                    <input type="hidden" name="lang_parent_id" value="{{ $property->id }}">
                                    <div class="form-group m-form__group">
                                        <button type="submit" class="btn btn-primary">{{ __('messages.Create') }}</button>
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
