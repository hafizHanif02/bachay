
<div class="sub-banner container-xxl">
    @if (count($main_section_banner) > 0 && $main_section_banner)
        <img class="rounded-5 imgBanner object-fit-cover" src="{{ asset('storage/app/public/banner/'.$main_section_banner[0]->photo) }}" alt="banner" width="100%" height="280px">
    @endif
</div>







{{-- @foreach($main_section_banner as $sub_banner) --}}
{{-- <div class="slider-container pt-3 mb-5">
    <div class="slider">
        @foreach($main_banner as $banner)        
        <div><img class="rounded-5 img-fluid imgBanner"  src="{{ asset('storage/app/public/banner/'.$banner->photo) }}" alt="Image 3"></div>
        @endforeach
    </div>
</div>   --}}
