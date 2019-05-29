@extends('client.layouts.master')
@section('content')
    <div class="breadcrumb breadcrumb-1 pos-center">
        <h1>{{ __('messages.BLOG') }}</h1>
    </div>
    <div class="content"><!-- Content Section -->
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-sm-8 blog-post-contents">
                    @if (isset($post))
                    <div class="blog-post"><!-- Blog Post -->
                        <h3><a href="{{ route('blog.detail'), $post->id }}">{{ $post->title }}</a></h3>
                        <div class="post-materials  clearfix">
                            <ul>
                                <li><h6><i class="fa fa-calendar"></i>{{ $post->date }}</h6></li>
                                <li><h6><i class="fa fa-user"></i>{{ __('messages.ADMIN') }}</h6></li>
                                <li><h6><i class="fa fa-comments"></i>13 {{ __('messages.COMMENTS') }}</h6></li>
                                <li><h6><a href="{{ route('blog.index'), $post->cate_id }}"><i class="fa fa-bars"></i>{{ $post->cate_name }}</a></h6></li>
                            </ul>
                        </div>
                        <div class="blog-image marginb30 margint30">
                            <img alt="Blog Image 2" class="img-responsive" src="{{ $post->image }}" >
                        </div>
                        <div class="button mini-button button-style-2 margint30">
                            {!! $post->body !!}
                        </div>
                    </div>
                    @else
                    <p>{{ __('messages.NoPost') }}</p>
                    @endif
                </div>
                <div class="col-lg-3 col-sm-4 margint60"><!-- Sidebar -->
                    <div class="luxen-widget news-widget">
                        <div class="title">
                            <h5>{{ __('messages.recentNew') }}</h5>
                        </div>
                        <ul class="sidebar-recent">
                            @if (isset($new_posts))
                            @foreach ($new_posts as $new)
                            <li class="clearfix">
                                <h6><a href="#">News from us from now</a></h6>
                                <div class="pull-left blg-img margint20">
                                    <img src="{{ $new->image }}" class="img-responsive img1" alt="">
                                </div>
                                <div class="pull-left blg-txt">
                                    <p>{{ route('blog.detail'), $new->id }}">[...]</a></p>
                                </div>
                            </li>
                            @endforeach
                            @else
                            <p>{{ __('messages.NoPost') }}</p>
                            @endif
                        </ul>
                    </div>
                    <div class="luxen-widget news-widget">
                        <div class="title">
                            <h5>{{ __('messages.HOTEL INFORMATION') }}</h5>
                        </div>
                        <p>{{ __('messages.lorem') }}</p>
                    </div>
                    <div class="luxen-widget news-widget">
                        <div class="title">
                            <h5>{{ __('messages.contact') }}</h5>
                        </div>
                        <ul class="footer-links">
                            <li><p><i class="fa fa-map-marker"></i>{{ __('messages.lorem') }}</p></li>
                            <li><p><i class="fa fa-phone"></i>{{ config('contact.phone') }}</p></li>
                            <li><p><i class="fa fa-envelope"></i>{{ config('contact.email') }}</p></li>
                        </ul>
                    </div>
                    <div class="luxen-widget news-widget">
                        <div class="title">
                            <h5>{{ __('messages.SOCIAL MEDIA') }}</h5>
                        </div>
                        <ul class="social-links">
                            <li><a href=""><i class="fa fa-facebook"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
