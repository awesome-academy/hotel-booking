@extends('client.layouts.master')
@section('content')
<div class="breadcrumb breadcrumb-1 pos-center">
    <h1>{{ __('messages.BLOG') }}</h1>
</div>
<div class="content"><!-- Content Section -->
    <div class="container">
        <div class="row">
            <br>
            <div class="col-lg-12 marginb20"><!-- Room Sort -->
                <div class="sortby clearfix">
                    <p>{{ __('messages.hover') }}</p>
                </div>
                </div>
                @if (isset($cates))
                @foreach ($cates as $cate)          
                <div class="col-lg-4 col-sm-6 clearfix">
                    <div class="home-room-box clearfix">
                        <div class="room-image">
                            <img alt="Room Images" class="img-responsive" src="{{ $cate->image }}">
                            <div class="home-room-details">
                                <h5>{{ __('messages.Category') }}: {{ $cate->name }}</h5>
                                <div class="pull-left">
                                    <ul>
                                        @if (isset($cate_child))
                                        @foreach ($cate_child as $child)
                                        <li>
                                            <a href="{{ asset('') }}blog/list/{{ $child->id }}"><span class="child_cate">{{ $child->name }}</span></a>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="pull-right room-rating">
                                    <ul>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star inactive"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
        </div>
    </div>
</div>
@endsection
