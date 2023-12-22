<style>
    body {
        font-family: 'Poppins';
    }
    .M-Head {
        width: 100%;
        background-color: #d4d5d6;
    }
    .block-1 {
        background: linear-gradient(257deg, rgba(253, 199, 65, 0.38) 0%, rgba(0, 0, 0, 0.00) 57.31%),
            var(--colors-system-surface-seconday-bg, #292D32);
    }
    .block-2 {
        background: linear-gradient(103deg, #292D32 -53.55%, #8A68C5 112.03%);
        padding: 30px 0px 23px 0px;
    }
    .btn-1 {
        background-color: #845DC2;
    }
    .Img-1 {
        width: 213px;
        height: 213px;
    }
    .Head-1 {
        font-size: 16.51px;
    }
    .btn-2 {
        background-color: #845DC2;
        align-items: center;
        margin-bottom: 13px;
    }
    .text-box1{
        background-color: #E6DFF3;
        padding: 0px 35px 0px 35px;
    }
    .para-1 {
        color: #845DC2;
        font-size: 13.458px;
    }
    .bottom-line{
        width: 100%;
        height: 1px;
        border: 1px solid gainsboro;
    }
    .cut-text{
        font-size: 10.767px;
    }
    .Head-2{
        font-size: 18px;
        padding: 7px 0px;
    }
    .image img{
        width: 130px;
        height: 130px;
    }
    .text-2{
        font-size:12px;
    }
    .text-5 {
        font-size: 14px;
        font-weight: 600;
        margin-top: 09px;
    }
    .text-image-5 {
        width: fit-content;
    }
    .text-image-4{
        margin-bottom: 18px;
    }
    .image-6 {
        margin-left: 90px;
    }
    .text-4 {
        font-size: 14px;
        font-weight: 600;
        margin-top: 20px;
    }
</style>
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
            <div class="M-Head fs-4 mb-5 bg-opacity-10 border rounded-pill">
                <p class="Head-2 ms-3 fw-bold m-2">Club Cash</p>
            </div>
            <div class="row">
                <div class="col">
                    <div class="block-1 d-flex rounded-4 justify-content-between ps-4 pe-4 pt-4">
                        <div>
                            <p class="text-white text-start fs-6">Current Balance</p>
                            <p class="fs-5 fw-bold text-white text-start">Rs. 278</p>
                            <button
                                class= "btn-1 ps-4 pe-4 pt-2 pb-2 text-white border-0 rounded-2 fs-5 fw-semi-bold">Shop
                                Now</button>
                        </div>
                        <div class="Img-1">
                            <img src="{{ asset('public/images/gameimg.png') }}" alt="" width="100%"
                                height="100%">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="block-2 rounded-4 justify-content-between">
                        <p class="Head-1 text-white text-start  text-center">Join Cub & Earn Club Cash Benefit
                            on Products</p>
                        <div class="row-2 d-flex justify-content-center">
                            <div class="text-box1 me-3 rounded-3">
                                <p class="fs-5 fw-bold mt-3 mb-2  lh-1 text-center">3 Months</p>
                                <p class="para-1 fw-bold mb-2 text-center lh-1">Rs. 327.18</p>
                                <p class="fs-6 text-success text-center mb-2 lh-1"><span
                                        class="cut-text text-decoration-line-through">Rs. 327.18 </span><span
                                        class="cut-text text-danger fw-bold text-decoration-none">18% Off</span></p>
                                <button class= "btn-2 text-white pt-2 pb-2 ps-4 pe-4 border rounded-2">Add
                                    Now</button>
                            </div>
                            <div class="text-box1 rounded-3">
                                <p class="fs-5 fw-bold mb-2 mt-3 lh-1 text-center">12 Months</p>
                                <p class="para-1 mb-2 fw-bold  lh-1 text-center">Rs.1087.32</p>
                                <p class=" text-success mb-2 lh-1 text-center"><span
                                        class="cut-text text-decoration-line-through">Rs. 1599 </span><span
                                        class="cut-text text-danger fw-bold">32% Off</span></p>
                                <button class= "btn-2 text-white pt-2 pb-2 ps-4 pe-4 mb-2 border rounded-2">Add
                                    Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-line mt-5 mb-5"></div>
            <h5 class="fw-bold mb-3">How To Earn Club Cash?</h4>
                <div class="item-3 d-flex mb-4 mt-4">
                    <div class="image">
                        <img class="rounded-circle border border-2 border border-black"
                            src="{{ asset('public/images/alpha.png') }}" alt="" width="100%" height="100%">
                    </div>
                    <div>
                
                  
                        <p class="ms-3 mb-2 fw-bold">Join Club membership & earn club cash on purchase of eligible products</p>
                        <ul class="ps-3">
                          <li class="d-flex align-items-center">
                            <div>
                              <img class="mb-3" src="{{ asset('public/images/Vector 3.svg')}}" alt="" width="12px" height="17px">
                            </div>
                            <div>
                              <h6 class="mb-0 ms-2 fw-bold">3 Month Plan</h6>
                              <p class=" text-2 mt-1 ms-2"> Customer receive Club Cash as per the Club cash allocation logic of Bachay.com</p>
                            </div>
                            </li>
                            <li class="d-flex align-items-center">
                              <div>
                                <img class=" mb-3" src="{{ asset('public/images/Vector 3.svg')}}" alt="" width="12px" height="17px">
                              </div>
                              <div>
                                <h6 class="mb-0 ms-2 fw-bold">3 Month Plan</h6>
                                <p class=" text-2 mt-1 ms-2">Customers receive 2 X of 3 Months Club Cash.</p>
                              </div>
                            </li>
                      </ul>
                      </div>
                </div>
                <div class="bottom-line mt-5 mb-5"></div>
                <h5 class="fw-bold mb-3">How Shop & Earn Works</h5>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="align-items-center d-flex">
                        <img class="sub-imge" src="{{ asset('public/images/club.png') }}" alt="" width="60px"
                            height="60px">
                        <p class=" text-4">Join Club</p>
                    </div>
                    <img class="" src="{{ asset('public/images/image 46.svg') }}" alt="" width="20px"
                        height="20px">
                    <div class="align-items-center d-flex">
                        <img src="{{ asset('public/images/star.png') }}" alt="" width="60px" height="60px">
                        <p class="text-4 lh-1 ms-1">Select your favorite<br> products on Bachay.com</p>
                    </div>
                    <img class="" src="{{ asset('public/images/image 46.svg') }}" alt="" width="20px"
                        height="20px">
                    <div class="align-items-center d-flex">
                        <img src="{{ asset('public/images/gift.png') }}" alt="" width="60px" height="60px">
                        <p class="text-4 lh-1 ms-1">Club Cash to be earned is mentioned <br> against each
                            eligible product</p>
                    </div>
                </div>


                <div class="d-flex justify-content-between mt-3 align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('public/images/hand.png') }}" alt="" width="60px" height="60px">
                        <p class="text-4 lh-1 ms-1">Accumulate a minimum of Rs. 100 Club Cash</p>
                    </div>
                    <div class="me-4">
                        <img class="ms-3 me-3" src="{{ asset('public/images/right-image.svg') }}"alt="" width="20px"
                            height="20px">
                    </div>
                    <div class="align-items-center d-flex">
                        <img src="{{ asset('public/images./hand-111.png') }}" alt="" width="60px"
                            height="60px">
                        <p class="text-4 lh-1 ms-1">Once product is successfully delivered, earned Club Cash
                            would show in your account </p>
                    </div>
                    <div class="me-5">
                        <img class="ms-3 me-2" src="{{ asset('public/images/right-image.svg') }}" alt=""
                            width="20px" height="20px">
                    </div>
                    <div class="text-image-4">
                        <div class="image-6">
                            <img class="mb-3" src="{{ asset('public/images/image 48.svg') }}" alt="">
                        </div>
                        <div class="d-flex">
                            <div class="d-flex">
                                <img src="{{ asset('public/images//gift-2.png') }}" alt="" width="60px"
                                    height="60px">
                                <p class="text-5 lh-1 ms-1">Earn Club Cash on your purchase</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-image-5">
                    <div class="text-center mb-3">
                        <img src="{{ asset('public/images/image 48.svg') }}" alt="">
                    </div>
                    <div class="align-items-center d-flex">
                        <img class="" src="{{ asset('public/images/mon.png') }}" alt=""
                            width="60px" height="60px">
                        <p class=" text-4 ms-2 lh-1">Pay for your order with <br> the Club Cash earned</p>
                    </div>
                </div>
                <div class="bottom-line mt-5 mb-5"></div>
                <h2 class="HowItWorks font-poppins mt-5">
                    Frequently Ask Questions
                </h2>
                <div class="FAQ-Accordion font-poppins mt-4">
                    <details class="rounded-pill for-border3 pt-3 pb-3 ps-4 pe-4 mb-4">
                        <summary class="d-flex justify-content-between align-items-center fw-bold">Vorem ipsum dolor
                            sit amet,
                            consectetur adipiscing elit.</summary>
                        <div class="content">
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                                invidunt ut
                                labore
                                et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
                                dolores et ea
                                rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit
                                amet. Lorem
                                ipsum
                                dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                                labore et
                                dolore
                                magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et
                                ea rebum.
                                Stet
                                clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                        </div>
                    </details>

                    <details class="rounded-pill for-border3 pt-3 pb-3 ps-4 pe-4 mb-4">
                        <summary class="d-flex justify-content-between align-items-center fw-bold">Vorem ipsum dolor
                            sit amet,
                            consectetur adipiscing elit.</summary>
                        <div class="content">
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                                invidunt ut
                                labore
                                et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
                                dolores et ea
                                rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit
                                amet. Lorem
                                ipsum
                                dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                                labore et
                                dolore
                                magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et
                                ea rebum.
                                Stet
                                clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                        </div>
                    </details>
                    <details class="rounded-pill for-border3 pt-3 pb-3 ps-4 pe-4 mb-4">
                        <summary class="d-flex justify-content-between align-items-center fw-bold">Vorem ipsum dolor
                            sit amet,
                            consectetur adipiscing elit.</summary>
                        <div class="content">
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                                invidunt ut
                                labore
                                et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
                                dolores et ea
                                rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit
                                amet. Lorem
                                ipsum
                                dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                                labore et
                                dolore
                                magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et
                                ea rebum.
                                Stet
                                clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                        </div>
                    </details>
                    <details class="rounded-pill for-border3 pt-3 pb-3 ps-4 pe-4 mb-4">
                        <summary class="d-flex justify-content-between align-items-center fw-bold">Vorem ipsum dolor
                            sit amet,
                            consectetur adipiscing elit.</summary>
                        <div class="content">
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                                invidunt ut
                                labore
                                et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
                                dolores et ea
                                rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit
                                amet. Lorem
                                ipsum
                                dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                                labore et
                                dolore
                                magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et
                                ea rebum.
                                Stet
                                clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                        </div>
                    </details>
                    <details class="rounded-pill for-border3 pt-3 pb-3 ps-4 pe-4 mb-4">
                        <summary class="d-flex justify-content-between align-items-center fw-bold">Vorem ipsum dolor
                            sit amet,
                            consectetur adipiscing elit.</summary>
                        <div class="content">
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                                invidunt ut
                                labore
                                et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
                                dolores et ea
                                rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit
                                amet. Lorem
                                ipsum
                                dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                                labore et
                                dolore
                                magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et
                                ea rebum.
                                Stet
                                clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                        </div>
                    </details>
                    <details class="rounded-pill for-border3 pt-3 pb-3 ps-4 pe-4 mb-4">
                        <summary class="d-flex justify-content-between align-items-center fw-bold">Vorem ipsum dolor
                            sit amet,
                            consectetur adipiscing elit.</summary>
                        <div class="content">
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                                invidunt ut
                                labore
                                et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
                                dolores et ea
                                rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit
                                amet. Lorem
                                ipsum
                                dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                                labore et
                                dolore
                                magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et
                                ea rebum.
                                Stet
                                clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                        </div>
                    </details>



                </div>




        </div>

    </div>
</div>
