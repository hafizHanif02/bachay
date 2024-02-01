<div class="flash-sales flashMobile mt-3">
    <h1 class="text-center textClr f-18">Flash Sales For Child Product Get Crazy Discounts</h1>
    <div class="row mt-3 col-12 d-flex align-items-center">
        <div class="slider-container mobile-cards">
            <div class="slider">
                @foreach ($flash_deal as $deal)
                    {{-- @php
                        $product_deals = $product->product;
                    @endphp --}}
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4 pt-3">
                        <div class="card rounded-5 cardMobile">
                            <a href="{{ route('product-list-slug', $deal->slug) }}">
                                <div class="deal-alert-circle">-{{ $deal->discount_percent }}%</div>
                                    <div class="icon_main">
                                        <img class="card-img rounded-5 object-fit-cover imgCardMobile"
                                            src="{{ asset('storage/app/public/deal/' . $deal->banner) }}"
                                            alt="Flash Sale 1" />
                                    </div>
                                <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">

                                    @if (strlen($deal->title) <= 20)
                                        <p class="card-text">{{ $deal->title }}</p>
                                    @else
                                        <p class="card-text"> {{ substr($deal->title, 0, 20) }}...</p>
                                    @endif

                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
                {{-- <div class="col-lg-4 col-md-6 col-sm-12 mb-4 pt-3">
                    <div class="card rounded-5 cardMobile">
                        <a href="#">
                            <div class="deal-alert-circle">-15%</div>
                            <img class="card-img rounded-5 imgCardMobile imgCardMobile"
                                src="{{ asset('public/images/flash-sales2.png') }}" alt="Flash Sale 1" height="411px" />
                            <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                                <p class="card-text f-18">New Toys For Children</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 pt-3">
                    <div class="card rounded-5 cardMobile">
                        <a href="#">
                            <div class="deal-alert-circle">-25%</div>
                            <img class="card-img rounded-5 imgCardMobile"
                                src="{{ asset('public/images/flash-sales3.png') }}" alt="Flash Sale 1" height="411px" />
                            <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                                <p class="card-text f-18">New Toys For Children</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 pt-3">
                    <div class="card rounded-5 cardMobile">
                        <a href="#">
                            <div class="deal-alert-circle">-55%</div>
                            <img class="card-img rounded-5 imgCardMobile"
                                src="{{ asset('public/images/flash-sales4.png') }}" alt="Flash Sale 1" height="411px" />
                            <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                                <p class="card-text f-18">New Toys For Children</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 pt-3">
                    <div class="card rounded-5 cardMobile">
                        <a href="#">
                            <div class="deal-alert-circle">-85%</div>
                            <img class="card-img rounded-5 imgCardMobile"
                                src="{{ asset('public/images/flash-sales5.png') }}" alt="Flash Sale 1" height="411px" />
                            <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                                <p class="card-text f-18">New Toys For Children</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 pt-3">
                    <div class="card rounded-5 cardMobile">
                        <a href="#">
                            <div class="deal-alert-circle">-40%</div>
                            <img class="card-img rounded-5 imgCardMobile"
                                src="{{ asset('public/images/flash-sales6.png') }}" alt="Flash Sale 1" height="411px" />
                            <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                                <p class="card-text f-18">New Toys For Children</p>
                            </div>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
{{-- <div class="row mt-5 col-12 flash-sales-container">
    @if (count($categories) > 0)
        @foreach ($categories->sortBy('created_at')->take(6) as $category)
            <div class="icon col-lg-4 col-md-6 col-sm-12 mb-5 mt-4">
                <div class="card card_image rounded-5">
                    <a href="{{ route('product-detail', $category->id) }}">
                        <div class="deal-alert-circle">-{{ $category->discount }}%</div>
                        <div class="forHeight">
                            <img class="object-fit-cover card-img rounded-5"
                                src="{{ asset('storage/app/public/category/' . $category->icon) }}" alt="Flash Sale"
                                width="100%" height="100%" />
                        </div>
                        <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                            @if (strlen($category->name) <= 20)
                                <p class="card-text">{{ $category->name }}</p>
                            @else
                                <p class="card-text"> {{ substr($category->name, 0, 20) }}...</p>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div> --}}
<style>
    .icon_main {
        height: 411px;
    }
</style>
