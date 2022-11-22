
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Payfeetz</title>
      
      <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
      
      <link rel="stylesheet" href="{{ asset('assets/css/backend.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.css') }}"/>

      <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/fonts/remixicon.css')}}"/>
      <link rel="stylesheet" href="{{ asset('assets/vendor/@icon/dripicons/dripicons.css') }}" />
      <link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.css')}}"/>
      <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/core/main.css') }}' />
      <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/daygrid/main.css') }}' />
      <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/timegrid/main.css') }}' />
      <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/list/main.css') }}' />
      <link rel="stylesheet" href="{{ asset('assets/vendor/mapbox/mapbox-gl.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/loader.css') }}">
      <link rel="stylesheet" href="{{ asset('global_assets/plugins/click-tap-image/css/image-zoom.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/jquery-year-picker/css/yearpicker.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/btn-toggle.css')}}"/>
      <link rel="stylesheet" href="{{ asset('assets/sweetalert2/dist/sweetalert2.css')}}"/>
      <link rel="stylesheet" href="{{ asset('jquery-ui/css/base/jquery-ui-1.10.4.custom.css') }}" rel="stylesheet">

      <link rel="stylesheet" href="{{ asset('assets/waitMe/waitMe.css') }}">
      
      <script src="{{ asset('assets/jquery/dist/jquery.js' )}}"></script> 
      <script  src="{{ asset('jquery-ui/js/jquery-1.10.2.js')}}">  </script>
      <script  src="{{ asset('jquery-ui/js/jquery-ui-1.10.4.custom.js')}}">  </script>
      <script  src="{{ asset('jquery-ui/development-bundle/ui/jquery.ui.dialog.js')}}">  </script>

      <script src="{{ asset('assets/select2/dist/js/select2.js' )}}"></script>

      <script src="{{ asset('assets/waitMe/waitMe.js')}}"></script>

      <script src="{{ asset('assets/backend/admin.js')}}"></script>
      <script src="{{ asset('assets/backend/bootstrap-toggle.min.js')}}"></script>
      <script src="{{ asset('assets/sweetalert2/dist/sweetalert2.js')}}"> </script>

      <link rel="stylesheet" href="{{ asset('assets/toastr/build/toastr.css')}}">
      
    

      <script  src="{{ asset('js/chart.js/dist/chart.min.js') }}">  </script>


      <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>



      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <style>

#hover_effect:hover   .img-display{
  display: block


}

.iq-sidebar-menu .iq-menu li a {

  padding-top: 10px;
  padding-left: 15px;
  padding-right: 15px;
  padding-bottom: 10px;


}

.custom-table {
    border-spacing: 0;
    border-radius: 10px;
    box-shadow: 0 0px 0px 0px rgb(0 0 0 / 0%), 0 0px 0px rgb(0 0 0 / 0%);
    border: 0;
}


.pro-content .rounded{
  width: 100% !important;
    margin-left: -21px !important;

}


.bounce {
  animation: bounce 3s ease infinite;
  
}
@keyframes bounce {
    70% { transform:translateY(0%); }
    80% { transform:translateY(-15%); }
    90% { transform:translateY(0%); }
    95% { transform:translateY(-7%); }
    97% { transform:translateY(0%); }
    99% { transform:translateY(-3%); }
    100% { transform:translateY(0); }
}


/* .iq-sidebar {

  background: #27445c;

} */

 body{
  font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
    font-weight: 400;
    overflow-x: hidden;
    overflow-y: auto;
    font-size: 14px !important;
    line-height: 1.42857143;
    color: #333;
    /* background-color: #fff; */
} 

.std_profile >  td, th {
        border-top: none !important;
        
    }

    
.iq-sidebar {
    background: linear-gradient(to bottom, rgba(237, 237, 237, 1) 0%, rgba(222, 222, 222, 1) 100%);
  /*background-color: #e9ecef;*/


}
.iq-sidebar-logo {
    background-color: #04476a;
    padding: 12px !important;
}

.iq-top-navbar {
  background-color:#04476a !important;

}

table.dataTable tfoot th {
    padding: 10px 9px 6px !important;
    text-align: right !important;
    border-top: 1px solid #111;
}

.iq-menu li {
    background: linear-gradient(to bottom, rgba(237, 237, 237, 1) 0%, rgba(222, 222, 222, 1) 100%);
    margin: 0 1px 0 0;
    border-top: 1px solid #bbb;
    border-bottom: 1px solid #bbb;
}

.iq-menu li ul li {
    margin: 0 1px 0 0;
    border-top: 1px solid #bbb;
    border-bottom: 1px solid #bbb;
}

.iq-menu li ul li ul li {
    margin: 0 1px 0 0;
    border-top: 1px solid #bbb;
    border-bottom: 1px solid #bbb;
}


.blink {
        animation: blink-animation 1s steps(5, start) infinite;
        -webkit-animation: blink-animation 1s steps(5, start) infinite;
      }
      @keyframes blink-animation {
        to {
          visibility: hidden;
        }
      }
      @-webkit-keyframes blink-animation {
        to {
          visibility: hidden;
        }
      }


      .todo-group-title {
    margin: 0;
    line-height: 31px;
    margin-top: -2%;
    padding: 0 0 0 10px;
    background: #fafafa;
    border-bottom: 1px solid #e7e7e7;
    border-top: 1px solid #f4f4f4;
    color: #999;
}

.bg-red {
  background-color: #c26565 !important;
}




