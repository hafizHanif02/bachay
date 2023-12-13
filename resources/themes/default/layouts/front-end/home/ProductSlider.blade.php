<div class="sub-contain">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="textClr m-0">Autum Whjisper</h1>
            <a class="d-flex align-items-center text-dark" href="{{ route('product-list') }}">
                <h5 class="m-0">See All</h5>
            </a>
        </div>
    </div>


    <div class="row">
        @foreach ($latest_products as $products)
            <div class="col-md-6 col-lg-3 mb-4">
                <a class="text-decoration-none" href="{{ route('product-detail', $products->id) }}">
                <div class="sub-card rounded-3 p-4">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <div class="imgCon">
                                    <img class="object-fit-cover rounded-3"
                                        src="{{ asset("storage/app/public/product/thumbnail/$products->thumbnail") }}"
                                        alt="" class="img-fluid" width="100%" height="100%">
                                </div>
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <button id="wishlist-btn" class="p-0 bg-transparent rounded-circle forBorder">
                                        <i class="bi bi-heart text-danger"></i>
                                        {{-- <i
                                class="bi {{ in_array($product->id, $wishlistProducts) ? 'bi-heart-fill' : 'bi-heart' }} text-danger"></i> --}}
                                    </button>
                                </div>
                                {{-- <div class="wish-list mt-3 me-2">
                                    <a href=""><img src="{{ asset('public/images/heart.svg') }}"
                                            alt=""></a>
                                </div> --}}
                                <p class="card-text mt-3" id="productDescription">
                                    @if (strlen($products->name) <= 20)
                                        {{ $products->name }}
                                    @else
                                        {{ substr($products->name, 0, 20) }}<span id="dots"> ....</span>
                                    @endif
                                </p>
                                <div class="d-flex">
                                    <h6 class="card-text price">Rs.
                                        {{ $products->unit_price - ($products->unit_price * $products->discount) / 100 }}
                                    </h6>
                                    {{-- <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 text-white units">141 Solds
                                    </p> --}}
                                </div>
                                <p class="card-text"><span class="discount">Rs. {{ $products->unit_price }}</span> <span
                                        class="text-success">-{{ $products->discount }}% Off</span></p>
                                <div class="subdiv d-flex justify-content-between">
                                    <a href="#">Standard Delivery</a>
                                    @foreach ($products->reviews as $reviews)
                                        <p class="rounded-pill text-white">{{ $reviews }} <img
                                                src="{{ asset('public/images/star.svg') }}" alt=""></p>
                                    @endforeach

                                    <h5>({{ $products->reviews_count }})</h5>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                </a>
            </div>
        @endforeach
        {{-- <div class="col-md-6 col-lg-3 mb-4">
                <div class="sub-card rounded-3 p-4">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <img src="{{ asset('public/images/card.png') }}" alt="" class="img-fluid"
                                    width="100%" height="100%">
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <a href=""><img src="{{ asset('public/images/heart.svg') }}"
                                            alt=""></a>
                                </div>
                                <p class="card-text mt-3">Class aptent taciti sociosq ad litora sit amet, ipiscin....
                                </p>
                                <div class="d-flex">
                                    <h4 class="card-text price">Rs. 1999</h4>
                                    <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 mt-1 text-white units">141 Solds
                                    </p>
                                </div>

                                <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                        class="text-success">-85% Off</span></p>
                                <div class="subdiv d-flex justify-content-between">
                                    <a href="#" class="bg-primary">Standard Delivery</a>
                                    <p class="rounded-pill text-white">4.9 <img
                                            src="{{ asset('public/images/star.svg') }}" alt=""></p>
                                    <h5>(17)</h5>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="sub-card rounded-3 p-4">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <img src="{{ asset('public/images/card.png') }}" alt="" class="img-fluid"
                                    width="100%" height="100%">
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <a href=""><img src="{{ asset('public/images/heart.svg') }}"
                                            alt=""></a>
                                </div>
                                <p class="card-text mt-3">Class aptent taciti sociosq ad litora sit amet, ipiscin....
                                </p>
                                <div class="d-flex">
                                    <h4 class="card-text price">Rs. 1999</h4>
                                    <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 mt-1 text-white units">141 Solds
                                    </p>
                                </div>

                                <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                        class="text-success">-85% Off</span></p>
                                <div class="subdiv d-flex justify-content-between">
                                    <a href="#" class="bg-primary">Standard Delivery</a>
                                    <p class="rounded-pill text-white">4.9 <img
                                            src="{{ asset('public/images/star.svg') }}" alt=""></p>
                                    <h5>(17)</h5>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="sub-card rounded-3 p-4">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <img src="{{ asset('public/images/card.png') }}" alt="" class="img-fluid"
                                    width="100%" height="100%">
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <a href=""><img src="{{ asset('public/images/heart.svg') }}"
                                            alt=""></a>
                                </div>
                                <p class="card-text mt-3">Class aptent taciti sociosq ad litora sit amet, ipiscin....
                                </p>
                                <div class="d-flex">
                                    <h4 class="card-text price">Rs. 1999</h4>
                                    <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 mt-1 text-white units">141 Solds
                                    </p>
                                </div>
                                <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                        class="text-success">-85% Off</span></p>
                                <div class="subdiv d-flex justify-content-between">
                                    <a href="#">Standard Delivery</a>
                                    <p class="rounded-pill text-white">4.9 <img
                                            src="{{ asset('public/images/star.svg') }}" alt=""></p>
                                    <h5>(17)</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="sub-card rounded-3 p-4">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <img src="{{ asset('public/images/card.png') }}" alt="" class="img-fluid"
                                    width="100%" height="100%">
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <a href=""><img src="{{ asset('public/images/heart.svg') }}"
                                            alt=""></a>
                                </div>
                                <p class="card-text mt-3">Class aptent taciti sociosq ad litora sit amet, ipiscin....
                                </p>
                                <div class="d-flex">
                                    <h4 class="card-text price">Rs. 1999</h4>
                                    <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 mt-1 text-white units">141 Solds
                                    </p>
                                </div>
                                <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                        class="text-success">-85% Off</span></p>
                                <div class="subdiv d-flex justify-content-between">
                                    <a href="#">Standard Delivery</a>
                                    <p class="rounded-pill text-white">4.9 <img
                                            src="{{ asset('public/images/star.svg') }}" alt=""></p>
                                    <h5>(17)</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="sub-card rounded-3 p-4">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <img src="{{ asset('public/images/card.png') }}" alt="" class="img-fluid"
                                    width="100%" height="100%">
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <a href=""><img src="{{ asset('public/images/heart.svg') }}"
                                            alt=""></a>
                                </div>
                                <p class="card-text mt-3">Class aptent taciti sociosq ad litora sit amet, ipiscin....
                                </p>
                                <div class="d-flex">
                                    <h4 class="card-text price">Rs. 1999</h4>
                                    <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 mt-1 text-white units">141 Solds
                                    </p>
                                </div>
                                <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                        class="text-success">-85% Off</span></p>
                                <div class="subdiv d-flex justify-content-between">
                                    <a href="#" class="bg-primary">Standard Delivery</a>
                                    <p class="rounded-pill text-white">4.9 <img
                                            src="{{ asset('public/images/star.svg') }}" alt=""></p>
                                    <h5>(17)</h5>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="sub-card rounded-3 p-4">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <img src="{{ asset('public/images/card.png') }}" alt="" class="img-fluid"
                                    width="100%" height="100%">
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <a href=""><img src="{{ asset('public/images/heart.svg') }}"
                                            alt=""></a>
                                </div>
                                <p class="card-text mt-3">Class aptent taciti sociosq ad litora sit amet, ipiscin....
                                </p>
                                <div class="d-flex">
                                    <h4 class="card-text price">Rs. 1999</h4>
                                    <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 mt-1 text-white units">141 Solds
                                    </p>
                                </div>

                                <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                        class="text-success">-85% Off</span></p>
                                <div class="subdiv d-flex justify-content-between">
                                    <a href="#" class="bg-primary">Standard Delivery</a>
                                    <p class="rounded-pill text-white">4.9 <img
                                            src="{{ asset('public/images/star.svg') }}" alt=""></p>
                                    <h5>(17)</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="sub-card rounded-3 p-4">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <img src="{{ asset('public/images/card.png') }}" alt="" class="img-fluid"
                                    width="100%" height="100%">
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <a href=""><img src="{{ asset('public/images/heart.svg') }}"
                                            alt=""></a>
                                </div>
                                <p class="card-text mt-3">Class aptent taciti sociosq ad litora sit amet, ipiscin....
                                </p>
                                <div class="d-flex">
                                    <h4 class="card-text price">Rs. 1999</h4>
                                    <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 mt-1 text-white units">141 Solds
                                    </p>
                                </div>

                                <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                        class="text-success">-85% Off</span></p>
                                <div class="subdiv d-flex justify-content-between">
                                    <a href="#">Standard Delivery</a>
                                    <p class="rounded-pill text-white">4.9 <img
                                            src="{{ asset('public/images/star.svg') }}" alt=""></p>
                                    <h5>(17)</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
    </div>

</div>
{{-- <div class="sub-contain">
    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <h1 class="textClr">{{ $data->pageSectionHeading->heading }}</h1>
            <a class="d-flex align-items-center text-dark" href="#">
                <h5>See All</h5>
            </a>
        </div>
    </div>
    <div class="main-con mt-5">
        <div class="row">
            @foreach ($data->pageSectionProducts as $pageSectionProduct)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="sub-card rounded-3 p-4">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <img src="{{ asset('web/images/card.png') }}" alt="" class="img-fluid"
                                    width="100%" height="100%">
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <a href=""><img src="{{ asset('web/images/heart.svg') }}" alt=""></a>
                                </div>
                                <p class="card-text mt-3">{{ $pageSectionProduct->product->name }}
                                </p>
                                @php
                                    $onePercent = (1/100) * $pageSectionProduct->product->productAttributes[0]->price;
                                    $percentValue = $pageSectionProduct->product->productAttributes[0]->discount_percentage * $onePercent;
                                    $priceAfterSale = $pageSectionProduct->product->productAttributes[0]->price - $percentValue
                                @endphp
                                <div class="d-flex">
                                    <h4 class="card-text price">{{ $pageSectionProduct->product->productAttributes[0]->currency->symbol.' '.$priceAfterSale }}</h4>
                                    <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 mt-1 text-white units">141 Solds
                                    </p>
                                </div>

                                <p class="card-text"><span class="discount">{{ $pageSectionProduct->product->productAttributes[0]->currency->symbol.' '.$pageSectionProduct->product->productAttributes[0]->price }}</span> <span
                                        class="text-success">-{{ $pageSectionProduct->product->productAttributes[0]->discount_percentage }}% Off</span></p>
                                <div class="subdiv d-flex justify-content-between">
                                    <a href="#">Standard Delivery</a>
                                    <p class="rounded-pill text-white">4.9 <img src="{{ asset('web/images/star.svg') }}"
                                            alt=""></p>
                                    <h5>(17)</h5>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div> --}}