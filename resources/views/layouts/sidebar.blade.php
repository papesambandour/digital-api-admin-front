<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-search">
            <span class="searchbar-toggle">  </span>
            <form id="searchForm" action="/transaction" class="pcoded-search-box ">
                <input name="search_in_any_id_transaction" type="text" placeholder="Rechercher une transaction">
                <span onclick="document.getElementById('searchForm').submit()" class="search-icon"><i class="ti-search" aria-hidden="true"></i></span>
            </form>
        </div>
        <div class="pcoded-navigatio-lavel" >Reporting</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="active">
                <a href="/">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Dashboard</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active" style="display: none">
                <a href="/statistic">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Statistique</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

        </ul>
        <div class="pcoded-navigatio-lavel" >Monétique</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="active">
                <a href="/partners">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" > Partenaires</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active">
                <a href="/versement">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Versements</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active">
                <a href="/transaction">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Transactions</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>

            <li class="active">
                <a href="/mvm-compte">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Mouvement compte</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active">
                <a href="/claim">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Réclamation</span>
                    <span class="pcoded-mcaret"></span>
                    @if(claimsNb())
                    <span class="claimsNb">+{{claimsNb()}}</span>
                    @endif
                </a>
            </li>
        </ul>
        <div class="pcoded-navigatio-lavel" >Configurations</div>
        <ul class="pcoded-item pcoded-left-item">

            <li class="active">
                <a href="/sous-service">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Sous Services</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active">
                <a href="/phones">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Services Providers</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active">
                <a href="/mvm-compte-phones">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Mvm Service Provider</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="active">
                <a href="/versement-phones">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Versement  Service Provider</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
           {{-- <li class="active">
                <a href="/apikey">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Mes Clées APIs</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>--}}
          {{--  <li class="active">
                <a href="/reclamation">
                    <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                    <span class="pcoded-mtext" >Réclamations</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>--}}

            <div class="pcoded-navigatio-lavel" >Administration</div>
            <ul class="pcoded-item pcoded-left-item">

                <li class="active">
                    <a href="/users">
                        <span class="pcoded-micon"><i class="ti-direction-alt"></i><b>D</b></span>
                        <span class="pcoded-mtext" >Utilisateurs</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
        </ul>
    </div>
</nav>
