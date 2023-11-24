<div class="col-9">
    <div class="collection pb-3 d-flex justify-content-between align-items-center">
        <h5>Products Collection</h5>
        <li class="nav-item sorted-by rounded-pill p-2 ps-4 pe-4">
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
        <div class="sub-btn" id="filter-btns">
        </div>
        <a href="#" class="clear-all-btn">Clear All</a>
    </div>


    <div class="row mt-4" id="product-list">
        @php
            $wishlistProducts = wishlistProducts();
            $cartProducts = cartProducts();
        @endphp
        @forelse ($products as $product)
            <div class="col-md-6 col-lg-3 mb-4 pb-3">
                
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <a href="{{ route('product-detail',$product->id) }}">
                                    <div class="ProductImgH">
                                        <img src="{{ Storage::url($product->productImages[0]->image) }}" alt="Product image" class="img-fluid rounded-3 "
                                            width="100%" height="100%">

                                    </div>
                                </a>
                                @if ($badge = $product->productBadge?->badge->name)
                                    <div class="sec-best-seller mt-3">
                                        <p>{{ $badge }}</p>
                                    </div>
                                @endif
                                <div class="wish-list mt-3 me-2">
                                    <button id="wishlist-btn-{{ $product->id }}" class="p-0 bg-transparent rounded-circle forBorder"
                                        onclick="addToWishlist('{{ $product->id }}')">
                                        <i
                                            class="bi {{ in_array($product->id, $wishlistProducts) ? 'bi-heart-fill' : 'bi-heart' }} text-danger"></i>
                                    </button>
                                </div>
                                <p class="product-text mt-3">{{ $product->name }}</p>


                                <div class="d-flex">
                                    <p class="product-price me-2">Rs {{ salePrice($product) }}</p>
                                    <p class="card-text"><span class="discount">Rs {{ $product->price }}</span> <span
                                            class="text-success">-{{ $product->discount_percentage }}% Off</span></p>

                                </div>

                                <div class="d-flex justify-content-between for-border-g">
                                    <div class="ratings-reviews d-flex">
                                        <img class="me-2" src="{{ asset('web/images/vector-star.svg') }}"
                                            alt="">
                                        <p class="m-0">{{ $product->reviews->avg('rating') }}<span class="Reviews">({{ $product->reviews->count() }})</span></p>
                                    </div>
                                    <a href="#" class="delivery-btn">{{ $product->deliveryType->name }}</a>
                                </div>

                                <div class="d-flex justify-content-between mt-3">
                                    <button class="buy-now rounded-pill text-white">Buy Now</button>
                                            <button id="cart-btn" class="p-0 bg-transparent rounded-circle forBorder"
                                            data-bs-toggle="modal" data-bs-target="#modalId" >
                                            <i
                                                class="bi {{ in_array($product->id, $cartProducts) ? 'bi-cart-fill' : 'bi-cart' }} text-purple"></i>
                                        </button>
                                        {{-- <x-web.product.product-detail-modal :product="$product" /> --}}
                                </div>
                            </div>
                        </div>
                    </div>
               
            </div>
        @empty
            <div class="text-center text-danger">No product found!</div>
        @endforelse
    </div>
</div>
