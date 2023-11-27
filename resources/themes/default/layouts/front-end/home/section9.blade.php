<div class="sub-contain mt-5 mb-5">

    <div class="row">
        @foreach ($footer_banner as $banner)
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 position-relative mb-5">


                <a href="">


                    <img class="btm-img" src="{{asset('storage/app/public/banner/'.$banner->photo) }}" alt="">
                    {{-- <p class="position-absolute bg-white text-dark start-50 fw-bold bottm-display-none">Topwear <i
                            class="bi bi-chevron-right"></i></p> --}}
                </a>

        </div>
        @endforeach


    </div>
</div>
{{-- <div class="sub-contain mt-5 mb-5">
    <div class="row">
        @foreach ($data->pageSectionCategories as $pageSectionCategory)
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 position-relative">
                <a href="{{ $pageSectionCategory->link }}">
                    <img class="btm-img" src="{{ Storage::url($pageSectionCategory->image) }}" alt="Category image">
                    <p class="position-absolute bg-white text-dark start-50 fw-bold bottm-display-none">
                        {{ $pageSectionCategory->text }} <i class="bi bi-chevron-right"></i></p>
                </a>
            </div>
        @endforeach
    </div>
</div> --}}
