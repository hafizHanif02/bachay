<div class="container-fluid products mt-4">
    <div class="row">

        {{-- {{ $prod }} --}}


        <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex flex-column fixedProduct">
            <div class="product-container">
                <div class="slider main-image">
                    <img id="main-image" class="detailed-product-img object-fit-cover"
                        src="{{ asset("storage/app/public/product/thumbnail/$product->thumbnail") }}" alt="Main Image"
                        width="100%" height="100%">
                        <img id="main-image" class="detailed-product-img object-fit-cover"
                        src="{{ asset("storage/app/public/product/thumbnail/$product->thumbnail") }}" alt="Main Image"
                        width="100%" height="100%">
                    @foreach (json_decode($product->color_image) as $key => $photo)
                        <img  id="main-image" class="detailed-product-img object-fit-cover"
                            src="{{ asset('storage/app/public/product/' . $photo->image_name) }}"
                            data-url='{{ asset('storage/app/public/product/' . $photo->image_name) }}'
                            alt="Small Image {{ $key + 1 }}">
                    @endforeach
                    @foreach (json_decode($product->images) as $key => $photo)
                        <img  id="main-image" class="detailed-product-img object-fit-cover"
                            src="{{ asset('storage/app/public/product/' . $photo) }}"
                            data-url='{{ asset('storage/app/public/product/' . $photo) }}'
                            alt="Small Image {{ $key + 1 }}">
                    @endforeach
                </div>



                {{-- <div class="small-images">
                        <div class="SmallImageCon">     
                                @foreach (json_decode($product->color_image) as $key => $photo)
                                    <img class="small-image object-fit-cover"
                                        id="image-#{{ $photo->color ? $photo->color : '' }}"
                                        src="{{ asset('storage/app/public/product/' . $photo->image_name) }}"
                                        data-url='{{ asset('storage/app/public/product/' . $photo->image_name) }}'
                                        alt="Small Image {{ $key + 1 }}">
                                @endforeach
                                @foreach (json_decode($product->images) as $key => $photo)
                                    <img class="small-image object-fit-cover"
                                        src="{{ asset('storage/app/public/product/' . $photo) }}"
                                        data-url='{{ asset('storage/app/public/product/' . $photo) }}'
                                        alt="Small Image {{ $key + 1 }}">
                            @endforeach
                        </div>
                </div> --}}




                {{-- <img class="small-image" src="{{ asset('sstytorage/app/public/product/images' . $photo) }}"
                                alt="Small Image 1"> --}}

                {{-- <img class="small-image " src="{{ asset('public/images/Frame 134 (2).png') }}" alt="Small Image 2">
                    <img class="small-image" src="{{ asset('public/images/Frame 135 (2).png') }}" alt="Small Image 3">
                    <img class="small-image " src="{{ asset('public/images/Frame 137 (2).png') }}" alt="Small Image 3">
                    <img class="small-image " src="{{ asset('public/images/Frame 855 (2).png') }}" alt="Small Image 3">
                    <img class="small-image " src="{{ asset('public/images/Frame 856 (2).png') }}" alt="Small Image 3"> --}}




            </div>
            {{-- <img class="detailed-product-img" src="{{ asset('public/images/Frame 83.png') }}" alt=""> --}}
            <div class="col-12 d-flex justify-content-between">
                <form action="{{ route('cart.buy-now') }}" method="POST" class="form-group-inline">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="price" id="price" value="{{ $product->unit_price }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="product[1][quantity]" value="1">
                    <input type="hidden" name="product[1][id]" value="{{ $product->id }}">
                    <input type="hidden" name="product[1][price]" value="{{ $product->unit_price }}">
                    <input type="hidden" name="product[1][product_id]" value="{{ $product->id }}">
                    <input type="hidden" name="product[1][tax]" value="{{ $product->tax }}">
                    <input type="hidden" name="product[1][tax_model]" value="{{ $product->tax_model }}">
                    <input type="hidden" name="product[1][color]" value="{{ $product->color }}">
                    <input type="hidden" name="product[1][variant]" value="{{ $product->variant }}">
                    <input type="hidden" name="product[1][discount]" value="{{ $product->discount }}">
                    <input type="hidden" name="product[1][discount_amount]"
                        value="{{ ($product->discount * $product->unit_price) / 100 }}">
                    <input type="hidden" name="product[1][actual_price]" value="{{ $product->unit_price }}">
                    <input type="hidden" name="product[1][price]" value="{{ $product->unit_price }}">
                    <input type="hidden" name="product[1][quantity]" value="1">
                    <button type="submit" class="buy-now rounded-pill w-100 text-white pt-3 pb-3 mt-3">Buy Now</button>
                </form>
                <form action="{{ route('cart.add') }}" method="POST" class="form-group-inline">
                    @csrf
                    <input type="hidden" name="price" id="price" value="{{ $product->unit_price }}">
                    <input type="hidden" name="discount" id="discount" value="{{ $product->discount }}">
                    <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="thumbnail" value="{{ $product->thumbnail }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="tax" value="{{ $tax }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="shipping_cost" value="{{ $product->shipping_cost }}">
                    <input type="hidden" name="color" id="color">
                    <input type="hidden" name="variant" id="variant">
                    <input type="hidden" name="slug" id="slug" value="{{ $product->slug }}">
                    <input type="hidden" name="customer_id" id="customer_id"
                        value="{{ auth('customer')->check() ? auth('customer')->user()->id : '' }}">

                    <div class="mt-3">
                        <button type="submit" class="w-100 rounded-pill text-dark fw-bold pt-3 pb-3">Add to
                            Cart</button>
                    </div>
                </form>
            </div>

        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-12 ">
            <div class="row pt-3 pb-3">
                <div class="col-12 d-flex align-items-center gap-2">
                    <h6 class="fontPoppins fw-bold boysClothes mb-0">
                        @if (strlen($categoryName) <= 10)
                            {{ $categoryName }}
                        @else
                            {{ substr($categoryName, 0, 10) }}...
                        @endif
                        {{-- {{ $categoryName }} --}}

                        {{-- Boys - Clothes --}}
                    </h6>
                    <div class="d-flex align-items-center gap-1">
                        <h6 class="share fontPoppins fw-bold mb-0">Share</h6>

                        <img class="ms-1 me-1 socialShareIcons" src="{{ asset('public/images/image 24.png') }}"
                            alt="">
                        <img class="ms-1 me-1 socialShareIcons" src="{{ asset('public/images/image 25.png') }}"
                            alt="">
                        <img class="ms-1 me-1 socialShareIcons" src="{{ asset('public/images/image 26.png') }}"
                            alt="">

                    </div>

                    <div class="vl"></div>

                    <div class="follow d-flex align-items-end">
                        <p class="m-0 fw-normal fontPoppins followUs">Follow Us </p>
                        <a href="#" class="pe-2 ps-2"><img class="socialShareIcons"
                                src="{{ asset('public/images/image 26.png') }}" alt=""></a>
                        <p class="m-0 fw-normal followUs">@profilehandel </p>
                        <a href="#" class="pe-2 ps-2"><img class="socialShareIcons"
                                src="{{ asset('public/images/image 27.png') }}" alt=""></a>
                        <p class="m-0 fw-normal followUs">@profilehandel </p>

                    </div>
                </div>
                <div class="col-12">
                    <h6 class="pt-3 pb-2 fw-bold fontPoppins m-0">

                        {{ $product->name }}
                    </h6>
                </div>
                <div class="col-12 d-flex align-items-center pb-2">
                    <h6 class="text-secondary pe-2 fontPoppins">Product ID: </h6>
                    <h6 class="text-dark fw-bold fontPoppins">{{ $product->id }}</h6>
                </div>
                <div class="col-12 pb-3">
                    <div class="hl "></div>
                </div>
                <div class="col-12 d-flex align-items-center">
                    <h4 class="fw-bold pe-2 fontPoppins" id="discounted_price">Rs.
                        {{ $product->unit_price - ($product->unit_price * $product->discount) / 100 }}</h4>
                    <h6 class="text-secondary text-decoration-line-through pe-1 fontPoppins" id="actual_price">Rs.
                        {{ $product->unit_price }}</h6>
                    <h6 class="discountPercent fontPoppins"> - {{ $product->discount }}% Off</h6>
                </div>
                <div class="col-12">
                    <h6 class="text-secondary txtFontWeight fontPoppins">
                        MRP incl. all taxes, Add'l charges may apply on discounted price
                    </h6>
                </div>

                <div class="col-8 pb-4 pt-3">
                    <div class=" rounded-pill border border-2 border-secondary p-2 ">

                        <div class="row align-items-center">
                            <div class="col-2">
                                <img class="joinImg" src="{{ asset('public/images/join.png') }}" alt="">
                            </div>
                            <div class="col-6">
                                <p class="text-dark mb-0 priceJoin fontPoppins">Save <span class="joinPrice fw-bold">
                                        Rs.25.98
                                    </span>
                                    With Club</p>
                                <p class="text-dark mb-0 priceClub fontPoppins">Club Price: <span class="clubPrice">Rs
                                        1000.23</span></p>
                            </div>
                            <div class="col-4">
                                <button class="buy-now rounded-pill text-white w-100 p-2 fontPoppins joinBTN">Join
                                    Now</button>

                            </div>
                        </div>


                    </div>
                </div>
                @if ($colors->isNotEmpty())

                    <div class="ProductColors col-12 d-flex align-items-center pb-4">
                        <p class="text-dark simpleText fs-6 mb-0 pe-3 fontPoppins">Colors</p>
                        @foreach ($colors as $color)
                            <input type="radio" class="me-3" style="background-color: {{ $color->code }}"
                                id="btn{{ $loop->iteration }}" onchange="changepicture('{{ $color->code }}')"
                                name="Btn">
                        @endforeach
                    </div>
                @endif
                <div class="col-12 d-flex align-items-center pb-2">
                    <p class="text-dark simpleText fs-6 mb-0 pe-3 fontPoppins">Size Basics</p>
                    <select name="" id=""
                        class="SizeLocation btn btn-sm border-secondary font-poppins pt-1 pb-1 ps-1 pe-3">
                        <option value="usa">USA</option>
                        <option value="uae">UAE</option>
                        <option value="pak">PAK</option>
                        <option value="aus">AUS</option>
                    </select>
                    <div class="ms-3 d-flex align-items-center">
                        <button type="button" class="btn sizeBTN fontPoppins" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <img class="sizeChartImg" src="{{ asset('public/images/size chart.png') }}"
                                alt="Size Chart">
                            Size Chart
                        </button>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fontPoppins" id="exampleModalLabel">Size Chart</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <img class="w-100" src="{{ asset('public/images/sizeChatImage.png') }}"
                                            alt="Size Chart Image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <p class="text-secondary toetoHeel  mb-0 fontPoppins">Toe to Heel Size (in CM): <span
                            class="sizeToeSpan ">19.5</span> | Age: <span class="sizeToeSpan">6 - 6.5 Y</span> | Size:
                        <span class="sizeToeSpan">EU 31</span> | Brand Size: <span class="sizeToeSpan">32</span>
                    </p>

                </div>

                <div class="Sizesbtn col-12 pt-2 d-flex align-items-center mb-3">
                    <p class="text-dark simpleText fs-6 mb-0 pe-3 fontPoppins">Size</p>
                    @foreach (json_decode($product->variation) as $variant)
                        @if ($variant->qty > 0)
                            <input class="square square1 ms-1 me-1 pt-2 pb-2 ps-3 pe-3 rounded-2 fontPoppins"
                                type="button" value="{{ $variant->type }}" data-price="{{ $variant->price }}"
                                onclick="InsertVariant('{{ $loop->iteration }}')"
                                data-discount={{ $product->discount }} id="variant{{ $loop->iteration }}">
                        @elseif($variant->qty <= 0)
                            <input
                                class="bg-danger text-white square square1 ms-1 me-1 pt-2 pb-2 ps-3 pe-3 rounded-2 fontPoppins"
                                disabled title="Not Available" type="button" value="{{ $variant->type }}">
                        @endif
                    @endforeach
                    {{-- <input class="square square1 ms-1 me-1 pt-2 pb-2 ps-3 pe-3 rounded-2 fontPoppins" type="button"
                        value="UK 11 (18.3 CM)">
                    <input class="fontPoppins square square2 ms-1 me-1 pt-2 pb-2 ps-3 pe-3 rounded-2" type="button"
                        value="UK 11.5 (18.9 CM)">
                    <input class="fontPoppins square square3 ms-1 me-1 pt-2 pb-2 ps-3 pe-3 rounded-2" type="button"
                        value="UK 12 (19.5 CM)">
                    <input class="fontPoppins square square4 ms-1 me-1 pt-2 pb-2 ps-3 pe-3 rounded-2" type="button"
                        value="UK 13 (20.2 CM)"> --}}
                </div>
                <div class="col-12 mb-4 mt-2">
                    <p class="text-secondary toetoHeel fontPoppins mb-0">Size: <span class="sizeToeSpan">I = Infants,
                            K =
                            Kid</span></p>

                </div>
                <div class="col-12 pb-3">
                    <div class="hl "></div>
                </div>
                <div class="col-12">
                    <h5 class="pt-3 pb-2 fw-bold fontPoppins">
                        Offers & Discounts
                    </h5>
                </div>

                <div class="col-12 mb-5">
                    <div class="row">
                        <div class="col-6 ">
                            <div class="offer pt-4 pb-4 ps-3 pe-3 rounded-4">
                                <div class="row align-items-start">
                                    <div class="col-2">
                                        <img class="offerIMG" src="{{ asset('public/images/join.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-10">
                                        <h6 class="fontPoppins fw-bold flatss mb-0">Flat 42% Off for All Users -
                                            Superhit
                                            Fashion Brands</h6>
                                        <a class="ViewTC fontPoppins" href="#">View T&C*</a>

                                    </div>
                                    <div class="col-12 pt-3 pb-3">
                                        <div class="dottedhl"></div>
                                    </div>

                                    <div class="col-12 pt-2 d-flex align-items-center justify-content-start gap-2">

                                        {{-- <a class=" fontPoppins pt-2 pb-2 codde btn d-flex justify-content-around   "><span
                                                class="text-start codeTxt text-white fontPoppins">FG5DST</span> <span
                                                class="copyCode text-end"><img class="copyIMG"
                                                    src="{{ asset('public/images/copy.png') }}" alt="">
                                                Copy</span></a> --}}
                                        <div
                                            class=" fontPoppins p-0 codde btn d-flex justify-content-around align-items-center">
                                            <span id="codeSpan"
                                                class="text-start codeTxt text-white fontPoppins">FJ3478</span>
                                            <button class="copyCode text-end border-0 bg-transparent p-2"
                                                onclick="copyToClipboard()"><img class="copyIMG"
                                                    src="{{ asset('public/images/copy.png') }}"
                                                    alt="">Copy</button>
                                        </div>

                                        <a class=" fontPoppins btn shareBtn pt-1 pb-1" href="#"><span
                                                class="copyCode text-end"><img class="copyIMG"
                                                    src="{{ asset('public/images/shareImg.png') }}" alt="">
                                                Share</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 ">
                            <div class="offer pt-4 pb-4 ps-3 pe-3 rounded-4">
                                <div class="row align-items-start">
                                    <div class="col-2">
                                        <img class="offerIMG" src="{{ asset('public/images/join.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-10">
                                        <h6 class="fontPoppins fw-bold flatss mb-0">Flat 42% Off for All Users -
                                            Superhit
                                            Fashion Brands</h6>
                                        <a class="ViewTC fontPoppins " href="#">View T&C*</a>

                                    </div>
                                    <div class="col-12 pt-3 pb-3">
                                        <div class="dottedhl"></div>
                                    </div>

                                    <div class="col-12 pt-2 d-flex align-items-center justify-content-start gap-2">

                                        {{-- <a class="fontPoppins pt-2 pb-2 codde btn d-flex justify-content-around   "><span
                                                class="text-start codeTxt text-white">FG5DST</span> <span
                                                class="copyCode text-end"><img class="copyIMG"
                                                    src="{{ asset('public/images/copy.png') }}" alt="">
                                                Copy</span></a> --}}
                                        <div
                                            class=" fontPoppins p-0 codde btn d-flex justify-content-around align-items-center">
                                            <span id="codeSpan2"
                                                class="text-start codeTxt text-white fontPoppins">GHD673</span>
                                            <button class="copyCode text-end border-0 bg-transparent p-2"
                                                onclick="copyToClipboard2()"><img class="copyIMG"
                                                    src="{{ asset('public/images/copy.png') }}"
                                                    alt="">Copy</button>
                                        </div>

                                        <a class="fontPoppins btn shareBtn pt-1 pb-1" href="#"><span
                                                class="copyCode text-end"><img class="copyIMG"
                                                    src="{{ asset('public/images/shareImg.png') }}" alt="">
                                                Share</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 pb-3">
                    <div class="hl "></div>
                </div>
                <div class="col-12">
                    <h5 class="pt-3 pb-2 fw-bold fontPoppins">
                        Bachay Club Benefits
                    </h5>
                </div>
                <div class="col-12 d-flex justify-content-between mt-2 mb-5 gap-2">
                    <div class="text-center clubCash">
                        <img class="mb-2 benefitsImg" src="{{ asset('public/images/Group 901.png') }}"
                            alt="">
                        <p class="clubCashTxt mb-0 fontPoppins">Club Cash Benefits</p>
                        <h6 class="fw-bold clubCashTxt fontPoppins">Upto <span class="priceUpto">Rs.26</span></h6>
                    </div>
                    <div class="text-center ">
                        <img class="mb-2 benefitsImg" src="{{ asset('public/images/Group 901 (1).png') }}"
                            alt="">
                        <p class="clubCashTxt mb-0 fontPoppins ">Excusive Offers
                            & Discounts </p>
                        {{-- <h6 class="fw-bold">Upto <span class="priceUpto">Rs.26</span></h6> --}}
                    </div>
                    <div class="text-center ">
                        <img class="mb-2 benefitsImg" src="{{ asset('public/images/Group 901 (2).png') }}"
                            alt="">
                        <p class="clubCashTxt mb-0 fontPoppins">Lower Prices on
                            Products</p>
                        {{-- <h6 class="fw-bold">Upto <span class="priceUpto">Rs.26</span></h6> --}}
                    </div>
                    <div class="text-center ">
                        <img class="mb-2 benefitsImg" src="{{ asset('public/images/Group 901 (3).png') }}"
                            alt="">
                        <p class="clubCashTxt mb-0 fontPoppins">Lower Shipping
                            Barrier</p>
                        {{-- <h6 class="fw-bold">Upto <span class="priceUpto">Rs.26</span></h6> --}}
                    </div>
                    <div class="text-center ">
                        <img class="mb-2 benefitsImg" src="{{ asset('public/images/Group 901 (4).png') }}"
                            alt="">
                        <p class="clubCashTxt mb-0 fontPoppins">Free baby gear
                            assembly</p>
                        {{-- <h6 class="fw-bold">Upto <span class="priceUpto">Rs.26</span></h6> --}}
                    </div>
                </div>
                <div class="col-12 pb-2">
                    <div class="hl"></div>
                </div>

                <div class="col-12 pt-3 pb-3">
                    <div class="row d-flex justify-content-between">
                        <div class="col-5 d-flex align-items-center justify-content-between">
                            <img class="deliveryVan" src="{{ asset('public/images/deliveryVan.png') }}"
                                alt="" width="20px" height="20px">
                            <h6 class="fontPoppins fw-bold mb-0">
                                Check Delivery Details
                            </h6>
                            <img class="deliveryVan" src="{{ asset('public/images/war.png') }}" alt=""
                                width="14px" height="14px">

                        </div>
                        <div class="col-5 d-flex align-items-center justify-content-between">
                            <img class="deliveryVan" src="{{ asset('public/images/clock.png') }}" alt=""
                                width="16px" height="16px">
                            <h6 class="fontPoppins exchange fw-bold mb-0">
                                7 Days Return or Exchange
                            </h6>
                            <img class="deliveryVan" src="{{ asset('public/images/war.png') }}" alt=""
                                width="14px" height="14px">

                        </div>
                    </div>
                </div>

                <div class="col-12 ">
                    <form class="form-inline my-2 my-lg-0 col-4 w-100">
                        <div class="search1 search-bar pt-2 pb-3">
                            <input class="form-control pt-3 pb-3 mr-sm-2 search-input fontPoppins" type="search"
                                name="searchPin" id="searchPin" placeholder="Enter Pin Code" aria-label="Search">

                            <ul class="results" id="location-result"></ul>

                            <div class="check-btn mt-2 mb-2">
                                <button
                                    class="btn btnCheck ps-5 pe-5 pt-2 pb-2 rounded-pill text-white fontPoppins">Check</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12">
                    <p class="txtPin fontPoppins mb-4">
                        Same Day/Next Day delivery applicable on this product. Enter pincode to check availability in
                        your area.
                    </p>
                </div>
                <div class="col-12 pb-2">
                    <div class="hl "></div>
                </div>

                <div class="col-12 pt-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fontPoppins fw-bold">
                            Size & Fit Information
                        </h6>
                    </div>
                    <div>
                        <a class=" fontPoppins btn border border-2 inchesAndCm border-dark fw-bold rounded-pill ps-4 pe-4 me-2"
                            href="#">Inches</a>
                        <a class="fontPoppins btn cmBtn inchesAndCm fw-bold rounded-pill text-white ps-5 pe-5 ms-2"
                            href="#">CM</a>

                    </div>
                </div>

                <div class="col-12 pt-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class=" fontPoppins">Age:</p>
                    </div>
                    {{-- @foreach ($ageOptions as $age)
                        <div>
                            <p class=" fontPoppins">{{ $age }} Years</p>
                        </div>
                    @endforeach --}}

                    <div>
                        <p class=" fontPoppins">2.5 - 3 Years</p>
                    </div>


                </div>
                <div class="col-12">
                    <div class="hl "></div>
                </div>
                <div class="col-12 pt-3 pb-3 d-flex align-items-center justify-content-between">
                    <div>
                        <p class=" fontPoppins m-0">Length:</p>
                    </div>
                    <div>
                        <p class="fontPoppins m-0">14.6 CM</p>
                    </div>
                </div>
                <div class="col-12 pb-4">
                    <div class="hl "></div>
                </div>

                <div class="col-12 pt-2 pb-1 content">
                    <div class="row">
                        <div class="col-12 pb-4">
                            <h6 class="fontPoppins fw-bold mb-4 ">
                                Product Description
                            </h6>
                            <h6 class="fontPoppins fs-14 specific fw-bold mb-2">
                                Specification
                            </h6>
                            <p class="speciTxt fs-14 fontPoppins mb-1">
                                @if (str_replace('-', ' ', $product->slug))
                                    {{ str_replace('-', ' ', $product->slug) }}
                                @else
                                    Default Value or Action
                                @endif
                            </p>

                            {{-- <p class="speciTxt fontPoppins mb-1">
                                Type - Sport Shoes
                            </p>
                            <p class="speciTxt fontPoppins mb-1">
                                Upper Material - PU
                            </p>
                            <p class="speciTxt fontPoppins mb-1">
                                Heel Height- Flat
                            </p>
                            <p class="speciTxt fontPoppins mb-1">
                                Sole - TPR
                            </p> --}}
                        </div>
                        {{-- {{ dd($product) }} --}}
                        <div class="col-12 more-content">
                            {{-- <p class="">This is the hidden content.</p> --}}
                            <div class="row">
                                <div class="col-12 pb-4">
                                    <h6 class="fontPoppins fw-bold mb-1">
                                        Items Included in Package
                                    </h6>
                                    <p class="fontPoppins fs-14 mb-1">
                                        One Pair of Shoes
                                    </p>
                                </div>
                                <div class="col-12 mb-3">

                                    <h6 class="fontPoppins fw-bold fs-14">
                                        Styling Tip: These shoes can be teamed up with a wide range of casual wear
                                    </h6>
                                </div>
                                <div class="col-12 ">

                                    <h6 class="fontPoppins fw-bold fs-14">
                                        Note: Kindly purchase footwear size 1/2 cm more than your kid's foot size
                                    </h6>
                                </div>
                                <div class="col-12">
                                    <p class="fontPoppins fs-14 fw-bold">Country of Origins: <span
                                            class="countryOrigin">
                                            China</span></p>
                                </div>
                                <div class="col-12">
                                    <p class="manufacture ">Manufacturing, Import, Packaging and Customer Care
                                        Information</p>
                                </div>
                                <div class="col-12">
                                    <p class="fontPoppins fs-14 noteTerms">
                                        <span class="fw-bold">Note :</span> Mix of 0 Taxes and discount may change
                                        depending the amount of tax being
                                        borne by the Company. However, the final price as charged from customer will
                                        remain same. Taxes collected against every transaction will be paid to the
                                        Government by FirstCry.com. Please refer to the <a class="termsOfUse fw-bold"
                                            href="#">Terms of Use</a> for full details.
                                    </p>
                                </div>
                                <div class="col-12 pb-4 pt-4">
                                    <div class="hl "></div>
                                </div>
                                <div class="col-12 pt-1 mb-3">

                                    <h6 class="fontPoppins fw-bold  ">
                                        Brand Information
                                    </h6>
                                </div>
                                <div class="col-12 pb-2">
                                    <a class="btn w-100 babyOye pt-3 fs-4 pb-3 text-white rounded-pill"
                                        href="#">Babyoye</a>
                                </div>
                                <div class="col-12 pt-2 pb-4">
                                    <p class="fontPoppins fs-14">Babyoye 'super-cute must haves' are designed to
                                        capture the
                                        magic of childhood, making perfect memories for the cute little adventurers.
                                        These oh-so-cute pieces stand for international quality & design available at
                                        affordable prices. The brand gives utmost importance to what their customer
                                        needs; safe, comfortable & trendy products for kids. They believe that your lil'
                                        one's wardrobe should be as happy as their smile!
                                    </p>
                                </div>

                            </div>


                        </div>
                    </div>
                    <button id="read-more" class="btn ps-0 pe-0 text-primary fs-14 fw-bold fontPoppins">Read More <img
                            class="ms-2 ps-1 readBtn" src="{{ asset('public/images/readMorethan.png') }}"
                            alt=""></button>
                    <button id="read-less" class="btn ps-0 pe-0 text-primary fs-6 fw-bold fontPoppins">Read Less <img
                            class="ms-2 ps-1 readBtn" src="{{ asset('public/images/readLess.png') }}"
                            alt=""></button>

                </div>

            </div>
        </div>


    </div>

</div>
<style>
    .slick-slider .slick-list, .slick-slider .slick-track{
        height: 500px !important;
    }
    .form-group-inline {
        width: 49%;
    }
    
    .border-ww{
        border: 2px solid #000;
    }
</style>
<script>
   $(".slider").slick({
    autoplay: true,
    arrows: true,
    autoplaySpeed: 5000,
    slidesToShow: 1,
    infinite: true,
});

    function copyToClipboard2() {
        const codeText = document.getElementById('codeSpan2').innerText;
        navigator.clipboard.writeText(codeText)
            .then(() => {
                alert(codeText + ' Code copied to clipboard!');
            })
            .catch((err) => {
                console.error('Unable to copy to clipboard', err);
            });
    }

    function copyToClipboard() {
        const codeText = document.getElementById('codeSpan').innerText;
        navigator.clipboard.writeText(codeText)
            .then(() => {
                alert(codeText + ' Code copied to clipboard!');
            })
            .catch((err) => {
                console.error('Unable to copy to clipboard', err);
            });
    }

    function changepicture(code) {
        $('.active').removeClass('active');
        var imageSrc = $('#image-' + code).attr('data-url');
        console.log(code, imageSrc);


        $('#main-image').attr('src', imageSrc);
        $('#image-' + code).addClass('active');
        $('#color').val('' + code);
    }

    function InsertVariant(index) {

        var variant_type = $('#variant' + index).val();
        var discount = $('#variant' + index).data('discount');
        var price = $('#variant' + index).data('price');
        var discountPercentage = parseFloat(discount) / 100;
        var actual_price = (parseFloat(price) - parseFloat((parseFloat(price) * discountPercentage).toFixed(1)))
            .toFixed(1);
        $('#discounted_price').html('Rs. ' + actual_price);
        $('#price').val(price);
        $('#actual_price').html('Rs. ' + price);
        $('#discount').html('-' + discount);
        $('#variant').val(variant_type);


        $('#price').val(price);


    }
</script>
