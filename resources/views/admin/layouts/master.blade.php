<!DOCTYPE html>
<html>
@include ('admin.layouts.head')
<body data-notification="{{ session('notification') }}" class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<div class="m-grid m-grid--hor m-grid--root m-page" id="app">
    @include('admin.layouts.header')
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <div id="m_aside_left" class="m-grid__item m-aside-left m-aside-left--skin-dark ">
            @include('admin.layouts.aside')
        </div>
        @yield('content')
    </div>
    @include('admin.layouts.footer')
</div>
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>
@include('admin.layouts.script')
@yield('script')
</body>
</html>
