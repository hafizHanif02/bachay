@extends('layouts.front-end.layout')

@section('title', $web_config['name']->value.' '.translate('online_Shopping').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">


@endpush

@section('content')

@foreach ($home_layouts as $layout)
    @includeIf('layouts.front-end.home.' . $layout->section_name)
@endforeach
{{-- @include('layouts.front-end.home.section1')
@include('layouts.front-end.home.section2')
@include('layouts.front-end.home.section3')
@include('layouts.front-end.home.section4')
@include('layouts.front-end.home.section5')
@include('layouts.front-end.home.section6')
@include('layouts.front-end.home.section7')
@include('layouts.front-end.home.section8')
@include('layouts.front-end.home.section9') --}}

@endsection

@push('script')

@endpush

