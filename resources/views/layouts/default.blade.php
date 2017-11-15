<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="AroundME">
        <meta name="author" content="AroundME">
        <title>Super Cool Layouts</title>
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
    </head>
    <body>
        <input id="pac-input" class="controls" type="text" placeholder="Enter your location">
        <div id="map"></div>
        <div class="container">
            <div id="main" class="row">
                @yield('content')
            </div>
            <footer class="row">
                <div id="copyright text-right">© Copyright 2017 AroundME</div>
            </footer>
        </div>
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo env('GOOGLE_PLACE_API_KEY'); ?>&callback=initMap&libraries=places&sensor=false"></script>
    </body>
</html>
