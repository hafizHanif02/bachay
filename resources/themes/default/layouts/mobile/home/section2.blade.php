<div class="slider-container mobileSection-main mt-3">
    <div class="slider-main">
        @foreach ($main_banner as $banner)
            <div>
                <img class="rounded-5 img-fluid imgBanner"
                    src="{{ asset('storage/app/public/banner/' . $banner->photo) }}" alt="Image">
            </div>
        @endforeach

        {{-- <div><img class="rounded-5 img-fluid imgBanner"  src="{{ asset('public/images/image 5.png') }}" alt="Image 2"></div>
        <div><img class="rounded-5 img-fluid imgBanner"  src="{{ asset('public/images/image 5.png') }}" alt="Image 3"></div> --}}
        <!-- Add more slides as needed -->
    </div>
</div>

