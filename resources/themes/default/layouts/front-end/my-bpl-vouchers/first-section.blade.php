<div class="products mt-4 pb-5">

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
        <div class="col-9 ps-4">
            <div class="MyAccount font-poppins">
                <h6 class="fw-bold m-0 rounded-pill">
                    MY BPL Vouchers
                </h6>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <h6 class="m-0 font-poppins fw-semibold">
                    Filter Voucher by
                </h6>
                <div class="nav-item d-flex align-items-center">
                    <div class="dropdown font-poppins rounded-pill nav-item sorted-by p-2 ps-4 pe-4">
                        <a class="dropbtn nav-link"><span class="pe-5">Sorted By: <span class="fw-bold">Active</span> </span><i class="bi bi-chevron-down ps-5"></i></a>
                        <div class="dropdown-content">
                            <a href="#">Winter</a>
                            <a href="#">Summer</a>

                        </div>
                    </div>
                </div>

            </div>
            <div class="order-List col-12 mt-4">
                <li class="DashBorderT d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center col-11">
                        <div class="CashCouponsFlat offer col-4 me-2">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <img src="{{ asset('public /images/gif.gif') }}" alt="" width="78px"
                                        height="78px">

                                </div>
                                <div class="">
                                    <h6 class="fs-20 font-poppins fw-bold flatss mb-0">FLAT 90% Off</h6>
                                </div>

                            </div>
                            <div class="col-12 pb-3">
                                <div class="dottedhl"></div>
                            </div>

                            <div id="CopyCode" class="copy-button pt-2 d-flex align-items-center justify-content-start">

                                <div class="fontPoppins pt-2 pb-2 codde btn d-flex justify-content-around   "><span id="TextToCopy"
                                    class="text-start codeTxt text-white fontPoppins">BACHAY3DP1</span> <span class="copyCode text-end"><img class="copyIMG"
                                        src="{{ asset('public /images/copy.png') }}" alt="">
                                    Copy</span></div>


                            </div>
                        </div>
                        <div class="ms-3 font-poppins col-8">
                            <p class="mb-2 fs-18 fw-bold">Description : Get 4 Free Live sessions on Logic and Problem Solving only on LQ Live, by LogIQids.
                            </p>
                            <div class="mb-1 fs-16">
                                <span class=""> <span class="fw-bold">Amount (FPL Points):</span>  30.00 |</span> <span> <span class="fw-bold">Offer Valid till: </span>  16-Oct-2023</span>
                            </div>
                             
                            <a class="fw-bold text-success text-decoration-none" href="">Active</a>
                        </div>
                    </div>
                    <a href=""><img src="{{ asset('public /images/Arrow-right.svg') }}" alt=""></a>
                </li>
                <li class="DashBorderT d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center col-11">
                        <div class="CashCouponsFlat offer col-4 me-2">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <img src="{{ asset('public /images/gif.gif') }}" alt="" width="78px"
                                        height="78px">

                                </div>
                                <div class="">
                                    <h6 class="fs-20 font-poppins fw-bold flatss mb-0">FLAT 90% Off</h6>
                                </div>

                            </div>
                            <div class="col-12 pb-3">
                                <div class="dottedhl"></div>
                            </div>

                            <div id="CopyCode" class="copy-button pt-2 d-flex align-items-center justify-content-start">

                                <div class="fontPoppins pt-2 pb-2 codde btn d-flex justify-content-around   "><span id="TextToCopy"
                                    class="text-start codeTxt text-white fontPoppins">BACHAY3DP1</span> <span class="copyCode text-end"><img class="copyIMG"
                                        src="{{ asset('public /images/copy.png') }}" alt="">
                                    Copy</span></div>


                            </div>
                        </div>
                        <div class="ms-3 font-poppins col-8">
                            <p class="mb-2 fs-18 fw-bold">Description : Get 4 Free Live sessions on Logic and Problem Solving only on LQ Live, by LogIQids.
                            </p>
                            <div class="mb-1 fs-16">
                                <span class=""> <span class="fw-bold">Amount (FPL Points):</span>  30.00 |</span> <span> <span class="fw-bold">Offer Valid till: </span>  16-Oct-2023</span>
                            </div>
                             
                            <a class="fw-bold text-success text-decoration-none" href="">Active</a>
                        </div>
                    </div>
                    <a href=""><img src="{{ asset('public /images/Arrow-right.svg') }}" alt=""></a>
                </li>
              
                <li class="DashBorderT d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center col-11">
                        <div class="CashCouponsFlat offer col-4 me-2">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <img src="{{ asset('public /images/gif.gif') }}" alt="" width="78px"
                                        height="78px">

                                </div>
                                <div class="">
                                    <h6 class="fs-20 font-poppins fw-bold flatss mb-0">FLAT 90% Off</h6>
                                </div>

                            </div>
                            <div class="col-12 pb-3">
                                <div class="dottedhl"></div>
                            </div>

                            <div id="CopyCode" class="copy-button pt-2 d-flex align-items-center justify-content-start">

                                <div class="fontPoppins pt-2 pb-2 codde btn d-flex justify-content-around   "><span id="TextToCopy"
                                    class="text-start codeTxt text-white fontPoppins">BACHAY3DP1</span> <span class="copyCode text-end"><img class="copyIMG"
                                        src="{{ asset('public /images/copy.png') }}" alt="">
                                    Copy</span></div>


                            </div>
                        </div>
                        <div class="ms-3 font-poppins col-8">
                            <p class="mb-2 fs-18 fw-bold">Description : Get 4 Free Live sessions on Logic and Problem Solving only on LQ Live, by LogIQids.
                            </p>
                            <div class="mb-1 fs-16">
                                <span class=""> <span class="fw-bold">Amount (FPL Points):</span>  30.00 |</span> <span> <span class="fw-bold">Offer Valid till: </span>  16-Oct-2023</span>
                            </div>
                             
                            <a class="fw-bold text-secondary text-decoration-none" href="">Expired</a>
                        </div>
                    </div>
                    <a href=""><img src="{{ asset('public /images/Arrow-right.svg') }}" alt=""></a>
                </li>
              

            </div>

        </div>




    </div>
</div>
