<style>
    .top {
        width: 100%;
        background-color: #d4d5d6;
    }

    body {
        font-family: 'Poppins';
    }

    .block-1 {
        background: linear-gradient(257deg, rgba(253, 199, 65, 0.38) 0%, rgba(0, 0, 0, 0.00) 57.31%),
            var(--colors-system-surface-seconday-bg, #292D32);

    }

    .block-2 {
        background: linear-gradient(103deg, #292D32 -53.55%, #8A68C5 112.03%);
        padding: 30px 0px 23px 0px;
    }

    .itp-2 {
        font-size: 16.51px;
    }

    .btn-1 {
        background-color: #845DC2;

    }

    .btn-2 {
        background-color: #845DC2;
        align-items: center;
        margin-bottom: 13px;
    }

    .gme-img {
        width: 213px;
        height: 213px;
    }

    .col-cl1 {
        background-color: #E6DFF3;
        padding: 0px 35px 0px 35px;

    }

    .col-cl2 {
        background-color: #E6DFF3;
        padding: 0px 35px 0px 35px;

    }

    .para-1 {
        color: #845DC2;
        font-size: 13.458px;
    }

    .line {
        width: 100%;
        height: 1px;
        border: 1px solid gainsboro;
    }
.cut-txt{
    font-size: 10.767px;
}
.min-haed{
    font-size: 18px;
    padding: 7px 0px;
}

    .imag img {
        width: 130px;
        height: 130px;
    }

    .img-2 {
        margin: -70px 0px 0px 30px;
    }

    .para-2 {
        margin: -42px 0px -15px 50px;
    }

    .para-5 {
        font-size: 14px;
        font-weight: 600;
        margin-top: 09px;
    }

    .multi-item {
        width: fit-content;
    }

    .box-5 {
        margin-bottom: 18px;
    }

    .img-6 {
        margin-left: 90px;
    }

    .para-4 {
        font-size: 14px;
        font-weight: 600;
        margin-top: 20px;
    }

    #faq li {
        border: 1px solid #80868E;
        border-radius: 50px;
        width: 800px;
    }

    #faq h2 {
        color: #000;
        font-weight: bold;
        font-size: 14px;
        padding: 20px 0px 0px 20px;
        display: block;
        margin-top: 5px;
        cursor: pointer;
        transition: .2s;
    }

    #faq ul li p {

        color: #333;
        font-size: 14px;
        padding: 0px 0px 0px 20px;
        transition: .3s opacity, .6s max-height;
    }

    #faq ul {
        list-style: none;
        perspective: 900;
        padding: 0;
        margin: 0;
    }

    #faq ul li {
        position: relative;
        overflow: hidden;
        padding: 0;
        margin: 0;
        background: #fff;
        box-shadow: 0 3px 10px -2px rgba(0, 0, 0, 0.1);
        -webkit-tap-highlight-color: transparent;
    }

    #faq ul li+li {
        margin-top: 15px;
    }

    #faq ul li:last-of-type {}

    #faq ul li i {
        position: absolute;
        transform: translate(-6px, 0);
        margin-top: 28px;
        right: 15px;
    }

    #faq ul li i:before,
    ul li i:after {
        content: "";
        position: absolute;
        background-color: black;
        width: 3px;
        height: 9px;
    }

    #faq ul li i:before {
        transform: translate(-2px, 0) rotate(45deg);
    }

    #faq ul li i:after {
        transform: translate(2px, 0) rotate(-45deg);
    }

    #faq ul li input[type=checkbox] {
        position: absolute;
        cursor: pointer;
        width: 100%;
        height: 100%;
        z-index: 1;
        opacity: 0;
        touch-action: manipulation;
    }

    #faq ul li input[type=checkbox]:checked~h2 {
        color: #000;
    }

    #faq ul li input[type=checkbox]:checked~p {
        /*margin-top: 0;*/
        max-height: 0;
        transition: .3s;
        opacity: 0;
        /*transform: translate(0, 50%);*/
    }

    #faq ul li input[type=checkbox]:checked~i:before {
        transform: translate(2px, 0) rotate(45deg);
    }

    #faq ul li input[type=checkbox]:checked~i:after {
        transform: translate(-2px, 0) rotate(-45deg);
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
            <div class="top fs-4 mb-5 bg-opacity-10 border rounded-pill">
                <p class="min-haed ms-3 fw-bold m-2">Club Cash</p>
            </div>
            <div class="row">
                <div class="col">
                    <div class="block-1 d-flex rounded-4 justify-content-between ps-4 pe-4 pt-4">
                        <div>
                            <p class="text-white text-start fs-6">Current Balance</p>
                            <p class="fs-5 fw-bold text-white text-start">Rs. 278</p>
                            <button class= "btn-1 ps-4 pe-4 pt-2 pb-2 text-white border-0 rounded-2 fs-5 fw-semi-bold">Shop
                                Now</button>
                        </div>

                        <div class="gme-img">
                            <img src="{{ asset('public/images/gameimg.png') }}" alt="" width="100%"
                                height="100%">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="block-2 rounded-4 justify-content-between">
                        <p class=" itp-2 text-white text-start  text-center">Join Cub & Earn Club Cash Benefit
                            on Products</p>
                        <div class="row-2 d-flex justify-content-center">
                            <div class="col-cl1 me-3 rounded-3">
                                <p class="fs-5 fw-bold mt-3 mb-2  lh-1 text-center">3 Months</p>
                                <p class="para-1 fw-bold mb-2 text-center lh-1">Rs. 327.18</p>
                                <p class="fs-6 text-success text-center mb-2 lh-1"><span
                                        class="cut-txt text-decoration-line-through">Rs. 327.18 </span><span
                                        class="cut-txt text-danger fw-bold text-decoration-none">18% Off</span></p>
                                <button class= "btn-2 text-white pt-2 pb-2 ps-4 pe-4 border rounded-2">Add
                                    Now</button>
                            </div>
                            <div class="col-cl2 rounded-3">
                                <p class="fs-5 fw-bold mb-2 mt-3 lh-1 text-center">12 Months</p>
                                <p class="para-1 mb-2 fw-bold  lh-1 text-center">Rs.1087.32</p>
                                <p class=" text-success mb-2 lh-1 text-center"><span
                                        class="cut-txt text-decoration-line-through">Rs. 1599 </span><span
                                        class="cut-txt text-danger fw-bold">32% Off</span></p>

                                <button class= "btn-2 text-white pt-2 pb-2 ps-4 pe-4 mb-2 border rounded-2">Add
                                    Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="line mt-5 mb-5"></div>
            <h5 class="fw-bold mb-3">How To Earn Club Cash?</h4>
                <div class="item-3 d-flex mb-4 mt-4">
                    <div class="imag">
                        <img class="rounded-circle border border-2 border border-black"
                            src="{{ asset('public/images/alpha.png') }}" alt="" width="100%" height="100%">
                    </div>
                    <div>
                        <p class="ms-4 mb-1 fw-bold">Join Club membership & earn club cash on purchase of
                            eligible products</p>
                        <p class="ms-5 fw-bold">3 Month Plan</p>
                        <img class="img-2" src="{{ asset('public/images/Vector 3.svg') }}" alt="">
                        <p class="para-2">Customer receive Club Cash as per the Club cash allocation logic of
                            Bachay.com</p>
                        <p class=" ms-5 fw-bold mt-4">3 Month Plan</p>
                        <img class="img-2" src="{{ asset('public/images/Vector 3.svg') }}" alt="">
                        <p class="para-2 ">Customer receive Club Cash as per the Club cash allocation logic of
                            Bachay.com</p>
                    </div>
                </div>
                <div class="line mt-5 mb-5"></div>
                <h5 class="fw-bold mb-3">How Shop & Earn Works</h5>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="align-items-center d-flex">
                        <img class="sub-imge" src="{{ asset('public/images/club.png') }}" alt="" width="60px"
                            height="60px">
                        <p class=" para-4">Join Club</p>
                    </div>
                    <img class="" src="{{ asset('public/images/image 46.svg') }}" alt="" width="20px"
                        height="20px">
                    <div class="align-items-center d-flex">
                        <img src="{{ asset('public/images/star.png') }}" alt="" width="60px" height="60px">
                        <p class="para-4 lh-1 ms-1">Select your favorite<br> products on Bachay.com</p>
                    </div>
                    <img class="" src="{{ asset('public/images/image 46.svg') }}" alt="" width="20px"
                        height="20px">
                    <div class="align-items-center d-flex">
                        <img src="{{ asset('public/images/gift.png') }}" alt="" width="60px" height="60px">
                        <p class="para-4 lh-1 ms-1">Club Cash to be earned is mentioned <br> against each
                            eligible product</p>
                    </div>
                </div>


                <div class="d-flex justify-content-between mt-3 align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('public/images/hand.png') }}" alt="" width="60px" height="60px">
                        <p class="para-4 lh-1 ms-1">Accumulate a minimum of Rs. 100 Club Cash</p>
                    </div>
                    <div class="me-4">
                    <img class="ms-3 me-3" src="{{ asset('public/images/right-image.svg') }}"alt="" width="20px"
                        height="20px">
                    </div>
                        <div class="align-items-center d-flex">
                        <img src="{{ asset('public/images./hand-111.png') }}" alt="" width="60px"
                            height="60px">
                        <p class="para-4 lh-1 ms-1">Once product is successfully delivered, earned Club Cash
                            would show in your account </p>
                    </div>
                    <div class="me-5">
                        <img class="ms-3 me-2" src="{{ asset('public/images/right-image.svg') }}" alt=""
                            width="20px" height="20px">
                    </div>
                    <div class="box-5">
                        <div class="img-6">
                            <img class="mb-3" src="{{ asset('public/images/image 48.svg') }}" alt="">
                        </div>
                        <div class="d-flex">
                            <div class="d-flex">
                                <img src="{{ asset('public/images//gift-2.png') }}" alt="" width="60px"
                                    height="60px">
                                <p class="para-5 lh-1 ms-1">Earn Club Cash on your purchase</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="multi-item">
                    <div class="text-center mb-3">
                        <img src="{{ asset('public/images/image 48.svg') }}" alt="">
                    </div>
                    <div class="align-items-center d-flex">
                        <img class="" src="{{ asset('public/images/mon.png') }}" alt=""
                            width="60px" height="60px">
                        <p class=" para-4 ms-2 lh-1">Pay for your order with <br> the Club Cash earned</p>
                    </div>
                </div>
                <div class="line mt-5 mb-5"></div>
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
