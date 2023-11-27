<div class="col-3 border-right">
    <div class="delivery-details-heading d-flex justify-content-between">
        <h5> <img src="{{ asset('web/images/cart-img.svg') }}" alt=""> Check Delivery Details</h5>
        <i class="bi bi-exclamation-circle-fill"></i>
    </div>
    <div class="input-bar mt-2 position-relative p-2">
        <input type="text" class="input-field" placeholder="Enter Pin Code">
        <button class="input-button position-absolute">Check</button>
    </div>

    <div class="filter-by d-flex justify-content-between align-items-center pt-2 pb-2 mt-3">
        <h5>
            Filter By
        </h5>
        <a class="clear-all-btn" href="">Clear All</a>
    </div>
    <form action="{{ route('products-list') }}" method="GET" >
        <div class="promo-services mt-3">
            Promotion & Services
        </div>
        <label class="col-12 f-spacing">
            <input type="checkbox" name="filter[1]['shipping_delivery']"> Free Delivery <span class="Reviews"></span>
        </label>
        <label class="col-12 f-spacing">
            <input type="checkbox" name="filter[2]['shipping_delivery']"> Standard Delivery <span class="Reviews"></span>
        </label>

        <div class="promo-services mt-4">
            Top Brands Here
        </div>
        @foreach($brands as $brand)
        <label class="col-12 f-spacing">
            <input type="checkbox" id="brand_id{{ $loop->iteration }}" onchange="filter({{ $loop->iteration }})" name="filter[{{ $loop->iteration }}][brand_id]" value="{{ $brand->id }}">{{ $brand->name }}<span class="Reviews"></span>
            <input type="hidden" id="brand_name{{ $loop->iteration }}" value="{{ $brand->name }}">
        </label>
        @endforeach
        

        <div class="promo-services mt-4">
            Prices
        </div>

    @if($pricefilter >= 1)
    <label class="col-12 f-spacing">
        <input type="radio" checked  onchange="pricefilter(1)" id="fullprice" name="filterprice" value="{{ 0 }}-{{  $pricefilter * 300  }}"> 
        Rs.0  to {{ $pricefilter * 300 }}
        <span class="Reviews"></span>
    </label>
    @php
        $startPrice = 0;
    @endphp
    @for($i = 1; $i <= $pricefilter; $i++)
        <label class="col-12 f-spacing">
            <input type="radio" onchange="pricefilter({{ $i }})" id="price{{ $i }}" name="filterprice" value="{{ $startPrice+1 }}-{{  $startPrice + 300  }}"> 
            Rs.{{ $startPrice + 1 }} to {{ $startPrice + 300 }}
            <span class="Reviews"></span>
        </label>

        @php
            $startPrice += 300;
        @endphp
        @endfor
    @endif

        <div class="promo-services mt-4">
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


        <div class="promo-services mt-4">
            Color
        </div>
        <label class="col-12 f-spacing d-flex align-items-center">
            <input type="checkbox" name="myCheckbox" class="me-2">
            <div class="bg-danger p-2 rounded-circle me-1"></div> <span class="colors-name me-1"> Red</span>
            <span class="Reviews"> (54)</span>
        </label>
        <label class="col-12 f-spacing d-flex align-items-center">
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
        </label>

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


        <button class="m-5 btn text-white rounded-pill" style="background-color: blueviolet" type="submit"> Apply</button>

    </form>

</div>


<script>
    function filter(id) {
    var brand = $('#brand_name'+id).val();
    var checkbox = $('#brand_id'+id);

    if (checkbox.prop('checked')) {
        // If the checkbox is checked, add the button
        $('#filters-btn').prepend(`
            <button class="boys rounded-3 btn-style" id="filter-tag${id}">
                <i class="bi bi-x-lg" onclick='remove(${id})'>${brand}</i>
            </button>
        `);
    } else {
        // If the checkbox is unchecked, remove the button
        $(`#filter-tag${id}`).remove();

        // Uncheck the checkbox
        checkbox.prop('checked', false);
    }
}
    
    function remove(id){
        $('#filter-tag'+id).hide();
        $('#brand_id'+id).prop('checked', false);
    }

    function pricefilter(id) {
    var price = $('#price'+id).val();

    // Remove any previously selected buttons
    $('.boys.rounded-3.btn-style').remove();

    // Append the new button
    $('#filters-btn').prepend(`
        <button class="boys rounded-3 btn-style" id="filter-tag${id}">
            <i class="bi bi-x-lg" onclick='remove(${id})'>${price}</i>
        </button>
    `);
}

</script>
