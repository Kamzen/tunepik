@php
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'githubAuth' => config('services.github.client_id'),
    'token' => csrf_token()
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<link rel="manifest" id="app-manifest" type="text/javascript" >
<meta name="theme-color" id="app-theme-color" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" type="text/css" href=" {{ asset('dist/fontawesome/css/all.css') }}" >
<style type="text/css">
  #app{
    min-height: 100%;
    height: 100%;
    width: 100%;
  }

  html, 
  body{
    min-height: 100%;
  }
</style>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{ config('app.name') }}</title>

  <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
  <style type="text/css">

      .wrapper-shimmer::after {
          position : absolute;
          top: 0;
          right: 0;
          bottom: 0;
          left: 0;
          transform: translateX(-100%);
          background-image: linear-gradient(
            90deg,
            rgba(#fff, 0) 0,
            rgba(#fff, .2) 20%,
            rgba(#fff, .5) 60%,
            rgba(#fff, 0) ,
          );
          animation: shimmer .3s infinite;
          content: '';

        }

        @keyframes shimmer{

          100% {
            transform: translateX(100%);
          }

        }
      
      .wrapper-shimmer{
        position: relative;
        overflow: hidden;
        background-color: rgba(211, 211, 211, .4);
        padding: 4px;

      }

      .wrap-inside{
        padding: 3px;
        border-radius: 6px;
        /*background-color: #fff;*/
      }

      .block{

      }

    </style>
</head>
<body id="main-body">
  <script type="text/javascript" defer src="{{ asset('dist/fontawesome/js/all.js') }}"></script>
  <script type="text/javascript" defer src="{{ asset('dist/recorder.js') }}"></script>
  <script type="text/javascript" defer src="{{ asset('dist/face-api.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('dist/pusher.min.js') }}"></script>
{{--   <script type="text/javascript" src="{{ asset('dist/flickity.pkgd.js') }}"></script>
  <script type="text/javascript" src="{{ asset('dist/attack.js') }}"></script> --}}

  <div id="app" style="height: 100%;">

    
    
    <center>
      
      <div class="skeleton-shimmer">
        
        <div class="wrap-inside">
          <h2>Tunepik</h2>
        </div>

      </div>

    </center>

  </div>

  {{-- Global configuration object --}}
  <script>
    window.config = @json($config);
  </script>

  {{-- Load the application scripts --}}
  <script src="{{ mix('dist/js/app.js') }}"></script>
</body>
</html>
