@extends('layouts.appvue')

@section('content')
        <notifications-gua :guardian="{{ auth()->user() }}"></notifications-gua>
@endsection
