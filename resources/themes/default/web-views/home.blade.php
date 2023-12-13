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

{{-- @foreach ($home_layouts as $layout)
    @includeIf('layouts.front-end.home.' . $layout->section_name)
@endforeach --}}
@include('layouts.front-end.home.DiscountCarousel')
@include('layouts.front-end.home.DiscountSlider')
@include('layouts.front-end.home.CategoryBannerSlider')
@include('layouts.front-end.home.ProductSlider')
@include('layouts.front-end.home.CategorySlider')
@include('layouts.front-end.home.ParentingTools')
@include('layouts.front-end.home.FlashDealBanner')
@include('layouts.front-end.home.UpcomingProducts')
@include('layouts.front-end.home.FooterBanner')

@endsection


{{-- @include('layouts.front-end.product.side-bar-old') --}}
@push('script')

@endpush

