<div class="full-s-banner object-fit-cover mt-5">
    @if (count($main_section_banner) > 1 && $main_section_banner)
    <img class="" src="{{ asset('storage/app/public/banner/'.$main_section_banner[1]->photo) }}" alt="" width="100%" height="200px">
    @endif
</div>
