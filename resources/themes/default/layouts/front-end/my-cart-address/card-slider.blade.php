<div class="border-t pt-4">
    <h5 class="font-poppins slider-heading">
        You May Also Like
    </h5>
</div>

@php
    $shuffledProducts = $products->shuffle();
@endphp
<div class="mt-5 card-slider">
    @foreach ($shuffledProducts as $product)
        <div class="mb-4 pb-3 me-3">
            <a class="text-decoration-none" href="{{ route('product-detail', $product->id) }}">
                <div class="rounded-3">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <div class="imgMAinH">
                                    <img src="{{ asset("storage/app/public/product/thumbnail/$product->thumbnail") }}"
                                        alt="" class="object-fit-cover rounded-2" width="100%" height="100%">
                                </div>
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <button id="wishlist-btn" class="p-0 bg-transparent rounded-circle forBorder">
                                        <i class="bi bi-heart text-danger"></i>
                                    </button>
                                </div>
                                <p class="product-text mt-3">
                                    @if (strlen($product->name) <= 30)
                                        {{ $product->name }}
                                    @else
                                        {{ substr($product->name, 0, 30) }}<span id="dots"> ....</span>
                                    @endif
                                </p>
                                <div class="d-flex">
                                    <p class="product-price me-2">Rs.
                                        {{ $product->unit_price - ($product->unit_price * $product->discount) / 100 }}
                                    </p>
                                    <p class="card-text"><span class="discount">Rs.
                                            {{ $product->unit_price }}</span>
                                        <span class="text-success">-{{ $product->discount }}%</span>
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between for-border-g">
                                    <div class="ratings-reviews d-flex">
                                        <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                            alt="">
                                        <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                                        @foreach ($product->reviews as $reviews)
                                            <p class="m-0">{{ $reviews }}<span
                                                    class="Reviews">({{ $products->reviews_count }})</span></p>
                                        @endforeach
                                    </div>
                                    <a href="#" class="delivery-btn">Standard Delivery</a>
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <button class="buy-now rounded-pill text-white">Buy Now</button>
                                    <button id="cart-btn" class="p-0 bg-transparent rounded-circle forBorder">
                                        <i class="bi bi-cart"></i>
                                        {{-- <i
                                class="bi {{ in_array($product->id, $cartProducts) ? 'bi-cart-fill' : 'bi-cart' }} text-purple"></i> --}}
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>


{{-- <div class="border-t pt-4">
    <h5 class="font-poppins slider-heading">
        You May Also Like
    </h5>
</div> --}}

@php
    $shuffledProducts = $products->shuffle();
@endphp
<div class="mt-5 card-slider">
    @foreach ($shuffledProducts as $product)
        <div class="mb-4 pb-3 me-3">
            <a class="text-decoration-none" href="{{ route('product-detail', $product->id) }}">
                <div class="rounded-3">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <div class="imgMAinH">
                                    <img src="{{ asset("storage/app/public/product/thumbnail/$product->thumbnail") }}"
                                        alt="" class="object-fit-cover rounded-2" width="100%" height="100%">
                                </div>
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <button id="wishlist-btn" class="p-0 bg-transparent rounded-circle forBorder">
                                        <i class="bi bi-heart text-danger"></i>
                                    </button>
                                </div>
                                <p class="product-text mt-3">
                                    @if (strlen($product->name) <= 30)
                                        {{ $product->name }}
                                    @else
                                        {{ substr($product->name, 0, 30) }}<span id="dots"> ....</span>
                                    @endif
                                </p>
                                <div class="d-flex">
                                    <p class="product-price me-2">Rs.
                                        {{ $product->unit_price - ($product->unit_price * $product->discount) / 100 }}
                                    </p>
                                    <p class="card-text"><span class="discount">Rs.
                                            {{ $product->unit_price }}</span>
                                        <span class="text-success">-{{ $product->discount }}%</span>
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between for-border-g">
                                    <div class="ratings-reviews d-flex">
                                        <img class="me-2" src="{{ asset('web/images/vector-star.svg') }}"
                                            alt="">
                                        <div class="ratings-reviews d-flex">
                                            <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                                alt="">
                                            <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                                        </div>
                                        @foreach ($product->reviews as $reviews)
                                            <p class="m-0">{{ $reviews }}<span
                                                    class="Reviews">({{ $products->reviews_count }})</span></p>
                                        @endforeach
                                    </div>
                                    <a href="#" class="delivery-btn">Standard Delivery</a>
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <button class="buy-now rounded-pill text-white">Buy Now</button>
                                    <button id="cart-btn" class="p-0 bg-transparent rounded-circle forBorder">
                                        <i class="bi bi-cart"></i>
                                        {{-- <i
                                class="bi {{ in_array($product->id, $cartProducts) ? 'bi-cart-fill' : 'bi-cart' }} text-purple"></i> --}}
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>


<div class="border-t pt-4">
    <h5 class="font-poppins slider-heading">
        Others Offerings From Babyoye
    </h5>
</div>


@php
    $shuffledProducts = $products->shuffle();
@endphp
<div class="mt-5 card-slider">
    @foreach ($shuffledProducts as $product)
        <div class="mb-4 pb-3 me-3">
            <a class="text-decoration-none" href="{{ route('product-detail', $product->id) }}">
                <div class="rounded-3">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <div class="imgMAinH">
                                    <img src="{{ asset("storage/app/public/product/thumbnail/$product->thumbnail") }}"
                                        alt="" class="object-fit-cover rounded-2" width="100%"
                                        height="100%">
                                </div>
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <button id="wishlist-btn" class="p-0 bg-transparent rounded-circle forBorder">
                                        <i class="bi bi-heart text-danger"></i>
                                    </button>
                                </div>
                                <p class="product-text mt-3">
                                    @if (strlen($product->name) <= 30)
                                        {{ $product->name }}
                                    @else
                                        {{ substr($product->name, 0, 30) }}<span id="dots"> ....</span>
                                    @endif
                                </p>
                                <div class="d-flex">
                                    <p class="product-price me-2">Rs.
                                        {{ $product->unit_price - ($product->unit_price * $product->discount) / 100 }}
                                    </p>
                                    <p class="card-text"><span class="discount">Rs.
                                            {{ $product->unit_price }}</span>
                                        <span class="text-success">-{{ $product->discount }}%</span>
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between for-border-g">
                                    <div class="ratings-reviews d-flex">
                                        <img class="me-2" src="{{ asset('web/images/vector-star.svg') }}"
                                            alt="">
                                        <div class="ratings-reviews d-flex">
                                            <img class="me-2" src="{{ asset('public/images/vector-star.svg') }}"
                                                alt="">
                                            <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                                        </div>
                                        @foreach ($product->reviews as $reviews)
                                            <p class="m-0">{{ $reviews }}<span
                                                    class="Reviews">({{ $products->reviews_count }})</span></p>
                                        @endforeach
                                    </div>
                                    <a href="#" class="delivery-btn">Standard Delivery</a>
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <button class="buy-now rounded-pill text-white">Buy Now</button>
                                    <button id="cart-btn" class="p-0 bg-transparent rounded-circle forBorder">
                                        <i class="bi bi-cart"></i>
                                        {{-- <i
                                class="bi {{ in_array($product->id, $cartProducts) ? 'bi-cart-fill' : 'bi-cart' }} text-purple"></i> --}}
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
