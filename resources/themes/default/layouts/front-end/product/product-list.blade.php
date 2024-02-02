<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="All_products">
    <div class="collection pb-3 d-flex justify-content-between align-items-center">
        <h5>Shoes Collection</h5>
        <li class="nav-item sorted-by rounded-pill p-2 ps-4 pe-4">
            <div class="dropdown">
                <a class="dropbtn nav-link">Sorted By: New Arrivals <i class="bi bi-chevron-down"></i></a>
                <div class="dropdown_content">
                    <a href="#">Name</a>
                    <a href="#">Price</a>

                </div>
            </div>
        </li>
    </div>
    <div class="filters-btn d-flex justify-content-between align-items-center mt-3 pb-3 collection borderline">
        <div class="sub-btn" id="filters-btn">
            <button class="boys rounded-3 btn-style"><i class="bi bi-x-lg"></i> Boys</button>
            <button class="Cloths rounded-3 btn-style"><i class="bi bi-x-lg"></i> Cloths</button>

        </div>
        <a href="#" class="clear-all-btn">Clear All</a>
    </div>


    <div class="product-list">
        @foreach ($products as $product)
            <div class="image-container product-wrapper">
                <div class="product_card">
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
                        <button type="button" class="wishlist-button p-0 bg-transparent rounded-circle forBorder"
                            data-product-id="{{ $product->id }}" onclick="addToWishlist(this)">
                            <i
                                class="bi heart-icon bi-heart{{ in_array($product->id, $wishlistProductsArray) ? '-fill' : '' }} text-danger"></i>
                        </button>
                    </div>
                    <p class="product_title product-text mt-0 mb-1">
                        @if (strlen($product->name) <= 40)
                            {{ $product->name }}
                        @else
                            {{ substr($product->name, 0, 40) }}<br>
                            {{ substr($product->name, 40, 25) }}<span id="dots"> ....</span>
                        @endif
                    </p>

                    <div class="product_price d-flex">
                        <p class="product-price me-2">Rs.
                            {{ $product->unit_price - ($product->unit_price * $product->discount) / 100 }}
                        </p>
                        <p class="card-text"><span class="discount">Rs.
                                {{ $product->unit_price }}</span>
                            <span class="text-success fw-bold">-({{ $product->discount }}% Off)</span>
                        </p>
                    </div>

                </div>

                <div class="expandable">
                    <div class="main_content">
                        {{-- <div class="d-flex justify-content-between for-border-g">
                            <div class="ratings-reviews d-flex">
                                <img class="me-2" src="{{ asset('public/images/Vector-star.svg') }}" alt="">
                                <p class="m-0 mt-1">5.0<span class="Reviews">({{ $product->reviews_count }})</span></p>
                            </div>
    
                            @foreach ($product->reviews as $review)
                                <p class="m-0">{{ $review }}<span
                                        class="Reviews">({{ $product->reviews_count }})</span></p>
                            @endforeach
    
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div> --}}
                        <div class="d-flex justify-content-between for-border-g">
                            {{-- <div class="ratings-reviews d-flex">
                                @if ($product->reviews->isEmpty())
                                    @for ($i = 0; $i < 5; $i++)
                                        <span class="bi bi-star me-2" style="color: #ffc107;"></span>
                                    @endfor
                                    <p class="m-0 mt-1"><span class="Reviews">No ratings</span></p>
                                @else
                                    @php $averageRating = $product->reviews->avg('rating'); @endphp
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < floor($averageRating))
                                            <span class="bi bi-star-fill me-2" style="color: #ffc107;"></span>
                                        @elseif ($i == floor($averageRating) && $averageRating - $i >= 0.5)
                                            <span class="bi bi-star-half me-2" style="color: #ffc107;"></span>
                                        @else
                                            <span class="bi bi-star me-2" style="color: #ffc107;"></span>
                                        @endif
                                    @endfor
                                    <span class="Reviews">({{ $product->reviews_count }} @if($product->reviews_count == 1) Rating @else Ratings @endif)</span>
                                @endif
                            </div> --}}
                            <div class="ratings-reviews d-flex">
                                @if ($product->reviews->isEmpty())
                                    <p class="m-0 mt-1">No reviews yet</p>
                                @else
                                    @php $averageRating = $product->reviews->avg('rating'); @endphp
                                    @for ($i = 0; $i < 1; $i++)
                                        @if ($i < floor($averageRating))
                                            <span class="bi bi-star-fill me-2" style="color: #ffc107;"></span>
                                        @elseif ($i == floor($averageRating) && $averageRating - $i >= 0.5)
                                            <span class="bi bi-star-half me-2" style="color: #ffc107;"></span>
                                        @else
                                            <span class="bi bi-star me-2" style="color: #ffc107;"></span>
                                        @endif
                                    @endfor
                                    {{-- <span class="Reviews">({{ $product->reviews_count }}
                                         @if($product->reviews_count == 1) Review @else Reviews @endif)
                                        </span> --}}
                                        <span class="Reviews">({{ $product->reviews_count }})
                                            
                                           </span>
                                @endif
                            </div>
                            
                        
                            <a href="#" class="delivery-btn">Standard Delivery</a>
                        </div>
                        

                    </div>

                    {{-- <div class="product-sizes">
                        @foreach ($product->sizes as $size)
                            <div class="size-box">{{ $size }}</div>
                        @endforeach
                    </div> --}}
                    <div class="expand_btn">
                        <div class="dfsize mt-2">
                            <div class="clr_size fs-12 font-poppins">
                                @foreach (($product->size) as $size)
                                {{-- <form  action="{{ route('product-detail',$product->id) }}" method="GET">
                                    @csrf --}}
                                    {{-- <input type="hidden" name="Size" value="{{ $size }}">
                                    @if(!empty(json_decode($product->colors)))
                                    <input type="hidden" name="Color" value="{{ json_decode($product->colors)[0] }}">
                                    @endif --}}
                                    <button type="submit" class="pt-1 pb-1 ps-2 pe-2 mb-1 bg-transparent"><a href="{{ route('product-detail',$product->id.'?Size='.$size) }}">{{ $size}}</a></button>
                                {{-- </form> --}}
                                @endforeach
                            </div>
                        </div>
                        <div class="ProductColors col-12 d-flex align-items-center mb-3 mt-3">
                                {{-- @if($product->id == '2')
                                {{ dd($product->size) }}
                                @endif --}}

                                
                            @foreach(json_decode($product->colors) as $color)
                            <input type="radio" class="me-3" style="background-color: {{ $color }}" id="btn1"
                                name="Btn">
                            {{-- <input type="radio" class="me-3" style="background-color: green" id="btn2"
                                name="Btn">
                            <input type="radio" class="me-3" style="background-color: blue" id="btn3"
                                name="Btn"> --}}
                            @endforeach
                        </div>
                        {{-- <div class="product-colors">
                            @foreach ($product->colors as $color)
                                <div class="color-box" style="background-color: {{ $color->hex_code }};"></div>
                            @endforeach
                        </div> --}}

                        <div class="d-flex justify-content-between mt-2 col-12 mb-2">
                            <form class="btn_style" action="{{ route('cart.buy-now') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="price" id="price" value="{{ $product->unit_price }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="product[1][quantity]" value="1">
                                <input type="hidden" name="product[1][id]" value="{{ $product->id }}">
                                <input type="hidden" name="product[1][price]" value="{{ $product->unit_price }}">
                                <input type="hidden" name="product[1][product_id]" value="{{ $product->id }}">
                                <input type="hidden" name="product[1][tax_model]"
                                    value="{{ $product->tax_model }}">
                                <input type="hidden" name="product[1][color]" value="{{ $product->color }}">
                                <input type="hidden" name="product[1][variant]" value="{{ $product->variant }}">
                                <input type="hidden" name="product[1][discount]" value="{{ $product->discount }}">
                                <input type="hidden" name="product[1][discount_amount]"
                                    value="{{ ($product->discount * $product->unit_price) / 100 }}">
                                <input type="hidden" name="product[1][actual_price]"
                                    value="{{ $product->unit_price }}">
                                <input type="hidden" name="product[1][price]" value="{{ $product->unit_price }}">
                                <input type="hidden" name="product[1][quantity]" value="1">
                                <button class="fs-12 buy-now w-100 rounded-pill text-white pt-2 pb-2 py-1 px-4">Buy Now</button>

                            </form>
                            <div class="d-flex mt-0 btn_style">
                                <button id="cart-btn{{ $product->id }}"
                                    class="p-0 bg-transparent AddtoCart rounded-pill fs-12 w-100"
                                    data-product-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                    data-price="{{ $product->unit_price }}" data-discount="{{ $product->discount }}"
                                    data-tax="{{ $product->tax }}" data-thumbnail="{{ $product->thumbnail }}"
                                    data-color="{{ $product->color }}" data-variant="{{ $product->variant }}"
                                    data-slug="{{ $product->slug }}" onclick="addToCart(this)">
                                    <i
                                        class="bi cart-icon bi-cart{{ in_array($product->id, $cartProductsArray) ? '-fill' : '' }} text-purple"></i>
                                    Add to Cart    
                                    
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>



</div>
<style>
    .btn_style{
        width: 48%;
     }
    .expand_btn {
        padding: 0 15px;
    }

    .product-wrapper:hover .product_title {
        display: none;
    }

    .product-wrapper .product_title {
        display: block;
    }

    .AddtoCart {
        border: 1px solid #8b5bc0;
        font-weight: 500;
        color: #8b5bc0;
    }

    .wish-list {
        top: 6%;
        right: 8%;
    }

    .sec-best-seller {
        top: 7%;
        left: 5%;
    }

    .btn-W {
        width: 100%;
        font-size: 12px;
    }
    .expandable {
        position: absolute;
        opacity: 0;
        visibility: hidden;
        width: 100%;
        background: #fff;
        z-index: 1002;
        box-shadow: 0 -20px 0 white, 0 2px 16px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease-out;
        /* box-shadow: 0 0 4px 1px #aaa; */
        box-shadow: 0 3.6px 4px 1px #aaa;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        padding-bottom: 5px;
    }
    .product-wrapper {
        overflow: hidden;
        margin-top: 15px;
    }
    .main_content{
        padding: 0 15px;
    }
    .product-wrapper::before {
        box-shadow: 0 2px 16px 0 rgba(0, 0, 0, 0.06);
    }

    .product-wrapper:hover {
        overflow: visible;
        box-shadow: 0 0 4px 1px #aaa;
        border-radius: 5px; 
    }

    .product-wrapper:hover .expandable {
        opacity: 1;
        visibility: visible;
    }
    .imgMAin {
        padding: 15px;
    }
    .product_title,
    .product_price {
        padding: 0 15px;
    }
    .forBorders {
        border: 1px solid #8b5bc0;
        width: 30px;
        height: 30px;
        transition: border-color 0.3s ease, border-width 0.3s ease;
    }

    .forBorders:hover {
        border-color: #a894bd;
        border-width: 3px;
    }

    .product-wrapper .buy-now:hover {
        background-color: #f3f3f3;
        color: #8b5bc0 !important;
    }

    .product-wrapper:hover .buy-now {
        border: 1px solid #8b5bc0;
    }

    .clr_size {
        line-height: 30px;
        text-align: left;
    }

    .clr_size button {
        border-radius: 5px;
        border: 1px solid black;
        line-height: 15px;

    }

    .clr_size button a {
        color: #000;
        text-decoration: none;
    }

    /* .product-wrapper:after {
    content: "";
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    height: 100%;
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    transition: opacity 0s ease;
    width: 100%;
    z-index: -1;
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
    .product-colors {
        display: flex;
        /* Optional: Use flexbox for horizontal arrangement */
    }

    .color-box {
        width: 20px;
        height: 20px;
        margin-right: 5px;
        /* Optional: Adjust spacing between color boxes */
    }

    .product-sizes {
        display: flex;
        /* Optional: Use flexbox for horizontal arrangement */
    }

    .size-box {
        padding: 5px;
        margin-right: 5px;
        /* Optional: Adjust spacing between size boxes */
        border: 1px solid #000;
        /* Optional: Add a border for better visibility */
    }

    .q-mark {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        text-align: center;
        background: #e0e0e0;
        margin-right: -5px;
        margin-top: 2px;
        float: right;
        margin-left: 2px;
    }

    .product-sizes {
        display: flex;
    }

    .size-box {
        width: 80px;
        /* Adjust the width based on your design */
        height: 40px;
        /* Adjust the height based on your design */
        padding: 5px;
        margin-right: 10px;
        /* Adjust spacing between size boxes */
        border: 1px solid #000;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
