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
                    My Payment Details
                </h6>
            </div>
            <div class="btn-con mt-4 col-12 row justify-content-between ps-3">
                <a class="col-5" href="{{ route('my-payment-detail-added') }}">

                    <button class="col-12 mt-2 btn-f rounded-pill p-3  bg-white text-purple border-0">Bank Account
                        Details</button>

                </a>
                <a class="col-5" href="{{ route('save-cards') }}">
                    <button class="col-12 mt-2 btn-f rounded-pill p-3 bg-purple text-white border-0">Save Cards &
                        Wallets</button>
                
                </a>
            </div>
            <h6 class="fs-20 font-poppins fw-bold mt-4">
                Save Cards
            </h6>
            <div
                class="for-border3 rounded-pill d-flex justify-content-between align-items-center mt-4 pt-3 pb-3 ps-4 pe-4">
                <div class="d-flex align-items-center">
                    <div class="forCardimg me-3">
                        <img class="" src="{{ asset('public/images/mastes.svg') }}" alt="" width="100%"
                            height="100%">

                    </div>
                    <div class="font-poppins">
                        <h6 class="forCardText m-0">
                            2222-3333-4444-5555
                        </h6>
                    </div>
                </div>
                <input type="radio" name="group-1" class="">
            </div>
            <div
                class="for-border3 rounded-pill d-flex justify-content-between align-items-center mt-4 pt-3 pb-3 ps-4 pe-4">
                <div class="d-flex align-items-center">
                    <div class="forCardimg me-3">
                        <img class="" src="{{ asset('public/images/visa.svg') }}" alt="" width="100%"
                            height="100%">
                    </div>
                    <div class="font-poppins">
                        <h6 class="forCardText m-0">
                            2222-3333-4444-5555
                        </h6>
                    </div>
                </div>
                <input type="radio" name="group-1" class="">
            </div>
        </div>

    </div>
</div>
