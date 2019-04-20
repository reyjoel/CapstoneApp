@extends('layouts.appvue')

@section('content')
        <message-stu :student="{{ auth()->user() }}"></message-stu>
@endsection
