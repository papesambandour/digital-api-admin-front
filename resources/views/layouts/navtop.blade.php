<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">

        <div class="navbar-logo">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="ti-menu"></i>
            </a>
            <a class="mobile-search morphsearch-search" href="#">
                <i class="ti-search"></i>
            </a>
            <a href="/">
{{--                <img class="img-fluid" src="assets/images/logo.png" alt="Theme-Logo" />--}}
                <span style="font-size: 35px;font-weight: bold;letter-spacing: 5px;">
                    INTECH
                </span>
                <span style="color: #fff;font-weight: bold ">
                    API
                </span>
            </a>
            <a class="mobile-options">
                <i class="ti-more"></i>
            </a>
        </div>

        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li>
                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                </li>

                <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()">
                        <i class="ti-fullscreen"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-right">
                <li class="user-profile header-notification">
                    <a href="#!">
                        <img src="/assets/icon/profil.svg" alt="User Profile" />
                        <span>{{_auth()['first_name']}}</span>
                        <i class="ti-angle-down"></i>
                    </a>
                    <ul class="show-notification profile-notification">
                        <li>
                            <a href="#">
                                <i class="ti-user"></i> Profil
                            </a>
                        </li>
                        <li>
                            <a href="/auth/logout">
                                <i class="ti-layout-sidebar-left"></i> Se déconnecter
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
