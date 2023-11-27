<div class="col-9">
    <div class="collection pb-3 d-flex justify-content-between align-items-center">
        <h5>Shoes Collection</h5>
        <li class="nav-item sorted-by rounded-2 p-2 ps-4 pe-4">
            <div class="dropdown">
                <a class="dropbtn nav-link">Sorted By: New Arrivals <i class="bi bi-chevron-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Winter</a>
                    <a href="#">Summer</a>

                </div>
            </div>
        </li>
    </div>
    <div class="filters-btn d-flex justify-content-between align-items-center mt-3 pb-3 collection">
        <div class="sub-btn" id="filters-btn">
            {{-- <button class="boys rounded-3 btn-style"><i class="bi bi-x-lg"></i> Boys</button>
            <button class="Cloths rounded-3 btn-style"><i class="bi bi-x-lg"></i> Cloths</button> --}}

        </div>
        <a href="#" class="clear-all-btn">Clear All</a>
    </div>


    <div class="row d-flex col-12 mt-5">
        @foreach ($products as $product)
            {{-- {{ $product->name }} --}}
            <div class="col-md-6 col-lg-3 mb-4 pb-3">
                <div class="rounded-3">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <div class="imgMAin">
                                    @foreach (json_decode($product->images) as $key => $photo)
                                        <img src="{{ asset("storage/app/public/product/$photo") }}" alt=""
                                            class="object-fit-cover" width="100%" height="100%">
                                    @endforeach
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
                                <p class="product-text mt-3">
                                    @if (strlen($product->name) <= 25)
                                        {{ $product->name }}
                                    @else
                                        {{ substr($product->name, 0, 25) }}<span id="dots"> ....</span>
                                    @endif
                                </p>


                                <div class="d-flex">
                                    <p class="product-price me-2">Rs.
                                        {{ $product->unit_price - ($product->unit_price * $product->discount) / 100 }}
                                    </p>
                                    <p class="card-text"><span class="discount">Rs. {{ $product->unit_price }}</span>
                                        <span class="text-success">-{{ $product->discount }}%</span></p>

                                </div>

                                <div class="d-flex justify-content-between for-border-g">
                                    <div class="ratings-reviews d-flex">
                                        <img class="me-2" src="{{ asset('web/images/vector-star.svg') }}"
                                            alt="">
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
            </div>
        @endforeach


    </div>
</div>