.content-page {
  background-color:#a0a0a0;
  background-color:#416b79;
  background-color:#4a6771; 
  background-color:#b8bcbd;  

}

/* some color #ecf0f5  */

/* .sidebar-default{
  background-color: #132135;
  color: #fff;
} */

@font-face {
	    font-family: maserrati;
	    src: url('{{  asset('fonts/Montserrat-Regular.ttf')  }}');
  }


#edit_year:hover {
        background-color:#1569C7;
      }

 /*          .select2-selection__rendered {
    line-height: 31px !important;
} */
.select2-container .select2-selection--single {
    /* height: 45px !important; */
    background-color: #fafbfe;
    /* padding-top: 5px; */
}
.select2-selection__arrow {
    /* height: 34px !important; */
}


.select2-container--default .select2-selection--multiple {
  background-color: #fafbfe;

}

.float_xmachina{

  overflow: visible;
  position: relative;
}

#float_x {
    position: absolute;
    color: white;
    margin-top: 7px !important;
    margin-right: -2px !important;
    top: -17px;
    right: -24px;
    background-color: #ff4b4b;
    border-color: #ff4b4b;
    border-radius: 15px !important;
    width: 28px;
    height: 26px;
}

.navbar-list li>a.language-title {
    font-size: 14px;
}
  
.btn:not(:disabled):not(.disabled) {
  color: white;
}


      </style>

    </head>
  <body id="toggle-flip">
    {{-- class="sidebar-main" --}}
    <!-- loader Start -->
    <div id="loading">
          <div id="loading-center">
          </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">

{{-- side bar --}}



@include('layouts.navigation')


      <div class="content-page">
      <div class="container-fluid">
         <div class="row">
       
{{-- header --}}

@yield('alerts-ground')

@yield('content-breadcrumbs')

@yield('content-heading')
     {{--Error Alert Area--}}
     @if($errors->any())
     <div class="alert alert-danger border-0 alert-dismissible">
         <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>

             @foreach($errors->all() as $er)
                 <span><i class="icon-arrow-right5"></i> {{ $er }}</span> <br>
             @endforeach

     </div>
 @endif

 <div id="ajax-alert" style="display: none"></div>

 
@yield('content-body')
@include('components.loader1')
@include('components.invoice_loader')
         </div>
      </div>
      </div>
    </div>
    <!-- Wrapper End-->
        @include('layouts.footer')
       
    <!-- Backend Bundle JavaScript -->
    <script src=" {{ asset('assets/js/backend-bundle.min.js') }}"></script>
    
    <!-- Flextree Javascript-->
    <script src=" {{ asset('assets/js/flex-tree.min.js')}}"></script>
    <script src="{{ asset('assets/js/tree.js') }}"></script>
    
    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('assets/js/table-treeview.js') }}"></script>
    
    <!-- Masonary Gallery Javascript -->
    <script src=" {{ asset('assets/js/masonry.pkgd.min.js') }}"></script>
    <script src=" {{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    
    <!-- Mapbox Javascript -->
    <script src="{{ asset('assets/js/mapbox-gl.js') }}"></script>
    <script src="{{ asset('assets/js/mapbox.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    
    <!-- Fullcalender Javascript -->
    <script src='{{ asset('assets/vendor/fullcalendar/core/main.js') }}'></script>
    <script src='{{ asset('assets/vendor/fullcalendar/daygrid/main.js')}}'></script>
    <script src='{{ asset('assets/vendor/fullcalendar/timegrid/main.js')}}'></script>
    <script src='{{ asset('assets/vendor/fullcalendar/list/main.js') }}'></script>
    
    
    <!-- SweetAlert JavaScript -->
    <script src=" {{ asset('assets/js/sweetalert.js') }}"></script>
    
    <!-- Vectoe Map JavaScript -->
    <script src="{{ asset('assets/js/vector-map-custom.js') }} "></script>
    
    <!-- Chart Custom JavaScript -->
    <script src=" {{ asset('assets/js/customizer.js') }}"></script>
    
    <!-- Chart Custom JavaScript -->
    <script src=" {{ asset('assets/js/chart-custom.js') }} "></script>
    
    <!-- slider JavaScript -->
    <script src=" {{ asset('assets/js/slider.js') }} "></script>


    {{--Uploaders--}}
{{-- <script src="{{ asset('global_assets/plugins/uploaders/fileinput/fileinput.min.js') }}"></script>
<script src="{{ asset('global_assets/demo_pages/uploader_bootstrap.js') }}"></script> --}}

<script src=" {{ asset('global_assets/plugins/click-tap-image/js/image-zoom.js') }} "></script>

    
    <!-- app JavaScript -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/toastr/build/toastr.min.js' )}}"></script>
    <script src="{{ asset('assets/jquery-year-picker/js/yearpicker.js')}}"></script>
    <script>
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    $('.toggleDisplay').click(function(){
      // e.preventDefault();

      $(this).parent().addClass('active').trigger('change');
      $(this).parent().parent().addclass('show');
    });


    
       @yield('scripts')   
         
    $(document).ready(function(){
      $('.student_profile_js').attr('style','width:100%');
      $('#content_update').css({'margin-left':'-21px', 'margin-top':'1%'});
    })
    </script>
    <script  src="{{  asset('assets/jquery-tabledit-master/jquery.tabledit.min.js') }}"></script>   

@include('shadows.custom_js')


  </body>
</html>
