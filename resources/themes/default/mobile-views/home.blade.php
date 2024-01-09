@extends('layouts.front-end.mobile-layout')

@section('content')
   
    @foreach ($home_layouts as $layout)
        @includeIf('layouts.mobile.home.' . $layout->section_name)
    @endforeach
@endsection
