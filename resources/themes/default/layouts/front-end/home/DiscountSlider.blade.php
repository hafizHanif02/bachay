<div class="bgcolor">
    <div class="flash-sales container-xxl">
        <h1 class="text-center textClr">Flash Sales For Child Products Get Crazy Discounts</h1>

        <div class="row mt-5 col-12 flash-sales-container ">
            {{-- @foreach ($categories as $category) --}}
            @if(count($categories) > 0)
            @foreach ($categories->sortBy('created_at')->take(6) as $category)
            
                <div class="col-lg-4 col-md-6 col-sm-12 mb-5 mt-4">
                    <div class="card rounded-5">
                        <a href="{{ route('product-detail', $category->id) }}">
                            <div class="deal-alert-circle">-{{ $category->discount }}%</div>
                            <div class="forHeight">
                                {{-- @foreach (json_decode($products->images) as $key => $photo) --}}
                                <img class="object-fit-cover card-img rounded-5"
                                    src="{{ asset('storage/app/public/category/' . $category->icon) }}"
                                    alt="Flash Sale" width="100%" height="100%" />
                                {{-- @endforeach --}}
                            </div>
                            <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                                @if (strlen($category->name) <= 20)
                                    <p class="card-text">{{ $category->name }}</p>
                                @else
                                    <p class="card-text"> {{ substr($category->name, 0, 20) }}...</p>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
            @endif
        </div>


    </div>

</div>


<style>
    .bgcolor {
        background: #fbdabf;
    }
</style>