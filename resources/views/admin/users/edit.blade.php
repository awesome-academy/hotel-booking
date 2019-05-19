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
                                    {{ __('messages.Edit_user') }}: {{ $user->full_name }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section">
                            <div class="m-section__content">
                                <form method="post" action="{{ route('admin.users.update', $user->id) }}">
                                    @method('put')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <div class="form-group m-form__group m--margin-top-10">
                                        <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                            {{ __('messages.must_fill_*') }}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Email') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="email"
                                               value="{{ old('email', $user->email) }}">
                                        @if ($errors->has('email'))
                                            <b class="text-danger">{{ $errors->first('email') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Fullname') }} <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control m-input" name="full_name"
                                               value="{{ old('full_name', $user->full_name) }}">
                                        @if ($errors->has('full_name'))
                                            <b class="text-danger">{{ $errors->first('full_name') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Role') }}</label>
                                        <select class="form-control" name="role_id">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" @if ($role->id == $user->role_id){{ 'selected' }}@endif>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Phone') }}</label>
                                        <input type="text" class="form-control m-input" name="phone"
                                               value="{{ old('phone', $user->phone) }}">
                                        @if ($errors->has('phone'))
                                            <b class="text-danger">{{ $errors->first('phone') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>{{ __('messages.Address') }}</label>
                                        <input type="text" class="form-control m-input" name="address"
                                               value="{{ old('address', $user->address) }}">
                                        @if ($errors->has('address'))
                                            <b class="text-danger">{{ $errors->first('address') }}</b>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <button type="submit" class="btn btn-primary">{{ __('messages.Edit') }}</button>
                                        <a href="javascript:;" class="btn btn-warning" data-toggle="modal"
                                           data-target="#m_modal">{{ __('messages.Change_password') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.Change_password') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group">
                            <label class="form-control-label">{{ __('messages.Old_password') }}</label>
                            <input type="password" class="form-control" id="old_password" name="old_password">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">{{ __('messages.New_password') }}</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">{{ __('messages.Re_new_password') }}</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                        <input type="hidden" id="id" value="{{ $user->id }}">
                        <button type="button" class="btn btn-primary change_password">{{ __('messages.Edit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            $('.change_password').click(function (e) {
                e.preventDefault();
                var id = $('#id').val();
                var old_password = $('#old_password').val();
                var password = $('#password').val();
                var password_confirmation = $('#password_confirmation').val();
                var formData = new FormData();
                formData.append('id', id);
                formData.append('old_password', old_password);
                formData.append('password', password);
                formData.append('password_confirmation', password_confirmation);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    contentType: false,
                    processData: false,
                    url: '{{route('admin.users.changepassword')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function (response) {
                        if (response.messages == 'errors') {
                            if (response.errors.old_password) {
                                toastr.error(response.errors['old_password'], '{{ __('messages.Warning') }}');
                            } else if (response.errors.password) {
                                toastr.error(response.errors['password'], '{{ __('messages.Warning') }}');
                            } else if (response.errors.password_confirmation) {
                                toastr.error(response.errors['password_confirmation'], '{{ __('messages.Warning') }}');
                            }
                        }
                        if (response.errors == 'wrong_old_password') {
                            toastr.error(response.messages, '{{ __('messages.Warning') }}');
                        }
                        if (response.errors == 'user_not_found') {
                            toastr.error(response.messages, '{{ __('messages.Warning') }}');
                        }
                        if (response.messages == 'success'){
                            toastr.success('{{ __('messages.Change_password_successfully') }}', '{{ __('messages.success') }}');
                        };
                    }, error: function () {
                        toastr.error('{{ __('messages.Got_errors') }}', '{{ __('messages.Warning') }}');
                    },
                });
            })
        });

        @if (session('update'))
        swal('{{ __('messages.Update_success') }}', '', 'success');
        @endif
    </script>
@endsection
