

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Payfeetz</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
      
      <link rel="stylesheet" href="{{ asset('assets/css/backend.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/fonts/remixicon.css')}}"/>
      <link rel="stylesheet" href="{{ asset('assets/vendor/@icon/dripicons/dripicons.css') }}" />
      
      <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/core/main.css') }}' />
      <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/daygrid/main.css') }}' />
      <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/timegrid/main.css') }}' />
      <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/list/main.css') }}' />
      <link rel="stylesheet" href="{{ asset('assets/vendor/mapbox/mapbox-gl.css') }}">

    </head>
  <body class="  ">
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
@yield('content-heading')
@yield('content-body')

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
    
    <!-- app JavaScript -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
  </body>
</html>


