<div class="sub-contain mt-5 mb-5">

    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 position-relative">

            <a href="">
                <img class="btm-img" src="{{ asset('public\images\img1.1.png') }}" alt="">
                    <p class="position-absolute bg-white text-dark start-50 fw-bold bottm-display-none">Topwear <i class="bi bi-chevron-right"></i></p>
            </a>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 position-relative">

            <a href="">
                <img class="btm-img" src="{{ asset('public\images\img2.2.png') }}" alt="">
                    <p class="position-absolute bg-white text-dark start-50 fw-bold bottm-display-none btm-img">Layer it up <i class="bi bi-chevron-right"></i></p>
            </a>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 position-relative">

            <a href="">
                <img class="btm-img" src="{{ asset('public\images\img3.png') }}" alt="">
                    <p class="position-absolute bg-white text-dark start-50 fw-bold bottm-display-none btm-img">Bottomwear <i class="bi bi-chevron-right"></i></p>
            </a>
        </div>
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
