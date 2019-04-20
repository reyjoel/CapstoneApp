@extends('layouts.app')

@section('content')
         <stutable-admin :admin="{{ auth()->user() }}"></stutable-admin>
@endsection
