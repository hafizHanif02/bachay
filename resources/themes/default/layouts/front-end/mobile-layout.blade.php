<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    {{-- <meta name="google" value="notranslate" />
    <meta content="bachay.com" property="og:site_name" />
    <meta content="Bachay Web App" property="og:title" />
    <meta content="publicsite" property="og:type" />
    <meta content="{{ route('mobile.home') }}" property="og:url" />
    <meta content="{{ asset('logo.publicp') }}" property="og:image" />
    <meta content="bachay.com app|E-commerce app" property="og:description" />
    <meta name="theme-color" content="#000232">
    <link rel="canonical" href="{{ route('mobile.home') }}" />
    <link rel="shortcut icon" href="{{ Storage::url($aboutUs->favicon) }}" />
    <title>{{ $meta->title ?? config('app.name') }}</title>
    <meta description="{{ $meta->description ?? '' }}" />
    <meta author="{{ $meta->author ?? '' }}" />
    <meta keywords="{{ isset($meta->keywords) ? collect($meta->keywords)->implode(', ') : '' }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <!-- CDN's -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Poppins' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.min.css" />
    <!-- Custom styles -->
    {{-- <link rel="stylesheet" href="{{ asset('public/style.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('public/mobile-view/style.css') }}" />
    {{-- <link rel="manifest" href="{{ asset('manifest.json') }}" /> --}}
</head>

<body>
    <header>
        <div class="mobile-nav d-flex justify-content-between pt-3">
            <div class="genders col-3 rouded-circle">
                <div class="img-gender">
                    <div class="sub-img-con d-flex">
                        <img class="rounded-circle me-2" id="Overly-popup" class="overly"
                            src="{{ asset('public/images/bachay.png') }}" alt="logo" width="100%" height="100%">
                        <div class="age-m">
                            <div id="ogrooModel" class="modalbox ogroobox">
                                <div class="dialog">
                                    <svg id="close" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-x-square bg-danger text-white" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                    <div class="popup pt-4 pb-4">
                                      
                                        <h6 class="text-center">Who are you shopping for today</h6>
                                        <div class="d-flex justify-content-around">
                                            <div class="mt-2">
                                                <a href="#" class="text-decoration-none">
                                                    <div class="for-sizing">
                                                        <img class="New-Season1 rounded-circle new-arival-container"
                                                            src="{{ asset('public/images/male-1.png') }}"
                                                            alt="male">
                                                    </div>

                                                    <h3 class="text-center text-dark fs-9 mt-1">Male</h3>
                                                </a>
                                            </div>
                                            <div class="mt-2">
                                                <a href="#" class="text-decoration-none">
                                                    <div class="for-sizing">
                                                        <img class="Gifts rounded-circle new-arival-container"
                                                            src="{{ asset('public/images/female-1.png') }}"
                                                            alt="female">
                                                    </div>
                                                    <h3 class="text-center text-dark fs-9 mt-1">Female</h3>
                                                </a>
                                            </div>
                                            <div class="mt-2">
                                                <a href="#" class="text-decoration-none">
                                                    <div class="for-sizing">
                                                        <img class="Kids-Accessories rounded-circle new-arival-container"
                                                            src="{{ asset('public/images/expecting.png') }}"
                                                            alt="expecting">
                                                    </div>
                                                    <h3 class="text-center text-dark fs-9 mt-1">Expecting</h3>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6 class="m-0">Male</h6>
                            <p class="font-size">06 Year</p>
                        </div>

                    </div>

                </div>
            </div>
            <div class="logo-m d-flex align-items-center">
                <img src="{{ asset('public/images/bachay-logo.png') }}" alt="">
            </div>
            <div class="m-icons">
               <a href="http://127.0.0.1:8000/mobile/search-filter"><img src="{{ asset('public/images/icon-m2.svg') }}" alt=""></a> 
                <img src="{{ asset('public/images/icon-m1.svg') }}" alt="">
                <img src="{{ asset('public/images/icon-m.svg') }}" alt="">
            </div>

        </div>
        <form class="form-inline mt-3 mb-3">
            <div class="search-bar pt-2 pb-3">
                <div class="location-icon">
                    <a href="#"><img class="pb-1" src="{{ asset('public/images/locationicon.svg') }}"
                            alt=""></a>
                </div>
                <input class="form-control pt-2 pb-2 mr-sm-2 search-input" type="search"
                    placeholder="Sindh, Karachi - Clifton, North" aria-label="Search" id="search" name="search">
                <div class="search-icon">
                    <img src="{{ asset('public/images/Searchicon.svg') }}" alt="">
                </div>
            </div>
        </form>
    </header>
    <main>
  
    @yield('content')

  
    </main>
    <footer>
        <div class="mobile-footer mt-4">
            <ul class="d-flex justify-content-between p-0">
                <li>
                    <i class="bi bi-shop"></i>
                    <h6 class="fs-10">
                        Shopping
                    </h6>
                </li>
                <li><i class="bi bi-compass"></i>
                    <h6 class="fs-10">
                        Explore
                    </h6>
                </li>
                <li><i class="bi bi-chat-square-heart"></i>
                    <h6 class="fs-10">
                        Parenting
                    </h6>
                </li>
                <li><i class="bi bi-person"></i>
                    <h6 class="fs-10">
                        Profile
                    </h6>
                </li>
                <li><i class="bi bi-menu-button-wide-fill"></i>
                    <h6 class="fs-10">
                        Menu
                    </h6>
                </li>
            </ul>
        </div>
    </footer>
    <!-- CDN's -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- Custom Scripts -->
    {{-- <script src="{{ asset('public/script.js') }}"></script> --}}
    <script src="{{ asset('public/mobile-view/script.js') }}"></script>

</body>

</html>
