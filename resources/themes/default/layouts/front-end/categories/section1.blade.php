<style>
    .slider img {
        height: 500px;
    }
</style>
<div class="container-xxl slider-container pt-3 mb-5">
    <div class="slider">
        @foreach ($main_banner as $banner)
            <div>
                <img class="rounded-5 imgBanner object-fit-cover"
                    src="{{ asset('storage/app/public/banner/' . $banner->photo) }}" alt="Banner Image" width="100%">
            </div>
        @endforeach
    </div>
</div>
