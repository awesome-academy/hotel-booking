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
                                    {{ __('messages.users_table') }}
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
                                                        <form method="get" action="{{ route('admin.users.index') }}">
                                                            <input type="text" class="form-control m-input"
                                                                   name="keyword"
                                                                   placeholder="{{ __('messages.Search') }}">
                                                        </form>
                                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                                            <i class="la la-search search-item"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                            <a href="{{ route('admin.users.create') }}"
                                               class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                                <span><i class="la la-user-plus"></i>{{ __('messages.create_user') }}</span>
                                            </a>
                                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('messages.Email') }}</th>
                                        <th>{{ __('messages.Fullname') }}</th>
                                        <th>{{ __('messages.Role') }}</th>
                                        <th>{{ __('messages.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php ($i = 1)
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->full_name }}</td>
                                            <td>
                                                @php ($role = $user->role()->first())
                                                {{ $role->name }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                   class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                                   title="{{ __('messages.Edit') }}"><i class="la la-edit"></i></a>
                                                <form method="post" action="{{ route('admin.users.destroy', $user->id) }}" class="form_content" id="form-delete-{{$user->id}}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button id="{{ $user->id }}" type="submit"
                                                            class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill btn-submit"
                                                            title="{{ __('messages.Delete') }}">
                                                        <i class="la la-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @php ($i++)
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $users->links() }}
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
            $('.btn-submit').on('click', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var form = $('#form-delete-' + id);
                swal({
                    title: "{{ __('messages.Are_you_sure') }}",
                    text: "",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "{{ __('messages.Cancel') }}",
                    confirmButtonText: "{{ __('messages.Im_sure') }}"
                }).then(function (e) {
                    e.value && form.submit();
                })
            })
        });
        @if(session('store'))
        swal('{{ __('messages.Store_success') }}', '', 'success');
        @endif
        @if(session('delete'))
        swal('{{ __('messages.Delete_success') }}', '', 'success');
        @endif
        @if(session('delete-error'))
        swal('{{ __('messages.Got_errors') }}', '', 'error');
        @endif
    </script>
@endsection
