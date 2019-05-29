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
                                   {{ __('messages.Websetting') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <div class="m-section__content">
                                <form method="post" action="{{ route('admin.web-setting.update', $web->id) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group m-form__group m--margin-top-10">
                                        <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                            {{ __('messages.must_fill_*') }}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Logo') }} <b class="text-danger">*</b></label>
                                        <br>
                                        <img id="is_image"
                                             src="{{ asset(config('upload.logo')) }}/{{ $web->logo }}"
                                             class="admin-image-300">
                                        <div></div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="select_image" name="logo"
                                                   accept="image/*">
                                            <label class="custom-file-label"
                                                   for="selectImage">{{ __('messages.Select_image') }}</label>
                                        </div>
                                        @if ($errors->has('logo'))
                                            <p class="text-danger">{{ $errors->first('logo') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('Facebook') }}</label>
                                        <input type="text" class="form-control m-input" name="facebook" value="{{ old('facebook', $web->facebook) }}">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('Twitter') }}</label>
                                        <input type="text" class="form-control m-input" name="twitter" value="{{ old('twitter', $web->twitter) }}">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('Instagram') }}</label>
                                        <input type="text" class="form-control m-input" name="instagram" value="{{ old('instagram', $web->instagram) }}">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('Linkedin') }}</label>
                                        <input type="text" class="form-control m-input" name="linkedin" value="{{ old('linkedin', $web->linkedin) }}">
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('Tripadvisor') }}</label>
                                        <input type="text" class="form-control m-input" name="tripadvisor" value="{{ old('tripadvisor', $web->tripadvisor) }}">
                                    </div>
                                    <input type="hidden" name="old_logo" value="{{ $web->logo }}">
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
