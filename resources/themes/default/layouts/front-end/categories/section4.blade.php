<div class="cateSlider space-between">
    <div class="slider-category mt-3">
        @foreach ($data->pageSectionCategories as $pageSectionCategory)
            <div>
                <a href="{{ $pageSectionCategory->link }}" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="New-Season rounded-circle new-arival-container" src="{{ Storage::url($pageSectionCategory->image) }}" alt="Category image">
                    </div>
                    <h3 class="text-center gradient-text fs-6">{{ $pageSectionCategory->text }}</h3>
                </a>
            </div>
        @endforeach
    </div>
</div>
{{-- 
<div class="mainCon space-between">
    @php
        $pageSectionCategories = $data->pageSectionCategories;
    @endphp
    <div class="scroll-cards mt-4">
        @foreach ($pageSectionCategories as $pageSectionCategory)
            <div class="circleCard">
                <a href="{{ $pageSectionCategory->link }}" class="text-decoration-none">
                    <div class="for-sizing">
                        <img class="CategImg rounded-circle object-fit-cover"
                            src="{{ Storage::url($pageSectionCategory->image) }}" alt="Category image" width="100%"
                            height="100%">
                    </div>
                    <h4 class="text-center gradient-text">{{ $pageSectionCategory->text }}</h4>
                </a>
            </div>
        @endforeach
    </div>
</div> --}}
