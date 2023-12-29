<div class="container-xxl row mt-5 pb-5 col-12 flash-sales-container d-flex justify-content-between ">
    @foreach ($categories->take(4) as $category)
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <a href="#" class="text-decoration-none">
                <div class="ImageCOntainer card rounded-circle for-border1">
                    <img class="card-img rounded-circle"
                        src="{{ asset('storage/app/public/category/' . $category->icon) }}" alt="Flash Sale 1"
                        width="100%" height="100%" />
                </div>
                <h4 class="text-center text-dark">{{ $category->name }}</h4>
            </a>
        </div>
    @endforeach





</div>
