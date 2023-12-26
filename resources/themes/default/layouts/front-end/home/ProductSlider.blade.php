<div class="sub-contain">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="textClr m-0">Autumn Whisper</h1>
            <a class="d-flex align-items-center text-dark" href="{{ route('product-list') }}">
                <h5 class="m-0">See All</h5>
            </a>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="row">
        @foreach ($latest_products as $products)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="sub-card rounded-3 p-4">
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
                                        class="wishlist-button p-0 bg-transparent rounded-circle forBorder"
                                        data-product-id="{{ $products->id }}" onclick="addToWishlist(this)">
                                        <i
                                            class="bi heart-icon bi-heart{{ in_array($products->id, $wishlistProductsArray) ? '-fill' : '' }} text-danger"></i>
                                    </button>
                                </div>
                                <p class="card-text mt-3" id="productDescription">
                                    @if (strlen($products->name) <= 20)
                                        {{ $products->name }}
                                    @else
                                        {{ substr($products->name, 0, 20) }}<span id="dots"> ....</span>
                                    @endif
                                </p>
                                <div class="d-flex">
                                    <h6 class="card-text price m-0">Rs.
                                        {{ $products->unit_price - ($products->unit_price * $products->discount) / 100 }}
                                    </h6>
                                    <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 text-white units m-0">141 Solds
                                    </p>
                                </div>
                                <p class="card-text"><span class="discount">Rs. {{ $products->unit_price }}</span>
                                    <span class="text-success">-{{ $products->discount }}% Off</span>
                                </p>
                                <div class="subdiv d-flex justify-content-between">
                                    <span href="#">Standard Delivery</span>
                                    {{-- @foreach ($products->reviews as $reviews) --}}
                                    <p class="rounded-pill text-white">4.9
                                        <img class="mb-1" src="{{ asset('public/images/star.svg') }}" alt="">
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
{{-- <script>
    function addToWishlist(productId) {
        $.ajax({
            type: "POST",
            url: "/add-to-wishlist",
            data: {
                productId: productId,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(data, status, xhr) {
                var heartIcon = $('#heartIcon' + productId);
                if (xhr.status === 200) {
                    heartIcon.toggleClass('bi-heart bi-heart-fill');
                    if (heartIcon.hasClass('bi-heart')) {
                        deleteFromWishlist(productId);
                    }
                } else if (xhr.status === 201) {
                    alert("Something went wrong");
                }
            },
            error: function(response) {
                // Handle error
            }
        });
    }

    function deleteFromWishlist(productId) {
        $.ajax({
            type: "POST",
            url: "/delete-wishlist",
            data: {
                productId: productId,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(data, status, xhr) {
                if (xhr.status === 200) {
                    Swal.fire(
                        'Deleted!',
                        'Your product has been removed from Wishlist.',
                        'success'
                    );
                } else {
                    alert("Failed to delete from wishlist. Server returned: " + xhr.status + " " + xhr
                        .statusText);
                }
            },
            error: function(xhr, status, error) {
                alert("Error occurred while deleting from wishlist");
            }
        });
    }
</script> --}}
