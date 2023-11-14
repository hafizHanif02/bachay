<main>
    {{-- banner image --}}
    <div class="full-width-banner">
        <a href="#">
            <img src="{{ asset("public/images/banner.png") }}" height="100%" width="100%" alt="banner image">
        </a>
    </div>
    {{-- category banner --}}
    <div class="sub-banner">
        <a href="#">
            <img class="rounded-5 img-fluid imgBanner" src="{{ asset("public/images/category.png") }}" alt="banner" width="100%">
        </a>
    </div>
    {{-- category card --}}
    <div class="mainCon space-between">
        @if (isset($data->pageSectionHeading))
            <div class="category-header d-flex justify-content-between align-items-center">
                <h1 class="text-start textClr">{{ $data->pageSectionHeading->heading }}</h1>
                <a class="d-flex align-items-center text-dark" href="{{ route('categories') }}">
                    <h5>See All</h5>
                </a>
            </div>
        @endif
        <div class="scroll-cards mt-5">
                <div class="circleCard">
                    <a href="" class="text-decoration-none">
                        <div class="for-sizing">
                            <img class="CategImg rounded-circle object-fit-cover"
                                src="" alt="Category image" width="100%"
                                height="100%">
                        </div>
                        <h4 class="text-center gradient-text"></h4>
                    </a>
                </div>
        </div>
    </div>
    {{-- category slider --}}
    <div class="new-arival mt-4">
        <div class="sub-container bg-white pt-5 pb-5 rounded-5">
            @if (isset($data->pageSectionHeading))
            <h1 class="text-center textClr"></h1>
            @endif
            <div class="row justify-content-evenly ps-5 pe-5 pt-5">
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12 p-0">
                        <a href="#" class="text-decoration-none">
                            <img class="NewSeasonBorder rounded-5 new-arival-container" src="" alt="Category image">
                            <h3 class="text-center gradient-text mt-1"></h3>
                        </a>
                    </div>
            </div>
        </div>
    </div>
    {{-- discount carousel --}}
    <div class="slider-container mb-5 mt-5">
        <div class="slider">
            <div>
                <a href="#">
                    <img class="rounded-5 img-fluid imgBanner"  src="{{ asset("public/images/brand-banner.png") }}" alt="Image 1">
                </a>
            </div>
        </div>
    </div>
    {{-- discount slider --}}
    <div class="flash-sales">
        @if (isset($data->pageSectionHeading))
            <h1 class="text-center textClr"></h1>
        @endif
        <div class="row mt-5 col-12 flash-sales-container">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
                    <div class="card rounded-5">
                        <a href="">
                            <div class="deal-alert-circle">-%</div>
                            <div class="forHeight">
                                <img class="object-fit-cover card-img rounded-5"
                                    src="{{ asset("public/images/flash-sales1.png") }}"
                                    alt="Flash Sale " width="100%" height="100%" />
                            </div>
                            <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                                <p class="card-text"></p>
                            </div>
                        </a>
                    </div>
                </div>
        </div>
    </div>
    {{-- parenting tool --}}
    <div class="sub-banner">
        <h1 class="textClr text-center">
        </h1>
        <div class="row mt-5" id="card-container">
                <div class="col mb-5 ParentingTool d-flex justify-content-center align-items-center">
                    <div class="outer1">
                        <div class="card card-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <span class="w-100 bg-white ps-3 pe-3 pt-1 pb-1 rounded-pill articles">
                                            
                                        </span>
                                    </div>
                                    <div class="col-12 text-center">
                                        <img class="mt-5 mb-5 articles-img" src="{{ asset("public/images/cate-img3.png") }}" alt="category image"
                                            srcset="">
                                    </div>
                                    <div class="col-12 text-center">
                                        <a href="" class="text-white text-decoration-none">
                                            Learn More &nbsp;<i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    {{-- product slider --}}
    <div class="sub-contain mt-5">
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <h1 class="textClr"></h1>
                <a class="d-flex align-items-center text-dark" href="{{ route('categories') }}">
                    <h5>See All</h5>
                </a>
            </div>
        </div>
        <div class="main-con mt-5">
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4">                   
                    <div class="sub-card rounded-3 p-4">
                        <div class="card1">
                            <div class="first-sec card1">
                                <div class="image-container">
                                    <a href="">
                                        <img src="{{ asset("public/images/savings.png") }}"
                                            alt="Product image" class="img-fluid" width="100%" height="100%">
                                    </a>
                                    <div class="sec-best-seller mt-3">
                                        <p>Best Seller</p>
                                    </div>
                                    <div class="wish-list mt-3 me-2">
                                        <button type="button"
                                            name="wishlist-button-"
                                            class="p-0 bg-transparent rounded-circle forBorder"
                                            onclick="">
                                            <i
                                                class="bi text-danger"></i>
                                        </button>
                                    </div>
                                    <p class="card-text mt-3">
                                    </p>
                                    <div class="d-flex">
                                        <h4 class="card-text price">
                                            Rs 
                                        </h4>
                                        <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 mt-1 text-white units">
                                            
                                            Solds
                                        </p>
                                    </div>
                                    <p class="card-text"><span
                                            class="discount">Rs </span>
                                        <span
                                            class="text-success">-%
                                            Off</span>
                                    </p>
                                    <div class="subdiv d-flex justify-content-between">
                                        <a href="#">Standard Delivery</a>
                                        <p class="rounded-pill text-white">
                                                <img
                                                src="{{ asset("public/images/star.svg") }}" alt=""></p>
                                        <h5></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</main>
