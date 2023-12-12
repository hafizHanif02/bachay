<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>
        @yield('title')
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180"
          href="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}">
    <link rel="icon" type="image/png" sizes="32x32"
          href="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}">
    {{-- light box --}}
    @stack('css_or_js')
    <!-- CDN's -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Poppins' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.min.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Poppins' />
    <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/style1.css">

    {{--dont touch this--}}
    <meta name="_token" content="{{csrf_token()}}">
    {{--dont touch this--}}
    <!--to make http ajax request to https-->
    <!--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->




    @php($google_tag_manager_id = \App\CPU\Helpers::get_business_settings('google_tag_manager_id'))
    @if($google_tag_manager_id )
    <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{$google_tag_manager_id}}');</script>
    <!-- End Google Tag Manager -->

    @endif

    @php($pixel_analytices_user_code =\App\CPU\Helpers::get_business_settings('pixel_analytics'))
    @if($pixel_analytices_user_code)
        <!-- Facebook Pixel Code -->
            <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $pixel_analytices_user_code }}');
            fbq('track', 'PageView');
            </script>
            <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $pixel_analytices_user_code }}&ev=PageView&noscript=1"/>
            </noscript>
        <!-- End Facebook Pixel Code -->
    @endif
</head>
<!-- Body-->
<body class="toolbar-enabled">
   

    <!-- The Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="tick-container">
                        <div class="tick" id="tickIcon"></div>
                    </div>
                    <br>
                    <p id="modalMessage"></p>
                </div>
            </div>
        </div>
    </div>


    @if($google_tag_manager_id)
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{$google_tag_manager_id}}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif

    <span id="order_again_url" data-url="{{ route('cart.order-again') }}"></span>

<!-- Sign in / sign up modal-->
@include('layouts.front-end.partials._modals')
<!-- Navbar-->
<!-- Quick View Modal-->
@include('layouts.front-end.partials._quick-view-modal')
<!-- Navbar Electronics Store-->
@include('layouts.front-end.partials.header')
<!-- Page title-->

<span id="authentication-status" data-auth="{{ auth('customer')->check() ? 'true' : 'false' }}"></span>

{{--loader--}}
    <div class="row">
        <div class="col-12" style="margin-top:10rem;position: fixed;z-index: 9999;">
            <div id="loading" style="display: none;">
               <center>
                <img width="200"
                     src="{{asset('storage/app/public/company')}}/{{\App\CPU\Helpers::get_business_settings('loader_gif')}}"
                     onerror="this.src='{{asset('public/assets/front-end/img/loader.gif')}}'">
               </center>
            </div>
        </div>
    </div>
{{--loader--}}

<!-- Page Content-->
@yield('content')


<span id="update_nav_cart_url" data-url="{{route('cart.nav-cart')}}"></span>
<span id="remove_from_cart_url" data-url="{{ route('cart.remove') }}"></span>
<span id="update_quantity_url" data-url="{{route('cart.updateQuantity.guest')}}"></span>
<span id="order_again_url" data-url="{{ route('cart.order-again') }}"></span>
<!-- Footer-->
<!-- Footer-->
@include('layouts.front-end.partials.footer')
@include('layouts.front-end.partials.modal._dynamic-modals')

<script src="{{asset('public/assets/front-end')}}/vendor/jquery/dist/jquery-2.2.4.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script
    src="{{asset('public/assets/front-end')}}/vendor/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/simplebar/dist/simplebar.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/tiny-slider/dist/min/tiny-slider.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

{{-- light box --}}
<script src="{{asset('public/js/lightbox.min.js')}}"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/drift-zoom/dist/Drift.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/lightgallery.js/dist/js/lightgallery.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/lg-video.js/dist/lg-video.min.js"></script>
{{--Toastr--}}
<script src={{asset("public/assets/back-end/js/toastr.js")}}></script>
<!-- Main theme script-->
<script src="{{asset('public/assets/front-end')}}/js/theme.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/js/custom.js"></script>
<script src="{{asset('public/assets/front-end')}}/js/slick.min.js"></script>

<script src="{{asset('public/assets/front-end')}}/js/sweet_alert.js"></script>

<script src="{{asset('public/assets/front-end')}}/js/script.js"></script>
{{--Toastr--}}
<script src={{asset("public/assets/back-end/js/toastr.js")}}></script>
{!! Toastr::message() !!}


</body>
</html>
<style>
    .tick-container {
        width: 50px;
        height: 50px;
        position: relative;
    }

    .tick {
        width: 20px;
        height: 40px;
        position: absolute;
        top: 15px;
        left: 15px;
        animation-duration: 1.5s;
    }

    .tick-success {
        border-bottom: 5px solid #28a745; /* Bootstrap success color */
        border-right: 5px solid #28a745;
        transform: rotate(45deg);
        animation-name: tickAnimation;
    }

    .tick-failure {
        background-image: url('../public/assets/back-end/img/stop-message.png'); /* Replace with the correct path to your image */
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        width: 50px;
        height: 50px;
        transform: scale(0);
        animation-name: stopSignAnimation;
        animation-duration: 1.8s;
    }

    @keyframes tickAnimation {
        0% {
            transform: rotate(45deg) scale(0);
        }
        50% {
            transform: rotate(45deg) scale(1.2);
        }
        100% {
            transform: rotate(45deg) scale(1);
        }
    }

    @keyframes stopSignAnimation {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
        }
    }
</style>
<script>
    // Check if there is a message and status in the session
    var message = "{{ session('message') }}";
    var status = "{{ session('status') }}";

    if (message) {
        // Set the message in the modal
        $('#modalMessage').text(message);

        // Set the appropriate animation class based on the status value
        var animationClass = (status == 0) ? 'tick-failure' : 'tick-success';
        $('#tickIcon').addClass(animationClass);

        // Trigger the modal
        $('#successModal').modal('show');

        // Close the modal after 3 seconds with animation
        setTimeout(function () {
            $('#successModal').modal('hide');
        }, 3000);
    }
</script>
