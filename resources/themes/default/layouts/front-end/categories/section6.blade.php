<div class="mainCon mb-4 space-between mb-5">
    <div class="scroll-cards mt-4">
        @foreach ($categories as $category)
            <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('storage/app/public/category/' . $category->icon) }}" alt="Category image"
                            width="100%" height="100%">

                    </div>
                    <h4 class="gradient-text">
                        @if (strlen($category->name) <= 10)
                            <p class="card-text text-center">{{ $category->name }}</p>
                        @else
                            <p class="card-text text-center"> {{ substr($category->name, 0, 10) }}...</p>
                        @endif
                    </h4>
                </a>
            </div>
            {{-- <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('public/images/cate-img2.png') }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">boy fashion</h4>
                </a>
            </div>
            <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('public/images/cate-img3.png') }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">boy fashion</h4>
                </a>
            </div>
            <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('public/images/cate-img4.png') }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">boy fashion</h4>
                </a>
            </div>
            <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('public/images/cate-img1.png') }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">boy fashion</h4>
                </a>
            </div>
            <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('public/images/cate-img2.png') }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">boy fashion</h4>
                </a>
            </div>
            <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('public/images/cate-img3.png') }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">boy fashion</h4>
                </a>
            </div>
            <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('public/images/cate-img4.png') }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">boy fashion</h4>
                </a>
            </div>
            <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('public/images/cate-img1.png') }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">boy fashion</h4>
                </a>
            </div>
            <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('public/images/cate-img2.png') }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">boy fashion</h4>
                </a>
            </div>
            <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('public/images/cate-img3.png') }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">boy fashion</h4>
                </a>
            </div>
            <div class="circleCard">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ asset('public/images/cate-img4.png') }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">boy fashion</h4>
                </a>
            </div> --}}
        @endforeach
    </div>
</div>
