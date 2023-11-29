<div class="col-3 border-right">
    <div class="delivery-details-heading d-flex justify-content-between">
        <h5> <img src="{{ asset('web/images/cart-img.svg') }}" alt=""> Check Delivery Details</h5>
        <i class="bi bi-exclamation-circle-fill"></i>
    </div>
    <div class="input-bar mt-2 position-relative p-2">
        <input type="text" class="input-field" placeholder="Enter Pin Code">
        <button class="input-button position-absolute">Check</button>
    </div>
    {{-- {{ dd($request->filterprice) }} --}}
    <div class="filter-by d-flex justify-content-between align-items-center pt-2 pb-2 mt-3">
        <h5>
            Filter By
        </h5>
        <a class="clear-all-btn" href="">Clear All</a>
    </div>
    <form action="{{ route('product-list') }}" method="GET" >
        <div class="promo-services mt-3">
            Tag
        </div>
        @foreach($products as $product )
        @foreach($product->tags as $tag)
        <label class="col-12 f-spacing">
            <input type="checkbox" name="filter[{{ $loop->iteration }}][tag]" value="{{ $tag->tag }}" > {{ $tag->tag }} <span class="Reviews"></span>
        </label>
        @endforeach
        @endforeach
      

        <div class="promo-services mt-3">
            Promotion & Services
        </div>
        <label class="col-12 f-spacing">
            <input type="checkbox" name="filter[1][free_shipping]" value="1"> Free Delivery <span class="Reviews"></span>
        </label>
        <label class="col-12 f-spacing">
            <input type="checkbox" name="filter[2][free_shipping]" value="0"> Standard Delivery <span class="Reviews"></span>
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
            <input type="radio" onchange="pricefilter({{ $i }})" {{ ($request->filterprice == ($startPrice + 1) . '-' . ($startPrice + 300) ) ? "checked" : "" }}
            id="price{{ $i }}" name="filterprice" value="{{ $startPrice+1 }}-{{  $startPrice + 300  }}"> 
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
        <div id="colorContainer">
            @foreach($colors as $index => $color)
                <label class="col-12 f-spacing d-flex align-items-center color-item">
                    <input type="checkbox" name="filter[{{ $loop->iteration }}][color]" value="{{ $color->code }}" class="me-2" onchange="colorFilter({{ $loop->iteration }})">
                    <div class="p-2 rounded-circle me-1" style="background-color: {{ $color->code }}"></div>
                    <span class="colors-name me-1">{{ $color->name }}</span>
                    <span class="Reviews"></span>
                </label>
            @endforeach
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


        <button class="m-5 btn text-white rounded-pill" style="background-color: blueviolet" type="submit"> Apply</button>

    </form>

</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
function remove(id, prefix) {
    $(`#${prefix}-tag${id}`).remove();
    $(`#${prefix}_id${id}`).prop('checked', false);
}

function filter(id) {
    var brand = $('#brand_name'+id).val();
    var checkbox = $('#brand_id'+id);

    if (checkbox.prop('checked')) {
        $('#filters-btn').prepend(`
            <button class="boys rounded-3 btn-style" id="filter-tag${id}">
                <i class="bi bi-x-lg" onclick='remove(${id}, "filter")'>${brand}</i>
            </button>
        `);
    } else {
        remove(id, "filter");
    }
}

function pricefilter(id) {
    var price = $('#price' + id).val();

    // Remove existing price filter button
    $('.boys.rounded-3.btn-style[id^="price-filter-tag"]').remove();

    // Add the new price filter button
    $('#filters-btn').prepend(`
        <button class="boys rounded-3 btn-style" id="price-filter-tag${id}">
            <i class="bi bi-x-lg" onclick='remove(${id}, "price-filter")'>${price}</i>
        </button>
    `);
}

// $(document).ready(function () {
//         var colorContainer = $('#colorContainer');
//         var readMoreBtn = $('#readMoreBtn');
//         var initialHeight = 100; // Set your initial height

//         readMoreBtn.click(function () {
//             if (colorContainer.height() === initialHeight) {
//                 colorContainer.css('max-height', 'none');
//                 readMoreBtn.html('Read Less <i class="bi bi-arrow-up"></i>');
//             } else {
//                 colorContainer.css('max-height', initialHeight + 'px');
//                 readMoreBtn.html('Read More <i class="bi bi-arrow-down"></i>');
//             }
//         });
//     });

function colorFilter(index) {
    var colorCode = $('#colorContainer input[name="filter[' + index + '][color]"]').val();
    var checkbox = $('#colorContainer input[name="filter[' + index + '][color]"]');

    if (checkbox.prop('checked')) {
        $('#filters-btn').prepend(`
            <button class="boys rounded-3 btn-style" id="color-filter-tag${index}">
                <i class="bi bi-x-lg" onclick='remove(${index}, "color-filter")'>
                    <div class="p-2 rounded-circle me-1" style="background-color: ${colorCode};"></div>
                </i>
            </button>
        `);
    } else {
        remove(index, "color-filter");
    }
}

</script>

{{-- <style>
    #colorContainer {
    max-height: 100px; /* Set a fixed height for initial display */
    overflow: hidden;
    transition: max-height 0.5s ease-out;
}

#readMoreBtn {
    cursor: pointer;
    color: blue;
}
</style> --}}

