@extends('layouts.backend')

@section('title')
User
@endsection

@section('headerScripts')
@include('backend.user.partials._userHeader')
@endsection

@section('heading')
Halaman Pengguna
@endsection

@section('subHeading')
User
@endsection

@section('content')
@include('backend.user.partials._userTable')
@include('backend.user.partials._addModelUser')
@include('backend.user.partials._editModelUser')
@endsection

@section('footerScripts')
@include('backend.user.partials._userScripts')
@endsection
