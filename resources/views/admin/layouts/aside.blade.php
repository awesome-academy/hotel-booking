<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1"
     m-menu-scrollable="1" m-menu-dropdown-timeout="500">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
        <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
            <a href="" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">{{ __('messages.Dashboard') }}</span>
                    </span>
                </span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon fa fa-cubes"></i>
                <span class="m-menu__link-text">{{ __('messages.Users_manage') }}</span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item" aria-haspopup="true">
                        <a href="{{ route('admin.users.create') }}" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-plus">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">{{ __('messages.Add') }}</span>
                        </a>
                    </li>
                    <li class="m-menu__item" aria-haspopup="true">
                        <a href="{{ route('admin.users.index') }}" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-list">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">{{ __('messages.List') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon fa fa-cubes"></i>
                <span class="m-menu__link-text">{{ __('messages.Location_manage') }}</span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu ">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    <li class="m-menu__item" aria-haspopup="true">
                        <a href="{{ route('admin.locations.create') }}" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-plus">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">{{ __('messages.Add') }}</span>
                        </a>
                    </li>
                    <li class="m-menu__item" aria-haspopup="true">
                        <a href="{{ route('admin.locations.index') }}" class="m-menu__link ">
                            <i class="m-menu__link-bullet fa fa-list">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">{{ __('messages.List') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
