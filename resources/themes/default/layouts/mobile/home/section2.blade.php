<div class="slider-container mobileSection-main mt-3">
    <div class="slider-main">
        @foreach ($main_banner as $banner)
            <div>
                <img class="rounded-5 object-fit-cover"
                    src="{{ asset('storage/app/public/banner/' . $banner->mobile_photo) }}" alt="Image"
                    width="100%" height="350px">
            </div>
        @endforeach

        {{-- <div><img class="rounded-5 img-fluid imgBanner"  src="{{ asset('public/images/image 5.png') }}" alt="Image 2"></div>
        <div><img class="rounded-5 img-fluid imgBanner"  src="{{ asset('public/images/image 5.png') }}" alt="Image 3"></div> --}}
        <!-- Add more slides as needed -->
    </div>
</div>

