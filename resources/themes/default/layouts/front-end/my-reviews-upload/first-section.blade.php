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
                    My Reviews & Uploads
                </h6>
            </div>
            <div class="btn-con mt-4 col-12 row justify-content-between ps-3 pe-5">
                <button class="col-5 mt-2 btn-f rounded-pill p-3 bg-purple text-white  border-0">Products Rated and Reviewed (0)</button>
                <button class="col-5 mt-2 btn-f rounded-pill p-3 bg-white text-purple border-0">Products Rated and Reviewed (0)</button>
            </div>
            <div class="text-center mt-5 font-poppins">
                {{-- <img src="{{ asset('public /images/union.svg') }}" alt=""> --}}
                <h6 class="MyReviewsUpload re-order mt-4">Looks like you have not bought anything from us yet. Shop from our amazing product range and benefit from our great offers and discounts! Start Shopping Now</h6>
                <a href="{{ route('product-list') }}">
                    <button class="btn-f StartShopping bg-white text-purple rounded-pill border-0">Start Shopping</button>


                </a>
            </div>

        </div>



    </div>

</div>
