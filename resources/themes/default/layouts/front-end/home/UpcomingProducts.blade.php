<div class="products_all sub-contain back_img container-xxl">
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="textClr m-0 pb-1 mt-1">Upcomings</h1>
            <a class="d-flex align-items-center text-dark" href="{{ route('product-list') }}">
                <h6 class="m-0">See All</h6>
            </a>
        </div>
    </div>
    <div class="main-con mt-1">
        <div class="row bg-white">
            @foreach ($latest_products as $products)
                <div class="col-md-6 col-lg-3 mb-2">
                    <div class="sub-card rounded-3 p-3 pb-0">
                        <div class="card1">
                            <div class="first-sec card1">
                                <div class="image-container">
                                    <div class="imgCon">
                                        <a class="text-decoration-none"
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
                                            {{ substr($products->name, 0, 40) }}<span id="dots"> ....</span>
                                        @endif
                                    </p>
                                    <div class="d-flex">
                                        <h6 class="card-text price mb-0">Rs.
                                            {{ $products->unit_price - ($products->unit_price * $products->discount) / 100 }}
                                        </h6>
                                        <p class="bg-primary rounded-pill ms-2 text-white units mb-0">141 Solds
                                        </p>
                                    </div>
                                    <p class="card-text"><span class="discount fw-bold">Rs.
                                            {{ $products->unit_price }}</span>
                                        <span class="Text-color">-{{ $products->discount }}% Off</span>
                                    </p>
                                    <div class="subdiv d-flex justify-content-between">
                                        <span href="#">Standard Delivery</span>
                                        {{-- @foreach ($products->reviews as $reviews) --}}
                                        <p class="rounded-pill text-white">4.9
                                            <img class="mb-1" src="{{ asset('public/images/star.svg') }}"
                                                alt="">
                                        </p>
                                        {{-- @endforeach --}}

                                        <h5 class="text-dark">({{ $products->reviews_count }})</h5>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

<style>
    .products_all {
        margin-top: 25px;
    }
</style>
