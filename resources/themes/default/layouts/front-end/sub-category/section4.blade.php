@php
    $shuffledProducts = $productsInFlashDeal->shuffle()->take(7);
@endphp
<div class="premiumBouquets container-xxl">
    <h1 class="text-center textClr pb-5">Premium Bouquets</h1>
    <div class="row col-12 flash-sales-container d-flex justify-content-center">
        @foreach ($shuffledProducts as $products)
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4 justify-content-between">
                <a href="#" style="text-decoration: none">
                    <div class="ImgCon card rounded-4 for-border">
                        <img class="card-img rounded-4 object-fit-cover"
                            src="{{ asset('storage/app/public/product/thumbnail/' . $products->product->thumbnail) }}"
                            alt="Flash Sale 1" width="100%" height="100%" />
                    </div>
                    <h4 class="text-center text-dark">
                        @if (strlen($products->product->name) <= 20)
                            {{ $products->product->name }}
                        @else
                            <span class="card-text"> {{ substr($products->product->name, 0, 20) }}...</span>
                        @endif
                    </h4>
                </a>
            </div>
        @endforeach
        {{-- <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <a href="#">
                <div class="ImgCon card rounded-4 for-border">

                    <img class="card-img rounded-4 object-fit-cover" src="{{ asset('public/images/premium-b-5.png') }}"
                        alt="Flash Sale 1" width="100%" height="100%" />

                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <a href="#">
                <div class="ImgCon card rounded-4 for-border">

                    <img class="card-img rounded-4 object-fit-cover" src="{{ asset('public/images/premium-b-5.png') }}"
                        alt="Flash Sale 1" width="100%" height="100%" />

                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <a href="#">
                <div class="ImgCon card rounded-4 for-border">

                    <img class="card-img rounded-4 object-fit-cover" src="{{ asset('public/images/premium-b-5.png') }}"
                        alt="Flash Sale 1" width="100%" height="100%" />

                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <a href="#">
                <div class="ImgCon card rounded-4 for-border">

                    <img class="card-img rounded-4 object-fit-cover" src="{{ asset('public/images/premium-b-5.png') }}"
                        alt="Flash Sale 1" width="100%" height="100%" />

                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <a href="#">
                <div class="ImgCon card rounded-4 for-border">

                    <img class="card-img rounded-4 object-fit-cover" src="{{ asset('public/images/premium-b-5.png') }}"
                        alt="Flash Sale 1" width="100%" height="100%" />

                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <a href="#">
                <div class="ImgCon card rounded-4 for-border">

                    <img class="card-img rounded-4 object-fit-cover" src="{{ asset('public/images/premium-b-5.png') }}"
                        alt="Flash Sale 1" width="100%" height="100%" />

                </div>
            </a>
        </div> --}}
    </div>
</div>
