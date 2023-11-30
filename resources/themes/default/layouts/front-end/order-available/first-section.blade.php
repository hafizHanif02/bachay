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
                    Quick Reorder
                </h6>
            </div>
            <div class="order-List col-12 mt-5">
                <li class="d-flex justify-content-between align-items-center pb-4">
                    <div class="d-flex align-items-center col-8">
                        <div class="ForWidth130 col-4">
                            <img class="object-fit-cover" src="{{ asset('public/images/flash-sales6.png') }}"
                                alt="" width="100%" height="100%">
                        </div>
                        <div class="ms-3 font-poppins col-8 font-poppins">
                            <p class="mb-1 fs-20 fw-bold">Pine Kids Lace Up Casual Shoes Color Block - White</p>
                            <p class="mb-1 fw-bold">Rs.17789</p>
                        </div>
                    </div>
                    <div class="Refund font-poppins text-center">
                        <button class="bg-purple rounded-pill ps-5 pe-5 pt-3 pb-3 border-0 text-white"> <span><img
                                    src="{{ asset('public/images/cart.png') }}" alt="" width="12px"
                                    height="12px"></span> Reorder</button>
                    </div>
                </li>
                <li class="d-flex justify-content-between align-items-center pb-4">
                    <div class="d-flex align-items-center col-8">
                        <div class="ForWidth130 col-4">
                            <img class="object-fit-cover" src="{{ asset('public/images/flash-sales6.png') }}"
                                alt="" width="100%" height="100%">
                        </div>
                        <div class="ms-3 font-poppins col-8 font-poppins">
                            <p class="mb-1 fs-20 fw-bold">Pine Kids Lace Up Casual Shoes Color Block - White</p>
                            <p class="mb-1 fw-bold">Rs.17789</p>
                        </div>
                    </div>
                    <div class="Refund font-poppins text-center">
                        <button class="bg-purple rounded-pill ps-5 pe-5 pt-3 pb-3 border-0 text-white"> <span><img
                                    src="{{ asset('public/images/cart.png') }}" alt="" width="12px"
                                    height="12px"></span> Reorder</button>
                    </div>
                </li>

            </div>
        </div>



    </div>

</div>
