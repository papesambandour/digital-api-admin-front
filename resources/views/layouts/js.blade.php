
<!-- Warning Section Ends -->
<!-- Required Jquery -->
<script type="text/javascript" src="/assets/js/notiflix-3.2.5.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/js/popper.js/popper.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="/assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
<!-- modernizr js -->
<script type="text/javascript" src="/assets/js/modernizr/modernizr.js"></script>
<!-- am chart -->
<script src="/assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="/assets/pages/widget/amchart/serial.min.js"></script>
<!-- Todo js -->
{{--<script type="text/javascript " src="/assets/pages/todo/todo.js"></script>--}}
<!-- Custom js -->
<script type="text/javascript" src="/assets/js/script.js"></script>
<script type="text/javascript " src="/assets/js/SmoothScroll.js"></script>
<script src="/assets/js/pcoded.min.js"></script>
<script src="/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/assets/js/demo-12.js"></script>
<script>
    var $window = $(window);
    var nav = $('.fixed-button');
    $window.scroll(function(){
        if ($window.scrollTop() >= 200) {
            nav.addClass('active');
        }
        else {
            nav.removeClass('active');
        }
    });


</script>
<script>

    $('li.page-item > a').on('click',function(event){
        event.preventDefault();
        console.log(event.target?.text)
        let url = window.location.href;
        url = url.replace(/(\?|&)page=\d*/,'')
        if(url.indexOf('?') !== -1){
            window.location.href =url + "&page="+ event.target?.text
        }else{
            window.location.href =url + "?page="+ event.target?.text
        }

    })
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@yield('js','')
