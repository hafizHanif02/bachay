<div class="container-xxl">
    <div class="border-t pt-4">
        <h5 class="font-poppins slider-heading">
            You May Also Like
        </h5>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                                        <a class="text-decoration-none"
                                            href="{{ route('product-detail', $product->id) }}">
                                            <img src="{{ asset("storage/app/public/product/thumbnail/$product->thumbnail") }}"
                                                alt="" class="object-fit-cover rounded-2" width="100%"
                                                height="100%">
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
                                        </form>
                                        <div class="d-flex mt-1">
                                            <button id="cart-btn{{ $product->id }}"
                                                class="p-0 bg-transparent rounded-circle forBorder"
                                                data-product-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-price="{{ $product->unit_price }}"
                                                data-discount="{{ $product->discount }}"
                                                data-tax="{{ $product->tax }}"
                                                data-thumbnail="{{ $product->thumbnail }}"
                                                data-color="{{ $product->color }}"
                                                data-variant="{{ $product->variant }}"
                                                data-slug="{{ $product->slug }}" onclick="addToCart(this)">
                                                <i
                                                    class="bi cart-icon bi-cart {{ in_array($product->id, $cartProductsArray) ? 'fill' : '' }} text-purple"></i>
                                            </button>
                                        </div>
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
                                        <a class="text-decoration-none"
                                            href="{{ route('product-detail', $product->id) }}">
                                            <img src="{{ asset("storage/app/public/product/thumbnail/$product->thumbnail") }}"
                                                alt="" class="object-fit-cover rounded-2" width="100%"
                                                height="100%">
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
                                            <img class="me-2" src="{{ asset('web/images/vector-star.svg') }}"
                                                alt="">
                                            <div class="ratings-reviews d-flex">
                                                <img class="me-2"
                                                    src="{{ asset('public/images/vector-star.svg') }}"
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

                                        </form>
                                        <div class="d-flex mt-1">
                                            <button id="cart-btn{{ $product->id }}"
                                                class="p-0 bg-transparent rounded-circle forBorder"
                                                data-product-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-price="{{ $product->unit_price }}"
                                                data-discount="{{ $product->discount }}"
                                                data-tax="{{ $product->tax }}"
                                                data-thumbnail="{{ $product->thumbnail }}"
                                                data-color="{{ $product->color }}"
                                                data-variant="{{ $product->variant }}"
                                                data-slug="{{ $product->slug }}" onclick="addToCart(this)">
                                                <i
                                                    class="bi cart-icon bi-cart {{ in_array($product->id, $cartProductsArray) ? 'fill' : '' }} text-purple"></i>
                                            </button>
                                        </div>

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
                                        <a class="text-decoration-none"
                                            href="{{ route('product-detail', $product->id) }}">
                                            <img src="{{ asset("storage/app/public/product/thumbnail/$product->thumbnail") }}"
                                                alt="" class="object-fit-cover rounded-2" width="100%"
                                                height="100%">
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
                                            <img class="me-2" src="{{ asset('web/images/vector-star.svg') }}"
                                                alt="">
                                            <div class="ratings-reviews d-flex">
                                                <img class="me-2"
                                                    src="{{ asset('public/images/vector-star.svg') }}"
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
                                        <form action="{{ route('cart.buy-now') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="price" id="price"
                                                value="{{ $product->unit_price }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="product[1][quantity]" value="1">
                                            <input type="hidden" name="product[1][id]"
                                                value="{{ $product->id }}">
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

                                        </form>
                                        <div class="d-flex mt-1">
                                            <button id="cart-btn{{ $product->id }}"
                                                class="p-0 bg-transparent rounded-circle forBorder"
                                                data-product-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-price="{{ $product->unit_price }}"
                                                data-discount="{{ $product->discount }}"
                                                data-tax="{{ $product->tax }}"
                                                data-thumbnail="{{ $product->thumbnail }}"
                                                data-color="{{ $product->color }}"
                                                data-variant="{{ $product->variant }}"
                                                data-slug="{{ $product->slug }}" onclick="addToCart(this)">
                                                <i
                                                    class="bi cart-icon bi-cart {{ in_array($product->id, $cartProductsArray) ? 'fill' : '' }} text-purple"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
