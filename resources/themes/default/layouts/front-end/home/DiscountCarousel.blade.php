<style>
    .slider img {
        height: 450px;
    }
</style>
<div class="slider-container pt-0 mb-0 container-xxl">
    <div class="slider">
        @foreach ($main_banner as $banner)
            <div>
                <img class="rounded-5 imgBanner object-fit-cover"
                    src="{{ asset('storage/app/public/banner/' . $banner->photo) }}" alt="Banner Image" width="100%">
            </div>
        @endforeach
    </div>
</div>
