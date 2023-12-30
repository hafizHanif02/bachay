<div class="bgcolor">
    <div class="flash-sales container-xxl">
        <h1 class="text-center textClr">Flash Sales For Child Products Get Crazy Discounts</h1>

        <div class="row mt-5 col-12 flash-sales-container ">
            @if(count($productsInFlashDeal) > 0)
            @foreach ($productsInFlashDeal->take(6) as $products)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
                    <div class="card rounded-5">
                        <a href="{{ route('product-detail', $products->id) }}">
                            <div class="deal-alert-circle">-{{ $products->discount }}%</div>
                            <div class="forHeight">
                                {{-- @foreach (json_decode($products->images) as $key => $photo) --}}
                                <img class="object-fit-cover card-img rounded-5"
                                    src="{{ asset("storage/app/public/product/thumbnail/$products->thumbnail") }}  "
                                    alt="Flash Sale" width="100%" height="100%" />
                                {{-- @endforeach --}}
                            </div>
                            <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                                @if (strlen($products->name) <= 20)
                                    <p class="card-text">{{ $products->name }}</p>
                                @else
                                    <p class="card-text"> {{ substr($products->name, 0, 20) }}...</p>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
            @endif
        </div>


    </div>

</div>


<style>
    .bgcolor {
        background: #fbdabf;
    }
</style>
