<div class="container-xxl mainCon mb-4 space-between mb-5">
    <div class="scroll-cards mt-4">
        @foreach ($categories as $category)
            <div class="circleCard">
                <a  href="{{ route('single.category', $category->slug) }}" class="text-decoration-none">
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
        @endforeach
    </div>
</div>
