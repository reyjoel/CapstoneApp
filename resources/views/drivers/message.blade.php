@extends('layouts.appvue')

@section('content')
        <message-dri :driver="{{ auth()->user() }}"></message-dri>
@endsection
