<!DOCTYPE html>
<html>
  <head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }}</title>
<!-- Styles -->
<script src="{{asset('js/app.js')}}" defer></script>
<link href="{{asset('css/app.css')}}" rel="stylesheet">
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.4.0/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.4.0/mapbox-gl.css' rel='stylesheet' />
  </head>
  <body>
    <div >
        @yield('content')
    </div>
  </body>
<style>
        .mapboxgl-popup {
            max-width: 400px;
            font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
        }
</style>
@yield('script')
</html>