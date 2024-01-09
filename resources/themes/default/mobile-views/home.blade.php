@extends('layouts.front-end.mobile-layout')

@section('content')
@include('layouts.mobile.home.section1')
@include('layouts.mobile.home.section2')
@include('layouts.mobile.home.section3')
@include('layouts.mobile.home.section4')
@include('layouts.mobile.home.section5')
@include('layouts.mobile.home.section6')
@include('layouts.mobile.home.section7')
@include('layouts.mobile.home.section8')
@include('layouts.mobile.home.section9')
@include('layouts.mobile.home.section10')
@include('layouts.mobile.home.section11')
@include('layouts.mobile.home.section12')
@include('layouts.mobile.home.section13')
@include('layouts.mobile.home.section14')


    {{-- @foreach ($home_layouts as $layout)
        @includeIf('layouts.mobile.home.' . $layout->section_name)
    @endforeach --}}
@endsection
