@extends('back.layout.pages-master')

@section('title', isset($pageTitle) ?? 'Examples Auth')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        {{ isset($pageTitle) ?: 'settings' }}
    </li>
@endsection

@section('content')
    aaaaaaaaallllllliiiiii
@endsection

