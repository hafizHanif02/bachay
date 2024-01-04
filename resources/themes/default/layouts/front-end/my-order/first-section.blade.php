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
        <div class="ps-4 profile_content">
            <div class="MyAccount font-poppins">
                <h6 class="fw-bold m-0 rounded-pill">
                    Order History
                </h6>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4 bottom-border pb-4">
                <h6 class="font-poppins fw-semibold">
                    Filter Order by
                </h6>
                <div class="nav-item d-flex align-items-center">
                    <h6 class="fw-bold pe-3">Type</h6>
                    <div class="dropdown font-poppins rounded-pill sorted-by p-2 ps-4 pe-4 me-3">
                        <a class="dropbtn nav-link"><span class="pe-3">Pending</span><i
                                class="bi bi-chevron-down ps-5"></i></a>
                        <div class="dropdown-content">
                            <a href="#">Winter</a>
                            <a href="#">Summer</a>

                        </div>
                    </div>
                    <h6 class="fw-bold pe-3">Time Period</h6>
                    <div class="dropdown font-poppins rounded-pill nav-item sorted-by p-2 ps-4 pe-4">
                        <a class="dropbtn nav-link"><span class="pe-3">All Orders</span><i
                                class="bi bi-chevron-down ps-5"></i></a>
                        <div class="dropdown-content">
                            <a href="#">Winter</a>
                            <a href="#">Summer</a>

                        </div>
                    </div>
                </div>

            </div>
            <div class="f-Border d-flex justify-content-between align-items-center rounded-pill mt-5 font-poppins">
                <h6 class="m-0">Order Number: <span class="fw-bold">188565454TFF5567</span> - 08 Oct 23</h6>

                <a href="#" class="fw-bold">View Details</a>
            </div>

            <div class="orderList col-12">
                <li class="d-flex justify-content-between align-items-center mt-5 bottom-border pb-4">
                    <div class="d-flex align-items-center">
                        <div class="ForWidth">
                            <img class="object-fit-cover rounded-3" src="{{ asset('public/images/flash-sales6.png') }}"
                                alt="" width="100%" height="100%">
                        </div>
                        <div class="ms-3 fw-semibold font-poppins fs-12">
                            <p class="mb-1">Pine Kids Lace Up Casual Shoes Color Block - White</p>
                            <p class="mb-1 text-purple">Successfully Delivered</p>
                            <p class="mb-1">Arrived On Tuesday 10 Oct 2023</p>
                            <p class="mb-1">Quantity: 02</p>
                        </div>
                    </div>
                    <a href=""><img src="{{ asset('public/images/Arrow-right.svg') }}" alt=""></a>
                </li>
                <li class="d-flex justify-content-between align-items-center mt-5 bottom-border pb-4">
                    <div class="d-flex align-items-center">
                        <div class="ForWidth">
                            <img class="object-fit-cover rounded-3" src="{{ asset('public/images/flash-sales6.png') }}"
                                alt="" width="100%" height="100%">
                        </div>
                        <div class="ms-3 fw-semibold font-poppins fs-12">
                            <p class="mb-1">Pine Kids Lace Up Casual Shoes Color Block - White</p>
                            <p class="mb-1 text-danger">Unsuccessfully Delivery</p>
                            <p class="mb-1">Arrived On Tuesday 10 Oct 2023</p>
                            <p class="mb-1">Quantity: 02</p>
                        </div>
                    </div>
                    <a href=""><img src="{{ asset('public/images/Arrow-right.svg') }}" alt=""></a>
                </li>
                <li class="d-flex justify-content-between align-items-center mt-5 bottom-border pb-4">
                    <div class="d-flex align-items-center">
                        <div class="ForWidth">
                            <img class="object-fit-cover rounded-3" src="{{ asset('public/images/flash-sales6.png') }}"
                                alt="" width="100%" height="100%">
                        </div>
                        <div class="ms-3 fw-semibold font-poppins fs-12">
                            <p class="mb-1">Pine Kids Lace Up Casual Shoes Color Block - White</p>
                            <p class="mb-1 text-warning ">Pending Delivery</p>
                            <p class="mb-1">Arrived On Tuesday 10 Oct 2023</p>
                            <p class="mb-1">Quantity: 02</p>
                        </div>
                    </div>
                    <a href=""><img src="{{ asset('public/images/Arrow-right.svg') }}" alt=""></a>
                </li>
                <div class="f-Border d-flex justify-content-between align-items-center rounded-pill mt-5 font-poppins">
                    <h6 class="m-0">Order Number: <span class="fw-bold">188565454TFF5567</span> - 01 Nov 23</h6>

                    <a href="#" class="fw-bold">View Details</a>
                </div>
                <li class="d-flex justify-content-between align-items-center mt-5 pb-4">
                    <div class="d-flex align-items-center">
                        <div class="ForWidth">
                            <img class="object-fit-cover rounded-3" src="{{ asset('public/images/flash-sales6.png') }}"
                                alt="" width="100%" height="100%">
                        </div>
                        <div class="ms-3 fw-semibold font-poppins fs-12">
                            <p class="mb-1">Pine Kids Lace Up Casual Shoes Color Block - White</p>
                            <p class="mb-1 text-warning">Cancelled</p>
                            <p class="mb-1">Arrived On Tuesday 10 Oct 2023</p>
                            <p class="mb-1">Quantity: 02</p>
                        </div>
                    </div>
                    <a href=""><img src="{{ asset('public/images/Arrow-right.svg') }}" alt=""></a>
                </li>
            </div>

        </div>
    </div>
</div>
