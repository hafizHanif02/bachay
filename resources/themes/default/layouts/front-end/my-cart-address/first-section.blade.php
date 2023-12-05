
<form action="{{ route('cart.updateQuantity') }}" method="POST">
    @csrf
<div class="row col-12 my-cart pb-5 mt-4">
    <input type="hidden" name="customer_id" value="{{ auth('customer')->check() ? auth('customer')->user()->id : '' }}">
    <input type="hidden" name="shipping_address" value="{{ auth('customer')->check() ? $shippingAddress->id : '' }}">
    <div class="col-8 border-right">
        <div class="btn-con col-12 d-flex justify-content-between">
            <button class="col-5 mt-2 btn-f rounded-pill p-3 bg-purple text-white border-0">Shopping Cart ({{ count($myCartProducts) }})</button>
            <button class="col-5 mt-2 btn-f rounded-pill p-3 bg-purple text-white border-0">My Shortlist</button>
        </div>
        <div class="inputBar col-12 p-2 rounded-pill mt-4 d-flex justify-content-between">
            <input name="PinCode" id="DelievryPincode" type="text" class="input-field input-w ms-3"
                placeholder="Delivery Pin Code">
            <button class="input-button rounded-pill ps-5 pe-5 pt-2 pb-2 col-3">Apply</button>
        </div>

        @foreach($myCartProducts as $Cartproduct)
        <div class="parent-card mt-5 pb-5 col-12 d-flex align-items-center bottom-border gap-3">
            <div class="col-3 for-img">
                <img class="object-fit-cover rounded-3"  src="{{ asset('storage/app/public/product/thumbnail/'.$Cartproduct->product->thumbnail) }}" alt=""
                    width="100%" height="100%">
            </div>
            <div class="col-5 border-right">
                <h5 class="fw-semibold m-0 font-poppins">
                    {{ $Cartproduct->product->name }}
                    <input type="hidden" name="product[{{ $loop->iteration }}][product_id]" value="{{ $Cartproduct->product_id }}">
                    <input type="hidden" name="product[{{ $loop->iteration }}][product_details]" value="{{ $Cartproduct->product->description }}">
                    <input type="hidden" name="product[{{ $loop->iteration }}][tax]" value="{{ $Cartproduct->product->tax }}">
                    <input type="hidden" name="product[{{ $loop->iteration }}][discount]" value="{{ $Cartproduct->product->discount }}">
                    <input type="hidden" name="product[{{ $loop->iteration }}][tax_model]" value="{{ $Cartproduct->product->tax_model }}">
                </h5>
                
                <div class="d-flex align-items-center mt-3">
                    @if($Cartproduct->color != null)
                        <p class="m-0 fw-semibold font-poppins me-2">Color</p>
                        <div class="danger-circle rounded-circle p-2 me-3" style="background-color: {{ $Cartproduct->color }}"></div>
                        <input type="hidden" name="product[{{ $loop->iteration }}][color]" value="{{ $Cartproduct->color }}">

                    @endif
                    @if($Cartproduct->variant != null)
                    <p class="m-0 fw-semibold font-poppins me-4">Size</p>

                    <p class="font-poppins m-0 sizes-btn rounded-2 p-1 fs-6">
                        <span class="fw-bold"></span> <span class="text-secondary">{{ $Cartproduct->variant }}</span>
                        <input type="hidden" name="product[{{ $loop->iteration }}][variant]" value="{{ $Cartproduct->variant }}">
                    </p>
                    @endif

                </div>
                <div class="mt-3">
                    <button class="col-5 mt-2 btn-delete p-2 rounded-pill text-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13"
                            fill="none">
                            <path d="M7.83164 9.71592L6.18164 8.06592" stroke="#EC1515" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7.81602 8.08392L6.16602 9.73392" stroke="#EC1515" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5.08411 0.5L2.91211 2.678" stroke="#EC1515" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8.91211 0.5L11.0841 2.678" stroke="#EC1515" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M1 4.01006C1 2.90006 1.594 2.81006 2.332 2.81006H11.668C12.406 2.81006 13 2.90006 13 4.01006C13 5.30006 12.406 5.21006 11.668 5.21006H2.332C1.594 5.21006 1 5.30006 1 4.01006Z"
                                stroke="#EC1515" />
                            <path
                                d="M1.90039 5.29999L2.74639 10.484C2.93839 11.648 3.40039 12.5 5.11639 12.5H8.73439C10.6004 12.5 10.8764 11.684 11.0924 10.556L12.1004 5.29999"
                                stroke="#EC1515" stroke-linecap="round" />
                        </svg> Delete</button>

                    <button class="col-5 mt-2 btn-edit p-2 rounded-pill">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"
                            fill="none">
                            <path
                                d="M5.88862 1.13647H4.80226C2.08636 1.13647 1 2.22283 1 4.93874V8.19782C1 10.9137 2.08636 12.0001 4.80226 12.0001H8.06134C10.7772 12.0001 11.8636 10.9137 11.8636 8.19782V7.11146"
                                stroke="#292D32" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M8.62644 1.69051L4.34618 5.97077C4.18322 6.13372 4.02027 6.4542 3.98768 6.68776L3.75411 8.32274C3.6672 8.9148 4.08545 9.32762 4.67752 9.24614L6.31249 9.01258C6.54062 8.97998 6.8611 8.81703 7.02949 8.65408L11.3097 4.37382C12.0485 3.63509 12.3961 2.77687 11.3097 1.69051C10.2234 0.604146 9.36516 0.951781 8.62644 1.69051Z"
                                stroke="#292D32" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M8.0127 2.30426C8.37663 3.60246 9.39237 4.61821 10.696 4.98757" stroke="#292D32"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> Edit</button>


                </div>

            </div>
            <div class="col-4">
                <h3 class="product-price mb-1">
                    Rs. {{ $Cartproduct->price - ($Cartproduct->discount/100)*$Cartproduct->price }}
                </h3>

                <div class="d-flex align-items-center">
                    <h6 class="text-decoration-line-through m-0 discount-off">Rs. {{ $Cartproduct->price }}</h6>
                    <span class="text-success fw-bold font-poppins"> - {{ $Cartproduct->discount  }}% Off</span>

                </div>
                <p class="taxes mt-1 mb-2">
                    MRP Includes all taxes
                </p>
                <input type="hidden" id="price{{ $loop->iteration }}" value="{{ $Cartproduct->price }}" name="product[{{ $loop->iteration }}][price]">
                <input type="hidden" id="discount{{ $loop->iteration }}" value="{{($Cartproduct->discount/100)*$Cartproduct->price }}" name="product[{{ $loop->iteration }}][discount]">

                <div class="blue-cart row align-items-center">
                    <div class="img col-3">
                        <img class="object-fit-cover" src="{{ asset('public/images/blue-cart-img.png') }}" alt=""
                            width="100%" height="auto">
                    </div>
                    <div class="text-area col-9 p-0">
                        <p class="m-0 font-poppins fs-12">Save <span class="text-success fw-bold font-poppins">Rs.25.98</span>
                            With Club</p>
                        <p class="m-0 font-poppins">Club Price: <span class="fw-bold font-poppins"> Rs 1000</span></p>

                    </div>
                </div>
                {{-- <div class="number rounded-pill mt-3 col-12">
                    <span class="minus rounded-circle col-2"><i class="bi bi-dash-lg"></i></span>
                    <input name="value1" id="Value1" class="border-0 text-center col-9 col-sm-6" type="text" value="1" />
                    <span class="plus rounded-circle col-2"><i class="bi bi-plus-lg"></i></span>
                </div> --}}
                <div class="number rounded-pill mt-3 d-flex justify-content-between col-12">
                    <span class="minus rounded-circle col-2 text-center"><i class="bi bi-dash-lg"></i></span>
                    <input name="product[{{ $loop->iteration }}][quantity]" id="Value{{ $loop->iteration }}" onchange="changeValue({{ $loop->iteration }})" class="border-0 text-center col-8 col-sm-6" type="number"
                        value="1" />
                    <span class="plus rounded-circle col-2 text-center"><i class="bi bi-plus-lg"></i></span>
                </div>



            </div>

        </div>
        @endforeach
        
       
      
       

        <div class="btn-con col-12 d-flex justify-content-between mt-4">
            @if(!empty($shippingAddress))
                <a class="col-5 mt-2 btn-f rounded-pill text-center p-3 bg-purple text-white border-0" href="{{ route('my-profile') }}" style="text-decoration: none">Change Address</a>
            @else
            <a class="col-5 mt-2 btn-f rounded-pill p-3 text-center bg-purple text-white border-0" href="{{ route('my-profile') }}" style="text-decoration: none">Add Address</a>
            @endif
            <button type="submit" class="col-5 mt-2 btn-f rounded-pill p-3 bg-purple text-white border-0">Place Order</button>
        </div>
        

        <h5 class="font-poppins fw-bold mt-5">
            Shop With Confidence
        </h5>

        <div class="d-flex justify-content-between pe-3 mt-3">

            <div class="returns">
                <img src="{{ asset('web/images/returns.svg') }}" alt=""> <span class="font-poppins"> Hassel
                    Free Returns or Exchange
                </span>
            </div>
            <div class="Handpicked-Products">
                <img src="{{ asset('web/images/hand-product.svg') }}" alt=""> <span
                    class="font-poppins">Handpicked Products</span>
            </div>
            <div class="Exchange">
                <img src="{{ asset('web/images/exchange.svg') }}" alt=""> <span class="font-poppins">Easy
                    Return Or Exchange</span>

            </div>

        </div>


    </div>

    <div class="col-4 pe-0">
        <div class="bottom-border pb-4">
            <div class="cashback rounded-4 p-2 d-flex align-items-center">
                <div class="col-4 subCon rounded-4 p-3 me-3">
                    <img class="object-fit-cover" src="{{ asset('public/images/smpl-cashback.png') }}" alt=""
                        width="100%" height="100%">

                </div>
                <div>
                    <p class="font-poppins percentage">
                        5% SIMPL Cashback
                    </p>
                    <p class="fw-semibold font-poppins upto-price">
                        Upto Rs.500 on first SIMPL Txn | Above Rs.999
                    </p>

                </div>

            </div>

        </div>
        <div class="bottom-border pb-4">
            <div class="earn-clubCard mt-4 bg-purple rounded-4 pt-3 pb-4 ps-1 pe-1">
                <p class="text-white text-center font-poppins mb-2">Join Cub & Earn Club Cash Benefit on Products</p>
                <div class="d-flex justify-content-evenly">
                    <div class="ThreeMonths text-center rounded-4 ps-4 pe-4 pt-2 pb-2">
                        <h6 class="mb-2 font-poppins">
                            3 Months
                        </h6>
                        <p class="mb-1 price-tag font-poppins">Rs. 327.18</p>
                        <p class="m-0 Discount font-poppins mb-2"> <span
                                class="text-decoration-line-through text-secondary">Rs. 327.18</span> <span
                                class="text-danger fw-bold">18% Off</span></p>
                        <button class="bg-purple text-white rounded-2 border-0 ps-4 pe-4 font-poppins pt-2 pb-2">Add
                            Now</button>

                    </div>
                    <div class="TwelveMonths text-center rounded-4 pt-2 pb-2 ps-4 pe-4">
                        <h6 class="mb-2 font-poppins">
                            12 Months
                        </h6>
                        <p class="mb-1 price-tag font-poppins">Rs. 327.18</p>
                        <p class="m-0 Discount font-poppins mb-2"> <span
                                class="text-decoration-line-through text-secondary">Rs. 327.18</span> <span
                                class="text-danger fw-bold">18% Off</span></p>
                        <button class="bg-purple text-white rounded-2 border-0 ps-4 pe-4 font-poppins pt-2 pb-2">Add
                            Now</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between pt-4">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                    fill="none">
                    <path
                        d="M2.98797 13.654L1.4657 12.1317C0.844767 11.5108 0.844767 10.4892 1.4657 9.86831L2.98797 8.34601C3.24836 8.08562 3.45868 7.57485 3.45868 7.21431V5.06106C3.45868 4.17973 4.17976 3.45868 5.06109 3.45868H7.21431C7.57485 3.45868 8.08562 3.24839 8.34601 2.988L9.86828 1.4657C10.4892 0.844767 11.5108 0.844767 12.1317 1.4657L13.654 2.988C13.9144 3.24839 14.4251 3.45868 14.7857 3.45868H16.9389C17.8202 3.45868 18.5413 4.17973 18.5413 5.06106V7.21431C18.5413 7.57485 18.7516 8.08562 19.012 8.34601L20.5343 9.86831C21.1552 10.4892 21.1552 11.5108 20.5343 12.1317L19.012 13.654C18.7516 13.9144 18.5413 14.4252 18.5413 14.7857V16.9389C18.5413 17.8202 17.8202 18.5414 16.9389 18.5414H14.7857C14.4251 18.5414 13.9144 18.7516 13.654 19.012L12.1317 20.5343C11.5108 21.1553 10.4892 21.1553 9.86828 20.5343L8.34601 19.012C8.08562 18.7516 7.57485 18.5414 7.21431 18.5414H5.06109C4.17976 18.5414 3.45868 17.8202 3.45868 16.9389V14.7857C3.45868 14.4152 3.24836 13.9044 2.98797 13.654Z"
                        stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M8.00684 13.9941L14.0158 7.98511" stroke="#292D32" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.5094 13.4934H13.5184" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M8.50209 8.48586H8.51108" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span class="fw-bold font-poppins fs-6">Coupon/Gift Certificated</span>
            </div>
            <a class="fw-bold" href="">View All Coupons</a>

        </div>
        <div class="d-flex align-items-center mt-4">
            <input type="radio" name="group-1" class="me-2"> <span class="me-4">Coupon</span>
            <input type="radio" name="group-1" class="me-2"> <span>Gift Certificated</span>
        </div>
        <div class="bottom-border pb-4">

            <div class="inputBar col-12 p-2 rounded-pill mt-4 d-flex justify-content-between">
                <input name="PinCode" id="DelievryPincode" type="text" class="input-field input-w ms-3"
                    placeholder="Delivery Pin Code">
                <button class="input-button rounded-pill text-center  col-3">Apply</button>
            </div>
            {{-- <div class="CouponCode pt-1 pb-1 rounded-pill mt-4 mb-1">
                <input name="CouponCode" id="Coupon" type="text" class="input-Code input-field  ms-3" placeholder="Enter your Coupon Code">
                <button class="input-button rounded-pill ps-5 pe-5 pt-2 pb-2">Apply</button>
            </div> --}}
        </div>

        <div class="bottom-border d-flex align-items-center justify-content-between mt-4 pb-4">
            <div class="d-flex align-items-center">
                <div class="gift-box me-2">
                    <img class="object-fit-cover" src="{{ asset('public/images/gift-box.png') }}" alt=""
                        width="100%" height="100%">

                </div>
                <div class="gift-text font-poppins">
                    <h6 class="m-0">
                        Buying For Love Ones?
                    </h6>
                    <p class="m-0">Gift Wrap and personalized Message on Card.</p>
                </div>

            </div>
            <div>
                <input type="radio" name="group-1" class="me-2">

            </div>


        </div>

        <div class="textAreaClub bottom-border mt-4 pb-3">
            <h6 class="fw-bold font-poppins">
                Use Club Cash <span class="fw-normal">( Rs.0 Available)</span>
            </h6>
            <p class="font-poppins">
                You have to earn a minimum of ₹100 Club Cash before you can redeem it in your future purchases.
            </p>
        </div>
        <div class="paymentInformation mt-4">
            <h6>Payment Information</h6>
            <div class="d-flex justify-content-between">
                <div class="listDown font-poppinns">
                    <p>Value of Product(s)</p>
                    <p>Discount</p>
                    {{-- <p>Estimated GST (+)</p> --}}
                    <p>Shipping (+)</p>
                </div>
                <div class="listDown">
                    <p class="fw-bold">Rs. {{ $total_product_price }}</p>
                    <input type="hidden" name="total_price" value="{{ $total_product_price }}">
                    <p class="text-success fw-bold">Rs. {{ $totalDiscount }}</p>
                    <input type="hidden" name="discount_amount" value="{{ $totalDiscount }}">
                    {{-- <p class="text-danger fw-bold">Rs. 390.74</p> --}}
                    <p class="text-success fw-bold">FREE</p>
                </div>

            </div>
            <div class="d-flex justify-content-between align-items-center forDashBorder pb-3 pt-3 ">
                <div>
                    <p class="m-0 font-poppins">Sub Total</p>

                </div>
                <div>
                    <p class="m-0 fw-bold" id="sub-total-down">Rs.{{ $total_product_price - $totalDiscount }}</p>
                </div>

            </div>
            <div class="d-flex justify-content-between mt-3">
                <div>
                    <p class="font-poppins fw-bold">Final Payment</p>

                </div>
                <div>
                    <p class="fw-bold" id="final-payment">Rs.{{ $total_product_price - $totalDiscount }}</p>
                    <input type="hidden" name="final_payment" value="{{ $total_product_price - $totalDiscount }}">

                </div>

            </div>
        </div>


    </div>

</div>
</form>

<script>
    function changeValue(index){
        var price = $('#price'+index).val();
        var price = $('#discount'+index).val();
        
    }
</script>
