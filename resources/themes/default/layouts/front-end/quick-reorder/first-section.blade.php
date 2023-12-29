<div class="products mt-4 pb-5 container-xxl">

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
            <div class="text-center mt-5 font-poppins">
                <h6 class="re-order">Looks like none of the products you have bought are available for re-order.
                </h6>
                <a href="{{ route('product-list') }}"
                    class="StartShopping btn bg-purple text-white rounded-pill d-inline-flex justify-content-center align-items-center">Start
                    Shopping</a>
            </div>

        </div>
    </div>
</div>
</div>
