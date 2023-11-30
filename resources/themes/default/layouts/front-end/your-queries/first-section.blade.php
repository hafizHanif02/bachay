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
                    Your Queries
                </h6>
            </div>
            <div class="text-center mt-5 font-poppins">
                <img src="{{ asset('public/images/your-queries.svg') }}" alt="">
                <h6 class="re-order">No Open Queries Found</h6>
                <button class="StartShopping bg-purple text-white rounded-pill border-0">Start Shopping</button>
            </div>
          

        </div>



    </div>

</div>
