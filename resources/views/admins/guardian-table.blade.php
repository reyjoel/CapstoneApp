@extends('layouts.app')

@section('content')
         <guatable-admin :admin="{{ auth()->user() }}"></guatable-admin>
@endsection
