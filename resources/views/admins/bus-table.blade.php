@extends('layouts.app')

@section('content')
         <bustable-admin :admin="{{ auth()->user() }}"></bustable-admin>
@endsection
