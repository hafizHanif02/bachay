<div class="border-t pt-4 mt-5">
    <h5 class="font-poppins slider-heading">
        You May Also Like
    </h5>
</div>


<div class="mt-5 card-slider">

    @foreach ($relatedProducts as $related )

    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
            <div class="card1">
                <div class="first-sec card1">
                    <div class="image-container">
                        @foreach (json_decode($related->images) as $key => $photo)
                        <img src="{{ asset("storage/app/public/product/$photo")  }}" alt="" class="img-fluid"
                            width="100%" height="100%">
                            @break($loop->first)
                        @endforeach

                        <div class="sec-best-seller mt-3">
                            <p>Best Seller</p>
                        </div>
                        <div class="wish-list mt-3 me-2">
                            <a href=""><img src="{{ asset('public/images/heart.svg') }}"
                                    alt=""></a>
                        </div>
                        <p class="product-text mt-3">
                            @if (strlen($related->name) <= 25)
                                        {{ $related->name }}
                                    @else
                                        {{ substr($related->name, 0, 25) }}<span id="dots"> ....</span>
                                    @endif

                        </p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. {{ $related->unit_price - ($related->unit_price * $related->discount) / 100 }}</p>
                            <p class="card-text"><span class="discount">Rs. {{ $related->unit_price }}</span> <span
                                    class="text-success">-{{ $related->discount }}% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                    @foreach ($related->reviews as $reviews)
                                    <p class="m-0">{{ $reviews }}<span
                                            class="Reviews">({{ $related->reviews_count }})</span></p>
                                @endforeach
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

</div>


<div class="border-t pt-4">
    <h5 class="font-poppins slider-heading">
        You May Also Like
    </h5>
</div>


<div class="mt-5 card-slider">

    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- <div class="border-t pt-4">
    <h5 class="font-poppins slider-heading">
        You May Also Like
    </h5>
</div>


<div class="mt-5 card-slider">

    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4 pb-3 me-3">
        <div class="rounded-3">
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
                        <p class="product-text mt-3">Class aptent taciti sociosq ad litora sit amet,
                            ipiscin</p>


                        <div class="d-flex">
                            <p class="product-price me-2">Rs. 1999</p>
                            <p class="card-text"><span class="discount">Rs. 3999</span> <span
                                    class="text-success">-85% Off</span></p>

                        </div>

                        <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                    alt="">
                                <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                            </div>
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                          <a href=""><img src="{{ asset('public/images/cart-image.svg') }}" alt=""></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> --}}




