<div class="products mt-4 pb-5 container-xxl">
    <div class="MyProfile-heading font-poppins bottom-border pb-3">
        <span>Home ></span> <span>My Account ></span> <span>My Profile</span>
    </div>
    {{-- <x-public.my-profile.breadcrumb :breadcrumbs="['Home' => route('home'), 'Manage Returns' => route('manage-returns')]" /> --}}

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
                    Manage Return
                </h6>
            </div>
            <div class="manage-returns d-flex rounded-5 align-items-start pt-3 pe-4 pb-3 mt-4">
                <img src="{{ asset('public/images/manage-returns.svg') }}" alt="">
                <p class="ps-4 font-poppins">You can track and manage your return requests in this section. Return
                    Request details will get updated only after 15 minutes from the request submission time. To know
                    more about our return policy, please <a href="#" class="fw-bold">click</a> here. In case if
                    any queries or concerns regarding your return, <a href="#" class="fw-bold">click</a> here to
                    get in touch with our customer care team</p>
            </div>
            <div class="dropdown font-poppins rounded-pill sorted-by p-2 ps-4 pe-4 me-3 mt-4">
                <a class="dropbtn nav-link"><span class="pe-3 return-status font-poppins">Return Status</span><i
                        class="bi bi-chevron-down ps-5"></i></a>
                <div class="dropdown-content">
                    <a href="#">Proceed</a>
                    <a href="#">Done</a>

                </div>
            </div>

            <div class="top-border mt-4">

                <div class="f-Border d-flex justify-content-between align-items-center rounded-pill mt-5 font-poppins">
                    <h6 class="m-0">Order Number: <span class="fw-bold">188565454TFF5567</span> - 08 Oct 23</h6>

                    <a href="#" class="fw-bold order_Details">View Details</a>

                </div>
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


            </div>

        </div>
    </div>

</div>
