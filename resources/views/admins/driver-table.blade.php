@extends('layouts.app')

@section('content')
         <dritable-admin :admin="{{ auth()->user() }}"></dritable-admin>
@endsection
