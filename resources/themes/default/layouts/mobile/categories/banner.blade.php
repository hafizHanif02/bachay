<div class="slider-container mobileSection4">
    <div class="slider">
        @foreach ($main_section_banner as $sub_banner)
            <div>
                <img class="rounded-5 object-fit-cover"
                    src="{{ asset('storage/app/public/banner/' . $sub_banner->photo) }}" alt="Image 1" width="100%"
                    height="80px">
            </div>
        @endforeach

    </div>
</div>
