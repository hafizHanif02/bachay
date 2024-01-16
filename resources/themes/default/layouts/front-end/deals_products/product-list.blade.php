<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="deals_products All_products">
    <div class="collection mb-4 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Shoes Collection</h5>
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
    {{-- <div class="filters-btn d-flex justify-content-between align-items-center mt-3 pb-3 collection">
        <div class="sub-btn" id="filters-btn">
            <button class="boys rounded-3 btn-style"><i class="bi bi-x-lg"></i> Boys</button>
            <button class="Cloths rounded-3 btn-style"><i class="bi bi-x-lg"></i> Cloths</button>

        </div>
        <a href="#" class="clear-all-btn">Clear All</a>
    </div> --}}


    <div class="d-grid all_products_cate gap-3">
        @foreach ($deals_products as $product)
            @php
                $product_deals = $product->product;
            @endphp
            <div class="image-container product-wrapper mb-3">
                <div class="imgMAin">
                    <a class="text-decoration-none" href="{{ route('product-detail', $product->id) }}">
                        <img src="{{ asset("storage/app/public/product/thumbnail/$product_deals->thumbnail") }}"
                            alt="" class="object-fit-cover rounded-2" width="100%" height="100%">
                    </a>
                </div>
                <div class="sec-best-seller mt-3">
                    <p>Best Seller</p>
                </div>
                <div class="wish-list mt-3 me-2">
                    {{-- <button type="button"
                                        class="wishlist-button p-0 bg-transparent rounded-circle forBorder"
                                        data-product-id="{{ $product->id }}" onclick="addToWishlist(this)">
                                        <i
                                            class="bi heart-icon bi-heart{{ in_array($product->id, $wishlistProductsArray) ? '-fill' : '' }} text-danger"></i>
                                    </button> --}}
                    <button type="button" class="wishlist-button p-0 bg-transparent rounded-circle forBorder"
                        onclick="addToWishlist(this)">
                        <i class="bi heart-icon bi-heart text-danger"></i>
                    </button>
                </div>
                <p class="product-text mt-1 mb-2">
                    @if (strlen($product_deals->name) <= 25)
                        {{ $product_deals->name }}
                    @else
                        {{ substr($product_deals->name, 0, 25) }}<span id="dots"> ....</span>
                    @endif
                </p>
                <div class="d-flex">
                    <p class="product-price me-2 mb-2">Rs.
                        {{ $product_deals->unit_price - ($product_deals->unit_price * $product_deals->discount) / 100 }}
                    </p>
                    <p class="card-text"><span class="discount">Rs.
                            {{ $product_deals->unit_price }}</span>
                        <span class="text-success">-{{ $product_deals->discount }}%</span>
                    </p>

                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center for-border-g">
                        <div class="ratings-reviews d-flex">
                            <img class="me-2" src="{{ asset('public/images/Vector-star.svg') }}" alt="">
                            <p class="m-0">5.0<span class="Reviews">(17)</span></p>
                        </div>
                        {{-- @foreach ($product->reviews as $reviews)
                                            <p class="m-0">{{ $reviews }}<span
                                                    class="Reviews">({{ $products->reviews_count }})</span></p>
                                        @endforeach --}}

                        <a href="#" class="delivery-btn">Standard Delivery</a>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <form action="" method="POST">
                            <input type="hidden" name="_token">
                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                        </form>

                        <div class="d-flex mt-0">
                            <button class="p-0 bg-transparent rounded-circle forBorder">
                                <i class="bi cart-icon bi-cart text-purple"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        {{-- <form action="{{ route('cart.buy-now') }}" method="POST">
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
                                            <button class="buy-now rounded-pill text-white mb-2">Buy Now</button>
                                        </form> --}}
                        {{-- <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="price" id="price"
                                                value="{{ $product->unit_price }}">
                                            <input type="hidden" name="discount" id="discount"
                                                value="{{ $product->discount }}">
                                            <input type="hidden" name="product_id" id="product_id"
                                                value="{{ $product->id }}">
                                            <input type="hidden" name="thumbnail" value="{{ $product->thumbnail }}">
                                            <input type="hidden" name="name" value="{{ $product->name }}"> --}}
                        {{-- <input type="hidden" name="tax" value="{{ $tax }}"> --}}
                        {{-- <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="shipping_cost"
                                                value="{{ $product->shipping_cost }}">
                                            <input type="hidden" name="color" id="color">
                                            <input type="hidden" name="variant" id="variant">
                                            <input type="hidden" name="slug" id="slug"
                                                value="{{ $product->slug }}">
                                            <input type="hidden" name="customer_id" id="customer_id"
                                                value="{{ auth('customer')->check() ? auth('customer')->user()->id : '' }}">
                                            <input type="hidden" name="price" value="{{ $product->unit_price }}">
    
                                            <div class="d-flex  mt-1">
                                                <button type="submit" id="cart-btn"
                                                    class="p-0 bg-transparent rounded-circle forBorder"
                                                    data-product-id="{{ $product->id }}"
                                                    onclick="addToCart({{ $product->id }})">
                                                    <i class="bi {{ in_array($product->id, $cartProductsArray) ? 'bi-cart-fill' : 'bi-cart' }} text-purple"
                                                        data-product-id="{{ $product->id }}"
                                                        onclick="addToCart({{ $product->id }})"></i>
                                                </button>
                                            </div>

                                        </form> --}}





                        {{-- <div class="d-flex mt-1">
                                            <button id="cart-btn{{ $product->id }}"
                                                class="p-0 bg-transparent rounded-circle forBorder"
                                                data-product-id="{{ $product->id }}"
                                                data-customer-id="{{ auth('customer')->check() ? auth('customer')->user()->id : '' }}"
                                                data-name="{{ $product->name }}"
                                                data-price="{{ $product->unit_price }}"
                                                data-discount="{{ $product->discount }}"
                                                data-tax="{{ $product->tax }}"
                                                data-thumbnail="{{ $product->thumbnail }}"
                                                data-color="{{ $product->color }}"
                                                data-variant="{{ $product->variant }}"
                                                data-slug="{{ $product->slug }}"
                                                onclick="{{ in_array($product->id, $cartProductsArray) ? 'deleteFromCart(' . $product->id . ')' : 'addToCart(' . $product->id . ')' }}">
                                                <i
                                                    class="bi {{ in_array($product->id, $cartProductsArray) ? 'bi-cart-fill' : 'bi-cart' }} text-purple">
                                                </i>
                                            </button>
                                        </div> --}}






                        {{-- <div class="d-flex mt-1">
                                            <button class="p-0 bg-transparent rounded-circle forBorder" onclick="toggleCart(this)">
                                                <i class="bi bi-cart text-purple"></i>
                                            </button>
                                        </div> --}}


                    </div>

                </div>


            </div>
        @endforeach


    </div>
