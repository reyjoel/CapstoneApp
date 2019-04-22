@extends('layouts.appvue')

@section('content')
    <notifications-dri :driver="{{ auth()->user() }}"></notifications-dri>
@endsection
