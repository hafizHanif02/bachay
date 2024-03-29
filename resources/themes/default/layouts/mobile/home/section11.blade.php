<div class="heading-con d-flex justify-content-between align-items-baseline mt-4">
    <div class="heading">
        <h1 class="textClr">Six Years Olds</h1>
    </div>
    <div class="see-all">
        <a class="text-dark" href="#">See All</a>
    </div>
</div>

<div class="cards-con space-between">
    <div class="slider-cards mt-2">
        @foreach ($latest_products->shuffle() as $products)
            <div class="">
                <div class="sub-card rounded-3 p-2 pe-3">
                    <div class="card1">
                        <div class="first-sec card1">
                            <div class="image-container">
                                <div class="imgCon">
                                    <a class="text-decoration-none product-link"
                                        href="{{ route('product-detail', $products->id) }}">
                                        <img src="{{ asset("storage/app/public/product/thumbnail/$products->thumbnail") }}"
                                        alt="" class="object-fit-cover rounded-3" width="100%" height="100%">
                                    </a>
                                </div>
                                <div class="sec-best-seller mt-3">
                                    <p>Best Seller</p>
                                </div>
                                <div class="wish-list mt-3 me-2">
                                    <a href="" tabindex="-1"><img src="{{ asset('public/images/heart.svg') }}"
                                            alt=""></a>
                                </div>
                                <p class="card-text mt-3">
                                    @if (strlen($products->name) <= 20)
                                        {{ $products->name }}
                                    @else
                                        {{ substr($products->name, 0, 45) }}<span id="dots"> ....</span>
                                    @endif
                                </p>
                                <div class="d-flex">
                                    <h4 class="card-text price">
                                        {{ $products->unit_price - ($products->unit_price * $products->discount) / 100 }}
                                    </h4>
                                    <p class="bg-primary rounded-pill ps-2 pe-2 ms-2 text-white units">141 Solds</p>
                                </div>

                                <p class="card-text"><span class="discount">Rs. {{ $products->unit_price }}</span> <span
                                        class="text-success">-{{ $products->discount }}% Off</span></p>
                                <div class="subdiv d-flex justify-content-between align-items-center">
                                    <a href="#" class="bg-dark m-0" tabindex="-1">Standard Delivery</a>
                                    <p class="rounded-pill text-white m-0">4.9 <img
                                            src="{{ asset('public/images/star.svg') }}" alt=""></p>
                                    <h6 class="m-0">({{ $products->reviews_count }})</h6>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach



    </div>






</div>