</div>
<style>
    .text-success {
        font-weight: 600;
    }

    .forBorder {
        border: 1px solid #8b5bc0;
    }

    .buy-now {
        width: 110%;
    }

    .wish-list {
        top: 12px;
        right: 10px;
    }

    .sec-best-seller {
        top: 20px;
        left: 15px;
    }

    .card-footer {
        padding-left: 15px;
        padding-right: 15px;

    }

    .product-price {
        padding: 0 15px;
    }

    .product-wrapper {
        box-shadow: 0 2px 16px 0 rgba(0, 0, 0, 0.06);
        border-radius: 5px;
    }

    .product-text {
        font-size: 14px !important;
        padding: 0 15px;
    }

    .imgMAin {
        height: 300px;
        padding: 15px;
    }

    .product-list {
        gap: 35px;
    }

    .product-wrapper {
  border: 1.5px solid transparent;
  transition: border-color 0.5s ease; 
  transition: transform 0.5s ease; 

}

.product-wrapper:hover {
  border-color: #c5c0c0;
  transform: scale(1.03);
  
}

    /* .expandable {
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

    .product-wrapper:hover::before {
        background: red;
        opacity: 1;
    }

    .product-wrapper:hover .expandable {
        opacity: 1;
        visibility: visible;
    } */
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
