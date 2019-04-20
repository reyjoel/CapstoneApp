@extends('layouts.appvue')

@section('content')
        <component-admin :admin="{{ auth()->user() }}"></component-admin>
@endsection
