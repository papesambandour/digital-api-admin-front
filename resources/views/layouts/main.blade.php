<!DOCTYPE html>
<html lang="fr">
@include('layouts.css')
<body>
{{--LOADER START--}}
@include('layouts.loader')
{{--LOADER END--}}

<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">

        {{--NAV HEADER TOP BAR START--}}
        @include('layouts.navtop')
        {{--NAV HEADER TOP BAR END--}}

        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">

                @include('layouts.sidebar')

                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <div class="main-body">
                            <div class="page-wrapper">

                                <div class="page-body">
                                    {{--MAIN PAGE--}}
                                    @yield('page','')
                                    {{--MAIN PAGE--}}
                                </div>
                            </div>

                            <div id="styleSelector">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--LOADER JS--}}
@include('layouts.js')
{{--LOADER JS--}}
</body>

</html>
