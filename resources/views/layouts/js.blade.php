
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
@livewireScripts
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


</script>

<script>
    function showLoader(text = 'Chargement...') {
        // Create a new div element for the loader
        const loader = document.createElement('div');

        // Set the id attribute of the loader element
        loader.id = 'loaderHtml';

        // Set the HTML content and inline CSS styles of the loader element
        loader.innerHTML = `
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
      <div style="width: 40px; height: 40px; border-radius: 50%; border: 4px solid #fff; border-top-color: #ccc; animation: spin 1s linear infinite;"></div>
      <span style="color: #fff; margin-top: 10px;">${text}</span>
    </div>
    <style>
      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }
    </style>
  `;

        // Apply CSS styles using the style property
        loader.style.zIndex = '99999999999';
        loader.style.position = 'absolute';

        // Append the loader element to the body of the document
        document.body.appendChild(loader);
    }




    function removeLoader() {
        // Find the loader element by its ID
        const loader = document.getElementById('loaderHtml');

        // Remove the loader element if it exists
        if (loader) {
            loader.parentNode.removeChild(loader);
        }
    }


    $(document).ready(function () {
        if( $('#_partener_').text()){
            $('#_partener_').select2();
        }
        if( $('#_operation_').text()){
            $('#_operation_').select2();
        }
        if( $('#_type_operation_').text()){
            $('#_type_operation_').select2();
        }
        if( $('#_sous_services_id').text()){
            $('#_sous_services_id').select2();
        }

        $('li.page-item  a.page-link').on('click',function(event){
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
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script  src="/assets/js/components/services.js"></script>
<script src="/assets/js/download.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
@yield('js','')
