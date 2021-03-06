<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  style="height: 100%; margin: 0px; padding: 0px;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">

        <title></title>

        {{-- Style --}}
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">

</head>
<body>
    <div id="app">
        <profile-stu :student="{{ auth()->user() }}"></profile-stu>
    </div>
    <script src="{{ asset('js/app.js')}}"></script>
</body>
</html>
