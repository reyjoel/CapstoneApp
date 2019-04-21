<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  style="height: 100%; margin: 0px; padding: 0px;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">

        <title>Driver</title>

        {{-- Style --}}
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">

</head>

<body style="height: 100%; margin: 0px; padding: 0px;">

    <div id="app">
    <component-dri :driver="{{ auth()->user() }}"></component-dri>
    </div>
    <script src="{{ asset('js/app.js')}}"></script>

    <div id="map" style="height: 100%; margin: 0px; padding: 0px;"></div>

        {{-- JQuery --}}
        <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>


        {{-- Map --}}
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjI6B6Y0FgM--xIXhLozuzr-xscjjt-rw&callback=initMap" async defer></script>
        <script>

                var markers = [];
                var lines = [];
                var map;


                function initMap() {

                    var mapOptions = {
                    center: new google.maps.LatLng(10.302601, 123.896132),
                    zoom: 14,
                    disableDefaultUI: true,
                    styles:
                        [
                            {
                                "featureType": "poi",
                                "stylers": [
                                {
                                "visibility": "off"
                                }
                                ]
                            },

                            {
                                "featureType": "transit",
                                "stylers": [
                                {
                                "visibility": "off"
                                }
                                ]
                            }
                        ]
                    };


        map = new google.maps.Map(document.getElementById('map'), mapOptions);


                var sideMenu = document.getElementById('app');
                var mapActive = document.getElementById('map');

                sideMenu.addEventListener("click", function(event) {

                if(event.target != sideMenu) {

                    map.setOptions({gestureHandling: 'cooperative'});

                }

                });

                mapActive.addEventListener("click", function(event) {

                if(event.target != mapActive) {

                    map.setOptions({gestureHandling: 'greedy'});

                }

                });

    // Info Location

    getDriverLocation();

    function updateDriverLocation(position) {

    var geoLat = position.coords.latitude;
    var geoLng = position.coords.longitude;
    var geoLocation = { lat: geoLat, lng: geoLng };
    var infoWindow = new google.maps.InfoWindow;

    map.setZoom(18);
    map.setCenter(geoLocation);

    infoWindow.setContent("<center>You're here.</center>");
    infoWindow.open(map);
    infoWindow.setPosition(geoLocation);
    setTimeout(function () { infoWindow.close(); }, 3000);
    }


    function errorDriverHandler(err) {
    if(err.code == 1) {
        alert("Error: Access is denied!");
    } else if( err.code == 2) {
        alert("Error: Position is unavailable!");
    }
    }


    function getDriverLocation(){

        var driverOptions = {enableHighAccuracy: true};
        var geoLocation = navigator.geolocation;
        var watchID = geoLocation.getCurrentPosition(updateDriverLocation, errorDriverHandler, driverOptions);
    }



    // WATCH LOCATION

    getUpdateLocation();

    function updateLocation(position) {

        var geoLat = position.coords.latitude;
        var geoLng = position.coords.longitude;

        var token = document.head.querySelector('meta[name="csrf-token"]');
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

        axios.post('/driver/home',{lat: geoLat, lng: geoLng });

                                        deleteLines();
                                        var lineSymbol = {
                                            path: google.maps.SymbolPath.CIRCLE,
                                                scale: 6,
                                                    fillColor: '#E65100',
                                                        fillOpacity: 1.0,
                                                    strokeColor: '#E65100',
                                                strokeOpacity: 0.3,
                                            strokeWeight: 9
                                        };

                                        var line = new google.maps.Polyline({
                                            path: [{lat: geoLat, lng: geoLng}, {lat: geoLat, lng: geoLng}],
                                                icons: [{
                                                    icon: lineSymbol,
                                                offset: '100%'
                                                }],
                                            map: map
                                        });

                                        lines.push(line);

                                        animateCircle(line);

                                        function animateCircle(line) {
                                                var count = 0;
                                                    window.setInterval(function() {
                                                        count = (count + 1) % 200;

                                                        var icons = line.get('icons');
                                                    icons[0].offset = (count / 2) + '%';
                                                line.set('icons', icons);
                                            }, 20);
                                        }


                                        function setMapOnAll(map) {
                                        for (var i = 0; i < lines.length; i++) {
                                        lines[i].setMap(map);
                                        }
                                        }

                                        function clearLines() {
                                        setMapOnAll(null);
                                        }

                                        function deleteLines() {
                                        clearLines();
                                        lines = [];
                                        }

    }

    function getUpdateLocation(){
            var options = {enableHighAccuracy: true};
            var geoLocation = navigator.geolocation;
            var watchID = geoLocation.watchPosition(updateLocation, errorDriverHandler, options);
    }


    }
    </script>
</body>
</html>
