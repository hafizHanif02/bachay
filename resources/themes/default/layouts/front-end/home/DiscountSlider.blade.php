<div class="bgcolor">
    <div class="flash-sales container-xxl">
        <h1 class="text-center textClr">Flash Sales For Child Products Get Crazy Discounts</h1>
        <div class="row mt-2 col-12 flash-sales-container">
            {{-- $flash_deal --}}

            
                @foreach ($flash_deal as $deal)
                    <div class="icon col-lg-4 col-md-6 col-sm-12 mb-4 mt-3">
                        <div class="card card_image rounded-5">
                            <a href="{{ route('product-list-slug', $deal->slug) }}">
                                <div class="deal-alert-circle">-{{ $deal->discount_percent }}%</div>
                                <div class="forHeight">
                                    <img class="object-fit-cover card-img rounded-5"
                                        src="{{ asset('storage/app/public/deal/'. $deal->banner) }}"
                                        alt="Flash Sale" width="100%" height="100%" />
                                </div>
                                <div class="card-img-overlay h-100 d-flex flex-column justify-content-end">
                                    @if (strlen($deal->title) <= 20)
                                        <p class="card-text">{{ $deal->title }}</p>
                                    @else
                                        <p class="card-text"> {{ substr($deal->title, 0, 20) }}...</p>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
           
        </div>
    </div>
</div>

<style>
    .bgcolor {
        background: #fbdabf;
    }

    .card_image {
        z-index: -1 !important;
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
