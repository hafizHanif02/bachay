<div class="mobileContainer space-between">
    <div class="row col-12 mt-3 mb-5">
        @foreach ($categories->SortByDesc('created_at') as $category)
            <div class="col-3 mt-2">
                <a href="#" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="Gifts rounded-circle new-arival-container"
                            src="{{ asset('storage/app/public/category') }}/{{ $category['icon'] }}" alt="">
                    </div>
                    <h3 class="text-center text-dark fs-9">
                        @if (strlen($category->name) <= 15)
                            {{ $category->name }}
                        @else
                            {{ substr($category->name, 0, 15) }}<span id="dots">...</span>
                        @endif


                    </h3>
                </a>
            </div>
        @endforeach
    </div>


</div>
