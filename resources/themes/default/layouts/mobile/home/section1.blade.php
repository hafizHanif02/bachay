<div class="slider-nav slider-con mt-1">
    @foreach ($categories as $category)
        <div class="">
            <a href="#" class="text-decoration-none">
                <img class="New-Season rounded-4 new-arival-container"
                    src="{{ asset('storage/app/public/category') }}/{{ $category['icon'] }}" alt="">
                <h3 class="text-center gradient-text fs-12">
                    @if (strlen($category->name) <= 15)
                        {{ $category->name }}
                    @else
                        {{ substr($category->name, 0, 15) }}<span id="dots">...</span>
                    @endif
                </h3>
            </a>
        </div>
    @endforeach
    {{-- <div class="">
        <a href="#" class="text-decoration-none">
            <img class="Gifts rounded-4 new-arival-container" src="{{ asset('public/images/Frame22.png') }}" alt="">
            <h3 class="text-center text-dark fs-12">Gifts <span class="text-success">-15%</span></h3>
        </a>
    </div>
    <div class="">
        <a href="#" class="text-decoration-none">
            <img class="Kids-Accessories rounded-4 new-arival-container" src="{{ asset('public/images/threekids.png') }}" alt="">
            <h3 class="text-center text-dark fs-12">Kids Accessories</h3>
        </a>
    </div>
    <div class="">
        <a href="#" class="text-decoration-none">
            <img class="Fashion rounded-4 new-arival-container" src="{{ asset('public/images/kid.png') }}" alt="">
            <h3 class="text-center text-dark fs-12">Fashion</h3>
        </a>
    </div>
    <div class="">
        <a href="#" class="text-decoration-none">
            <img class="Education rounded-4 new-arival-container" src="{{ asset('public/images/books.png') }}" alt="">
            <h3 class="text-center text-dark fs-12">Education</h3>
        </a>
    </div>               --}}
</div>
