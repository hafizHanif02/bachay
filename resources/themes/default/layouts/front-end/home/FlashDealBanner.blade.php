<div class="sub-contain container-xxl">
    <div class="row justify-content-center align-items-center">

        <div class="col-12 text-center mb-5 sub-banner2">
        @if($flash_deal)
            <img src="{{asset('storage/app/public/deal/'.$flash_deal->banner) }}" style="border-radius:30px; width: 100%; height:50vh; object-fit:cover;" srcset="">
        @endif
        </div>


    </div>
</div>

{{-- <div class="sub-banner">
    <img class="rounded-5 img-fluid imgBanner" src="{{ Storage::url($data->pageSectionBanners[0]->banner) }}" alt="banner" width="100%">
</div> --}}
