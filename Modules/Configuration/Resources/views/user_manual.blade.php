<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


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

    <style>

        .td_border{
        border: 
    }

    body{
        color: #074D70 !important;
    }

    .zoomCategory {
    vertical-align: text-bottom;
    height: 136px;
    box-sizing: border-box;
    border-radius: 5px;
    border: 1px solid #d2d3d3;
    display: block;
    margin: 10px;
    position: relative;
    padding: 34px 20px 50px;
    text-decoration: none;
    color: #575757;
}

      </style>


      <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>
<body>
    
    <article class="ml-auto">
        <h1 style="font-size: 36px; margin-top:2%; color: #074D70; text-align:center">Get help with support team!!</h1>
       <div class="knowledge-base" style="margin: 0 auto; align:center;">
        <div><h6 style="margin-left: 28%; color: #074D70;">Popular Topics</h6></div>
        <table style="text-align: center; margin:auto; vertical-align:text-bottom; vertical-align: text-bottom;" class="pouplarTopics">
    
                <tbody><tr>
                <td><a class="zoomCategory" href="#"><img src="{{ asset('assets/user_manual/billing.png') }}" style="width: 74px; height: 49.33px; margin-top:8px;"><div class="category-label">Online Fee Payment</div></a></td>
            <td><a href="#" class="zoomCategory"><img src="{{ asset('assets/user_manual/getting_started.png')}}"><div class="category-label">Getting Started</div></a></td>
          <td><a href="#" class="zoomCategory"><img src="{{ asset('assets/user_manual/audio_video_share.png') }}"><div class="category-label" style="font-size: 12px;">Audio, Video, Sharing</div></a></td>
    <td><a href="#" class="zoomCategory"><img src="{{ asset('assets/user_manual/account_admin.png') }}"><div class="category-label">Account &amp; Admin</div></a></td>
         </tr>
            <tr>
          <td><a href="#" class="zoomCategory"><img src="{{ asset('assets/user_manual/mobile_app.png') }}"><div class="category-label">Mobile App</div></a></td>
    <td><a href="#" class="zoomCategory"><img src="{{ asset('assets/user_manual/academics.png') }}"><div class="category-label">Academics</div></a></td>
    <td><a href="#" class="zoomCategory"><img src="{{ asset('assets/user_manual/messaging.png')  }}"><div class="category-label">Messaging</div></a></td>
    <td><a href="#" class="zoomCategory"><img src="{{ asset('assets/user_manual/intergration.png') }}"><div class="category-label">Integration</div></a></td>
            </tr>
          
    </tbody></table>
    
    <h5 style="margin-left: 28%; color: #074D70;" >Get Help</h5>
    <table style="text-align:middle !important; margin:auto; vertical-align:middle;" class="clearfix contact-info">
        <tbody><tr valign="middle">
    
          <td class="contactMethods" style="width: 200px !important;padding: 0 0 0 0 !important;background: url( {{ asset('assets/user_manual/status.png')  }}) left center no-repeat;background-position: 15% 50%;">
            <a class="zoomCategory" href="#" style="text-decoration: none; width: 220px !important; height: 90px !important; ">
                <span style="margin-left: 40px; vertical-align: middle;">&nbsp;Email Support</span>
                <br>
                <span style="margin-left: 10px;font-weight:500; vertical-align: middle;color:#2da5ff;">tarick.abdul@bizytech.com</span>
            </a>
        </td>
        
          <td class="contactMethods" style="width: 200px !important;padding: 0 0 0 0 !important;background: url( {{ asset('assets/user_manual/training.png') }}) left center no-repeat;background-position: 15% 50%;"><a class="zoomCategory" href="#" style="text-decoration: none; width: 220px !important; height: 90px !important;"><span style="margin-left: 37px; vertical-align: top;">Tutorials &amp; Training</span></a></td>
    
          <td class="contactMethods" style="width: 200px !important; padding: 0 0 0 0 !important;background: url( {{ asset('assets/user_manual/contact_support.png')  }} ) left center no-repeat;background-position: 15% 50%;"><a class="zoomCategory" href="#" style="text-decoration: none; width: 220px !important; height: 90px !important;">
            <span style="margin-left: 40px; vertical-align: middle;">&nbsp;Contact Support</span>
            <br>
            <span style="margin-left: 40px;font-weight:500; vertical-align: middle;color:#2da5ff;">+255 718 054 054</span></a></td>
            
        </tr>
      </tbody></table>
      
      </div></article>

</body>
</html>
   