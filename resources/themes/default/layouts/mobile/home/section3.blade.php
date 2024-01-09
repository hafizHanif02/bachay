<div class="heading-con d-flex justify-content-between align-items-baseline mt-4">
    <div class="heading">
        <h1 class="textClr">Categories</h1>
    </div>
    <div class="see-all">
        <a class="text-dark" href="{{ route('categories') }}">See All</a>
    </div>
</div>

<div class="mobileContainer space-between">
    <div class="slider-nav mt-3">

        @foreach ($categories->shuffle() as $category)
            <div class="main_container_category">
                <div>
                    <a href="#" class="text-decoration-none ">
                        <div class="for-sizing">
                            <img class="New-Season rounded-circle new-arival-container"
                                src="{{ asset('storage/app/public/category') }}/{{ $category['icon'] }}" alt="">
                        </div>
    
                        <h3 class="ps-1 gradient-text fs-12">
                            @if (strlen($category->name) <= 10)
                                {{ $category->name }}
                            @else
                                {{ substr($category->name, 0, 10) }}<span id="dots">...</span>
                            @endif
                        </h3>
                    </a>

                </div>
            </div>
        @endforeach
      
        {{-- <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Gifts rounded-circle new-arival-container" src="{{ asset('public/images/cate-img2.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-12">Gifts <span class="text-success">-15%</span></h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Kids-Accessories rounded-circle new-arival-container" src="{{ asset('public/images/cate-img3.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-12">Kids Accessories</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Fashion rounded-circle new-arival-container" src="{{ asset('public/images/kid.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-12">Fashion</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Education rounded-circle new-arival-container" src="{{ asset('public/images/cate-img4.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-12">Education</h3>
            </a>
        </div> --}}

    </div>

    <div class="slider-nav">

        @foreach ($categories->shuffle() as $category)
            <div class="">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="New-Season rounded-circle new-arival-container"
                            src="{{ asset('storage/app/public/category') }}/{{ $category['icon'] }}" alt="">
                    </div>

                    <h3 class="ps-1 gradient-text fs-12">
                        @if (strlen($category->name) <= 10)
                            {{ $category->name }}
                        @else
                            {{ substr($category->name, 0, 10) }}<span id="dots">...</span>
                        @endif
                    </h3>
                </a>
            </div>
        @endforeach
        {{-- <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Gifts rounded-circle new-arival-container" src="{{ asset('public/images/cate-img3.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-12">Gifts <span class="text-success">-15%</span></h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Kids-Accessories rounded-circle new-arival-container" src="{{ asset('public/images/cate-img1.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-12">Kids Accessories</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Fashion rounded-circle new-arival-container" src="{{ asset('public/images/cate-img4.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-12">Fashion</h3>
            </a>
        </div>
        <div class="">
            <a href="#" class="text-decoration-none">
                <div class="for-sizing">
                <img class="Education rounded-circle new-arival-container" src="{{ asset('public/images/cate-img2.png') }}" alt="">
                </div>
                <h3 class="text-center text-dark fs-12">Education</h3>
            </a>
        </div> --}}

    </div>

</div>
