<style>
    .slider img {
        height: 450px;
    }
</style>
@foreach($category_banners as $banner)
<div class="container-xxl slider-container pt-3 mb-5">
    <div class="slider">
            <div>
                <img class="rounded-5 imgBanner object-fit-cover"
                    src="{{ asset('storage/app/public/banner/' . $banner->photo) }}" alt="Banner Image" width="100%">
            </div>
    </div>
</div>
@endforeach

