<div class="slider-container pt-3 mb-5">
    <div class="slider">
        @foreach($main_banner as $banner)        
        <div><img class="rounded-5 img-fluid imgBanner"  src="{{ asset('storage/app/public/banner/'.$banner->photo) }}" alt="Image 3" width="100%"></div>
        @endforeach
    </div>
</div> 


