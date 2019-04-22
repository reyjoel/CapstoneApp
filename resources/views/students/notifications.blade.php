@extends('layouts.appvue')

@section('content')
    <notification-stu :student="{{ auth()->user() }}"></notification-stu>
@endsection
