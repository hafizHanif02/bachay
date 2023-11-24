<div class="col-3 border-right">
    {{-- <div class="delivery-details-heading d-flex justify-content-between">
        <h5> <img src="{{ asset('web/images/cart-img.svg') }}" alt=""> Check Delivery Details</h5>
        <i class="bi bi-exclamation-circle-fill"></i>
    </div>
    <div class="input-bar mt-2">
        <input name="PinCode" id="Pin" type="text" class="input-field" placeholder="Enter Pin Code">
        <button class="input-button">Check</button>
    </div> --}}
    <div class="filter-by d-flex justify-content-between align-items-center pt-2 pb-2 ">
        <h5>
            Filter By
        </h5>
        <a class="clear-all-btn" href="{{ route('products') }}">Clear All</a>
    </div>
    <div class="promo-services mt-3">
        Badges
    </div>
    @foreach ($filters['badges'] as $badge)
        <label class="col-12 f-spacing">
            <input type="checkbox" name="myCheckbox" onchange="productsFilter(this,'badge','{{ $badge['name'] }}')"
            {{ isset(request()->query('filter')['badge']) && in_array($badge['name'], request()->query('filter')['badge']) ? 'checked' : '' }}>
            {{ $badge['name'] }} <span class="Reviews"> ({{ $badge['count'] }})</span>
        </label>
    @endforeach
    <div class="promo-services mt-4">
        Top Brands Here
    </div>
    @foreach ($filters['brands'] as $brand)
        <label class="col-12 f-spacing">
            <input type="checkbox" name="myCheckbox" onchange="productsFilter(this,'brand','{{ $brand['name'] }}')"
                {{ isset(request()->query('filter')['brands']) && in_array($brand['name'], request()->query('filter')['brands']) ? 'checked' : '' }}>
            {{ $brand['name'] }} <span class="Reviews"> ({{ $brand['count'] }})</span>
        </label>
    @endforeach
    <div class="promo-services mt-4">
        Prices
    </div>
    @foreach ($filters['prices'] as $price)
    {{-- {{ dd($price) }} --}}
        <label class="col-12 f-spacing">
            <input type="checkbox" name="myCheckbox"
                onchange="productsFilter(this,'price',{{ $price['range']['from'] . ',' . $price['range']['to'] }})"
                {{ isset(request()->query('filter')['prices']['from']) &&
                in_array($price['from'], request()->query('filter')['prices']['from']) &&
                isset(request()->query('filter')['prices']['to']) &&
                in_array($price['to'], request()->query('filter')['prices']['to'])
                    ? 'checked'
                    : '' }}>
            Rs.{{ $price['range']['from'] . ' to ' . $price['range']['to'] }} <span class="Reviews"> ({{ $price['count'] }})</span>
        </label>
    @endforeach
    {{-- <label class="col-12 custom-price mt-3 mb-2">
        <input class="rounded-2" type="text" name="mytext" placeholder="custom">
    </label> --}}
    <div class="promo-services mt-4">
        Ratings
    </div>
    @foreach ($filters['ratings'] as $rating)
        <label class="col-12 f-spacing d-flex align-items-center">
            <input type="checkbox" name="myCheckbox" class="me-2"
                onchange="productsFilter(this,'rating',{{ $rating['star'] }})"
                {{ isset(request()->query('filter')['ratings']) && in_array($rating['star'], request()->query('filter')['ratings']) ? 'checked' : '' }}> 
                <img class="me-2"
                src="{{ asset('web/images/vector-star.svg') }}" alt=""><span class="Ratings">
                {{ $rating['star'] }}</span> <span class="ms-5 text-muted">({{ $rating['count'] }})</span>
        </label>
    @endforeach
    <div class="promo-services mt-4">
        Color
    </div>
    @foreach ($filters['colors'] as $color)
        <label class="col-12 f-spacing d-flex align-items-center">
            <input type="checkbox" name="myCheckbox" class="me-2"
                onchange="productsFilter(this,'color','{{ $color['name'] }}')"
                {{ isset(request()->query('filter')['colors']) && in_array($color['name'], request()->query('filter')['colors']) ? 'checked' : '' }}>
            <div class="p-2 rounded-circle me-1" style="background: {{ $color['code'] }}" nonce="{{ csp_nonce() }}">
            </div>
            <span class="colors-name me-1"> {{ $color['name'] }}</span>
            <span class="Reviews"> ({{ $color['count'] }})</span>
        </label>
    @endforeach
</div>
