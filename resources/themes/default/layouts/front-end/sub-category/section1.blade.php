{{-- <div class="slider-container pt-3 mb-5">
    <div class="slider">
        <div><img class="rounded-5 img-fluid imgBanner"  src="{{ asset('public/images/sub-category-banner.png') }}" alt="Image 1"></div>
        <div><img class="rounded-5 img-fluid imgBanner"  src="{{ asset('public/images/sub-category-banner.png') }}" alt="Image 2"></div>
        <div><img class="rounded-5 img-fluid imgBanner"  src="{{ asset('public/images/sub-category-banner.png') }}" alt="Image 3"></div>
    </div>
</div> --}}

<style>

    .slider img {
        height: 80vh;
    }
</style>
<div class="slider-container pt-3 mb-5">
    <div class="slider">
        @foreach($main_banner as $banner)
        <div>
            <img class="rounded-5 imgBanner object-fit-cover" src="{{ asset('storage/app/public/banner/'.$banner->photo) }}" alt="Banner Image" width="100%">
        </div>
        @endforeach
    </div>
</div> 