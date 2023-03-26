@extends('layouts.auth')

@section('header')
@include('auth.partials._loginHeader')
@endsection

@section('content')
@include('auth.partials._loginForm')
@endsection

@section('js')
@include('auth.partials._loginScripts')
@endsection
