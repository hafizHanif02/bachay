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
                    Guaranteed Savings
                </h6>
            </div>
            <div class="text-center mt-5 font-poppins">
                <h6 class="re-order">You are not enrolled in any Guaranteed Savings offer by Bachay.com</h6>
              <a href="{{ route('guaranteed-savings-offer') }}">
                  <button class="StartShopping bg-purple text-white rounded-pill border-0">Click here to see all Guaranteed Savings Offers</button>

              </a>
               

            </div>
        </div>



    </div>

</div>
`