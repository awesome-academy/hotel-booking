<header id="m_header" class="m-grid__item m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <a href="javascript:;" id="m_aside_left_minimize_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                            <span></span>
                        </a>
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div id="m_header_topbar"
                 class="m-header-menu m-aside-header-menu-mobile m-header-menu--skin-light m-header-menu--submenu-skin-light">
                <div id="m_header_menu"
                     class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas m-header-menu--skin-light">
                    <ul class="m-menu__nav m-menu__nav--submenu-arrow ">
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click"
                            m-menu-link-redirect="1" aria-haspopup="true">
                            <div class="m-dropdown m-dropdown--inline m-dropdown--arrow" m-dropdown-toggle="hover"
                                 aria-expanded="true">
                                <a href="javascript:;"
                                   class="m-dropdown__toggle btn btn-primary dropdown-toggle">{{ $current_language->name }}</a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--left"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav">
                                                    @foreach ($header_languages as $header_language)
                                                        <li class="m-nav__item">
                                                            <a href="{{ route('client.changeLanguage', $header_language->id) }}"
                                                               class="m-nav__link">
                                                                <span class="m-nav__link-text">{{ $header_language->name }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click"
                            m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-user"></i>
                                <span class="m-menu__link-text">{{ $admin->full_name }}</span>
                                <i class="m-menu__hor-arrow la la-angle-down"></i>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item" aria-haspopup="true">
                                        <a href="{{ route('admin.users.edit', $admin->id) }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-file"></i>
                                            <span class="m-menu__link-text">{{ __('messages.Profile') }}</span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item text-center" aria-haspopup="true">
                                        <form id="logout-form" action="{{ route('client.logout') }}" method="POST">
                                            @csrf
                                            <button class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">{{ __('messages.Log_out') }}</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel">
                            <a href="{!! route('client.index') !!}" class="m-dropdown__toggle btn btn-primary"><i
                                        class="m-menu__link-icon fa fa-home"></i></a>
                        </li>
                        <li class="m-menu__item m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click"
                            m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="notification-holder m-menu__link-icon flaticon-music-2">
                                    <span class="count-notification-circle">0</span>
                                </i>
                                <i class="m-menu__hor-arrow la la-angle-down"></i>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>

                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <ul class="m-menu__subnav dropdown-notifications m-widget4">
                                    @foreach ($header_comments as $header_comment)
                                        @php
                                            $room = $header_comment->room()->first();
                                            $roomDetail = $room->roomDetails()->where('lang_id', session('locale'))->first();
                                        @endphp
                                        @if (!is_null($room) && !is_null($roomDetail))
                                            <li class="m-menu__item dropdown-notifications-item" aria-haspopup="true">
                                                <p class="notification-title">{{ $header_comment->email }}</p>
                                                <div class="comment-rating">
                                                    <ul>
                                                        @for($i = 0; $i < $header_comment->rating; $i++)
                                                            <li><i class="fa fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                                <p class="block-ellipsis">
                                                    {{ $header_comment->body }}
                                                </p>
                                                <a href="{{ route('client.rooms.detail', $header_comment->object_id) }}">{{ $roomDetail->name }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                    <li class="m-menu__item dropdown-notifications-item" aria-haspopup="true">
                                        <a href="{{ route('admin.comment.index', config('comment.room')) }}">{{ __('messages.See_more') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<input type="hidden" name="" a="{{ __('messages.Are_you_sure') }}" b="{{ __('messages.Delete') }}" c="{{ __('messages.Cancel') }}" id="hiddendelete">
