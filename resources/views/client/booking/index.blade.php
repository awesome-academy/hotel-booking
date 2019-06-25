@extends('client.layouts.master')
@section('breadcumb')
    {{ __('messages.Checkout') }}
@endsection
@section('content')
    @include('client.layouts.page-breadcumb')
    <div class="container">
        <div class="row margint40">
            <div class="col-md-6">
                <form method="post" action="{{ route('client.booking.checkout') }}">
                    @csrf
                    <div class="form-group">
                        <label class="my-label">{{ __('messages.Fullname') }}</label>
                        <input type="text" class="form-control" name="customer_name"
                               value="{{ old('customer_name', $user->full_name) }}">
                        @if ($errors->has('customer_name'))
                            <p class="text-danger">{{ $errors->first('customer_name') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="my-label">{{ __('messages.Email') }}</label>
                        <input type="text" class="form-control" name="customer_email"
                               value="{{ old('customer_email', $user->email) }}">
                        @if ($errors->has('customer_email'))
                            <p class="text-danger">{{ $errors->first('customer_email') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="my-label">{{ __('messages.Phone') }}</label>
                        <input type="text" class="form-control" name="customer_phone"
                               value="{{ old('customer_phone', $user->phone) }}" }}>
                        @if ($errors->has('customer_phone'))
                            <p class="text-danger">{{ $errors->first('customer_phone') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="my-label">{{ __('messages.Address') }}</label>
                        <input type="text" class="form-control" name="customer_address"
                               value="{{ old('customer_address', $user->address) }}">
                        @if ($errors->has('customer_address'))
                            <p class="text-danger">{{ $errors->first('customer_address') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="my-label">{{ __('messages.Messages') }}</label>
                        <textarea class="form-control" name="messages" rows="10">{{ old('messages') }}</textarea>
                    </div>
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    <input type="hidden" name="check_in_date" value="{{ $info['check_in'] }}">
                    <input type="hidden" name="price" value="{{ $info['price'] }}">
                    <input type="hidden" name="check_out_date" value="{{ $info['check_out'] }}">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="currency" value="{{ __('messages.currency') }}">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ __('messages.Submit') }}</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <h2 class="reservation__title">{{ __('messages.Info_booking') }}</h2>
                <div class="col-md-6">
                    <span class="reservation-date__title">{{ __('messages.Check_in_day') }}</span>
                    <div class="reservation-date__date">
                        {{ $info['check_in'] }}
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="reservation-date__title">{{ __('messages.Check_out_day') }}</span>
                    <div class="reservation-date__date">
                        {{ $info['check_out'] }}
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="my-label">{{ __('messages.location') }}</label>
                    {{ $location->name }}
                </div>
                <div class="col-md-12">
                    <label class="my-label">{{ __('messages.Feature_image') }}</label>
                    <img src="{{ config('upload.rooms') }}/{{ $room->image }}" class="img-responsive">
                </div>
                <div class="col-md-12">
                    <label class="my-label">{{ __('messages.Name') }}</label>
                    {{ $roomDetail->name }}
                </div>
                <div class="col-md-12">
                    <label class="my-label">{{ __('messages.Price') }}</label>
                    @if ($room->sale_status == 1)
                        <del class="text-danger price">{{ $roomDetail->price }} {{ __('messages.currency') }}</del>
                        <p class="text-success price">{{ $roomDetail->sale_price }} {{ __('messages.currency') }}</p>
                    @else
                        <p class="text-success price">{{ $roomDetail->price }} {{ __('messages.currency') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
