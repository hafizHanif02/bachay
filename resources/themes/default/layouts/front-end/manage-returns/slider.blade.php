<div class="container-xxl">
    <div class="border-t pt-4">
        <h5 class="font-poppins slider-heading">
            You May Also Like
        </h5>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
    $latest_products = $products->shuffle();
    @endphp
    <div class="mt-5 card-slider">
        @foreach ($latest_products as $products)
            <div class="col-md-4 custom-xl-20 col-xl-3 col-lg-4 mb-4">
                <div class="sub-card rounded-3 p-4 pb-0">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <div class="imgCon">
                                    <a class="text-decoration-none product-link"
                                        href="{{ route('product-detail', $products->id) }}">
                                        <img class="object-fit-cover rounded-3"
                                            src="{{ asset("storage/app/public/product/thumbnail/$products->thumbnail") }}"
                                            alt="" class="img-fluid" width="100%" height="100%">
                                    </a>
                                </div>
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                {{-- <div class="wish-list mt-3 me-2">
                                    <button type="button" name="wishlist-button-{{ $products->id }}"
                                        class="p-0 bg-transparent rounded-circle forBorder"
                                        onclick="addToWishlist('{{ $products->id }}')">
                                        <i id="hearticon{{ $products->id }}"
                                            class="bi {{ in_array($products->id, $wishlistProductsArray) ? 'bi-heart-fill' : 'bi-heart' }} text-danger"></i>
                                    </button>
                                </div> --}}
                                <div class="wish-list mt-3 me-2">
                                    <button type="button"
                                        class="wishlist-button p-0 bg-light rounded-circle forBorder"
                                        data-product-id="{{ $products->id }}" onclick="addToWishlist(this)">
                                        <i
                                            class="bi heart-icon bi-heart{{ in_array($products->id, $wishlistProductsArray) ? '-fill' : '' }} text-danger"></i>
                                    </button>
                                </div>
                                <p class="card-text mt-3" id="productDescription">
                                    @if (strlen($products->name) <= 20)
                                        {{ $products->name }}
                                    @else
                                        {{ substr($products->name, 0, 45) }}<span id="dots"> ....</span>
                                    @endif
                                </p>
                                <div class="d-flex">
                                    <h6 class="card-text price mb-0">Rs.
                                        {{ $products->unit_price - ($products->unit_price * $products->discount) / 100 }}
                                    </h6>
                                    <p class="bg-primary rounded-pill ms-2  text-white units mb-0">141 Solds
                                    </p>
                                </div>
                                <p class="card-text"><span class="discount fw-bold">Rs. {{ $products->unit_price }}</span>
                                    <span class="Text-color">-{{ $products->discount }}% Off</span>
                                </p>
                                <div class="subdiv d-flex justify-content-between">
                                    <span href="#">Standard Delivery</span>
                                    {{-- @foreach ($products->reviews as $reviews) --}}
                                    <p class="d-flex rounded-pill text-white">4.9
                                        <img class="mb-1 ms-2" src="{{ asset('public/images/star.svg') }}" alt="">
                                    </p>
                                    {{-- @endforeach --}}

                                    <h5 class="text-dark m-0">({{ $products->reviews_count }})</h5>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>

 <?php 
/*  @php
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
                                        <a class="text-decoration-none"
                                            href="{{ route('product-detail', $product->id) }}">
                                            <img src="{{ asset("storage/app/public/product/thumbnail/$product->thumbnail") }}"alt=""
                                                class="object-fit-cover rounded-2" width="100%" height="100%">
                                        </a>
                                    </div>
                                    <div class="sec-best-seller mt-3">
                                        <p>Best Seller</p>
                                    </div>
                                    <div class="wish-list mt-3 me-2">
                                        <button type="button"
                                            class="wishlist-button p-0 bg-transparent rounded-circle forBorder"
                                            data-product-id="{{ $product->id }}" onclick="addToWishlist(this)">
                                            <i
                                                class="bi heart-icon bi-heart{{ in_array($product->id, $wishlistProductsArray) ? '-fill' : '' }} text-danger"></i>
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
                                        <form action="{{ route('cart.buy-now') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="price" id="price"
                                                value="{{ $product->unit_price }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="product[1][quantity]" value="1">
                                            <input type="hidden" name="product[1][id]" value="{{ $product->id }}">
                                            <input type="hidden" name="product[1][price]"
                                                value="{{ $product->unit_price }}">
                                            <input type="hidden" name="product[1][product_id]"
                                                value="{{ $product->id }}">
                                            {{-- <input type="hidden" name="product[1][tax]" value="{{ ($product->tax) }}"> --}}
                                            <input type="hidden" name="product[1][tax_model]"
                                                value="{{ $product->tax_model }}">
                                            <input type="hidden" name="product[1][color]"
                                                value="{{ $product->color }}">
                                            <input type="hidden" name="product[1][variant]"
                                                value="{{ $product->variant }}">
                                            <input type="hidden" name="product[1][discount]"
                                                value="{{ $product->discount }}">
                                            <input type="hidden" name="product[1][discount_amount]"
                                                value="{{ ($product->discount * $product->unit_price) / 100 }}">
                                            <input type="hidden" name="product[1][actual_price]"
                                                value="{{ $product->unit_price }}">
                                            <input type="hidden" name="product[1][price]"
                                                value="{{ $product->unit_price }}">
                                            <input type="hidden" name="product[1][quantity]" value="1">
                                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                                        </form>
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="price" id="price"
                                                value="{{ $product->unit_price }}">
                                            <input type="hidden" name="discount" id="discount"
                                                value="{{ $product->discount }}">
                                            <input type="hidden" name="product_id" id="product_id"
                                                value="{{ $product->id }}">
                                            <input type="hidden" name="thumbnail"
                                                value="{{ $product->thumbnail }}">
                                            <input type="hidden" name="name" value="{{ $product->name }}">
                                            {{-- <input type="hidden" name="tax" value="{{ $tax }}"> --}}
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="shipping_cost"
                                                value="{{ $product->shipping_cost }}">
                                            <input type="hidden" name="color" id="color">
                                            <input type="hidden" name="variant" id="variant">
                                            <input type="hidden" name="slug" id="slug"
                                                value="{{ $product->slug }}">
                                            <input type="hidden" name="customer_id" id="customer_id"
                                                value="{{ auth('customer')->check() ? auth('customer')->user()->id : '' }}">

                                            <div class="d-flex  mt-1">
                                                <button id="cart-btn"
                                                    class="p-0 bg-transparent rounded-circle forBorder">
                                                    <i class="bi bi-cart"></i>
                                                    {{-- <i
                                            class="bi {{ in_array($product->id, $cartProducts) ? 'bi-cart-fill' : 'bi-cart' }} text-purple"></i> --}}
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>



{{-- <div class="mt-5 card-slider mb-4">
    
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
   
</div> --}} */
?>
