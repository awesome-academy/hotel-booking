@extends('client.layouts.master')
@section('breadcumb')
@endsection
@section('content')
    <div class="container margint40">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <ul class="nav nav-pills nav-pills-success nav-stacked">
                    <li class="active"><a data-toggle="pill" href="#profile">{{ __('messages.Profile') }}</a></li>
                    <li><a data-toggle="pill" href="#invoice">{{ __('messages.Invoices_table') }}</a></li>
                </ul>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="tab-content">
                    <div id="profile" class="tab-pane fade in active">
                        <form method="post" action="{{ route('client.users.update', $user->id) }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="form-group m-form__group m--margin-top-10">
                                <div class="alert alert-danger m-alert m-alert--default" role="alert">
                                    {{ __('messages.must_fill_*') }}
                                </div>
                            </div>
                            <div class="form-group m-form__group">
                                <label class="my-label">{{ __('messages.Email') }} <b class="text-danger">*</b></label>
                                <input type="text" class="form-control m-input" name="email"
                                       value="{{ old('email', $user->email) }}">
                                @if ($errors->has('email'))
                                    <b class="text-danger">{{ $errors->first('email') }}</b>
                                @endif
                            </div>
                            <div class="form-group m-form__group">
                                <label class="my-label">{{ __('messages.Fullname') }} <b
                                            class="text-danger">*</b></label>
                                <input type="text" class="form-control m-input" name="full_name"
                                       value="{{ old('full_name', $user->full_name) }}">
                                @if ($errors->has('full_name'))
                                    <b class="text-danger">{{ $errors->first('full_name') }}</b>
                                @endif
                            </div>
                            <div class="form-group m-form__group">
                                <label class="my-label">{{ __('messages.Phone') }}</label>
                                <input type="text" class="form-control m-input" name="phone"
                                       value="{{ old('phone', $user->phone) }}">
                                @if ($errors->has('phone'))
                                    <b class="text-danger">{{ $errors->first('phone') }}</b>
                                @endif
                            </div>
                            <div class="form-group m-form__group">
                                <label class="my-label">{{ __('messages.Address') }}</label>
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
                    <div id="invoice" class="tab-pane fade in">
                        @foreach ($invoices as $invoice)
                            @php
                                $detail = $invoice->rooms()->first();
                                if (session('locale')) {
                                    $roomDetail = $detail->roomDetails()->where('lang_id', session('locale'))->first();
                                    if (!$roomDetail) {
                                        $roomDetail = $detail->roomDetails()->where('lang_id', $base_lang_id)->first();
                                    } else {
                                        $roomDetail = $detail->roomDetails()->where('lang_id', $base_lang_id)->first();
                                    }
                                }
                                $pivot = $detail->pivot;
                            @endphp
                            <div class="invoice-item">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ __('messages.Invoice_code') }}</th>
                                            <th>{{ __('messages.Check_in_day') }}</th>
                                            <th>{{ __('messages.Check_out_day') }}</th>
                                            <th>{{ __('messages.Invoice_info') }}</th>
                                            <th id="customer-info-{{ $invoice->id }}">{{ __('messages.Customer_info') }}
                                                <button class="btn btn-primary btn-customer-info" data-toggle="modal"
                                                        data-target=".modal-customer-info"
                                                        url="{{ route('client.users.showInfo', $invoice->id) }}">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{ $invoice->code }}</td>
                                            <td>{{ $pivot->check_in_date }}</td>
                                            <td>{{ $pivot->check_out_date }}</td>
                                            <td>
                                                <p>{{ __('messages.Name') }}: {{ $roomDetail->name }}</p>
                                                <p>{{ __('messages.Room_number') }}: {{ $pivot->room_number }}</p>
                                                <p class="price">{{ __('messages.Price') }}
                                                    : {{ $pivot->price }} {{ $pivot->currency }}</p>
                                            </td>
                                            <td>
                                                <p id="invoice-customer-name-{{ $invoice->id }}">{{ $invoice->customer_name }}</p>
                                                <p id="invoice-customer-email-{{ $invoice->id }}">{{ $invoice->customer_email }}</p>
                                                <p id="invoice-customer-phone-{{ $invoice->id }}">{{ $invoice->customer_phone }}</p>
                                                <p id="invoice-customer-address-{{ $invoice->id }}">{{ $invoice->customer_address }}</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.Change_password') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="form-control-label my-label">{{ __('messages.Old_password') }}</label>
                            <input type="password" class="form-control" id="old_password" name="old_password">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label my-label">{{ __('messages.New_password') }}</label>
                            <input type="password" class="form-control" id="password-1" name="password">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label my-label">{{ __('messages.Re_new_password') }}</label>
                            <input type="password" class="form-control" id="password_confirmation-1"
                                   name="password_confirmation">
                        </div>
                        <input type="hidden" id="id" value="{{ $user->id }}">
                        <input type="hidden" id="url-password" value="{{ route('client.users.changepassword') }}">
                        <button type="button" class="btn btn-primary change_password">{{ __('messages.Edit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-customer-info" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.Edit_customer_info') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="my-label">{{ __('messages.Fullname') }}</label>
                            <input type="text" class="form-control" id="edit-invoice-customer-name" value="">
                        </div>
                        <div class="form-group">
                            <label class="my-label">{{ __('messages.Email') }}</label>
                            <input type="text" class="form-control" id="edit-invoice-customer-email" value="">
                        </div>
                        <div class="form-group">
                            <label class="my-label">{{ __('messages.Phone') }}</label>
                            <input type="text" class="form-control" id="edit-invoice-customer-phone" value="">
                        </div>
                        <div class="form-group">
                            <label class="my-label">{{ __('messages.Address') }}</label>
                            <input type="text" class="form-control" id="edit-invoice-customer-address" value="">
                        </div>
                        <input type="hidden" id="update-invoice-id">
                        <input type="hidden" id="update-invoice-url" value="{{ route('client.users.updateInfo') }}">
                        <div class="form-group">
                            <button class="btn btn-primary btn-update-invoice-customer-info">{{ __('messages.Edit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('bower_components/bower/js/invoice.js') }}"></script>
    <script src="{{ asset('bower_components/bower/js/changepassword.js') }}"></script>
@endsection
