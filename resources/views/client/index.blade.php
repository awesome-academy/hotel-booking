@extends('client.layouts.master')
@section('content')
<div class="slider slider-home"><!-- Slider Section -->
    <div class="flexslider slider-loading falsenav">
        <ul class="slides">
            <li>
                <div class="slider-textbox clearfix">
                    <div class="container">
                        <div class="row">
                            <div class="slider-bar pull-left">{{ trans('messages.Coming soon') }}</div>
                            <div class="slider-triangle pull-left"></div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="slider-bar-under pull-left">{{ trans('messages.Coming soon') }}</div>
                            <div class="slider-triangle-under pull-left"></div>
                        </div>
                    </div>
                </div>
                <img alt="Slider 1" class="img-responsive" src="" />
            </li>
            <li>
                <div class="slider-textbox clearfix">
                    <div class="container">
                        <div class="row">
                            <div class="slider-bar pull-left">{{ trans('messages.Coming soon') }}</div>
                            <div class="slider-triangle pull-left"></div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="slider-bar-under pull-left">{{ trans('messages.Coming soon') }}</div>
                            <div class="slider-triangle-under pull-left"></div>
                        </div>
                    </div>
                </div>
                <img alt="Slider 1" class="img-responsive" src="" />
            </li>
        </ul>
    </div>
    <div class="book-slider">
        <div class="container">
            <div class="row pos-center">
                <div class="reserve-form-area">
                    <form action="#" method="post" id="ajax-reservation-form">
                        <ul class="clearfix">
                            <li class="li-input">
                                <label>{{ trans('messages.Coming soon') }}</label>
                                <input type="text" id="dpd1" name="dpd1" data-date-format="dd/mm/yyyy" class="date-selector" placeholder="&#xf073;" required />
                            </li>
                            <li class="li-input">
                                <label>{{ trans('messages.Coming soon') }}</label>
                                <input type="text" id="dpd2" name="dpd2" data-date-format="dd/mm/yyyy" class="date-selector" placeholder="&#xf073;" required />
                            </li>
                            <li class="li-select">
                                <label>{{ trans('messages.Coming soon') }}</label>
                                <select name="rooms" class="pretty-select">
                                    <option selected="selected" value="1" >1</option>
                                    <option value="2">{{ trans('messages.Coming soon') }}</option>
                                    <option value="3">{{ trans('messages.Coming soon') }}</option>
                                    <option value="4">{{ trans('messages.Coming soon') }}</option>
                                    <option value="5">{{ trans('messages.Coming soon') }}</option>
                                </select>
                            </li>
                            <li class="li-select">
                                <label>{{ trans('messages.Coming soon') }}</label>
                                <select name="adult" class="pretty-select">
                                    <option selected="selected" value="1" >1</option>
                                    <option value="2">{{ trans('messages.Coming soon') }}</option>
                                    <option value="3">{{ trans('messages.Coming soon') }}</option>
                                    <option value="4">{{ trans('messages.Coming soon') }}</option>
                                    <option value="5">{{ trans('messages.Coming soon') }}</option>
                                </select>
                            </li>
                            <li class="li-select">
                                <label>{{ trans('messages.Coming soon') }}</label>
                                <select name="children" class="pretty-select">
                                    <option selected="selected" value="0" >{{ trans('messages.Coming soon') }}</option>
                                    <option value="1">{{ trans('messages.Coming soon') }}</option>
                                    <option value="2">{{ trans('messages.Coming soon') }}</option>
                                    <option value="3">{{ trans('messages.Coming soon') }}</option>
                                    <option value="4">{{ trans('messages.Coming soon') }}</option>
                                    <option value="5">{{ trans('messages.Coming soon') }}</option>
                                </select>
                            </li>
                            <li>
                                <div class="button-style-1">
                                    <a id="res-submit" href="#"><i class="fa fa-search"></i>{{ trans('messages.Coming soon') }}</a>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-book-slider">
        <div class="container">
            <div class="row pos-center">
                <ul>
                    <li><i class="fa fa-shopping-cart"></i>{{ trans('messages.Coming soon') }}</li>
                    <li><i class="fa fa-globe"></i>{{ trans('messages.Coming soon') }}</li>
                    <li><i class="fa fa-coffee"></i>{{ trans('messages.Coming soon') }}</li>
                    <li><i class="fa fa-windows"></i>{{ trans('messages.Coming soon') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="content"><!-- Content Section -->
    <div class="about clearfix"><!-- About Section -->
        <div class="container">
            <div class="row">
                <div class="about-title pos-center">
                    <h2>{{ trans('messages.Coming soon') }}</h2>
                    <div class="title-shape"><img alt="{{ trans('messages.Coming soon') }}" src=""></div>
                    <p>{{ trans('messages.Coming soon') }}<span class="active-color">{{ trans('messages.Coming soon') }}</span>{{ trans('messages.Coming soon') }}</p>
                </div>
                <div class="otel-info margint60">
                    <div class="col-lg-4 col-sm-12">
                        <div class="title-style-1 marginb40">
                            <h5>{{ trans('messages.Coming soon') }}</h5>
                            <hr>
                        </div>
                        <div class="flexslider">
                            <ul class="slides">
                                <li><img alt="Slider 1" class="img-responsive" src="" /></li>
                                <li><img alt="Slider 1" class="img-responsive" src="" /></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="title-style-1 marginb40">
                            <h5>{{ trans('messages.Coming soon') }}</h5>
                            <hr>
                        </div>
                        <p>{{ trans('messages.Coming soon') }}</p>
                        <p>{{ trans('messages.Coming soon') }}</p>
                        <p>{{ trans('messages.Coming soon') }}</p>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="title-style-1 marginb40">
                            <h5>{{ trans('messages.Coming soon') }}</h5>
                            <hr>
                        </div>
                        <div class="home-news">
                            <div class="news-box clearfix">
                                <div class="news-time pull-left">
                                    <div class="news-date pos-center"><div class="date-day">{{ trans('messages.Coming soon') }}<hr /></div>{{ trans('messages.Coming soon') }}</div>
                                </div>
                                <div class="news-content pull-left">
                                    <h6><a href="#">{{ trans('messages.Coming soon') }}</a></h6>
                                    <p class="margint10">{{ trans('messages.Coming soon') }}<a class="active-color" href="#">[...]</a></p>
                                </div>
                            </div>
                            <div class="news-box clearfix">
                                <div class="news-time pull-left">
                                    <div class="news-date pos-center">
                                        <div class="date-day">{{ trans('messages.Coming soon') }}<hr />
                                        </div>
                                        {{ trans('messages.Coming soon') }}
                                    </div>
                                </div>
                                <div class="news-content pull-left">
                                    <h6><a href="#">{{ trans('messages.Coming soon') }}</a></h6>
                                    <p class="margint10">{{ trans('messages.Coming soon') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="explore-rooms margint30 clearfix"><!-- Explore Rooms Section -->
        <div class="container">
            <div class="row">   
                <div class="title-style-2 marginb40 pos-center">
                    <h3>{{ trans('messages.Coming soon') }}</h3>
                    <hr>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="home-room-box">
                        <div class="room-image">
                            <img alt="Room Images" class="img-responsive" src="">
                            <div class="home-room-details">
                                <h5><a href="#">{{ trans('messages.Coming soon') }}</a></h5>
                                <div class="pull-left">
                                    <ul>
                                        <li><i class="fa fa-calendar"></i></li>
                                        <li><i class="fa fa-flask"></i></li>
                                        <li><i class="fa fa-umbrella"></i></li>
                                        <li><i class="fa fa-laptop"></i></li>
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
                        <div class="room-details">
                            <p>{{ trans('messages.Coming soon') }}</p>
                        </div>
                        <div class="room-bottom">
                            <div class="pull-left"><h4>{{ trans('messages.Coming soon') }}$<span class="room-bottom-time">/ {{ trans('messages.Coming soon') }}</span></h4></div>
                            <div class="pull-right">
                                <div class="button-style-1">
                                    <a href="#">{{ trans('messages.Coming soon') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="home-room-box">
                        <div class="room-image">
                            <img alt="Room Images" class="img-responsive" src="">
                            <div class="home-room-details">
                                <h5><a href="#">{{ trans('messages.Coming soon') }}</a></h5>
                                <div class="pull-left">
                                    <ul>
                                        <li><i class="fa fa-calendar"></i></li>
                                        <li><i class="fa fa-flask"></i></li>
                                        <li><i class="fa fa-umbrella"></i></li>
                                        <li><i class="fa fa-laptop"></i></li>
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
                        <div class="room-details">
                            <p>{{ trans('messages.Coming soon') }}</p>
                        </div>
                        <div class="room-bottom">
                            <div class="pull-left"><h4>{{ trans('messages.Coming soon') }}$<span class="room-bottom-time">/ {{ trans('messages.Coming soon') }}</span></h4></div>
                            <div class="pull-right">
                                <div class="button-style-1">
                                    <a href="#">{{ trans('messages.Coming soon') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="home-room-box">
                        <div class="room-image">
                            <div class="room-features">{{ trans('messages.Coming soon') }}</div>
                            <img alt="Room Images" class="img-responsive" src="">
                            <div class="home-room-details">
                                <h5><a href="#">{{ trans('messages.Coming soon') }}</a></h5>
                                <div class="pull-left">
                                    <ul>
                                        <li><i class="fa fa-calendar"></i></li>
                                        <li><i class="fa fa-flask"></i></li>
                                        <li><i class="fa fa-umbrella"></i></li>
                                        <li><i class="fa fa-laptop"></i></li>
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
                        <div class="room-details">
                            <p>{{ trans('messages.Coming soon') }}</p>
                        </div>
                        <div class="room-bottom">
                            <div class="pull-left"><h4>{{ trans('messages.Coming soon') }}$<span class="room-bottom-time">/ {{ trans('messages.Coming soon') }}</span></h4></div>
                            <div class="pull-right">
                                <div class="button-style-1">
                                    <a href="#">{{ trans('messages.Coming soon') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="parallax123" class="parallax parallax-one clearfix margint60"><!-- Parallax Section -->
        <div class="support-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-4">
                        <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                            <div class="flipper">
                                <div class="support-box pos-center front">
                                    <div class="support-box-title"><i class="fa fa-phone"></i></div>
                                    <h4>{{ trans('messages.Coming soon') }}</h4>
                                    <p class="margint20">{{ trans('messages.Coming soon') }}</p>
                                </div>
                                <div class="support-box pos-center back">
                                    <div class="support-box-title"><i class="fa fa-phone"></i></div>
                                    <h4>{{ trans('messages.Coming soon') }}</h4>
                                    <p class="margint20">{{ trans('messages.Coming soon') }}<br />{{ trans('messages.Coming soon') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                            <div class="flipper">
                                <div class="support-box pos-center front">
                                    <div class="support-box-title"><i class="fa fa-envelope"></i></div>
                                    <h4>{{ trans('messages.Coming soon') }}</h4>
                                    <p class="margint20">{{ trans('messages.Coming soon') }}</p>
                                </div>
                                <div class="support-box pos-center back">
                                    <div class="support-box-title"><i class="fa fa-envelope"></i></div>
                                    <h4>{{ trans('messages.Coming soon') }}</h4>
                                    <p class="margint20">{{ trans('messages.Coming soon') }}<br />{{ trans('messages.Coming soon') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                            <div class="flipper">
                                <div class="support-box pos-center front">
                                    <div class="support-box-title"><i class="fa fa-home"></i></div>
                                    <h4>{{ trans('messages.Coming soon') }}</h4>
                                    <p class="margint20">{{ trans('messages.Coming soon') }}</p>
                                </div>
                                <div class="support-box pos-center back">
                                    <div class="support-box-title"><i class="fa fa-home"></i></div>
                                    <h4>{{ trans('messages.Coming soon') }}</h4>
                                    <p class="margint20">{{ trans('messages.Coming soon') }}<br />v</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="newsletter-section"><!-- Newsletter Section -->
        <div class="container">
            <div class="row">
                <div class="newsletter-top pos-center margint30">
                    <img alt="{{ trans('messages.Coming soon') }}" src="" >
                </div>
                <div class="newsletter-form margint40 pos-center">
                    <div class="newsletter-wrapper">
                        <div class="pull-left">
                            <h2>{{ trans('messages.Coming soon') }}</h2>
                        </div>
                        <div class="pull-left">
                            <form action="#" method="post" id="ajax-contact-form">
                                <input type="text" placeholder="{{ trans('messages.Coming soon') }}">
                                <input type="submit" value="{{ trans('messages.Coming soon') }}" >
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
