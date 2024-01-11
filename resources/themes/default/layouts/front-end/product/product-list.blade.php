<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="All_products">
    <div class="collection pb-3 d-flex justify-content-between align-items-center">
        <h5>Shoes Collection</h5>
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
        <div class="sub-btn" id="filters-btn">
            {{-- <button class="boys rounded-3 btn-style"><i class="bi bi-x-lg"></i> Boys</button>
            <button class="Cloths rounded-3 btn-style"><i class="bi bi-x-lg"></i> Cloths</button> --}}

        </div>
        <a href="#" class="clear-all-btn">Clear All</a>
    </div>


    <div class="d-grid product-list">
        @foreach ($products as $product)
            <div class="col-md-6 col-lg-12 mb-4 pb-3">
                <div class="rounded-3">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container product-wrapper">
                                <div class="imgMAin">
                                    <a class="text-decoration-none" href="{{ route('product-detail', $product->id) }}">
                                        <img src="{{ asset("storage/app/public/product/thumbnail/$product->thumbnail") }}"
                                            alt="{{ $product->name }}" class="object-fit-cover rounded-2" width="100%"
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
                                    <p class="card-text"><span class="discount">Rs.
                                            {{ $product->unit_price }}</span>
                                        <span class="text-success">-{{ $product->discount }}%</span>
                                    </p>
                                </div>
    
                                <div class="expandable">
                                    <div class="d-flex justify-content-between for-border-g">
                                        <div class="ratings-reviews d-flex">
                                            <img class="me-2" src="{{ asset('public/images/Vector-star.svg') }}" alt="">
                                            <p class="m-0 mt-1">5.0<span
                                                    class="Reviews">({{ $product->reviews_count }})</span></p>
                                        </div>
    
                                        @foreach ($product->reviews as $review)
                                            <p class="m-0">{{ $review }}<span
                                                    class="Reviews">({{ $product->reviews_count }})</span></p>
                                        @endforeach
    
                                        <a href="#" class="delivery-btn">Standard Delivery</a>
                                    </div>
    
                                    <div class="d-flex justify-content-between mt-3">
                                        {{-- Buy Now button --}}
                                        <form action="{{ route('cart.buy-now') }}" method="POST">
                                            @csrf
                                            <button class="buy-now rounded-pill text-white mb-2">Buy Now</button>
                                        </form>
    
                                         {{-- Add to Cart button  --}}
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
                                                <i class="bi cart-icon bi-cart {{ in_array($product->id, $cartProductsArray) ? 'fill' : '' }} text-purple"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    
    
</div>
<style>


    .expandable {
        position: absolute;
        opacity: 0;
        visibility: hidden;
        width: 100%;
        background: #fff;
        z-index: 1002;
        box-shadow: 0 -20px 0 white, 0 2px 16px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease-out;
    }

    .product-wrapper {
        overflow: hidden;
    }

    .product-wrapper::before {
        box-shadow: 0 2px 16px 0 rgba(0, 0, 0, 0.06);
    }

    .product-wrapper:hover {
        overflow: visible;
        box-shadow: 0 2px 16px 0 rgba(0, 0, 0, 0.06);

    }

    /* .product-wrapper:hover::before {
        background: red;
        opacity: 1;
    } */

    .product-wrapper:hover .expandable {
        opacity: 1;
        visibility: visible;
    }
    /* .expandable {
  position: absolute;
  opacity: 0;
  visibility: hidden;
  top: 100%;
  width: 110%;
  right: 0;
  left: -5%;
  padding: 0 30px 20px 30px;
  background: #fff;
  z-index: 1002;
  box-shadow: 0 -20px 0 white, 0 2px 16px 0 rgba(0, 0, 0, 0.06);
}
.product-wrapper {
  overflow: hidden;
  &::before {
    content: '';
    display: block;
    background: transparent;
    position: absolute;
    opacity: 0;
    z-index: 1001;
    top: -8%;
    left: -5%;
    bottom: 0;
    width: 110%;
    box-shadow: 0 2px 16px 0 rgba(0, 0, 0, 0.06);
  }
  &:hover {
    overflow: visible;
    &::before {
      background: #fff;
      opacity: 1;
    }
    *:not(.expandable) { position: relative; z-index: 1002; }
    .expandable {
      opacity: 1;
      visibility: visible;
    }
  }
} */
</style>
