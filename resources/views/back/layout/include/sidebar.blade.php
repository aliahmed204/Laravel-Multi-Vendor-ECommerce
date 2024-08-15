<div class="sidebar-menu">
    <ul id="accordion-menu">
        @if(Route::is('admin.*'))
            <li>
                <a href="{{route('admin.home')}}" class="dropdown-toggle no-arrow">
                    <span class="micon bi bi-calendar4-week"></span>
                    <span class="mtext">Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="dropdown-toggle no-arrow {{ activeSideBar('admin.categories.index') }}">
                    <span class="micon dw dw-align-left3"></span>
                    <span class="mtext">{{__('Manage Categories')}}</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle"><span class="micon bi bi-archive"></span>
                    <span class="mtext"> UI Elements </span>
                </a>
                <ul class="submenu">
                    <li><a href="ui-buttons.html">Buttons</a></li>
                    <li><a href="ui-cards.html">Cards</a></li>
                    <li><a href="ui-cards-hover.html">Cards Hover</a></li>
                    <li><a href="ui-modals.html">Modals</a></li>
                    <li><a href="ui-tabs.html">Tabs</a></li>
                    <li>
                        <a href="ui-tooltip-popover.html">Tooltip &amp; Popover</a>
                    </li>
                    <li><a href="ui-sweet-alert.html">Sweet Alert</a></li>
                    <li><a href="ui-notification.html">Notification</a></li>
                    <li><a href="ui-timeline.html">Timeline</a></li>
                    <li><a href="ui-progressbar.html">Progressbar</a></li>
                    <li><a href="ui-typography.html">Typography</a></li>
                    <li><a href="ui-list-group.html">List group</a></li>
                    <li><a href="ui-range-slider.html">Range slider</a></li>
                    <li><a href="ui-carousel.html">Carousel</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle">
								<span class="micon bi bi-command"></span
                                ><span class="mtext">Icons</span>
                </a>
                <ul class="submenu">
                    <li><a href="bootstrap-icon.html">Bootstrap Icons</a></li>
                    <li><a href="font-awesome.html">FontAwesome Icons</a></li>
                    <li><a href="foundation.html">Foundation Icons</a></li>
                    <li><a href="ionicons.html">Ionicons Icons</a></li>
                    <li><a href="themify.html">Themify Icons</a></li>
                    <li><a href="custom-icon.html">Custom Icons</a></li>
                </ul>
            </li>
            <li>
                <a href="sitemap.html" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-diagram-3"></span
                                ><span class="mtext">Sitemap</span>
                </a>
            </li>
            <li>
                <a href="chat.html" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-chat-right-dots"></span
                                ><span class="mtext">Chat</span>
                </a>
            </li>
            <li>
                <a href="invoice.html" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-receipt-cutoff"></span
                                ><span class="mtext">Invoice</span>
                </a>
            </li>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <li>
                <div class="sidebar-small-cap">Settings</div>
            </li>
            <li>
                <a href="{{route('admin.profile')}}"
                    class="dropdown-toggle no-arrow {{ activeSideBar('admin.profile') }}">
                    <span class="micon fa fa-user"></span>
                    <span class="mtext">{{__('Profile')}}</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.settings')}}"
                    class="dropdown-toggle no-arrow {{ activeSideBar('admin.settings') }}">
                    <span class="micon icon-copy fi-widget"></span>
                    <span class="mtext">{{__('Settings')}}</span>
                </a>
            </li>
        @endif
    </ul>
</div>
