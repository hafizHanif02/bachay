<div class="subCategory-Accordian ">

    <h1 class="textClr">Best Sellers</h1>

    <div class="accordion mt-3 mb-1" id="accordionExample1">
        {{-- first --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne1">
                <button class="accordion-button btnAccor" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                    <img class="subCateIMG ms-2 me-2 p-1" src="{{ asset('web/images/cate-img4.png') }}" alt="">
                    Dorem ipsum
                </button>
            </h2>
            <div id="collapseOne1" class="accordion-collapse collapse show" aria-labelledby="headingOne1"
                data-bs-parent="#accordionExample1">
                <div class="accordion-body btnAccor-body ">

                    <div class="accordion" id="sub-accordionExample1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="sub-headingOne1">
                                <button class="accordion-button btnAccor collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#sub-collapseOne1" aria-expanded="true"
                                    aria-controls="sub-collapseOne1">
                                    Lorem, ipsum dolor.
                                </button>
                            </h2>
                            <div id="sub-collapseOne1" class="accordion-collapse collapse show "
                                aria-labelledby="sub-headingOne1" data-bs-parent="#sub-accordionExample1">
                                <div class="accordion-body btnAccor-body">
                                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                    </li>
                                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                    </li>
                                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                    </li>
                                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                    </li>
                                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                    </li>
                                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                    </li>
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button btnAccor collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    Dolor sit amet
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body btnAccor-body">
                                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                    </li>
                                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                    </li>
                                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                    </li>

                                </div>
                            </div>
                        </div>

                    </div>
                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a></li>
                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a></li>
                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a></li>

                    {{-- <a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    <a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    <a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a> --}}
                </div>
            </div>

        </div>


        {{-- second --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button btnAccor collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <img class="subCateIMG ms-2 me-2 p-1" src="{{ asset('web/images/cate-img3.png') }}" alt="">
                    Dolor sit amet
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#accordionExample">
                <div class="accordion-body btnAccor-body">
                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <div class="accordion-item mt-2">
                        <h2 class="accordion-header" id="sub-headingOne">
                            <button class="accordion-button btnAccor" type="button" data-bs-toggle="collapse"
                                data-bs-target="#sub-collapseOne" aria-expanded="true"
                                aria-controls="sub-collapseOne">
                                Lorem, ipsum dolor.
                            </button>
                        </h2>
                        <div id="sub-collapseOne" class="accordion-collapse collapse show "
                            aria-labelledby="sub-headingOne" data-bs-parent="#sub-accordionExample1">
                            <div class="accordion-body btnAccor-body">
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mt-2">
                        <h2 class="accordion-header" id="sub-headingTwo">
                            <button class="accordion-button btnAccor" type="button" data-bs-toggle="collapse"
                                data-bs-target="#sub-collapseTwo" aria-expanded="true"
                                aria-controls="sub-collapseTwo">
                                Lorem, ipsum dolor.
                            </button>
                        </h2>
                        <div id="sub-collapseTwo" class="accordion-collapse collapse show "
                            aria-labelledby="sub-headingTwo" data-bs-parent="#sub-accordionExample2">
                            <div class="accordion-body btnAccor-body">
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                                <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                                </li>
                            </div>
                        </div>
                    </div>
                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                </div>
            </div>
        </div>
        {{-- third --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button btnAccor collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <img class="subCateIMG ms-2 me-2 p-1" src="{{ asset('web/images/cate-img2.png') }}"
                        alt="">
                    Consectetur adipiscin
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#accordionExample">
                <div class="accordion-body btnAccor-body">
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                </div>
            </div>
        </div>
        {{-- fourth --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button btnAccor collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <img class="subCateIMG ms-2 me-2 p-1" src="{{ asset('web/images/cate-img1.png') }}"
                        alt="">
                    Forem ipsum dolor
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                data-bs-parent="#accordionExample">
                <div class="accordion-body btnAccor-body">
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                </div>
            </div>
        </div>
        {{-- fifth --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button btnAccor collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    <img class="subCateIMG ms-2 me-2 p-1" src="{{ asset('web/images/kid.png') }}" alt="">
                    Sit amet, consec
                </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                data-bs-parent="#accordionExample">
                <div class="accordion-body btnAccor-body">
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                </div>
            </div>
        </div>
        {{-- sixth --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingSix">
                <button class="accordion-button btnAccor collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    <img class="subCateIMG ms-2 me-2 p-1" src="{{ asset('web/images/cate-img2.png') }}"
                        alt="">
                    Ectetur adipiscing elit.
                </button>
            </h2>
            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                data-bs-parent="#accordionExample">
                <div class="accordion-body btnAccor-body">
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                </div>
            </div>
        </div>
        {{-- seventh --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo1">
                <button class="accordion-button btnAccor collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                    <img class="subCateIMG ms-2 me-2 p-1" src="{{ asset('web/images/cate-img3.png') }}"
                        alt="">
                    Apiscing elit.
                </button>
            </h2>
            <div id="collapseTwo1" class="accordion-collapse collapse" aria-labelledby="headingTwo1"
                data-bs-parent="#accordionExample">
                <div class="accordion-body btnAccor-body">
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                    <li class="mt-1"><a class="sub-sub-category p-1 fs-16" href="#">Lorem ipsum dolor sit.</a>
                    </li>
                </div>
            </div>
        </div>
    </div>




    {{-- <div class="accordion mt-3" id="accordionExample1">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button btnAccor" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <img class="subCateIMG ms-2 me-2 p-1" src="{{asset('web/images/cate-img4.png')}}" alt="">
                    Dorem ipsum
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body btnAccor-body">

                    <div class="accordion" id="sub-accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="sub-headingOne">
                                <button class="accordion-button btnAccor" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#sub-collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Accordion Item #1
                                </button>
                            </h2>
                            <div id="sub-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="sub-headingOne" data-bs-parent="#sub-accordionExample">
                                <div class="accordion-body btnAccor-body">
                                    <strong>This is the first item's accordion body.</strong> It is hidden by default,
                                    until the collapse plugin adds the appropriate classes that we use to style each
                                    element. These classes control the overall appearance, as well as the showing and
                                    hiding via CSS transitions. You can modify any of this with custom CSS or overriding
                                    our default variables. It's also worth noting that just about any HTML can go within
                                    the <code>.accordion-body btnAccor-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="sub-headingTwo">
                                <button class="accordion-button btnAccor collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#sub-collapseTwo" aria-expanded="false"
                                    aria-controls="sub-collapseTwo">
                                    Accordion Item #2
                                </button>
                            </h2>
                            <div id="sub-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="sub-headingTwo" data-bs-parent="#sub-accordionExample">
                                <div class="accordion-body btnAccor-body">
                                    <strong>This is the second item's accordion body.</strong> It is hidden by default,
                                    until the collapse plugin adds the appropriate classes that we use to style each
                                    element. These classes control the overall appearance, as well as the showing and
                                    hiding via CSS transitions. You can modify any of this with custom CSS or overriding
                                    our default variables. It's also worth noting that just about any HTML can go within
                                    the <code>.accordion-body btnAccor-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="accordion" id="accordionExample2">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button btnAccor" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <img class="subCateIMG ms-2 me-2 p-1" src="{{asset('web/images/cate-img3.png')}}" alt="">
                    Dorem ipsum
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body btnAccor-body">

                    <div class="accordion" id="sub-accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="sub-headingOne">
                                <button class="accordion-button btnAccor" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#sub-collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Accordion Item #1
                                </button>
                            </h2>
                            <div id="sub-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="sub-headingOne" data-bs-parent="#sub-accordionExample">
                                <div class="accordion-body btnAccor-body">
                                    <strong>This is the first item's accordion body.</strong> It is hidden by default,
                                    until the collapse plugin adds the appropriate classes that we use to style each
                                    element. These classes control the overall appearance, as well as the showing and
                                    hiding via CSS transitions. You can modify any of this with custom CSS or overriding
                                    our default variables. It's also worth noting that just about any HTML can go within
                                    the <code>.accordion-body btnAccor-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="sub-headingTwo">
                                <button class="accordion-button btnAccor collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#sub-collapseTwo" aria-expanded="false"
                                    aria-controls="sub-collapseTwo">
                                    Accordion Item #2
                                </button>
                            </h2>
                            <div id="sub-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="sub-headingTwo" data-bs-parent="#sub-accordionExample">
                                <div class="accordion-body btnAccor-body">
                                    <strong>This is the second item's accordion body.</strong> It is hidden by default,
                                    until the collapse plugin adds the appropriate classes that we use to style each
                                    element. These classes control the overall appearance, as well as the showing and
                                    hiding via CSS transitions. You can modify any of this with custom CSS or overriding
                                    our default variables. It's also worth noting that just about any HTML can go within
                                    the <code>.accordion-body btnAccor-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="accordion" id="accordionExample3">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button btnAccor" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <img class="subCateIMG ms-2 me-2 p-1" src="{{asset('web/images/cate-img2.png')}}" alt="">
                    Dorem ipsum
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body btnAccor-body">

                    <div class="accordion" id="sub-accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="sub-headingOne">
                                <button class="accordion-button btnAccor" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#sub-collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Accordion Item #1
                                </button>
                            </h2>
                            <div id="sub-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="sub-headingOne" data-bs-parent="#sub-accordionExample">
                                <div class="accordion-body btnAccor-body">
                                    <strong>This is the first item's accordion body.</strong> It is hidden by default,
                                    until the collapse plugin adds the appropriate classes that we use to style each
                                    element. These classes control the overall appearance, as well as the showing and
                                    hiding via CSS transitions. You can modify any of this with custom CSS or overriding
                                    our default variables. It's also worth noting that just about any HTML can go within
                                    the <code>.accordion-body btnAccor-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="sub-headingTwo">
                                <button class="accordion-button btnAccor collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#sub-collapseTwo" aria-expanded="false"
                                    aria-controls="sub-collapseTwo">
                                    Accordion Item #2
                                </button>
                            </h2>
                            <div id="sub-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="sub-headingTwo" data-bs-parent="#sub-accordionExample">
                                <div class="accordion-body btnAccor-body">
                                    <strong>This is the second item's accordion body.</strong> It is hidden by default,
                                    until the collapse plugin adds the appropriate classes that we use to style each
                                    element. These classes control the overall appearance, as well as the showing and
                                    hiding via CSS transitions. You can modify any of this with custom CSS or overriding
                                    our default variables. It's also worth noting that just about any HTML can go within
                                    the <code>.accordion-body btnAccor-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="accordion" id="accordionExample4">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button btnAccor" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <img class="subCateIMG ms-2 me-2 p-1" src="{{asset('web/images/cate-img3.png')}}" alt="">
                    Dorem ipsum
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body btnAccor-body">

                    <div class="accordion" id="sub-accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="sub-headingOne">
                                <button class="accordion-button btnAccor" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#sub-collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Accordion Item #1
                                </button>
                            </h2>
                            <div id="sub-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="sub-headingOne" data-bs-parent="#sub-accordionExample">
                                <div class="accordion-body btnAccor-body">
                                    <strong>This is the first item's accordion body.</strong> It is hidden by default,
                                    until the collapse plugin adds the appropriate classes that we use to style each
                                    element. These classes control the overall appearance, as well as the showing and
                                    hiding via CSS transitions. You can modify any of this with custom CSS or overriding
                                    our default variables. It's also worth noting that just about any HTML can go within
                                    the <code>.accordion-body btnAccor-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="sub-headingTwo">
                                <button class="accordion-button btnAccor collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#sub-collapseTwo" aria-expanded="false"
                                    aria-controls="sub-collapseTwo">
                                    Accordion Item #2
                                </button>
                            </h2>
                            <div id="sub-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="sub-headingTwo" data-bs-parent="#sub-accordionExample">
                                <div class="accordion-body btnAccor-body">
                                    <strong>This is the second item's accordion body.</strong> It is hidden by default,
                                    until the collapse plugin adds the appropriate classes that we use to style each
                                    element. These classes control the overall appearance, as well as the showing and
                                    hiding via CSS transitions. You can modify any of this with custom CSS or overriding
                                    our default variables. It's also worth noting that just about any HTML can go within
                                    the <code>.accordion-body btnAccor-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div> --}}
</div>
