<div class="products mt-4 pb-5 container-xxl">

    <div class="MyProfile-heading font-poppins bottom-border pb-3">
        <span>Home ></span> <span>My Account ></span> <span>My Profile</span>
    </div>

    <div class="font-poppins bottom-border pb-3 pt-3">
        <h4 class="fw-bold m-0">
            My Account
        </h4>
    </div>

    <div class="row mt-4">
        @include('layouts.front-end.my-profile.aside')
        <div class="profile_content ps-4">
            <div class="MyAccount font-poppins">
                <h6 class="fw-bold m-0 rounded-pill">
                    Track Order
                </h6>
            </div>
            <div class="f-Border d-flex justify-content-between align-items-center rounded-pill mt-5 font-poppins">
                <h6 class="m-0">Order Number: <span class="fw-bold">188565454TFF5567</span> - 08 Oct 23</h6>

                <a href="#" class="order_Details">View Details</a>
            </div>

            <div class="orderList col-12">
                <li class="d-flex justify-content-between align-items-center mt-5">
                    <div class="d-flex align-items-center">
                        <div class="ForWidth">
                            <img class="object-fit-cover rounded-3" src="{{ asset('public/images/flash-sales6.png') }}"
                                alt="" width="100%" height="100%">
                        </div>
                        <div class="ms-3 fw-semibold font-poppins">
                            <p class="mb-1 text-order">Pine Kids Lace Up Casual Shoes Color Block - White</p>
                            <p class="mb-1 text-Delivered">Out For Delivery</p>
                            <p class="mb-1 text-order">Arrived On Tuesday 10 Oct 2023</p>
                            <p class="mb-1 text-order">Quantity: 02</p>
                        </div>
                    </div>
                    <a href=""><img src="{{ asset('public/images/Arrow-right.svg') }}" alt=""></a>
                </li>
                <li class="d-flex justify-content-between align-items-center mt-5">
                    <div class="d-flex align-items-center">
                        <div class="ForWidth">
                            <img class="object-fit-cover rounded-3" src="{{ asset('public/images/flash-sales6.png') }}"
                                alt="" width="100%" height="100%">
                        </div>
                        <div class="ms-3 fw-semibold font-poppins">
                            <p class="mb-1 text-order">Pine Kids Lace Up Casual Shoes Color Block - White</p>
                            <p class="mb-1 text-danger text-Deliveredr">Shipment Delayed</p>
                            <p class="mb-1 text-order">Arrived On Tuesday 10 Oct 2023</p>
                            <p class="mb-1 text-order">Quantity: 02</p>
                        </div>
                    </div>
                    <a href=""><img src="{{ asset('public/images/Arrow-right.svg') }}" alt=""></a>
                </li>
                <li class="d-flex justify-content-between align-items-center mt-5">
                    <div class="d-flex align-items-center">
                        <div class="ForWidth">
                            <img class="object-fit-cover rounded-3" src="{{ asset('public/images/flash-sales6.png') }}"
                                alt="" width="100%" height="100%">
                        </div>
                        <div class="ms-3 fw-semibold font-poppins">
                            <p class="mb-1 text-order">Pine Kids Lace Up Casual Shoes Color Block - White</p>
                            <p class="mb-1 text-success text-Delivered-1">Arriving Today</p>
                            <p class="mb-1 text-order">Arrived On Tuesday 10 Oct 2023</p>
                            <p class="mb-1 text-order">Quantity: 02</p>
                        </div>
                    </div>
                    <a href=""><img src="{{ asset('public/images/Arrow-right.svg') }}" alt=""></a>
                </li>
            </div>
            {{-- <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="font-poppins returnsDetail">
                    <p class="m-0">Order Number: <span class="fw-bold">18833462IZTF58B012</span> </p>
                    Return On: <span class="fw-bold">Sun, 11th Apr 23, 12:38 AM - 01 Items</span>
                    <p></p>
                    Return Status: <span class="fw-bold">Approved</span>
                    <p></p>
                    Total Refund: <span class="fw-bold">Rs.3900</span>
                    <p></p>
                </div>
                <div class="Refund font-poppins text-center ">
                    <button class="bg-purple rounded-pill ps-5 pe-5 pt-3 pb-3 border-0 text-white">Print Label</button>
                    <p class="mt-3"><a href="#" class="text-decoration-none text-dark">Refund Via Bachay
                            Wallet</a></p>
                </div>
            </div>


            <div class="top-border order-List col-12 mt-4">
                <li class="d-flex justify-content-between align-items-center mt-5 pb-4">
                    <div class="d-flex align-items-center col-8">
                        <div class="ForWidth180 col-4">
                            <img class="object-fit-cover rounded-3" src="{{ asset('public/images/flash-sales6.png') }}"
                                alt="" width="100%" height="100%">
                        </div>
                        <div class="ms-3 font-poppins col-8 font-poppins">
                            <p class="mb-1 fs-20 fw-bold">Pine Kids Lace Up Casual Shoes Color Block - White</p>
                            <p class="mb-1 fw-bold">Rs.17789</p>
                            <p class="d-flex align-items-center mb-1"> <span class="me-2">Colors</span> <span class="SizebtnBorder rounded-pill dot-red dot1 me-3"></span> <span class="me-2">Size</span>
                                <span class="SizebtnBorder square square1 ms-1 me-1 pt-1 pb-1 ps-2 pe-2 rounded-2 fontPoppins me-4">
                                  <span class="fw-bold">UK 11</span>   <span class="squareTxt"> (18.3 CM)</span>
                                </span>
                            </p>
                            <p class="mb-1">Order Quantity: 02</p>
                            <p class="m-0 fw-bold">Arrived on Tuesday 10 Oct 23</p>
                        </div>
                    </div>
                    <div class="Refund font-poppins text-center">
                        <button class="bg-purple rounded-pill ps-5 pe-5 pt-3 pb-3 border-0 text-white"> <span><img
                                    src="{{ asset('public/images/cart.png') }}" alt="" width="12px"
                                    height="12px"></span> Reorder</button>

                        <p class="mt-3"><a href="#" class="text-decoration-none text-dark"><span><img
                                        src="{{ asset('public/images/raise-icon.svg') }}" alt=""> </span> Raise
                                Your Concern</a></p>
                    </div>
                </li>


            </div>


            <div class="d-flex justify-content-between align-items-baseline mt-3">
               <div class="text-center orderCycle">
                    <img class="text-center" src="{{ asset('public/images/checkmark.svg') }}" alt="">  
                    <p>Request Received</p>
                </div> 
                <div class="border-w">
                </div>
                <div class="text-center orderCycle">
                    <img class="text-center" src="{{ asset('public/images/checkmark.svg') }}" alt="">   
                    <p>Pick Up From Address</p>
                </div>
                <div class="border-w">
                </div>
                <div class="text-center orderCycle">
                    <img class="text-center" src="{{ asset('public/images/clock.svg') }}" alt="">   
                    <p>Logistic Facility</p>     
                </div>
                <div class="border-w">
                </div>
                <div class="text-center orderCycle">
                    <img class="text-center" src="{{ asset('public/images/triangle.svg') }}" alt=""> 
                    <p>Package Received</p>    
                </div>
                <div class="border-w">
                </div>
                <div class="text-center orderCycle">
                    <img class="text-center" src="{{ asset('public/images/close.svg') }}" alt="">
                    <p>Refund Processing</p>              
                </div>
                <div class="border-w">

                </div>
                <div class="text-center orderCycle">
                    <img class="text-center" src="{{ asset('public/images/refunddone.svg') }}" alt=""> 
                    <p>Refund Approved</p>
                </div>
               
            </div>
             --}}
            

        </div>



    </div>

</div>
