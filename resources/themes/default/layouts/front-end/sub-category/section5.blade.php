<div class="row mt-5 pb-5 col-12 flash-sales-container d-flex justify-content-between">
    @foreach ($categories->take(4) as $category)
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <a href="#" class="text-decoration-none">
            <div class="card rounded-circle for-border1">
  
                <img class="card-img rounded-circle" src="{{ asset('storage/app/public/category/' . $category->icon) }}" alt="Flash Sale 1"
                    height="265px" />
  
  
            </div>
            <h4 class="text-center text-dark">{{ $category->name }}</h4>
        </a>
    </div>
    @endforeach
    {{-- <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <a href="#" class="text-decoration-none">
            <div class="card rounded-circle for-border1">
  
                <img class="card-img rounded-circle" src="{{ asset('public/images/cate-img2.png') }}" alt="Flash Sale 1"
                    height="265px" />
  
  
            </div>
            <h4 class="text-center text-dark">Health & Safety</h4>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <a href="#" class="text-decoration-none">
            <div class="card rounded-circle for-border1">
  
                <img class="card-img rounded-circle" src="{{ asset('public/images/cate-img3.png') }}" alt="Flash Sale 1"
                    height="265px" />
  
  
            </div>
            <h4 class="text-center text-dark">Nursing</h4>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <a href="#" class="text-decoration-none">
            <div class="card rounded-circle for-border1">
  
                <img class="card-img rounded-circle" src="{{ asset('public/images/cate-img4.png') }}" alt="Flash Sale 1"
                    height="265px" />
  
  
            </div>
            <h4 class="text-center text-dark">Entertainment</h4>
        </a>
    </div>
   --}}
  
    {{-- <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card rounded-circle for-border1">
          <a href="#">
            <img class="card-img rounded-circle" src="{{ asset('public/images/cate-img2.png') }}" alt="Flash Sale 1" height="265px" />
          </a>
        </div>
      </div> --}}
  
    {{-- <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card rounded-circle for-border1">
          <a href="#">
            <img class="card-img rounded-circle" src="{{ asset('public/images/cate-img3.png') }}" alt="Flash Sale 1" height="265px" />
          </a>
        </div>
      </div> --}}
  
  
  
  
  </div> 
  
  