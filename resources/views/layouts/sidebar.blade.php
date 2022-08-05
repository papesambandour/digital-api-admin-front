<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-search">
            <span class="searchbar-toggle">  </span>
            <form id="searchForm" action="/partner/transaction" class="pcoded-search-box ">
                <input name="external_transaction_id" type="text" placeholder="Rechercher une transaction">
                <span onclick="document.getElementById('searchForm').submit()" class="search-icon"><i class="ti-search" aria-hidden="true"></i></span>
            </form>
        </div>
        <div class="pcoded-navigatio-lavel" >Reporting</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="active">
                <a href="/partner">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Dashboard</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active" style="display: none">
                <a href="/partner/statistic">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Statistique</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

        </ul>
        <div class="pcoded-navigatio-lavel" >Monétique</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="active">
                <a href="/partner/transaction">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Transactions</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active">
                <a href="/partner/versement">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Versements</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active">
                <a href="/partner/mvm-compte">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Mouvement compte</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
        <div class="pcoded-navigatio-lavel" >Configurations</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="active">
                <a href="/partner/service">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Mes Services</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active">
                <a href="/partner/apikey">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Mes Clées APIs</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active">
                <a href="/partner/reclamation">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Réclamations</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>

{{--        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.other">Other</div>--}}
       {{-- <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu ">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>M</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.menu-levels.main">Menu Levels</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-21">Menu Level 2.1</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="pcoded-hasmenu ">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-22.main">Menu Level 2.2</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="javascript:void(0)">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Menu Level 3.1</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-23">Menu Level 2.3</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                </ul>
            </li>
        </ul>--}}
    </div>
</nav>
