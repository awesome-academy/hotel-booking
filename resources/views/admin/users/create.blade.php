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
                                    {{ __('messages.create_user') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <div class="m-section__content">
                                <form method="post" action="{{ route('admin.users.store') }}">
                                    @csrf
                                    <div class="form-group m-form__group m--margin-top-10">
                                        <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                            {{ __('messages.must_fill_*') }}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Email') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="email"
                                               placeholder="{{ __('messages.Enter_Email') }}"
                                               value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <b class="text-danger">{{ $errors->first('email') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Fullname') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="full_name"
                                               placeholder="{{ __('messages.Enter_fullname') }}"
                                               value="{{ old('full_name') }}">
                                        @if ($errors->has('full_name'))
                                            <b class="text-danger">{{ $errors->first('full_name') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Password') }} <b class="text-danger">*</b></label>
                                        <input type="password" class="form-control m-input" name="password"
                                               placeholder="{{ __('messages.Enter_password') }}">
                                        @if ($errors->has('password'))
                                            <b class="text-danger">{{ $errors->first('password') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Re-Password') }} <b class="text-danger">*</b></label>
                                        <input type="password" class="form-control m-input" name="password_confirmation"
                                               placeholder="{{ __('messages.Re-Password') }}">
                                        @if ($errors->has('password_confirmation'))
                                            <b class="text-danger">{{ $errors->first('password_confirmation') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Role') }}</label>
                                        <select class="form-control" name="role_id">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Phone') }}</label>
                                        <input type="text" class="form-control m-input" name="phone"
                                               placeholder="{{ __('messages.Enter_phone') }}"
                                               value="{{ old('phone') }}">
                                        @if ($errors->has('phone'))
                                            <b class="text-danger">{{ $errors->first('phone') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Address') }}</label>
                                        <input type="text" class="form-control m-input" name="address"
                                               placeholder="{{ __('messages.Enter_address') }}"
                                               value="{{ old('address') }}">
                                        @if ($errors->has('address'))
                                            <b class="text-danger">{{ $errors->first('address') }}</b>
                                        @endif
                                    </div>
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
