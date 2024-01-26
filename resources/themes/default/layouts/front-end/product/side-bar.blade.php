<div class="filter_aside border-right">
    <div class="delivery-details-heading d-flex justify-content-between align-items-center">
         <img src="{{ asset('public/images/cart-img.svg') }}" alt=""> 
         <div class="mt-1">
            <h6 class="fs-10 m-0 fw-bold">
            Check Delivery
            Details</h6>
        </div>
        <div class="popup mt-1">
            <i class="bi bi-info-circle"></i></a>
            <div class="popup-content">
                <a href="#">Choose your locality to get delivery time. Actual time may vary depending on other
                    items in your order.
                </a>
            </div>
        </div>
    </div>
    <div class="input-bar mt-2 position-relative p-1 rounded-pill align-items-center">
        <form action="">
            <input type="text" class="input-field mb-1" placeholder="Enter Pin Code" required>
            <div>
                <button class="input-button position-absolute rounded-pill">Check</button>
            </div>
            
        </form>
    </div>
    <div class="filter-by d-flex justify-content-between align-items-center pt-2 pb-2 mt-3">
        <h6 class="m-0">
            Filter By
        </h6>
        <a class="clear-all-btn mt-1" href="">Clear All</a>
    </div>
    <form action="{{ route('product-list') }}" method="GET">
        <div class="scroll-main fs-14">
            <div class="promo-services mt-3">
                Tag
            </div>
            <div class="scroll">
                @foreach ($products as $product)
                    @foreach ($product->tags as $tag)
                        <label class="col-12 f-spacing">
                            @if (isset($request->filter))
                                <input type="checkbox"
                                    @foreach ($request->filter as $filter)
                                        @if (isset($filter['tag']))
                                            {{ $filter['tag'] == $tag->tag ? 'checked' : '' }}
                                        @endif @endforeach
                                    name="filter[{{ $loop->iteration }}][tag]" value="{{ $tag->tag }}">
                                {{ $tag->tag }} <span class="Reviews"></span>
                            @else
                                <input type="checkbox" name="filter[{{ $loop->iteration }}][tag]"
                                    value="{{ $tag->tag }}"> {{ $tag->tag }} <span class="Reviews"></span>
                            @endif
                        </label>
                    @endforeach
                @endforeach
            </div>
      

            <div class="promo-services mt-3 border-top pt-4">
                Promotion & Services
            </div>
            {{-- <div class="scroll"> --}}
                <label class="col-12 f-spacing">
                    @if (isset($request->filter) && isset($request->filter[1]['free_shipping']))
                        <input type="checkbox" name="filter[1][free_shipping]" value="1" checked>
                    @else
                        <input type="checkbox" name="filter[1][free_shipping]" value="1">
                    @endif
                    Free Delivery <span class="Reviews"></span>
                </label>

                <label class="col-12 f-spacing">
                    @if (isset($request->filter) && isset($request->filter[2]['free_shipping']))
                        <input type="checkbox" name="filter[2][free_shipping]" value="0" checked>
                    @else
                        <input type="checkbox" name="filter[2][free_shipping]" value="0">
                    @endif
                    Standard Delivery <span class="Reviews"></span>
                </label>
            {{-- </div> --}}
        


            <div class="promo-services mt-4 border-top pt-4">
                Top Brands Here
            </div>
            {{-- <div class="scroll"> --}}
                @foreach ($brands as $brand)
                    <label class="col-12 f-spacing">
                        @if (isset($request->filter))
                            <input type="checkbox" id="brand_id{{ $loop->iteration }}"
                                @foreach ($request->filter as $filter)
                                    @if (isset($filter['brand_id']))
                                        {{ $filter['brand_id'] == $brand->id ? 'checked' : '' }}
                                    @endif @endforeach
                                onchange="filter({{ $loop->iteration }})" name="filter[{{ $loop->iteration }}][brand_id]"
                                value="{{ $brand->id }}">
                        @else
                            <input type="checkbox" id="brand_id{{ $loop->iteration }}"
                                onchange="filter({{ $loop->iteration }})" name="filter[{{ $loop->iteration }}][brand_id]"
                                value="{{ $brand->id }}">
                        @endif
                        {{ $brand->name }}<span class="Reviews"></span>
                        <input type="hidden" id="brand_name{{ $loop->iteration }}" value="{{ $brand->name }}">
                    </label>
                @endforeach
            {{-- </div> --}}


            <div class="promo-services mt-4 border-top pt-4">
                Prices
            </div>
            {{-- <div class="scroll"> --}}
                @if ($pricefilter >= 1)
                    <label class="col-12 f-spacing">
                        <input type="radio" checked onchange="pricefilter(1)" id="fullprice" name="filterprice"
                            value="{{ 0 }}-{{ $pricefilter * 300 }}">
                        Rs.0 to {{ $pricefilter * 300 }}
                        <span class="Reviews"></span>
                    </label>
                    @php
                        $startPrice = 0;
                    @endphp
                    @for ($i = 1; $i <= $pricefilter; $i++)
                        <label class="col-12 f-spacing">
                            <input type="radio" onchange="pricefilter({{ $i }})"
                                {{ $request->filterprice == $startPrice + 1 . '-' . ($startPrice + 300) ? 'checked' : '' }}
                                id="price{{ $i }}" name="filterprice"
                                value="{{ $startPrice + 1 }}-{{ $startPrice + 300 }}">
                            Rs.{{ $startPrice + 1 }} to {{ $startPrice + 300 }}
                            <span class="Reviews"></span>
                        </label>

                        @php
                            $startPrice += 300;
                        @endphp
                    @endfor
                @endif
            {{-- </div> --}}

            <div class="promo-services mt-4 border-top pt-4">
                Ratings
            </div>
            <label class="col-12 f-spacing d-flex align-items-center">
                <input type="checkbox" name="myCheckbox" class="me-2"> <img class="me-2"
                    src="{{ asset('web/images/vector-star.svg') }}" alt=""><span class="Ratings">
                    5.0</span>
            </label>
            <label class="col-12 f-spacing d-flex align-items-center">
                <input type="checkbox" name="myCheckbox" class="me-2"> <img class="me-2"
                    src="{{ asset('web/images/vector-star.svg') }}" alt=""><span class="Ratings">
                    4.0</span>
            </label>
            <label class="col-12 f-spacing d-flex align-items-center">
                <input type="checkbox" name="myCheckbox" class="me-2"> <img class="me-2"
                    src="{{ asset('web/images/vector-star.svg') }}" alt=""><span class="Ratings">
                    3.0</span>
            </label>
            <div class="promo-services mt-4 border-top pt-4">
                Color
            </div>
            <div class="scroll">
                <div id="colorContainer">
                    @foreach ($colors as $index => $color)
                        <label class="col-12 f-spacing d-flex align-items-center color-item">
                            @if (isset($request->filter))
                                <input type="checkbox"
                                    @foreach ($request->filter as $filter)
                        @if (isset($filter['color']))
                            {{ $filter['color'] == $color->code ? 'checked' : '' }}
                        @endif @endforeach
                                    name="filter[{{ $loop->iteration }}][color]" value="{{ $color->code }}"
                                    class="me-2" onchange="colorFilter({{ $loop->iteration }})">
                            @else
                                <input type="checkbox" name="filter[{{ $loop->iteration }}][color]"
                                    value="{{ $color->code }}" class="me-2"
                                    onchange="colorFilter({{ $loop->iteration }})">
                            @endif
                            <div class="p-2 rounded-circle me-1" style="background-color: {{ $color->code }}"></div>
                            <span class="colors-name me-1">{{ $color->name }}</span>
                            <span class="Reviews"></span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- <div class="text-primary" id="readMoreBtn">Read More <i class="bi bi-arrow-down"></i>
        </div> --}}
        {{-- <label class="col-12 f-spacing d-flex align-items-center">
            <input type="checkbox" name="myCheckbox" class="me-2">
            <div class="bg-info p-2 rounded-circle me-1"></div> <span class="colors-name me-1"> Blue</span>
            <span class="Reviews"> (5)</span>
        </label>
        <label class="col-12 f-spacing d-flex align-items-center">
            <input type="checkbox" name="myCheckbox" class="me-2">
            <div class="bg-warning p-2 rounded-circle me-1"></div> <span class="colors-name me-1">
                Yellow</span>
            <span class="Reviews"> (20)</span>
        </label>
        <label class="col-12 f-spacing d-flex align-items-center">
            <input type="checkbox" name="myCheckbox" class="me-2">
            <div class="bg-dark p-2 rounded-circle me-1"></div> <span class="colors-name me-1"> Black</span>
            <span class="Reviews"> (12)</span>
        </label>
        <label class="col-12 f-spacing d-flex align-items-center">
            <input type="checkbox" name="myCheckbox" class="me-2">
            <div class="bg-success p-2 rounded-circle me-1"></div> <span class="colors-name me-1">
                Green</span>
            <span class="Reviews"> (34)</span>
        </label> --}}

        {{-- <div class="promo-services mt-4">
            Location
        </div>
        <label class="col-12 f-spacing">
            <input type="checkbox" name="myCheckbox"> Pakistan <span class="Reviews"> (81)</span>
        </label>
        <label class="col-12 f-spacing">
            <input type="checkbox" name="myCheckbox"> China <span class="Reviews"> (77)</span>
        </label>
        <label class="col-12 f-spacing">
            <input type="checkbox" name="myCheckbox"> United State <span class="Reviews"> (51)</span>
        </label> --}}
        <hr>
        <button class="mt-0 input-button rounded-pill fs-6" type="submit" style="width: 95%">Apply</button>
       

    </form>

</div>
<style>
    .fs-10{
        font-size: 10px;
    }
</style>