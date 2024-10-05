@extends('layouts.index')

@section('seo_title', 'МК Ростов')
@section('seo_description', 'МК Ростов')
@section('seo_keywords', 'МК Ростов')

@section('content')
    @include('home.sections._hero')
    @include('home.sections._products')
    @include('home.sections._new_items')
    @include('home.sections._process')
    @include('home.sections._services')
    @include('general._benefits')
@endsection
