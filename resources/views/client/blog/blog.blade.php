@extends('client.layouts.master')
@section('content')
    <div class="breadcrumb breadcrumb-1 pos-center">
        <h1>{{ __('messages.BLOG') }}</h1>
    </div>
    <div class="content"><!-- Content Section -->
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-sm-8 blog-post-contents">
                    @if (count($posts) <= 0)
                        <div class="blog-post"><!-- Blog Post -->
                            {{ __('messages.No_posts') }}
                        </div>
                    @endif
                    @if (isset($posts))
                        @foreach ($posts as $post)
                            <div class="blog-post"><!-- Blog Post -->
                                <h3><a href="{{ route('client.blog.detail', $post->id) }}">{{ $post->title }}</a></h3>
                                <div class="post-materials  clearfix">
                                    <ul>
                                        <li><h6><i class="fa fa-calendar"></i>{{ $post->date }}</h6></li>
                                        <li><h6>
                                                <i class="fa fa-comments"></i>{{ count($allcomments) }}</span> {{ __('messages.COMMENTS') }}
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                <a href="{{ route('client.blog.index', $post->cate_id) }}">
                                                    <i class="fa fa-bars"></i>{{ $post->cate_name }}
                                                </a>
                                            </h6>
                                        </li>
                                    </ul>
                                </div>
                                <div class="blog-image marginb30 margint30">
                                    <img alt="Blog Image 2" class="img-responsive img-blog" src="{{ $post->image }}">
                                </div>
                                <div class="post-content margint10">
                                    <p>{{ $post->description }}</p>
                                </div>
                                <div class="button mini-button button-style-2 margint30">
                                    <h6>
                                        <a href="{{ route('client.blog.detail', $post->id) }}">{{ __('messages.READ MORE') }}</a>
                                    </h6>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>{{ __('messages.NoPost') }}</p>
                    @endif
                    {{ $posts->links() }}
                </div>
                @include('client.layouts.sidebar_posts')
            </div>
        </div>
    </div>
@endsection
