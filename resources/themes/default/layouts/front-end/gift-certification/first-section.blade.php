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
                    Gift Certificates
                </h6>
            </div>
            <div class="btn-con mt-4 col-12 row justify-content-between ps-3 pe-5">
                <button class="col-5 mt-2 btn-f rounded-pill p-3 bg-white text-purple border-0">Gifted to You</button>
                <button class="col-5 mt-2 btn-f rounded-pill p-3 bg-purple text-white  border-0">Gifted by You</button>
            </div>
            <div class="text-center mt-5 font-poppins">
                {{-- <img src="{{ asset('public /images/union.svg') }}" alt=""> --}}
                <h6 class="re-order mt-4">There is no Gift Certificate which has been gifted to you.</h6>
                <button class="btn-f StartShopping bg-white text-purple rounded-pill border-0">Check Our Intellibaby Program</button>
            </div>

        </div>



    </div>

</div>
