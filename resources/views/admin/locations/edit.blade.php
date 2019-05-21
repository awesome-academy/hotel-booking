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
                                    {{ $location->name }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <div class="m-section__content">
                                <form method="post" action="{{ route('admin.locations.update', $location->id) }}">
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="id" value="{{ $location->id }}">
                                    @csrf
                                    <div class="form-group m-form__group m--margin-top-10">
                                        <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                            {{ __('messages.must_fill_*') }}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Location_name') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="name"
                                               placeholder="{{ __('messages.Enter_location_name') }}"
                                               value="{{ old('name', $location->name) }}">
                                        @if ($errors->has('name'))
                                            <b class="text-danger">{{ $errors->first('name') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Email') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="email"
                                               placeholder="{{ __('messages.Enter_Email') }}"
                                               value="{{ old('email', $location->email) }}">
                                        @if ($errors->has('email'))
                                            <b class="text-danger">{{ $errors->first('email') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Provinces') }} <b class="text-danger">*</b></label>
                                        <select class="form-control m-input" name="province_id" id="province_id">
                                            @foreach ($provinces as $province)
                                                <option></option>
                                                <option value="{{ $province->id }}" @if ($province->id == $location->province_id){{ 'selected' }}@endif>{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('province_id'))
                                            <b class="text-danger">{{ $errors->first('province_id') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Phone') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="phone"
                                               placeholder="{{ __('messages.Enter_phone') }}"
                                               value="{{ old('phone', $location->phone) }}">
                                        @if ($errors->has('phone'))
                                            <b class="text-danger">{{ $errors->first('phone') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Address') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="address"
                                               placeholder="{{ __('messages.Enter_address') }}"
                                               value="{{ old('address', $location->address) }}">
                                        @if ($errors->has('address'))
                                            <b class="text-danger">{{ $errors->first('address') }}</b>
                                        @endif
                                    </div>
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
@section('script')
    <script>
        $(document).ready(function () {
            $("#province_id").select2({placeholder: "{{ __('messages.Select_provinces') }}"});
        });

        @if (session('update'))
            swal('{{ __('messages.Update_success') }}', '', 'success');
        @endif
    </script>
@endsection
