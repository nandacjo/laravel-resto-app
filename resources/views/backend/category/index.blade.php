@extends('layouts.backend')

@section('title')
    {{ $data['title'] }}
@endsection


@section('headerScripts')
    <!-- Csrf Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- sweetalert css -->
    <link rel="stylesheet" href="{{ asset('sweetalert/sweetalert2.min.css') }}">

    <!-- Library Datatable -->
    <link rel="stylesheet" href="{{ asset('datatable/dataTables.bootstrap4.min.css') }}">

    <style>
        .show {
            background-color: 'blue'
        }
    </style>
@endsection

@section('heading')
    {{ $data['heading'] }}
@endsection

@section('subHeading')
    {{ $data['subheading'] }}
@endsection

@section('content')
    <div x-data="{ open: '' }">

        <div x-text="open">

        </div>
    </div>


    @if (request()->is('category/trash'))
        @include('backend.category._trashCategoryTable')
    @else
        @include('backend.category._categoryTable')
    @endif
    @include('backend.category._addModalKategory')
    @include('backend.category._editModalKategory')
@endsection

@section('footerScripts')
    @include('backend.category._scriptsCategory')
@endsection
