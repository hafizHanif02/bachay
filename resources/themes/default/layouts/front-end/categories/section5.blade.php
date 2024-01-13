<div class="container-xxl premiumBouquets mb-4">
    <h1 class="text-center textClr">Style For Every Kid</h1>
    <div class="row mt-5 col-12 flash-sales-container">
        @if (count($categories) > 0)
            @foreach ($categories->sortBy('created_at')->take(18) as $category)
                <div class="icon col-lg-4 col-md-6 col-sm-12 mb-5 mt-4">
                    <div class="card card_image rounded-5">
                        <a  href="{{ route('single.category', $category->slug) }}">
                            {{-- <div class="deal-alert-circle">-{{ $category->discount }}%</div> --}}
                            <div class="forHeight">
                                <img class="object-fit-cover card-img rounded-5"
                                    src="{{ asset('storage/app/public/category/' . $category->icon) }}"
                                    alt="Flash Sale" width="100%" height="100%" />
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
<style>
    .bgcolor {
        background: #fbdabf;
    }
    .card_image {
        z-index: -1 !important;
    }
    .ruler {
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        background-color: rgba(255, 255, 255, 0.05);
        position: absolute;
        top: 50%;
        height: 50%;
        left: 0%;
        right: 0%;
    }
    .icon {
        --transition-duration: 500ms;
        --transition-easing: ease-out;
        backdrop-filter: blur(2px);
        transition: transform var(--transition-duration) var(--transition-easing);
        overflow: hidden;
        &::before {
            content: '';
            background: rgba(255, 255, 255, 0.4);
            width: 20%;
            height: 100%;
            top: 0%;
            left: -125%;
            transform: skew(45deg);
            position: absolute;
            transition: left var(--transition-duration) var(--transition-easing);
        }

        &:hover {
            transform: translateY(-4%);

            &::before {
                left: 150%;
            }
        }
    }
</style>
