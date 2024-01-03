<div class="sub-banner container-xxl">
    @if (count($main_section_banner) > 1 && $main_section_banner)
        <img class="rounded-5 imgBanner object-fit-cover" src="{{ asset('storage/app/public/banner/'.$main_section_banner[1]->photo) }}" alt="banner" width="100%" height="280px">
    @endif
</div>