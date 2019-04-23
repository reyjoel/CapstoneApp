@extends('layouts.appvue')

@section('content')
    <emergency-gua :guardian="{{ auth()->user() }}"></emergency-gua>
@endsection