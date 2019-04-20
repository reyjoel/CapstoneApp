<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  style="height: 100%; margin: 0px; padding: 0px;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">

        <title>Guardian</title>

        {{-- Style --}}
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">

</head>

<body style="height: 100%; margin: 0px; padding: 0px;">
        <div id="app">
        <component-gua :guardian="{{ auth()->user() }}"></component-gua>
        </div>
        <script src="{{ asset('js/app.js')}}"></script>

        <div id="map" style="height: 100%; margin: 0px; padding: 0px;"></div>

            {{-- JQuery --}}
            <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

            {{-- Map --}}
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjI6B6Y0FgM--xIXhLozuzr-xscjjt-rw&callback=initMap" async defer></script>

<script>

var lines = [];
var map;

function initMap() {

var mapOptions = {
    center: new google.maps.LatLng(10.302601, 123.896132),
    zoom: 15,
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

// Location Control Function
function LocationControl(controlDivLOC, map) {

// Set CSS for the control border.
var controlLOC = document.createElement('div');
controlLOC.style.backgroundColor = '#263238';
controlLOC.style.border = '7px solid #263238';
controlLOC.style.borderRadius = '20px';
controlLOC.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
controlLOC.style.cursor = 'pointer';
controlLOC.style.marginBottom = '65px';
controlLOC.style.marginRight = '10px';
controlLOC.style.textAlign = 'center';
controlDivLOC.appendChild(controlLOC);

// Set CSS for the control interior.
var controlText = document.createElement('div');
controlText.style.WebkitUserSelect = "none";
controlText.style.MozUserSelect = "none";
controlText.style.msUserSelect = "none";
controlText.style.userSelect = "none";
controlText.style.color = '#ECEFF1';
controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
controlText.style.fontSize = '16px';
controlText.style.lineHeight = '38px';
controlText.style.paddingLeft = '5px';
controlText.style.paddingRight = '5px';
controlText.innerHTML = 'Locate My Child/Driver';
controlLOC.appendChild(controlText);

google.maps.event.addDomListener(controlLOC, 'click', showLocation);
}

function showLocation(){


    axios.get('/guardian/home/showlocation')
        .then(response => {
        var student_id = response.data.student.stu_id;
        var stuLat = JSON.parse(response.data.student.lat);
        var stuLng = JSON.parse(response.data.student.lng);
        var stuLocation = { lat: stuLat, lng: stuLng };
        var infoWindow = new google.maps.InfoWindow;


        infoWindow.setContent("<center>My Child</center>");
        infoWindow.open(map);
        infoWindow.setPosition(stuLocation);
        setTimeout(function () { infoWindow.close(); }, 2000);



        map.setZoom(13);
        map.setCenter(stuLocation);

        Echo.channel('show-location.'+student_id)
            .listen('Location', (e) => {


                                    var stuLat = JSON.parse(e.student.lat);
                                    var stuLng = JSON.parse(e.student.lng);

                                    var driLat = JSON.parse(e.driver[0].lat);
                                    var driLng = JSON.parse(e.driver[0].lng);


                                    deleteLines();

                                        var lineSymbol = {
                                            path: google.maps.SymbolPath.CIRCLE,
                                                scale: 6,
                                                    fillColor: '#263238',
                                                        fillOpacity: 1.0,
                                                    strokeColor: '#263238',
                                                strokeOpacity: 0.3,
                                            strokeWeight: 9
                                        };

                                        var line = new google.maps.Polyline({
                                            path: [{lat: stuLat, lng: stuLng}, {lat: stuLat, lng: stuLng}],
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
                                            path: [{lat: driLat, lng: driLng}, {lat: driLat, lng: driLng}],
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

        });


    });



}


// Location Control
var locControlDiv = document.createElement('div');
var locationControl = new LocationControl(locControlDiv, map);
map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(locControlDiv);


}
</script>

</body>
</html>
