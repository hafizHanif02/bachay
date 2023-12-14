<div class="premiumBouquets">
    <h1 class="text-center textClr pb-2 pt-2">Premium Bouquets</h1>
    <div class="row mt-5 col-12 flash-sales-container">
      @foreach ($productsInFlashDeal->take(6) as $products)
          <div class="col-lg-4 col-md-6 col-sm-12 mb-5">
              <div class="card rounded-5">
                  <a href="{{ route('product-detail', $products->id) }}">
                      <div class="deal-alert-circle">-{{ $products->discount }}%</div>
                      <div class="forHeight">
                          {{-- @foreach (json_decode($products->images) as $key => $photo) --}}
                          <img class="object-fit-cover card-img rounded-5"
                              src="{{ asset("storage/app/public/product/thumbnail/".$products->product->thumbnail) }}"
                              alt="Flash Sale" width="100%" height="100%" />
                          {{-- @endforeach --}}
                      </div>
                      <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                          @if (strlen($products->product->name) <= 20)
                              <p class="card-text">{{ $products->product->name }}</p>
                          @else
                              <p class="card-text"> {{ substr($products->product->name, 0, 20) }}...</p>
                          @endif
                      </div>
                  </a>
              </div>
          </div>
      @endforeach
      {{-- <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <div class="card rounded-5">
              <a href="#">
                  <div class="deal-alert-circle">-75%</div>
                  <img class="card-img rounded-5" src="{{ asset('public/images/flash-sales1.png') }}"
                      alt="Flash Sale 1" height="411px" />
                  <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                      <p class="card-text">New Toys For Children</p>
                  </div>
              </a>
          </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <div class="card rounded-5">
              <a href="#">
                  <div class="deal-alert-circle">-15%</div>
                  <img class="card-img rounded-5" src="{{ asset('public/images/flash-sales2.png') }}"
                      alt="Flash Sale 1" height="411px" />
                  <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                      <p class="card-text">New Toys For Children</p>
                  </div>
              </a>
          </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <div class="card rounded-5">
              <a href="#">
                  <div class="deal-alert-circle">-25%</div>
                  <img class="card-img rounded-5" src="{{ asset('public/images/flash-sales3.png') }}"
                      alt="Flash Sale 1" height="411px" />
                  <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                      <p class="card-text">New Toys For Children</p>
                  </div>
              </a>
          </div>
      </div>


      <div class="for-spacing p-3"></div>


      <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <div class="card rounded-5">
              <a href="#">
                  <div class="deal-alert-circle">-55%</div>
                  <img class="card-img rounded-5" src="{{ asset('public/images/flash-sales4.png') }}"
                      alt="Flash Sale 1" height="411px" />
                  <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                      <p class="card-text">New Toys For Children</p>
                  </div>
              </a>
          </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <div class="card rounded-5">
              <a href="#">
                  <div class="deal-alert-circle">-85%</div>
                  <img class="card-img rounded-5" src="{{ asset('public/images/flash-sales5.png') }}"
                      alt="Flash Sale 1" height="411px" />
                  <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                      <p class="card-text">New Toys For Children</p>
                  </div>
              </a>
          </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <div class="card rounded-5">
              <a href="#">
                  <div class="deal-alert-circle">-40%</div>
                  <img class="card-img rounded-5" src="{{ asset('public/images/flash-sales6.png') }}"
                      alt="Flash Sale 1" height="411px" />
                  <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                      <p class="card-text">New Toys For Children</p>
                  </div>
              </a>
          </div>
      </div> --}}


  </div>


</div>
