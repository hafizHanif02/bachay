<div class="slider-container mt-4 mobileSection4">
    <div class="slider">
        @foreach($main_section_banner->reverse() as $sub_banner)   
            <div>
                <img class="rounded-5 object-fit-cover"
                    src="{{ asset('storage/app/public/banner/' . $sub_banner->photo) }}" alt="Image 1" width="100%" height="90px">
            </div>
        @endforeach
    </div>
</div>

{{-- @foreach ($main_section_banner as $sub_banner)
            <div>
                <img class="rounded-5 object-fit-cover imgBanner"
                    src="{{ asset('storage/app/public/banner/' . $sub_banner->photo) }}" alt="Image 1" width="100%" height="110px">
            </div>
        @endforeach --}}