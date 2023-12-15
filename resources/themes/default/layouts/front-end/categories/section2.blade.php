<div class="premiumBouquets">
    <h1 class="text-center textClr">Premium Bouquets</h1>
    <div class="row mt-5 col-12 flash-sales-container">
        @foreach ($productsInFlashDeal->take(6) as $products)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
                <div class="card rounded-5">
                    <a href="{{ route('product-detail', $products->id) }}">
                        <div class="deal-alert-circle">-{{ $products->discount }}%</div>
                        <div class="forHeight">
                            <img class="object-fit-cover card-img rounded-5"
                                src="{{ asset('storage/app/public/product/thumbnail/' . $products->product->thumbnail) }}"
                                alt="Flash Sale" width="100%" height="100%" />
                        </div>
                        <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                            @if (strlen($products->product->name) <= 20)
                                <p class="card-text">{{ $products->product->name }}</p>
                            @else
                                <p class="card-text"> {{ substr($products->product->name, 0, 20) }}...</p>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
        @endforeach

    </div>

</div>
