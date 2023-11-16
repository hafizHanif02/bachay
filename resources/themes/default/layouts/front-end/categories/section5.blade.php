{{-- {{-- <div class="cateSlider space-between pb-5 pt-5">


    <div class="slider-category mt-3 mb-3">

        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                    <img class="New-Season rounded-circle new-arival-container" src="{{ asset('web/images/cate-img1.png') }}" alt="">
                </div>

                <h3 class="text-center gradient-text fs-6">New Season</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Gifts rounded-circle new-arival-container" src="{{ asset('web/images/cate-img2.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Health & Safety</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Kids-Accessories rounded-circle new-arival-container" src="{{ asset('web/images/cate-img3.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Nursing</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Fashion rounded-circle new-arival-container" src="{{ asset('web/images/kid.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Fashion</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Education rounded-circle new-arival-container" src="{{ asset('web/images/cate-img4.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Education</h3>
            </a>
        </div>

        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                    <img class="New-Season rounded-circle new-arival-container" src="{{ asset('web/images/cate-img1.png') }}" alt="">
                </div>

                <h3 class="text-center gradient-text fs-6">New Season</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Gifts rounded-circle new-arival-container" src="{{ asset('web/images/cate-img2.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Health & Safety</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Kids-Accessories rounded-circle new-arival-container" src="{{ asset('web/images/cate-img3.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Nursing</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Fashion rounded-circle new-arival-container" src="{{ asset('web/images/kid.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Fashion</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Education rounded-circle new-arival-container" src="{{ asset('web/images/cate-img4.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Education</h3>
            </a>
        </div>

        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                    <img class="New-Season rounded-circle new-arival-container" src="{{ asset('web/images/cate-img1.png') }}" alt="">
                </div>

                <h3 class="text-center gradient-text fs-6">New Season</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Gifts rounded-circle new-arival-container" src="{{ asset('web/images/cate-img2.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Health & Safety</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Kids-Accessories rounded-circle new-arival-container" src="{{ asset('web/images/cate-img3.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Nursing</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Fashion rounded-circle new-arival-container" src="{{ asset('web/images/kid.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Fashion</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Education rounded-circle new-arival-container" src="{{ asset('web/images/cate-img4.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-6">Education</h3>
            </a>
        </div>

    </div>

</div> --}}




{{-- <div class="cateSlider space-between">
    <div class="slider-category mt-3">
        @foreach ($data->pageSectionCategories as $pageSectionCategory)
            <div>
                <a href="{{ $pageSectionCategory->link }}" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="New-Season rounded-circle new-arival-container" src="{{ Storage::url($pageSectionCategory->image) }}" alt="Category image">
                    </div>
                    <h3 class="text-center gradient-text fs-6">{{ $pageSectionCategory->text }}</h3>
                </a>
            </div>
        @endforeach
    </div>
</div>  --}}
<div class="mainCon mb-4 space-between">
    @php
        $pageSectionCategories = $data->pageSectionCategories;
    @endphp
    <div class="scroll-cards mt-4">
        @foreach ($pageSectionCategories as $pageSectionCategory)
            <div class="circleCard">
                <a href="{{ $pageSectionCategory->link }}" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ Storage::url($pageSectionCategory->image) }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">{{ $pageSectionCategory->text }}</h4>
                </a>
            </div>
        @endforeach
    </div>
</div>
