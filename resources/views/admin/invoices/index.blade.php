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
                                    {{ __('messages.Invoices_table') }}
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
                                                              action="{{ route('admin.invoices.index') }}">
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
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('messages.Invoice_code') }}</th>
                                        <th>{{ __('messages.Customer_info') }}</th>
                                        <th>{{ __('messages.Invoice_info') }}</th>
                                        <th>{{ __('messages.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php ($i = 1)
                                    @foreach ($invoices as $invoice)
                                        <?php
                                        $room = $invoice->rooms()->first();
                                        if (session('locale')) {
                                            $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
                                            if (is_null($roomDetail)) {
                                                $roomDetail = $room->roomDetails()->where('lang_id', $base_lang_id)->first();
                                            }
                                        } else {
                                            $roomDetail = $room->roomDetails()->where('lang_id', $base_lang_id)->first();
                                        }
                                        $pivot = $room->pivot;
                                        ?>
                                        @if (!is_null($room))
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $invoice->code }}</td>
                                                <td>
                                                    <p>{{ $invoice->customer_name }}</p>
                                                    <p>{{ $invoice->customer_email }}</p>
                                                    <p>{{ $invoice->customer_phone }}</p>
                                                    <p>{{ $invoice->customer_address }}</p>
                                                </td>
                                                <td>
                                                    <p><span>{{ __('messages.Name') }}: </span>{{ $roomDetail->name }}
                                                    </p>
                                                    <p><span>{{ __('messages.Room_number') }}
                                                            : </span>{{ $pivot->room_number }}</p>
                                                    <p><span>{{ __('messages.Check_in_day') }}
                                                            : </span>{{ $pivot->check_in_date }}</p>
                                                    <p><span>{{ __('messages.Check_out_day') }}
                                                            : </span>{{ $pivot->check_out_date }}</p>
                                                    <p class="price"><span>{{ __('messages.Price') }}
                                                            : </span>{{ $pivot->price }}
                                                        <span>{{ $pivot->currency }}</span></p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.invoices.show', $invoice->id) }}"
                                                       class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill"
                                                       title="{{ __('messages.See_more') }}"><i
                                                                class="la la-eye"></i></a>
                                                    <a href="javascript:;" linkurl="{{ route('admin.invoices.delete', $invoice->id) }}"
                                                       class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill btn-delete"
                                                       title="{{ __('messages.Delete') }}"><i
                                                                class="la la-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                        @php ($i++)
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('bower_components/bower/admin/custom/js/invoice.js') }}"></script>
@endsection
