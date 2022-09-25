@php
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'githubAuth' => config('services.github.client_id'),
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<link rel="manifest" type="text/css" href="{{ asset('dist/js/manifest.json') }}">
<link rel="manifest" type="text/css" href=" {{ asset('dist/fontawesome/css/all.css') }} ">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{ config('app.name') }}</title>

  <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
</head>
<body>
  <script type="text/javascript" src="{{ asset('dist/fontawesome/js/all.js') }}"></script>
  <script type="text/javascript" src="{{ asset('dist/recorder.js') }}"></script>
  <script type="text/javascript" src="{{ asset('dist/attack.js') }}"></script>

  <div id="app"></div>

  {{-- Global configuration object --}}
  <script>
    window.config = @json($config);
  </script>

  {{-- Load the application scripts --}}
  <script src="{{ mix('dist/js/app.js') }}"></script>
</body>
</html>
