<div class="flash-sales flashMobile mt-3">
    <h1 class="text-center textClr f-18">One of out Top Trending Products and Most Popular</h1>

    <div class="row mt-3 col-12 d-flex align-items-center">
        <div class="slider-container mobile-cards">
            <div class="slider">
                {{-- @foreach ($categories->sortBy('created_at') as $category) --}}
                @foreach ($flash_deal as $deal)

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4 pt-3">
                        <div class="card rounded-5 cardMobile">
                            <a href="{{ route('product-list-slug', $deal->slug) }}">
                                <div class="deal-alert-circle">-{{ $deal->discount_percent }}%</div>
                                <div class="icon_main">

                                    <img class="card-img rounded-5 object-fit-cover imgCardMobile"
                                        {{-- src="{{ asset('storage/app/public/category/' . $category->icon) }}" --}}
                                        src="{{ asset('storage/app/public/deal/' . $deal->banner) }}"
                                        alt="Flash Sale 1" />
                                </div>
                                <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">

                                    {{-- @if (strlen($category->name) <= 20)
                                        <p class="card-text">{{ $category->name }}</p>
                                    @else
                                        <p class="card-text"> {{ substr($category->name, 0, 20) }}...</p>
                                    @endif --}}
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
                            <div class="deal-alert-circle">-75%</div>
                            <img class="card-img rounded-5 imgCardMobile"
                                src="{{ asset('public/images/flash-sales1.png') }}" alt="Flash Sale 1" height="411px" />
                            <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                                <p class="card-text f-18">New Toys For Children</p>
                            </div>
                        </a>
                    </div>
                </div> --}}

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
