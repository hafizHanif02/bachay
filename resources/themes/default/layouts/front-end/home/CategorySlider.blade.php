<div class="new-arival mt-4 container-xxl">
    <div class="sub-container bg-light pt-5 pb-5 rounded-5">

        <h1 class="text-center textClr">Early Breeze New Arrivals</h1>
        <div class="New_arrival row justify-content-evenly ps-5 pe-5 pt-5">
            {{-- @foreach ($new_arrivals_categories as $arrivals) --}}
            @foreach ($categories->sortByDesc('created_at')->take(5) as $category)
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 p-0">
                    <a href="#" class="text-decoration-none">

                        <img class="NewSeasonBorder rounded-5 new-arival-container"
                            src="{{ asset('storage/app/public/category') }}/{{ $category['icon'] }}" alt="Category image">

                            <h4 class="text-center gradient-text mt-1 mb-0 pb-1" id="productDescription">
                                @if (strlen($category->name) <= 15)
                                    {{ $category->name }}
                                @else
                                    {{ substr($category->name, 0, 15) }}<span id="dots">...</span>
                                @endif
                            </h4>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>





{{-- <div class="new-arival">
    <div class="sub-container bg-white pt-5 pb-5 rounded-5">
        <h1 class="text-center textClr">Early Breeze New Arival</h1>
        <div class="row pt-5">
            <div class="col-lg-1 col-md-4 col-sm-6 col-12">

            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <a href="#" class="text-decoration-none">
                    <img class="New-Season rounded-5 new-arival-container" src="{{ asset('public/images/child.png') }}" alt="">
                    <h3 class="text-center gradient-text">{{ $home_categories[0]->name }}</h3>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <a href="#" class="text-decoration-none">
                    <img class="Gifts rounded-5 new-arival-container" src="{{ asset('public/images/frame22.png') }}" alt="">
                    <h3 class="text-center text-dark">{{ $home_categories[1]->name }} <span class="text-success">-15%</span></h3>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <a href="#" class="text-decoration-none">
                    <img class="Kids-Accessories rounded-5 new-arival-container" src="{{ asset('public/images/threekids.png') }}" alt="">
                    <h3 class="text-center text-dark">{{ $home_categories[2]->name }}</h3>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <a href="#" class="text-decoration-none">
                    <img class="Fashion rounded-5 new-arival-container" src="{{ asset('public/images/kid.png') }}" alt="">
                    <h3 class="text-center text-dark">{{ $home_categories[3]->name }}</h3>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                <a href="#" class="text-decoration-none">
                    <img class="Education rounded-5 new-arival-container" src="{{ asset('public/images/books.png') }}" alt="">
                    <h3 class="text-center text-dark">{{ $home_categories[4]->name }}</h3>
                </a>
            </div>
            <div class="col-lg-1 col-md-4 col-sm-6 col-12">

            </div>
        </div>
    </div>

</div>  --}}
{{-- <div class="new-arival">
    <div class="sub-container bg-white pt-5 pb-5 rounded-5">
        <h1 class="text-center textClr">{{ $data->pageSectionHeading->heading }}</h1>
        <div class="row pt-5">
            <div class="col-lg-1 col-md-4 col-sm-6 col-12">
            </div>
            @foreach ($data->pageSectionCategories as $pageSectionCategory)
                <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                    <a href="#" class="text-decoration-none">
                        <img class="New-Season rounded-5 new-arival-container" src="{{ Storage::url($pageSectionCategory->image) }}" alt="category image">
                        <h3 class="text-center gradient-text">{{ $pageSectionCategory->text }}</h3>
                    </a>
                </div>
            @endforeach
            <div class="col-lg-1 col-md-4 col-sm-6 col-12">
            </div>
        </div>
    </div>
</div> --}}
