@extends('layouts.appvue')

@section('content')
    <emergency-dri :driver="{{ auth()->user() }}"></emergency-dri>
@endsection