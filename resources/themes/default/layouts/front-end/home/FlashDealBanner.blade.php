<div class="sub-banner sub-contain container-xxl">
    @if (count($main_section_banner) > 1 && $main_section_banner)
        <img class="rounded-5 object-fit-cover"
            src="{{ asset('storage/app/public/banner/' . $main_section_banner[1]->photo) }}" alt="banner" width="100%" height="280px">
    @endif
</div>





{{-- <div class="sub-banner">
    <img class="rounded-5 img-fluid imgBanner" src="{{ Storage::url($data->pageSectionBanners[0]->banner) }}" alt="banner" width="100%">
</div> --}}
