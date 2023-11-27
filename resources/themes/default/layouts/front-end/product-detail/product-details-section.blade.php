<div class="products mt-4">
    <div class="row">

        {{-- {{ $prod }} --}}


        <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex flex-column fixedProduct">
            <div class="product-container">
                <div class="main-image">

                    @foreach (json_decode($product->images) as $key => $photo)

                    <img id="main-image" class="detailed-product-img p-3" src="{{ asset("storage/app/public/product/$photo") }}"
                        alt="Main Image">
                    @endforeach
                </div>
                <div class="small-images">
                    {{-- @foreach (json_decode($product->color_images) as $key => $photo) --}}
                    <img class="small-image " src="{{ asset('public/images/Frame 855 (2).png') }}" alt="Small Image 1">
                    {{-- @endfor --}}
                    <img class="small-image " src="{{ asset('public/images/Frame 134 (2).png') }}" alt="Small Image 2">
                    <img class="small-image" src="{{ asset('public/images/Frame 135 (2).png') }}" alt="Small Image 3">
                    <img class="small-image " src="{{ asset('public/images/Frame 137 (2).png') }}" alt="Small Image 3">
                    <img class="small-image " src="{{ asset('public/images/Frame 855 (2).png') }}" alt="Small Image 3">
                    <img class="small-image " src="{{ asset('public/images/Frame 856 (2).png') }}" alt="Small Image 3">



                </div>
            </div>
            {{-- <img class="detailed-product-img" src="{{ asset('public/images/Frame 83.png') }}" alt=""> --}}
            <div class="d-flex  mt-1">
                <button class="buy-now rounded-pill text-white w-100 pt-4 pb-4 m-2 ms-3 me-3">Buy Now</button>
            </div>

            <div class="d-flex  mt-1">
                <button class="rounded-pill text-dark fw-bold w-100 pt-4 pb-4 m-2 ms-3 me-3">Add to Cart</button>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-12 ">
            <div class="row pt-3 pb-3">
                <div class="col-12 d-flex align-items-center">
                    <h6 class="pe-5 fontPoppins fw-bold boysClothes mb-0">{{ $categoryName }}
                        {{-- Boys - Clothes --}}
                    </h6>
                    <div class="d-flex align-items-center me-3">
                        <h6 class="share pe-3 fontPoppins fw-bold mb-0">Share</h6>

                        <img class="ms-1 me-1 socialShareIcons" src="{{ asset('public/images/image 24.png') }}"
                            alt="">
                        <img class="ms-1 me-1 socialShareIcons" src="{{ asset('public/images/image 25.png') }}"
                            alt="">
                        <img class="ms-1 me-1 socialShareIcons" src="{{ asset('public/images/image 26.png') }}"
                            alt="">

                    </div>

                    <div class="vl"></div>

                    <div class=" ms-3 follow d-flex align-items-end">
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
                    <h4 class="pt-3 pb-2 fw-bold fontPoppins">

                        {{ $product->name }}
                    </h4>
                </div>
                <div class="col-12 d-flex align-items-center pb-2">
                    <h6 class="text-secondary pe-2 fontPoppins">Product ID: </h6>
                    <h6 class="text-dark fw-bold fontPoppins">{{ $product->id }}</h6>
                </div>
                <div class="col-12 pb-3">
                    <div class="hl "></div>
                </div>
                <div class="col-12 d-flex align-items-center">
                    <h3 class="fw-bold pe-3 fontPoppins">Rs.     {{ $product->unit_price - ($product->unit_price * $product->discount) / 100 }}</h3>
                    <h5 class="text-secondary text-decoration-line-through pe-1 fontPoppins">Rs. {{ $product->unit_price }}</h5>
                    <h6 class="discountPercent fontPoppins"> - {{ $product->discount }}% Off</h6>
                </div>
                <div class="col-12">
                    <h6 class="text-secondary txtFontWeight fontPoppins">
                        MRP incl. all taxes, Add'l charges may apply on discounted price
                    </h6>
                </div>

                <div class="col-8 pb-4 pt-3">
                    <div class=" rounded-pill border border-2 border-secondary p-2 ">

                        <div class="row">
                            <div class="col-2">
                                <img class="joinImg" src="{{ asset('public/images/join.png') }}" alt="">
                            </div>
                            <div class="col-6">
                                <p class="text-dark mb-0 priceJoin fontPoppins">Save <span class="joinPrice"> Rs.25.98
                                    </span>
                                    With Club</p>
                                <p class="text-dark mb-0 priceClub fontPoppins">Club Price: <span class="clubPrice">Rs
                                        1000.23</span></p>
                            </div>
                            <div class="col-4">
                                <button class="buy-now rounded-pill text-white w-100 p-3 me-4 fontPoppins joinBTN">Join
                                    Now</button>

                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-12 d-flex align-items-center pb-4">
                    <p class="text-dark simpleText fs-6 mb-0 pe-3 fontPoppins">Colors</p>
                    <span class="dot dot1 ms-1 me-1" onclick="selectDot(1)"></span>
                    <span class="dot dot2 ms-1 me-1" onclick="selectDot(2)"></span>
                    <span class="dot dot3 ms-1 me-1" onclick="selectDot(3)"></span>
                    <span class="dot dot4 ms-1 me-1" onclick="selectDot(4)"></span>
                    <span class="dot dot5 ms-1 me-1" onclick="selectDot(5)"></span>
                </div>
                <div class="col-12 d-flex align-items-center pb-2">
                    <p class="text-dark simpleText fs-6 mb-0 pe-4 fontPoppins">Size Basics</p>


                    <div class="dropdown">
                        <button class="btn border border-secondary btn-sm dropdown-toggle" type="button"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            UK &nbsp; &nbsp; &nbsp; &nbsp;
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item fontPoppins" href="#">USA</a></li>
                            <li><a class="dropdown-item fontPoppins" href="#">UAE</a></li>
                            <li><a class="dropdown-item fontPoppins" href="#">PAK</a></li>
                        </ul>
                    </div>

                    <div class="ms-3 d-flex align-items-center">

                        <button type="button" class="btn sizeBTN fontPoppins" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <img class="me-2 sizeChartImg" src="{{ asset('public/images/size chart.png') }}"
                                alt="">

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
                                            alt="">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 pb-4">
                    <p class="text-secondary toetoHeel  mb-0 fontPoppins">Toe to Heel Size (in CM): <span
                            class="sizeToeSpan ">19.5</span> | Age: <span class="sizeToeSpan">6 - 6.5 Y</span> | Size:
                        <span class="sizeToeSpan">EU 31</span> | Brand Size: <span class="sizeToeSpan">32</span>
                    </p>

                </div>

                <div class="col-12 pt-2 d-flex align-items-center pb-4">
                    <p class="text-dark simpleText fs-6 mb-0 pe-3 fontPoppins">Size</p>

                    <span class="square square1 ms-1 me-1 pt-2 pb-2 ps-3 pe-3 rounded-2 fontPoppins"
                        onclick="selectSquare(1)">
                        UK 11 <span class="squareTxt"> (18.3 CM)</span>
                    </span>
                    <span class="fontPoppins square square2 ms-1 me-1 pt-2 pb-2 ps-3 pe-3 rounded-2"
                        onclick="selectSquare(2)">
                        UK 11.5 <span class="squareTxt"> (18.9 CM)</span>
                    </span>
                    <span class="fontPoppins square square3 ms-1 me-1 pt-2 pb-2 ps-3 pe-3 rounded-2"
                        onclick="selectSquare(3)">
                        UK 12 <span class="squareTxt"> (19.5 CM)</span>
                    </span>
                    <span class="fontPoppins square square4 ms-1 me-1 pt-2 pb-2 ps-3 pe-3 rounded-2"
                        onclick="selectSquare(4)">
                        UK 13 <span class="squareTxt"> (20.2 CM)</span>
                    </span>
                </div>

                <div class="col-12 pb-5 pt-2">
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

                <div class="col-12 pb-5">
                    <div class="row">
                        <div class="col-6 ">
                            <div class="offer p-4 rounded-4">
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

                                    <div class="col-12 pt-2 d-flex align-items-center justify-content-start">

                                        <a class=" fontPoppins pt-2 pb-2 codde btn d-flex justify-content-around   "><span
                                                class="text-start codeTxt text-white fontPoppins">FG5DST</span> <span
                                                class="copyCode text-end"><img class="copyIMG"
                                                    src="{{ asset('public/images/copy.png') }}" alt="">
                                                Copy</span></a>

                                        <a class=" fontPoppins btn shareBtn ms-2 pt-1 pb-1" href="#"><span
                                                class="copyCode text-end"><img class="copyIMG"
                                                    src="{{ asset('public/images/shareImg.png') }}" alt="">
                                                Share</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 ">
                            <div class="offer2 p-4 rounded-4">
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

                                    <div class="col-12 pt-2 d-flex align-items-center justify-content-start">

                                        <a class="fontPoppins pt-2 pb-2 codde btn d-flex justify-content-around   "><span
                                                class="text-start codeTxt text-white">FG5DST</span> <span
                                                class="copyCode text-end"><img class="copyIMG"
                                                    src="{{ asset('public/images/copy.png') }}" alt="">
                                                Copy</span></a>

                                        <a class="fontPoppins btn shareBtn ms-2 pt-1 pb-1" href="#"><span
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
                <div class="col-12 d-flex justify-content-between mt-2 pb-5">
                    <div class="text-center clubCash">
                        <img class="mb-3 benefitsImg" src="{{ asset('public/images/Group 901.png') }}" alt="">
                        <p class="clubCashTxt mb-0 fontPoppins">Club Cash Benefits</p>
                        <h6 class="fw-bold clubCashTxt fontPoppins">Upto <span class="priceUpto">Rs.26</span></h6>
                    </div>
                    <div class="text-center ">
                        <img class="mb-3 benefitsImg" src="{{ asset('public/images/Group 901 (1).png') }}"
                            alt="">
                        <p class="clubCashTxt mb-0 fontPoppins ">Excusive Offers
                            & Discounts </p>
                        {{-- <h6 class="fw-bold">Upto <span class="priceUpto">Rs.26</span></h6> --}}
                    </div>
                    <div class="text-center ">
                        <img class="mb-3 benefitsImg" src="{{ asset('public/images/Group 901 (2).png') }}"
                            alt="">
                        <p class="clubCashTxt mb-0 fontPoppins">Lower Prices on
                            Products</p>
                        {{-- <h6 class="fw-bold">Upto <span class="priceUpto">Rs.26</span></h6> --}}
                    </div>
                    <div class="text-center ">
                        <img class="mb-3 benefitsImg" src="{{ asset('public/images/Group 901 (3).png') }}"
                            alt="">
                        <p class="clubCashTxt mb-0 fontPoppins">Lower Shipping
                            Barrier</p>
                        {{-- <h6 class="fw-bold">Upto <span class="priceUpto">Rs.26</span></h6> --}}
                    </div>
                    <div class="text-center ">
                        <img class="mb-3 benefitsImg" src="{{ asset('public/images/Group 901 (4).png') }}"
                            alt="">
                        <p class="clubCashTxt mb-0 fontPoppins">Free baby gear
                            assembly</p>
                        {{-- <h6 class="fw-bold">Upto <span class="priceUpto">Rs.26</span></h6> --}}
                    </div>
                </div>
                <div class="col-12 pb-4">
                    <div class="hl "></div>
                </div>

                <div class="col-12 pt-3 pb-4">
                    <div class="row d-flex justify-content-between">
                        <div class="col-5 d-flex align-items-center justify-content-between">
                            <img class="deliveryVan" src="{{ asset('public/images/deliveryVan.png') }}" alt="">
                            <h6 class="fontPoppins fw-bold mb-0">
                                Check Delivery Details
                            </h6>
                            <img class="deliveryVan" src="{{ asset('public/images/war.png') }}" alt="">

                        </div>
                        <div class="col-5 d-flex align-items-center justify-content-between">
                            <img class="deliveryVan" src="{{ asset('public/images/clock.png') }}" alt="">
                            <h6 class="fontPoppins exchange fw-bold mb-0">
                                7 Days Return or Exchange
                            </h6>
                            <img class="deliveryVan" src="{{ asset('public/images/war.png') }}" alt="">

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
                <div class="col-12 pt-3 pb-3">
                    <p class="txtPin fontPoppins">
                        Same Day/Next Day delivery applicable on this product. Enter pincode to check availability in
                        your area.
                    </p>
                </div>
                <div class="col-12 pb-4">
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

                <div class="col-12 pt-5 d-flex align-items-center justify-content-between">
                    <div>
                        <p class=" fontPoppins">Age:</p>
                    </div>
                    <div>
                        <p class=" fontPoppins">2.5 - 3 Years</p>
                    </div>

                </div>
                <div class="col-12 pb-4">
                    <div class="hl "></div>
                </div>
                <div class="col-12 pt-2 pb-2 d-flex align-items-center justify-content-between">
                    <div>
                        <p class=" fontPoppins">Length:</p>
                    </div>
                    <div>
                        <p class="fontPoppins">14.6 CM</p>
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
                            <h6 class="fontPoppins specific fw-bold mb-2">
                                Specification
                            </h6>
                            <p class="speciTxt fontPoppins mb-1">
                                Brand - Babyoye
                            </p>
                            <p class="speciTxt fontPoppins mb-1">
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
                            </p>
                        </div>
                        <div class="col-12 more-content">
                            {{-- <p class="">This is the hidden content.</p> --}}
                            <div class="row">
                                <div class="col-12 pb-4">
                                    <h6 class="fontPoppins fw-bold  ">
                                        Items Included in Package
                                    </h6>
                                    <p class="fontPoppins mb-1">
                                        One Pair of Shoes
                                    </p>
                                </div>
                                <div class="col-12 pb-4">

                                    <h6 class="fontPoppins fw-bold  ">
                                        Styling Tip: These shoes can be teamed up with a wide range of casual wear
                                    </h6>
                                </div>
                                <div class="col-12 ">

                                    <h6 class="fontPoppins fw-bold  ">
                                        Note: Kindly purchase footwear size 1/2 cm more than your kid's foot size
                                    </h6>
                                </div>
                                <div class="col-12 pb-4">
                                    <p class="fontPoppins fw-bold">Country of Origins: <span class="countryOrigin">
                                            China</span></p>
                                </div>
                                <div class="col-12">
                                    <p class="manufacture ">Manufacturing, Import, Packaging and Customer Care
                                        Information</p>
                                </div>
                                <div class="col-12">
                                    <p class="fontPoppins noteTerms">
                                        <span class="fw-bold">Note :</span> Mix of Taxes and discount may change
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
                                <div class="col-12 pt-1 pb-4">

                                    <h6 class="fontPoppins fw-bold  ">
                                        Brand Information
                                    </h6>
                                </div>
                                <div class="col-12 pb-2">
                                    <a class="btn w-100 babyOye pt-3 fs-4 pb-3 text-white rounded-3"
                                        href="#">babyoye</a>
                                </div>
                                <div class="col-12 pt-2 pb-4">
                                    <p class="fontPoppins">Babyoye 'super-cute must haves' are designed to capture the
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
                    <button id="read-more" class="btn ps-0 pe-0 text-primary fs-6 fw-bold fontPoppins">Read More <img
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