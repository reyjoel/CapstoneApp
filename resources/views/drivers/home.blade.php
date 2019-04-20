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

    // DISPLAYS LOCATION

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


    var lineSymbol = {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 4,
            fillColor: '#757575',
            fillOpacity: 1.0,
            strokeColor: '#757575',
            strokeOpacity: 0.3,
            strokeWeight: 6
            };

            var line = new google.maps.Polyline({
            path: [{lat: geoLat, lng: geoLng}, {lat: geoLat, lng: geoLng}],
            icons: [{
                icon: lineSymbol,
                offset: '100%'
            }],
            map: map
            });


    }


    function errorDriverHandler(err) {
    if(err.code == 1) {
        alert("Error: Access is denied!");
    } else if( err.code == 2) {
        alert("Error: Position is unavailable!");
    }
    }


    function getDriverLocation(){

        var driverOptions = {enableHighAccuracy: true, maximumAge: Infinity};
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

    }

    function getUpdateLocation(){
            var options = {enableHighAccuracy: true};
            var geoLocation = navigator.geolocation;
            var watchID = geoLocation.watchPosition(updateLocation, errorDriverHandler, options);
    }

        // END WATCH LOCATION




    // //Geolocation Controller
    // function GeolocationControl(controlDiv, map) {

    // // Set CSS for the control button
    // var controlUI = document.createElement('div');
    //     controlUI.style.backgroundColor = '#E65100';
    //     controlUI.style.border = '7px solid #E65100';
    //     controlUI.style.borderRadius = '20px';
    //     controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
    //     controlUI.style.cursor = 'pointer';
    //     controlUI.style.marginBottom = '50px';
    //     controlUI.style.textAlign = 'center';
    //     controlDiv.appendChild(controlUI);

    // // Set CSS for the control text
    // var controlText = document.createElement('div');
    //     controlText.style.WebkitUserSelect = "none";
    //     controlText.style.MozUserSelect = "none";
    //     controlText.style.msUserSelect = "none";
    //     controlText.style.userSelect = "none";
    //     controlText.style.color = '#ECEFF1';
    //     controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
    //     controlText.style.fontSize = '16px';
    //     controlText.style.lineHeight = '38px';
    //     controlText.style.paddingLeft = '5px';
    //     controlText.style.paddingRight = '5px';
    //     controlText.innerHTML = 'Start';
    //     controlUI.appendChild(controlText);


    // // Setup the click event listeners to geolocate user
    // google.maps.event.addDomListener(controlUI, 'click', startLocation);

    // }

    // var geolocationDiv = document.createElement('div');
    // var geolocationControl = new GeolocationControl(geolocationDiv, map);
    // map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(geolocationDiv);



    // function startLocation(){

    // }

    }
    </script>
</body>
</html>
