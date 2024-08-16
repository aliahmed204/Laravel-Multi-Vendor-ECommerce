@extends('back.layout.pages-master')

@section('title', isset($pageTitle) ?: 'seller')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($pageTitle) ?: 'settings' }}
    </li>
@endsection

@section('content')
    seller home page
@endsection

