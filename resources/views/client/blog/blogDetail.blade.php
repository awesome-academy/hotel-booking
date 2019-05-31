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
                        <h3><a href="{{ route('client.blog.detail', $post->id) }}">{{ $post->title }}</a></h3>
                        <div class="post-materials  clearfix">
                            <ul>
                                <li><h6><i class="fa fa-calendar"></i>{{ $post->date }}</h6></li>
                                <li><h6><i class="fa fa-user"></i><span class="number_comment">{{ count($allcomments) }}</span> {{ __('messages.COMMENTS') }}</h6></li>
                                <li><h6><a href="{{ route('client.blog.index', $post->cate_id) }}"><i class="fa fa-bars"></i>{{ $post->cate_name }}</a></h6></li>
                            </ul>
                        </div>
                        <div class="blog-image marginb30 margint30">
                            <img alt="Blog Image 2" class="img-responsive img-blog" src="{{ $post->image }}" >
                        </div>
                        <div class="button mini-button button-style-2 margint30">
                            {!! $post->body !!}
                        </div>
                    </div>
                    @else
                    <p>{{ __('messages.NoPost') }}</p>
                    @endif
                    <div class="comment-number clearfix margint30"><!-- Blog Comment Number Section -->
                    <div class="pull-right write-comment">
                        <h5><a href="#write-comment">{{ __('messages.write-comment') }}</a></h5>
                    </div>
                </div>
                <div class="comments-container clearfix comments-container-blog"><!-- Blog Comments Section -->
                    <ul id="style-9">
                        @foreach ($comments as $comment)
                        <li class="comment-box clearfix margint40 comment-blog">
                            <div class="col-lg-2 comment-author-image">
                                <img alt="Blog Comments Image 1" class="img-circle" src="{{ asset(config('upload.default_image')) }}">
                            </div>
                            <div class="col-lg-10">
                                <h5>{{ $comment->email }}</h5>
                                <div class="date marginb10">{{ $comment->date }}
                                </div>
                                <p>{{ $comment->body }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <br>
                    @if (count($allcomments) > 5)
                    <p><a href="" class="moreComment">{{ __('messages.XemThem') }}[..]</a></p>
                    @endif
                </div>
                <div><!-- Write Comment -->
                    <div id="write-comment" class="write-comment-box padt60 marginb60 clearfix"><!-- Write Comment Section -->
                        <h2>{{ __('messages.write-comment') }}</h2>
                        <div class="contact-form margint40">
                            <h6 id="errorname" class="error"></h6>
                            <input type="text" placeholder="E-MAIL ADDRESS" id="cemail">
                            <h6 id="erroremail" class="error"></h6>
                            <textarea placeholder="Morbi leo risus, porta ac consectetur ac, vestibulum at eros." id="ctext" class="text-comment"></textarea>
                            <h6 id="errortext" class="error"></h6>
                            <button class="margint10 submit btn btn-success">{{ __('messages.Submit') }}</button>
                        </div>
                    </div>
                </div>
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
                                <h6><a href="{{ route('client.blog.detail', $new->id) }}">{{ $new->title }}</a></h6>
                                <div class="pull-left blg-img margint20">
                                    <img src="{{ $new->image }}" class="img-responsive img1" alt="">
                                </div>
                                <div class="pull-left blg-txt">
                                    <p><a href="{{ route('client.blog.detail', $new->id) }}">{{ $new->description }}[...]</a></p>
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
<input type="hidden" name="" id="hiddenimage" value="{{ asset(config('upload.default_image')) }}">
<input type="hidden" name="" id="hiddenmore" value="{{ route('client.blog.more', $post->id) }}">
<input type="hidden" name="" id="hiddenblog" value="{{ $post->id }}">
<input type="hidden" name="" id="hiddenasset" value="{{ asset('') }}">
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('') }}bower_components/bower/js/blog.js"></script>
@endsection
