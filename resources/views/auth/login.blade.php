<!DOCTYPE html>
<html lang="en" id="login-page">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="GitHub is where people build software. More than 19 million people use GitHub to discover, fork, and contribute to over 50 million projects.">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/login.css') }}">
    <link rel="icon" type="image/x-icon" href="https://assets-cdn.github.com/favicon.ico">
    <title>Sign in to Payfeetz</title>
  </head>
  <body>
    <div style="margin-top:5%;" class="header" role="banner">
      <div class="container clearfix width-full">
          <img style="margin-left:41%; margin-bottom:1%;" class="header-logo" src="{{ asset('assets/images/logo.png') }}" alt=""   viewBox="0 0 16 16" height="70">
        {{-- <a class="header-logo" href="#"><svg class="octicon octicon-mark-github" height="48"  viewBox="0 0 16 16" width="48"><path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg></a> --}}
      </div>
      <div class="access-aid"></div>
      <div role="main">
        <div id="">
          <div class="form-div px-3">
            <form  action="{{ route('login') }}" method="POST">  
                @csrf
              <div class="form-header">
                {{-- <h1>Sign in </h1> --}}
              </div>
              <div class="form-body">
                <label>Username</label>
                <input class="form-control input-block" id="username" name="username" :value="old('username')" required autofocus>
                <label>Password<a href="#" class="label-link">Forgot password?</a></label>
                <input class="form-control input-block" type="password" name="password" required autocomplete="current-password">

                <input class="button" type="submit" value="Sign in">
              </div>
            
            </form>
            <p class="create-account">New to Payfeetz? <a style="cursor: pointer;" href="{{route('payfeetz.create.account')}}">Create an account</a>.</p>
          </div>
        </div>
      </div>
      <div class="site-footer">
        <ul class="site-footer-links">
          <li><a href="#">Terms</a></li>
          <li><a href="#">Privacy</a></li>
          <li><a href="#">Security</a></li>
          <li><a href="#">Contact Bizytech</a></li>
        </ul>
      </div>
    </div>
  </body>

  <footer>
      <script>

let inputElem = document.querySelector("#login-page");
window.addEventListener('load', function(e) {
    inputElem.focus();
});


// $('#toggle-eye').click(function(e){

// e.preventDefault();
// if($('#show_hide_password input').attr("type") == "text"){
//     $('#show_hide_password input').attr('type', 'password');
//     $('#show_hide_password i').addClass( "fa-eye-slash" );
//     $('#show_hide_password i').removeClass( "fa-eye" );
// }else if($('#show_hide_password input').attr("type") == "password"){
//     $('#show_hide_password input').attr('type', 'text');
//     $('#show_hide_password i').removeClass( "fa-eye-slash" );
//     $('#show_hide_password i').addClass( "fa-eye" );
// }

// });


      </script>
  </footer>
</html>
