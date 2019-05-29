@extends('admin.layouts.master')
@section('content')
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet">
                    <div class="m-portlet__body m-portlet__body--no-padding">
                        <div class="m-invoice-2">
                            <div class="m-invoice__wrapper">
                                <div class="m-invoice__head">
                                    <div class="m-invoice__container m-invoice__container--centered">
                                        <div class="m-invoice__logo">
                                            <a href="#">
                                                <h1>{{ __('messages.Invoice') }}</h1>
                                            </a>
                                        </div>
                                        <div class="m-invoice__items">
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{ __('messages.Time') }}</span>
                                                <span class="m-invoice__text">{{ __('messages.Check_in_day') }}
                                                    : {{ $pivot->check_in_date }}</span>
                                                <span class="m-invoice__text">{{ __('messages.Check_out_day') }}
                                                    : {{ $pivot->check_out_date }}</span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{ __('messages.Invoice_code') }}</span>
                                                <span class="m-invoice__text">{{ $invoice->code }}</span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{ __('messages.Customer_info')}}</span>
                                                <span class="m-invoice__text">{{ $invoice->customer_name }}</span>
                                                <span class="m-invoice__text">{{ $invoice->customer_email }}</span>
                                                <span class="m-invoice__text">{{ $invoice->customer_phone }}</span>
                                                <span class="m-invoice__text">{{ $invoice->customer_address }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-invoice__body m-invoice__body--centered">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>{{ __('messages.Feature_image') }}</th>
                                                <th>{{ __('messages.Name') }}</th>
                                                <th>{{ __('messages.Room_number') }}</th>
                                                <th>{{ __('messages.Price_in_invoice') }}</th>
                                                <th>{{ __('messages.Price_in_room') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <img class="img-invoice" src="{{ asset(config('upload.rooms')) }}/{{ $room->image }}">
                                                </td>
                                                <td>{{ $roomDetail->name }}</td>
                                                <td>{{ $pivot->room_number }}</td>
                                                <td class="price">{{ $pivot->price }} {{ $pivot->currency }}</td>
                                                <td class="price">{{ $roomDetail->price }} {{ __('messages.currency') }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="m-invoice__head">
                                    <div class="m-invoice__container m-invoice__container--centered">
                                        <div class="m-invoice__logo">
                                            <a href="#">
                                                <h2>{{ __('messages.Messages') }}</h2>
                                            </a>
                                        </div>
                                        <div class="m-invoice__items">
                                            {{ $invoice->messages }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
