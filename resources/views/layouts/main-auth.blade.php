<!DOCTYPE html>
<html lang="fr">
@include('layouts.css')
<body>
{{--LOADER START--}}
@include('layouts.loader')
{{--LOADER END--}}

<section class="login p-fixed d-flex text-center bg-primary common-img-bg">
    <!-- Container-fluid starts -->
    <div class="container">
       @yield('page')
        <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
</section>

{{--LOADER JS--}}
@include('layouts.js')
{{--LOADER JS--}}
</body>

</html>
