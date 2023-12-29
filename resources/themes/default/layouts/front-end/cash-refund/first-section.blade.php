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
        <div class="col-9 ps-4">
            <div class="MyAccount font-poppins">
                <h6 class="fw-bold m-0 rounded-pill">
                    Cash Refund
                </h6>
            </div>
            
            <div class="showNow MyAccount font-poppins mt-4">
                <h6 class="fw-bold m-0 rounded-pill text-center text-white">
                    You have Rs. 0.00 Cash Refund <a href="" class="text-pink text-decoration-none">Show Now</a>
                </h6>
            </div>
            <div class="d-flex justify-content-between mt-4 font-poppins">
                <p class="fs-6 fw-bold">Balance Amount: <span class="text-purple">Rs.256</span></p>
                <div class="Refund font-poppins text-center">
                    <button class="bg-purple rounded-pill ps-5 pe-5 pt-3 pb-3 border-0 text-white"> Refund Amount</button>
                </div>
            </div>

        </div>



    </div>

</div>
