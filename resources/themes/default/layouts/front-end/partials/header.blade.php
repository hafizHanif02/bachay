<header>
    <div class="desktop-nav">

        <nav class="navbar navbar-expand-md d-flex justify-content-between align-items-center col-12">
            <div class="d-flex col-md-5">
                <a class="navbar-brand col-4" href="{{ url('/') }}">
                    <img src="{{ asset('public/images/logo.png') }}" alt="Logo">
                </a>
                <form class="form-inline my-2 my-lg-0 col-7">
                    <div class="search1 search-bar pt-2 pb-3 col-12">
                        <input class="form-control pt-2 pb-2 mr-sm-2 search-input" type="text" name="search"
                            id="search" placeholder="Search for a Category, Brand or Product" aria-label="Search" />
                        <ul class="results" id="search-result"></ul>
                        <div class="search-icon2">
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                <ul class="navbar-nav mr-auto align-items-center gap-1 ">
                    <li class="nav-item dropdown">
                        <a class="dropbtn nav-link  ">Stores <i class="bi bi-caret-down-fill"></i></a>
                        <div class="dropdown-content">
                            <a href="#">Boys Clothing</a>
                            <a href="#">Girls Clothing</a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link  " href="#">Support</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Parenting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Track Order</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-heart"></i> Wishlist</a>
                    </li>
                    @auth
                        
                        <li class="nav-item position-relative">
                            <a class="nav-link" href="">
                                @if (isset(auth()->user()->cart))
                                    <div class="red-dot bg-warning position-absolute rounded-circle cart-w-h ms-2">
                                    </div>
                                @endif
                                <i class="bi bi-cart3"></i> Cart
                            </a>
                        </li>
                    @endauth
                    @auth('customer')
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#">Track Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Parenting</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-heart"></i> Wishlist</a>
                        </li> --}}
                        <li class="nav-item position-relative">
                            <a class="nav-link" href="{{ route('my-cart-address') }}">
                                @if (isset(auth('customer')->user()->cart))
                                    <div class="red-dot bg-warning position-absolute rounded-circle cart-w-h ms-2">
                                    </div>
                                @endif
                                <i class="bi bi-cart3"></i> Cart
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center ms-2">
                            <div class="dropdown">
                                <a class="nav-link d-flex align-items-center gap-1 px-0  " href="{{ route('my-profile') }}">
                                    <img class="rounded-circle"
                                        src="{{ asset('public/assets/images/customers/' . auth('customer')->user()->image) }}"
                                        alt="user avatar" height="30" width="30">

                                    @if (strlen(auth('customer')->user()->f_name . ' ' . auth('customer')->user()->l_name) <= 15)
                                        <p class="card-text m-0">
                                            {{ auth('customer')->user()->f_name . ' ' . auth('customer')->user()->l_name }}
                                        </p>
                                    @else
                                        <p class="card-text m-0">
                                            {{ substr(auth('customer')->user()->f_name . ' ' . auth('customer')->user()->l_name, 0, 15) }}...
                                        </p>
                                    @endif

                                </a>
                                <div class="dropdown-content">
                                    <a class="nav-link px-0 text-center"
                                        href="{{ route('customer.auth.logout') }}">Logout</a>

                                </div>
                            </div>
                        </li>
                    @else
                        <li class="nav-item d-flex align-items-center ms-2 ">
                            <a class="nav-link px-0  " href="{{ route('customer.auth.login') }}">Login</a>
                            <span class="px-1">/</span>
                            <a class="nav-link px-0  " href="{{ route('customer.auth.sign-up') }}">Register</a>
                        </li>
                    @endauth

                    {{-- @guest
                        <li class="nav-item d-flex align-items-center ms-2 ">
                            <a class="nav-link px-0  " href="{{route('customer.auth.login')}}">Login</a>
                            <span class="px-1">/</span>
                            <a class="nav-link px-0  " href="{{route('customer.auth.sign-up')}}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="nav-link d-flex align-items-center gap-2" href="#">
                                    <img class="rounded-circle" src=""
                                        alt="user avatar" height="30" width="30" class="dropdown">
                                        <p class="text-muted text-center mb-0 fw-bold">{{ auth()->user()->name }}</p>
                                </a>
                                <div class="dropdown-content py-2 px-3">
                                    <a href="">
                                        <i class="bi bi-person-circle"></i>
                                        Profile
                                    </a>
                                    <a href="#" onclick="logout()">
                                        <i class="bi bi-box-arrow-in-left"></i>
                                        Logout
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endguest --}}
                </ul>
            </div>
        </nav>

        <div class="nav-btn" id="mega-menu" class="hide-on-med-and-down">
            <ul class="sub-nav d-flex justify-content-between align-items-baseline pt-4 pb-4">
                <li><a href="" class="browse-all-cate text-white">
                        <i class="bi bi-grid"></i> Browse All Categories
                    </a>
                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    @foreach ($home_categories as $category)
                                        <li><a href="#">{{ $category->name }} <span class="color">NEW</span></a>
                                        </li>
                                    @endforeach
                                    {{-- <li><a href="#">Sets & Suits <span class="color">NEW</span></a></li>
                                    <li><a href="#">T-shirts <span class="color">NEW</span></a></li>
                                    <li><a href="">Nightwear</a></li>
                                    <li><a href="#">Sweatshirts<span class="color">NEW</span></a></li>
                                    <li><a href="#">Jackets <span class="color">NEW</span></a></li>
                                    <li><a href="#">Sweaters<span class="color">NEW</span></a></li>
                                    <li><a href="#">Ethnic Wear<span class="color">NEW</span></a></li>
                                    <li><a href="#">Party Wear<span class="color">NEW</span></a></li>
                                    <li><a href="#">Jeans & Trousers</a></li>
                                    <li><a chref="#">Lounge & Trackpants</a></li>
                                    <li><a href="#">Diaper & Bootie Leggings</a></li>
                                    <li><a href="#">Shirts <span class="color">NEW</span></a></li>
                                    <li><a href="#">Onesies & Rompers</a></li>
                                    <li><a href="#">Athleisure & Sportswear</a></li>
                                    <li><a href="#">Thermals <span class="color">NEW</span></a></li>
                                    <li><a href="#">Inner Wear</a></li>
                                    <li><a href="#">Caps & Gloves <span class="color">NEW</span></a></li>
                                    <li><a href="#">Bath Time</a></li>
                                    <li><a href="#">Swim Wear</a></li>
                                    <li><a href="#">Rainwear</a></li>
                                    <li><a href="#">Theme Costumes</a></li>
                                    <li><a href="#">View All</a></li> --}}
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY COLLECTION</h4>
                                    </li>
                                    <li><a href="#">Fall For Fashion <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Bestsellers</span></a></li>
                                    <li><a href="">Multi-packs</a></li>
                                    <li><a href="#">Baby Essentials <span class="color">NEW</span></a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>FASHION ACCESSORIES</h4>
                                    </li>
                                    <li><a href="#">Sunglasses</a></li>
                                    <li><a href="#">Summer Caps <span class="color">NEW</span></a></li>
                                    <li><a href="#">Watches <span class="color">NEW</span></a></li>
                                    <li><a href="#">Ties, Belts & Suspenders <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Bags</a></li>
                                    <li><a href="#">Kids Umbrellas</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>FOOTWEAR</h4>
                                    </li>
                                    <li><a href="#">Casual Shoes <span class="color">NEW</span></a></li>
                                    <li><a href="#">Sneakers & Sports Shoes <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Formal & Partywear <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Booties</a></li>
                                    <li><a href="#">Clogs </a></li>
                                    <li><a href="#">Flip Flops</a></li>
                                    <li><a href="#">Sandals</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY AGE</h4>
                                    </li>
                                    <li><a href="#">Preemie/Tine Preemie</a></li>
                                    <li><a href="#">New Born (0-3 M)</span></a></li>
                                    <li><a href="">3-6 Months</a></li>
                                    <li><a href="#">6-9 Months</a></li>
                                    <li><a href="#">9-12 Months</span></a></li>
                                    <li><a href="#">12-18 Months</a></li>
                                    <li><a href="#">18-24 Months</a></li>
                                    <li><a href="#">2 to 4 Years</a></li>
                                    <li><a href="#">4 to 6 Years</a></li>
                                    <li><a href="#">6 to 8 Years</a></li>
                                    <li><a href="#">8+ Years </a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SHOP BY PRICE</h4>
                                    </li>
                                    <li><a href="#">All Under 199</a></li>
                                    <li><a href="#">All Under 299</a></li>
                                    <li><a href="#">All Under 399</a></li>
                                    <li><a href="#">All Under 499</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY BRANDS</h4>
                                    </li>
                                    <li><a href="#">Babyhug</a></li>
                                    <li><a href="#">Babyoye</a></li>
                                    <li><a href="">Kookie Kids</a></li>
                                    <li><a href="#">Carter's</a></li>
                                    <li><a href="#">Pine Kids</a></li>
                                    <li><a href="#">Cute Walk</a></li>
                                    <li><a href="#">Honeyhap</a></li>
                                    <li><a href="#">OLLINGTON ST.</a></li>
                                    <li><a href="#">Doodle Poodle</a></li>
                                    <li><a href="#">Primo Gino</a></li>
                                    <li><a href="#">Mark & Mia</a></li>
                                    <li><a href="#">Bonfino</a></li>
                                    <li><a href="#">Earthy Touch</a></li>
                                    <li><a href="#">Arias by Lara Dutta</a></li>
                                    <li><a href="#">Pine Active</a></li>
                                    <li><a href="#">ToffyHouse</a></li>
                                    <li><a href="#">Ed-a-mamma</a></li>
                                    <li><a href="#">UCB</a></li>
                                    <li><a href="#">U.S. Polo Assn. Kids</a></li>
                                    <li><a href="#">Monte Carlo</a></li>
                                    <li><a href="#">Gini & Jony</a></li>
                                    <li><a href="#">Puma</a></li>
                                    <li><a href="#">Tommy Hilfiger</a></li>
                                    <li><a href="#">ADIDAS KIDS</a></li>
                                    <li><a href="#">RUFF</a></li>
                                    <li><a href="#">Puma</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <div class="z-depth-1 polariod">
                                    <img class="object-fit-cover rounded-3"
                                        src="{{ asset('public/images/img1.1.webp') }}" alt="image 1"
                                        class="theme responsive-img" width="100%" height="100%">

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li> <a href="#" class="drp-btn active">
                        <i class="bi bi-fire"></i> Hot Deals
                    </a>
                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Sets & Suits <span class="color">NEW</span></a></li>
                                    <li><a href="#">T-shirts <span class="color">NEW</span></a></li>
                                    <li><a href="">Nightwear</a></li>
                                    <li><a href="#">Sweatshirts<span class="color">NEW</span></a></li>
                                    <li><a href="#">Jackets <span class="color">NEW</span></a></li>
                                    <li><a href="#">Sweaters<span class="color">NEW</span></a></li>
                                    <li><a href="#">Ethnic Wear<span class="color">NEW</span></a></li>
                                    <li><a href="#">Party Wear<span class="color">NEW</span></a></li>
                                    <li><a href="#">Jeans & Trousers</a></li>
                                    <li><a chref="#">Lounge & Trackpants</a></li>
                                    <li><a href="#">Diaper & Bootie Leggings</a></li>
                                    <li><a href="#">Shirts <span class="color">NEW</span></a></li>
                                    <li><a href="#">Onesies & Rompers</a></li>
                                    <li><a href="#">Athleisure & Sportswear</a></li>
                                    <li><a href="#">Thermals <span class="color">NEW</span></a></li>
                                    <li><a href="#">Inner Wear</a></li>
                                    <li><a href="#">Caps & Gloves <span class="color">NEW</span></a></li>
                                    <li><a href="#">Bath Time</a></li>
                                    <li><a href="#">Swim Wear</a></li>
                                    <li><a href="#">Rainwear</a></li>
                                    <li><a href="#">Theme Costumes</a></li>
                                    <li><a href="#">View All</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY COLLECTION</h4>
                                    </li>
                                    <li><a href="#">Fall For Fashion <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Bestsellers</span></a></li>
                                    <li><a href="">Multi-packs</a></li>
                                    <li><a href="#">Baby Essentials <span class="color">NEW</span></a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>FASHION ACCESSORIES</h4>
                                    </li>
                                    <li><a href="#">Sunglasses</a></li>
                                    <li><a href="#">Summer Caps <span class="color">NEW</span></a></li>
                                    <li><a href="#">Watches <span class="color">NEW</span></a></li>
                                    <li><a href="#">Ties, Belts & Suspenders <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Bags</a></li>
                                    <li><a href="#">Kids Umbrellas</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>FOOTWEAR</h4>
                                    </li>
                                    <li><a href="#">Casual Shoes <span class="color">NEW</span></a></li>
                                    <li><a href="#">Sneakers & Sports Shoes <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Formal & Partywear <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Booties</a></li>
                                    <li><a href="#">Clogs </a></li>
                                    <li><a href="#">Flip Flops</a></li>
                                    <li><a href="#">Sandals</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY AGE</h4>
                                    </li>
                                    <li><a href="#">Preemie/Tine Preemie</a></li>
                                    <li><a href="#">New Born (0-3 M)</span></a></li>
                                    <li><a href="">3-6 Months</a></li>
                                    <li><a href="#">6-9 Months</a></li>
                                    <li><a href="#">9-12 Months</span></a></li>
                                    <li><a href="#">12-18 Months</a></li>
                                    <li><a href="#">18-24 Months</a></li>
                                    <li><a href="#">2 to 4 Years</a></li>
                                    <li><a href="#">4 to 6 Years</a></li>
                                    <li><a href="#">6 to 8 Years</a></li>
                                    <li><a href="#">8+ Years </a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SHOP BY PRICE</h4>
                                    </li>
                                    <li><a href="#">All Under 199</a></li>
                                    <li><a href="#">All Under 299</a></li>
                                    <li><a href="#">All Under 399</a></li>
                                    <li><a href="#">All Under 499</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY BRANDS</h4>
                                    </li>
                                    <li><a href="#">Babyhug</a></li>
                                    <li><a href="#">Babyoye</a></li>
                                    <li><a href="">Kookie Kids</a></li>
                                    <li><a href="#">Carter's</a></li>
                                    <li><a href="#">Pine Kids</a></li>
                                    <li><a href="#">Cute Walk</a></li>
                                    <li><a href="#">Honeyhap</a></li>
                                    <li><a href="#">OLLINGTON ST.</a></li>
                                    <li><a href="#">Doodle Poodle</a></li>
                                    <li><a href="#">Primo Gino</a></li>
                                    <li><a href="#">Mark & Mia</a></li>
                                    <li><a href="#">Bonfino</a></li>
                                    <li><a href="#">Earthy Touch</a></li>
                                    <li><a href="#">Arias by Lara Dutta</a></li>
                                    <li><a href="#">Pine Active</a></li>
                                    <li><a href="#">ToffyHouse</a></li>
                                    <li><a href="#">Ed-a-mamma</a></li>
                                    <li><a href="#">UCB</a></li>
                                    <li><a href="#">U.S. Polo Assn. Kids</a></li>
                                    <li><a href="#">Monte Carlo</a></li>
                                    <li><a href="#">Gini & Jony</a></li>
                                    <li><a href="#">Puma</a></li>
                                    <li><a href="#">Tommy Hilfiger</a></li>
                                    <li><a href="#">ADIDAS KIDS</a></li>
                                    <li><a href="#">RUFF</a></li>
                                    <li><a href="#">Puma</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <div class="z-depth-1 polariod">
                                    <img class="object-fit-cover rounded-3"
                                        src="{{ asset('public/images/img2.2.webp') }}" alt="image 2"
                                        class="theme responsive-img" width="100%" height="100%">

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li> <a href="#" class="drp-btn">Girls Fashion</a>
                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Sets & Suits <span class="color">NEW</span></a></li>
                                    <li><a href="#">T-shirts <span class="color">NEW</span></a></li>
                                    <li><a href="">Nightwear</a></li>
                                    <li><a href="#">Sweatshirts<span class="color">NEW</span></a></li>
                                    <li><a href="#">Jackets <span class="color">NEW</span></a></li>
                                    <li><a href="#">Sweaters<span class="color">NEW</span></a></li>
                                    <li><a href="#">Ethnic Wear<span class="color">NEW</span></a></li>
                                    <li><a href="#">Party Wear<span class="color">NEW</span></a></li>
                                    <li><a href="#">Jeans & Trousers</a></li>
                                    <li><a chref="#">Lounge & Trackpants</a></li>
                                    <li><a href="#">Diaper & Bootie Leggings</a></li>
                                    <li><a href="#">Shirts <span class="color">NEW</span></a></li>
                                    <li><a href="#">Onesies & Rompers</a></li>
                                    <li><a href="#">Athleisure & Sportswear</a></li>
                                    <li><a href="#">Thermals <span class="color">NEW</span></a></li>
                                    <li><a href="#">Inner Wear</a></li>
                                    <li><a href="#">Caps & Gloves <span class="color">NEW</span></a></li>
                                    <li><a href="#">Bath Time</a></li>
                                    <li><a href="#">Swim Wear</a></li>
                                    <li><a href="#">Rainwear</a></li>
                                    <li><a href="#">Theme Costumes</a></li>
                                    <li><a href="#">View All</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY COLLECTION</h4>
                                    </li>
                                    <li><a href="#">Fall For Fashion <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Bestsellers</span></a></li>
                                    <li><a href="">Multi-packs</a></li>
                                    <li><a href="#">Baby Essentials <span class="color">NEW</span></a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>FASHION ACCESSORIES</h4>
                                    </li>
                                    <li><a href="#">Sunglasses</a></li>
                                    <li><a href="#">Summer Caps <span class="color">NEW</span></a></li>
                                    <li><a href="#">Watches <span class="color">NEW</span></a></li>
                                    <li><a href="#">Ties, Belts & Suspenders <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Bags</a></li>
                                    <li><a href="#">Kids Umbrellas</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>FOOTWEAR</h4>
                                    </li>
                                    <li><a href="#">Casual Shoes <span class="color">NEW</span></a></li>
                                    <li><a href="#">Sneakers & Sports Shoes <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Formal & Partywear <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Booties</a></li>
                                    <li><a href="#">Clogs </a></li>
                                    <li><a href="#">Flip Flops</a></li>
                                    <li><a href="#">Sandals</a></li>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY AGE</h4>
                                    </li>
                                    <li><a href="#">Preemie/Tine Preemie</a></li>
                                    <li><a href="#">New Born (0-3 M)</span></a></li>
                                    <li><a href="">3-6 Months</a></li>
                                    <li><a href="#">6-9 Months</a></li>
                                    <li><a href="#">9-12 Months</span></a></li>
                                    <li><a href="#">12-18 Months</a></li>
                                    <li><a href="#">18-24 Months</a></li>
                                    <li><a href="#">2 to 4 Years</a></li>
                                    <li><a href="#">4 to 6 Years</a></li>
                                    <li><a href="#">6 to 8 Years</a></li>
                                    <li><a href="#">8+ Years </a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SHOP BY PRICE</h4>
                                    </li>
                                    <li><a href="#">All Under 199</a></li>
                                    <li><a href="#">All Under 299</a></li>
                                    <li><a href="#">All Under 399</a></li>
                                    <li><a href="#">All Under 499</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY BRANDS</h4>
                                    </li>
                                    <li><a href="#">Babyhug</a></li>
                                    <li><a href="#">Kookie Kids</a></li>
                                    <li><a href="">Babyoye Kids</a></li>
                                    <li><a href="#">Pine Kids's</a></li>
                                    <li><a href="#">Carter's</a></li>
                                    <li><a href="#">Cutewalk</a></li>
                                    <li><a href="#">Mark & Mia</a></li>
                                    <li><a href="#">Honeyhap</a></li>
                                    <li><a href="#">Hola Bonita</a></li>
                                    <li><a href="#">OLLINGTON ST.</a></li>
                                    <li><a href="#">Doodle Poodle</a></li>
                                    <li><a href="#">Earthy Touch</a></li>
                                    <li><a href="#">Primo Gino</a></li>
                                    <li><a href="#">Bonfino</a></li>
                                    <li><a href="#">Arias by Lara Dutta</a></li>
                                    <li><a href="#">Pine Active</a></li>
                                    <li><a href="#">ToffyHouse</a></li>
                                    <li><a href="#">Ed-a-Mamma</a></li>
                                    <li><a href="#">Puma</a></li>
                                    <li><a href="#">ASICS Kids</a></li>
                                    <li><a href="#">ADIDAS KIDS</a></li>
                                    <li><a href="#">UCB</a></li>
                                    <li><a href="#">Gini & Jony</a></li>
                                    <li><a href="#">Global Desi</a></li>
                                    <li><a href="#">And Girl</a></li>
                                    <li><a href="#">Tommy Hilfiger</a></li>
                                    <li><a href="#">NIKE</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <div class="z-depth-1 polariod">
                                    <img class="object-fit-cover rounded-3"
                                        src="{{ asset('public/images/premium-b-7.webp') }}" alt="premium image"
                                        class="theme responsive-img" width="100%" height="100%">

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="#" class="drp-btn">Boys Fashion</a>

                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Casual Shoes <span class="color">NEW</span></a></li>
                                    <li><a href="#">Sneakers & Sports Shoess <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Mojaris/Ethnic Footwear <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Formal & Party Wear <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Booties</a></li>
                                    <li><a href="#">Bellies & Peep Toes <span class="color">NEW</span></a>
                                    </li>
                                    <li><a href="#">Sandals</a></li>
                                    <li><a href="#">Clogs</a></li>
                                    <li><a href="#">Flip Flops</a></li>
                                    <li><a href="#">Winter Boots</a></li>
                                    <li><a href="#">School Shoes</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY AGE</h4>
                                    </li>
                                    <li><a href="#">Preemie/Tine Preemie</a></li>
                                    <li><a href="#">New Born (0-3 M)</span></a></li>
                                    <li><a href="">3-6 Months</a></li>
                                    <li><a href="#">6-9 Months</a></li>
                                    <li><a href="#">9-12 Months</span></a></li>
                                    <li><a href="#">12-18 Months</a></li>
                                    <li><a href="#">18-24 Months</a></li>
                                    <li><a href="#">2 to 4 Years</a></li>
                                    <li><a href="#">4 to 6 Years</a></li>
                                    <li><a href="#">6 to 8 Years</a></li>
                                    <li><a href="#">8+ Years </a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>DON'T MISS</h4>
                                    </li>
                                    <li><a href="#">Sock Shoes</a></li>
                                    <li><a href="#">Socks</a></li>
                                    <li><a href="#">Stockings & Tights</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY BRANDS</h4>
                                    </li>
                                    <li><a href="#">Cutewalk</a></li>
                                    <li><a href="#">Pinekids</a></li>
                                    <li><a href="">Babyoye</a></li>
                                    <li><a href="#">Puma</a></li>
                                    <li><a href="#">ADIDAS KIDS</a></li>
                                    <li><a href="#">Crocs</a></li>
                                    <li><a href="#">Skechers</a></li>
                                    <li><a href="#">Campus</a></li>
                                    <li><a href="#">Kazarmax</a></li>
                                    <li><a href="#">Asics Kids</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <div class="z-depth-1 polariod">
                                    <img class="object-fit-cover rounded-3"
                                        src="{{ asset('public/images/premium-b-6.webp') }}" alt="premium 6 image"
                                        class="theme responsive-img" width="100%" height="100%">

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="#" class="drp-btn">Footwear</a>

                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Musical Toys</a></li>
                                    <li><a href="#">Learning & Educational Toys</a></li>
                                    <li><a href="">Soft Toys</a></li>
                                    <li><a href="#">Backyard Play</a></li>
                                    <li><a href="#">Play Gyms & Playmats</a></li>
                                    <li><a href="#">Sports & Games</a></li>
                                    <li><a href="#">Role & Pretend Play Toys</a></li>
                                    <li><a href="#">Blocks & Construction Sets</a></li>
                                    <li><a href="#">Stacking Toys</a></li>
                                    <li><a chref="#">Kids Puzzles</a></li>
                                    <li><a href="#">Baby Rattles</a></li>
                                    <li><a href="#">Toys Cars Trains & Vehicles</a></li>
                                    <li><a href="#">Kids Musical Instruments</a></li>
                                    <li><a href="#">Dolls & Dollhouses</a></li>
                                    <li><a href="#">Push & Pull Along Toys</a></li>
                                    <li><a href="#">Art Crafts & Hobby Kits</a></li>
                                    <li><a href="#">Board Games</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4></h4>
                                    </li>
                                    <li><a href="#">Action Figures & Collectibles</a></li>
                                    <li><a href="#">Radio & Remote Control Toys</a></li>
                                    <li><a href="">Bath Toys</a></li>
                                    <li><a href="#">Toys Guns & Weapons</a></li>
                                    <li><a href="#">Kids Gadgets <span class="color">NEW</span></a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4> RIDE-ONS & SCOOTERS</h4>
                                    </li>
                                    <li><a href="#">Battery Operated Ride-ons</a></li>
                                    <li><a href="#">Manual Push Ride-ons</a></li>
                                    <li><a href="#">Swing cars/twisters</a></li>
                                    <li><a href="#">Rocking Ride Ons</a></li>
                                    <li><a href="#">Tricycles</a></li>
                                    <li><a href="#">Bicycles</a></li>
                                    <li><a href="#">Balance Bike</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4> COMBO PACKS</h4>
                                    </li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BOARD GAMES</h4>
                                    </li>
                                    <li><a href="#">IQ Games</a></li>
                                    <li><a href="#">Ludo, Snakes & Ladders</span></a></li>
                                    <li><a href="">Words, Pictures & Scrabble Games</a></li>
                                    <li><a href="#">Playing Cards</a></li>
                                    <li><a href="#">Life & Travel Board Games</span></a></li>
                                    <li><a href="#">Animal, Birds & Marine Life Games</a></li>
                                    <li><a href="#">Business/Monopoly</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>BHOME PLAY ACTIVITIES</h4>
                                    </li>
                                    <li><a href="#">Play Dough, Sand & Moulds</a></li>
                                    <li><a href="#">Coloring, Sequencing & Engraving Art</a></li>
                                    <li><a href="#">Activity Kit </a></li>
                                    <li><a href="#">SBuilding Construction Sets</a></li>
                                    <li><a href="#">Multi Model Making Sets</a></li>
                                    <li><a href="#">Kitchen Sets</a></li>
                                    <li><a href="#">Play Foods</a></li>
                                    <li><a href="#">Kids' Doctor Sets</a></li>
                                    <li><a href="#">Piano & Keyboards</a></li>
                                    <li><a href="#">Drum Sets & Percussion</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY BRANDS</h4>
                                    </li>
                                    <li><a href="#">Fisher Price</a></li>
                                    <li><a href="#">Intellikit</a></li>
                                    <li><a href="">Babyhug</a></li>
                                    <li><a href="#">Intelliskills</a></li>
                                    <li><a href="#">Intellibaby</a></li>
                                    <li><a href="#">Fab n Funky</a></li>
                                    <li><a href="#">Hotwheels</a></li>
                                    <li><a href="#">Disney</a></li>
                                    <li><a href="#">Barbie</a></li>
                                    <li><a href="#">Giggles</a></li>
                                    <li><a href="#">Lego</a></li>
                                    <li><a href="#">Bonfino</a></li>
                                    <li><a href="#">Pine Kids</a></li>
                                    <li><a href="#">Playnation</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SHOP BY PRICE</h4>
                                    </li>
                                    <li><a href="#">Under 299</a></li>
                                    <li><a href="#">Under 499</a></li>
                                    <li><a href="#">Under 699</a></li>
                                    <li><a href="#">Under 999</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <div class="z-depth-1 polariod">
                                    <img class="object-fit-cover rounded-3"
                                        src="{{ asset('public/images/premium-b-3.webp') }}" alt="premium b3 image"
                                        class="theme responsive-img" width="100%" height="100%">

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="#" class="drp-btn">Toys</a>

                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Musical Toys</a></li>
                                    <li><a href="#">Learning & Educational Toys</a></li>
                                    <li><a href="">Soft Toys</a></li>
                                    <li><a href="#">Backyard Play</a></li>
                                    <li><a href="#">Play Gyms & Playmats</a></li>
                                    <li><a href="#">Sports & Games</a></li>
                                    <li><a href="#">Role & Pretend Play Toys</a></li>
                                    <li><a href="#">Blocks & Construction Sets</a></li>
                                    <li><a href="#">Stacking Toys</a></li>
                                    <li><a chref="#">Kids Puzzles</a></li>
                                    <li><a href="#">Baby Rattles</a></li>
                                    <li><a href="#">Toys Cars Trains & Vehicles</a></li>
                                    <li><a href="#">Kids Musical Instruments</a></li>
                                    <li><a href="#">Dolls & Dollhouses</a></li>
                                    <li><a href="#">Push & Pull Along Toys</a></li>
                                    <li><a href="#">Art Crafts & Hobby Kits</a></li>
                                    <li><a href="#">Board Games</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4></h4>
                                    </li>
                                    <li><a href="#">Action Figures & Collectibles</a></li>
                                    <li><a href="#">Radio & Remote Control Toys</a></li>
                                    <li><a href="">Bath Toys</a></li>
                                    <li><a href="#">Toys Guns & Weapons</a></li>
                                    <li><a href="#">Kids Gadgets <span class="color">NEW</span></a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4> RIDE-ONS & SCOOTERS</h4>
                                    </li>
                                    <li><a href="#">Battery Operated Ride-ons</a></li>
                                    <li><a href="#">Manual Push Ride-ons</a></li>
                                    <li><a href="#">Swing cars/twisters</a></li>
                                    <li><a href="#">Rocking Ride Ons</a></li>
                                    <li><a href="#">Tricycles</a></li>
                                    <li><a href="#">Bicycles</a></li>
                                    <li><a href="#">Balance Bike</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4> COMBO PACKS</h4>
                                    </li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BOARD GAMES</h4>
                                    </li>
                                    <li><a href="#">IQ Games</a></li>
                                    <li><a href="#">Ludo, Snakes & Ladders</span></a></li>
                                    <li><a href="">Words, Pictures & Scrabble Games</a></li>
                                    <li><a href="#">Playing Cards</a></li>
                                    <li><a href="#">Life & Travel Board Games</span></a></li>
                                    <li><a href="#">Animal, Birds & Marine Life Games</a></li>
                                    <li><a href="#">Business/Monopoly</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>BHOME PLAY ACTIVITIES</h4>
                                    </li>
                                    <li><a href="#">Play Dough, Sand & Moulds</a></li>
                                    <li><a href="#">Coloring, Sequencing & Engraving Art</a></li>
                                    <li><a href="#">Activity Kit </a></li>
                                    <li><a href="#">SBuilding Construction Sets</a></li>
                                    <li><a href="#">Multi Model Making Sets</a></li>
                                    <li><a href="#">Kitchen Sets</a></li>
                                    <li><a href="#">Play Foods</a></li>
                                    <li><a href="#">Kids' Doctor Sets</a></li>
                                    <li><a href="#">Piano & Keyboards</a></li>
                                    <li><a href="#">Drum Sets & Percussion</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY BRANDS</h4>
                                    </li>
                                    <li><a href="#">Fisher Price</a></li>
                                    <li><a href="#">Intellikit</a></li>
                                    <li><a href="">Babyhug</a></li>
                                    <li><a href="#">Intelliskills</a></li>
                                    <li><a href="#">Intellibaby</a></li>
                                    <li><a href="#">Fab n Funky</a></li>
                                    <li><a href="#">Hotwheels</a></li>
                                    <li><a href="#">Disney</a></li>
                                    <li><a href="#">Barbie</a></li>
                                    <li><a href="#">Giggles</a></li>
                                    <li><a href="#">Lego</a></li>
                                    <li><a href="#">Bonfino</a></li>
                                    <li><a href="#">Pine Kids</a></li>
                                    <li><a href="#">Playnation</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SHOP BY PRICE</h4>
                                    </li>
                                    <li><a href="#">Under 299</a></li>
                                    <li><a href="#">Under 499</a></li>
                                    <li><a href="#">Under 699</a></li>
                                    <li><a href="#">Under 999</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <div class="z-depth-1 polariod">
                                    <img class="object-fit-cover rounded-3"
                                        src="{{ asset('public/images/premium-b-2.webp') }}" alt="premium b2 image"
                                        class="theme responsive-img" width="100%" height="100%">

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="#" class="drp-btn">Entertainment</a>

                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Diaper Pants</a></li>
                                    <li><a href="#">Taped Diapers</a></li>
                                    <li><a href="">Baby Wipes</a></li>
                                    <li><a href="#">Diaper Rash Cream</a></li>
                                    <li><a href="#">Cloth Nappies & Accessories</a></li>
                                    <li><a href="#">Cloth Diaper Training Pants & Inserts</a></li>
                                    <li><a href="#">Bed Protectors</a></li>
                                    <li><a href="#">Diaper Changing Mats</a></li>
                                    <li><a href="#">Diaper Bags & Backpacks</a></li>
                                    <li><a chref="#">Diaper Bins & Disposable Bags</a></li>
                                    <li><a href="#">Potty Chairs & Seats</a></li>
                                    <li><a href="#">Waterproof Nappies</a></li>
                                    <li><a href="#">Swim Diapers</a></li>
                                    <li><a href="#">Diaper Monthly Packs</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>BABY SKIN CARE</h4>
                                    </li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>DISPOSABLE BABY DIAPERS</h4>
                                    </li>
                                    <li><a href="#">Diaper Pants</a></li>
                                    <li><a href="#">Taped Diapers</a></li>
                                    <li><a href="">Monthly Packs</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>BABY DIAPER BY SIZE</h4>
                                    </li>
                                    <li><a href="#">New Born/Extra Small</a></li>
                                    <li><a href="#">Small</a></li>
                                    <li><a href="#">Medium</a></li>
                                    <li><a href="#">Large</a></li>
                                    <li><a href="#">Extra Large</a></li>
                                    <li><a href="#">XXL/XXXL</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>BABY DIAPER BY WEIGHT</h4>
                                    </li>
                                    <li><a href="#">0 to 7 Kg</a></li>
                                    <li><a href="#">7 to 14 Kg</a></li>
                                    <li><a href="#">14 to 18 Kg</a></li>
                                    <li><a href="#">18 to 25 Kg</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BABY WIPES</h4>
                                    </li>
                                    <li><a href="">String Nappies</a></li>
                                    <li><a href="#">Velcro Nappies</a></li>
                                    <li><a href="#">Square Nappies</span></a></li>
                                    <li><a href="#">Waterproof Nappies</a></li>
                                    <li><a href="#">Swim Diapers</a></li>
                                    <li><a href="#">Nappy Inserts & Accessories</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>NEW BORN CHECKLIST</h4>
                                    </li>
                                    <li><a href="#">Pampers</a></li>
                                    <li><a href="#">Babyhug</a></li>
                                    <li><a href="">MamyPoko</a></li>
                                    <li><a href="#">Huggies</a></li>
                                    <li><a href="#">Himalaya Babycare</a></li>
                                    <li><a href="#">Mother Sparsh</a></li>
                                    <li><a href="#">SuperBottoms</a></li>
                                </ul>
                            </div>

                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>TOP BRANDS</h4>
                                    </li>
                                    <li><a href="#">Pampers</a></li>
                                    <li><a href="#">Babyhug</a></li>
                                    <li><a href="">MamyPoko</a></li>
                                    <li><a href="#">Huggies</a></li>
                                    <li><a href="#">Himalaya Babycare</a></li>
                                    <li><a href="#">Mother Sparsh</a></li>
                                    <li><a href="#">SuperBottoms</a></li>
                                    <li><a href="#">Chicco</a></li>
                                    <li><a href="#">Sebamed</a></li>
                                    <li><a href="#">Charlie Banana</a></li>
                                    <li><a href="#">Mee Mee</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                {{-- <div class="z-depth-1 polariod">
                                    <img src="" alt="" class="theme responsive-img">

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="#" class="drp-btn">Nursing</a>

                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Baby Strollers & Prams</a></li>
                                    <li><a href="#">Ride-ons & Scooters</a></li>
                                    <li><a href="">Nightwear</a></li>
                                    <li><a href="#">Battery Operated Ride-Ons</a></li>
                                    <li><a href="#">Tricycles & Bikes</a></li>
                                    <li><a href="#">Baby Walkers</a></li>
                                    <li><a href="#">Bouncers, Rockers & Swings</a></li>
                                    <li><a href="#">High Chairs & Booster Seats</a></li>
                                    <li><a href="#">Car Seats</a></li>
                                    <li><a chref="#">Baby On Board Stickers</a></li>
                                    <li><a href="#">Baby Carriers</a></li>
                                    <li><a href="#">Baby Carrycots</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>BATTERY OPERATED RIDE-ONS</h4>
                                    </li>
                                    <li><a href="#">Cars</a></li>
                                    <li><a href="#">Bikes and Scooters/a></li>
                                    <li><a href="#">ATVs</a></li>
                                    <li><a href="#">Jeeps</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BABY STROLLERS & PRAMS</h4>
                                    </li>
                                    <li><a href="#">Prams</a></li>
                                    <li><a href="#">Lightweight Strollers</span></a></li>
                                    <li><a href="">Twin Strollers & Prams</a></li>
                                    <li><a href="#">Standard Strollers<span class="color">NEW</span></a>
                                    </li>
                                    <div class="box"></div>
                                    <li><a href="#">Travel Systems</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>CAR SEATS BY TYPE</h4>
                                    </li>
                                    <li><a href="#">Convertible Car Seats (Rear and Forward-facing)</a></li>
                                    <li><a href="#">Rear-facing Baby Car Seats</a></li>
                                    <li><a href="#">Forward-facing Child Car Seats</a></li>
                                    <li><a href="#">Backless Booster Car Seats</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>CAR SEATS BY CHILD WEIGHT</h4>
                                    </li>
                                    <li><a href="#">Upto 9 Kgs</a></li>
                                    <li><a href="#">Upto 15 Kgs</a></li>
                                    <li><a href="#">Upto 22 Kgs</a></li>
                                    <li><a href="#">Upto 36 Kgs</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>RIDE-ONS & SCOOTERS</h4>
                                    </li>
                                    <li><a href="#">Battery Operated Ride-Ons</a></li>
                                    <li><a href="#">Manual Push Ride-Ons</span></a></li>
                                    <li><a href="">Twister/Swing Cars</a></li>
                                    <li><a href="#">Kids Scooters</a></li>
                                    <li><a href="#">Rocking Ride-ons</a></li>
                                    <li><a href="#">Protective Gear</a></li>
                                    <li><a href="#">Skates & Skateboards</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>TRICYCLES & BIKES</h4>
                                    </li>
                                    <li><a href="#">Tricycles</a></li>
                                    <li><a href="#">Bicycles</a></li>
                                    <div class="box"></div>
                                    <li><a href="#">Training / Balance Bikes</a></li>
                                    <li class="collection-item">
                                        <h4>HIGH CHAIRS & BOOSTER SEATS</h4>
                                    </li>
                                    <li><a href="#">High Chairs</a></li>
                                    <li><a href="#">Wooden High Chairs</a></li>
                                    <li><a href="#">Booster Seats</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BABY WALKERS</h4>
                                    </li>
                                    <li><a href="#">Musical & Regular Walkers</a></li>
                                    <li><a href="#">Activity / Push Walkers</a></li>
                                    <li><a href="">Walker Cum Rockers</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>INFANT ACTIVITY TIME</h4>
                                    </li>
                                    <li><a href="#">Rockers</a></li>
                                    <li><a href="#">Bouncers</a></li>
                                    <li><a href="#">Swings</a></li>

                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>TOP BRANDS</h4>
                                    </li>
                                    <li><a href="#">Babyhug</a></li>
                                    <li><a href="#">Fab n Funky</a></li>
                                    <li><a href="">R for Rabbit</a></li>
                                    <li><a href="#">Fisher Price</a></li>
                                    <li><a href="#">Chicco</a></li>
                                    <li><a href="#">Graco</a></li>
                                    <li><a href="#">Joie</a></li>
                                    <li><a href="#">Luv Lap</a></li>
                                    <li><a href="#">Mee Mee</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                {{-- <div class="z-depth-1 polariod">
                                    <img src="" alt="" class="theme responsive-img">

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="#" class="drp-btn">Health & Safety</a>

                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Baby Food & <br>Infant Formula</a></li>
                                    <li><a href="#">Feeding Bottles & Teats</a></li>
                                    <li><a href="">Breast Feeding</a></li>
                                    <li><a href="#">Sippers & Cupsa</li>
                                    <li><a href="#">Bibs & Hankies</a></li>
                                    <li><a href="#">Kids Foods & Supplements</a></li>
                                    <li><a href="#">Dishes & Utensils</a></li>
                                    <li><a href="#">Teethers & Pacifiers</a></li>
                                    <li><a href="#">Sterilizers & Warmers</a></li>
                                    <li><a chref="#">Feeding Accessories</a></li>
                                    <li><a href="#">Feeding Bottle Cleaning</a></li>
                                    <li><a href="#">Kitchen Appliances</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BABY FOOD & INFANT FORMULA</h4>
                                    </li>
                                    <li><a href="#">Dry Milk Powder / Formula</a></li>
                                    <li><a href="#">Porridge/Cereals/Grains </a></li>
                                    <li><a href="">MPuree - Fruits & Vegetables</a></li>
                                    <li><a href="#">Finger Food / Snacks</a></li>
                                    <li><a href="#">Add on Nutritional Mix</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>FEEDING BOTTLE CLEANING</h4>
                                    </li>
                                    <li><a href="#">Bottle & Nipple Cleaning Brushes</a></li>
                                    <li><a href="#">Drying Racks</a></li>
                                    <li><a href="#">Cleaning Combo Sets</a></li>
                                    <li><a href="#">Bottle Tongs</a></li>
                                    <li><a href="#"></a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>STERLIZERS & WARMERS</h4>
                                    </li>
                                    <li><a href="#">Bottle Sterilizers</a></li>
                                    <li><a href="#">Bottle & Food Warmers</a></li>
                                    <li><a href="#">Multipurpose Sterilizers</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BREAST FEEDING</h4>
                                    </li>
                                    <li><a href="#">Breast Pumps</a></li>
                                    <li><a href="#">Electric Breast Pump</a></li>
                                    <li><a href="">Manual Breast Pump</a></li>
                                    <li><a href="#">Breast Pads</a></li>
                                    <li><a href="#">Nipple Shields</span></a></li>
                                    <li><a href="#">Nipple Pullers</a></li>
                                    <li><a href="#">Breast Milk Storage</a></li>
                                    <li><a href="#">Feeding Pillows <br> & Covers</a></li>
                                    <li><a href="#">Nursing Covers & Bibs</a></li>
                                    <li><a href="#">Nursing Bras</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>BIBS & HANKY</h4>
                                    </li>
                                    <li><a href="#">Bibs</a></li>
                                    <li><a href="#">Burp/Wash Clothes</a></li>
                                    <li><a href="#">Hanky / Napkins</a></li>
                                    <li><a href="#">Aprons</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SUPER SAVERS</h4>
                                    </li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>FEEDING BOTTLES & ACC.</h4>
                                    </li>
                                    <li><a href="#">Feeding Bottles</a></li>
                                    <li><a href="#">Nipples & Teats</a></li>
                                    <li><a href="">Food Feeder</a></li>
                                    <li><a href="#">Fruit & Food Nibbler</a></li>
                                    <li><a href="#">Bottle Covers & Insulated Bags</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SIPPERS & CUPS</h4>
                                    </li>
                                    <li><a href="#">Spout Sippers</a></li>
                                    <li><a href="#">Straw Sippers</a></li>
                                    <li><a href="#">Tumblers</a></li>
                                    <li><a href="#">Mugs</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>TEETHERS & PACIFIERS</h4>
                                    </li>
                                    <li><a href="#">Silicone Teethers</a></li>
                                    <li><a href="#">Water Filled Silicone Teethers</a></li>
                                    <li><a href="#">Orthodontic Pacifiers</a></li>
                                    <li><a href="#">Pacifiers</a></li>
                                    <li><a href="#">Rattle Teethers</a></li>
                                    <li><a href="#">Wooden Teethers</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>KIDS FOODS & SUPPLEMENTS</h4>
                                    </li>
                                    <li><a href="#">Health Drinks & Powders</a></li>
                                    <li><a href="#">Breakfast & Cereals</a></li>
                                    <li><a href="">Ready to Cook</a></li>
                                    <li><a href="#">Dry Fruits, Nuts & Seeds</a></li>
                                    <li><a href="#">Snacks & Finger Food</a></li>
                                    <li><a href="#">Biscuits & Cookies</a></li>
                                    <li><a href="#">Chocolates, Candies & Sweets</a></li>
                                    <li><a href="#">Vitamin Gummies</a></li>
                                    <li><a href="#">Spreads, Jams & Ketchup</a></li>
                                    <li><a href="#">Ghee & Cooking Oils</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>DISHES & UTENSILS</h4>
                                    </li>
                                    <li><a href="#">Bowls, Containers & Dispensers</a></li>
                                    <li><a href="#">Cutlery</a></li>
                                    <li><a href="#">Feeding Sets</a></li>
                                    <li><a href="#">Pacifiers</a></li>
                                    <li><a href="#">Dishes</a></li>
                                    <li><a href="#">Milk Powder Containers</a></li>
                                    <li><a href="#">Milk Tableware</a></li>
                                    <li><a href="#">Milk Drinkware</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>KITCHEN APPLIANCES</h4>
                                    </li>
                                    <li><a href="#">High Chairs and Booster Sheets</a></li>
                                    <li><a href="#">TOP BRANDS</a></li>
                                    <li><a href="">Babyhug</a></li>
                                    <li><a href="#">Nestle</a></li>
                                    <li><a href="#">Medela</a></li>
                                    <li><a href="#">Chicco</a></li>
                                    <li><a href="#">Pigeon</a></li>
                                    <li><a href="#">Aptamil</a></li>
                                    <li><a href="#">Enfagrow</a></li>
                                    <li><a href="#">Enfamil</a></li>
                                    <li><a href="#">PediaSure</a></li>
                                    <li><a href="#">Similac</a></li>
                                    <li><a href="#">Mee Mee</a></li>
                                    <li><a href="#">Rattle Teethers</a></li>
                                    <li><a href="#">Luv Lap</a></li>
                                    <li><a href="#">Early Foods</a></li>
                                    <li><a href="#">timios</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                {{-- <div class="z-depth-1 polariod">
                                    <img src="" alt="" class="theme responsive-img">

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </li>
                <li> <a href="#" class="drp-btn">Toys</a>

                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Baby Food & <br>Infant Formula</a></li>
                                    <li><a href="#">Feeding Bottles & Teats</a></li>
                                    <li><a href="">Breast Feeding</a></li>
                                    <li><a href="#">Sippers & Cupsa</li>
                                    <li><a href="#">Bibs & Hankies</a></li>
                                    <li><a href="#">Kids Foods & Supplements</a></li>
                                    <li><a href="#">Dishes & Utensils</a></li>
                                    <li><a href="#">Teethers & Pacifiers</a></li>
                                    <li><a href="#">Sterilizers & Warmers</a></li>
                                    <li><a chref="#">Feeding Accessories</a></li>
                                    <li><a href="#">Feeding Bottle Cleaning</a></li>
                                    <li><a href="#">Kitchen Appliances</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BABY FOOD & INFANT FORMULA</h4>
                                    </li>
                                    <li><a href="#">Dry Milk Powder / Formula</a></li>
                                    <li><a href="#">Porridge/Cereals/Grains </a></li>
                                    <li><a href="">MPuree - Fruits & Vegetables</a></li>
                                    <li><a href="#">Finger Food / Snacks</a></li>
                                    <li><a href="#">Add on Nutritional Mix</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>FEEDING BOTTLE CLEANING</h4>
                                    </li>
                                    <li><a href="#">Bottle & Nipple Cleaning Brushes</a></li>
                                    <li><a href="#">Drying Racks</a></li>
                                    <li><a href="#">Cleaning Combo Sets</a></li>
                                    <li><a href="#">Bottle Tongs</a></li>
                                    <li><a href="#"></a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>STERLIZERS & WARMERS</h4>
                                    </li>
                                    <li><a href="#">Bottle Sterilizers</a></li>
                                    <li><a href="#">Bottle & Food Warmers</a></li>
                                    <li><a href="#">Multipurpose Sterilizers</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BREAST FEEDING</h4>
                                    </li>
                                    <li><a href="#">Breast Pumps</a></li>
                                    <li><a href="#">Electric Breast Pump</a></li>
                                    <li><a href="">Manual Breast Pump</a></li>
                                    <li><a href="#">Breast Pads</a></li>
                                    <li><a href="#">Nipple Shields</span></a></li>
                                    <li><a href="#">Nipple Pullers</a></li>
                                    <li><a href="#">Breast Milk Storage</a></li>
                                    <li><a href="#">Feeding Pillows <br> & Covers</a></li>
                                    <li><a href="#">Nursing Covers & Bibs</a></li>
                                    <li><a href="#">Nursing Bras</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>BIBS & HANKY</h4>
                                    </li>
                                    <li><a href="#">Bibs</a></li>
                                    <li><a href="#">Burp/Wash Clothes</a></li>
                                    <li><a href="#">Hanky / Napkins</a></li>
                                    <li><a href="#">Aprons</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SUPER SAVERS</h4>
                                    </li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>FEEDING BOTTLES & ACC.</h4>
                                    </li>
                                    <li><a href="#">Feeding Bottles</a></li>
                                    <li><a href="#">Nipples & Teats</a></li>
                                    <li><a href="">Food Feeder</a></li>
                                    <li><a href="#">Fruit & Food Nibbler</a></li>
                                    <li><a href="#">Bottle Covers & Insulated Bags</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SIPPERS & CUPS</h4>
                                    </li>
                                    <li><a href="#">Spout Sippers</a></li>
                                    <li><a href="#">Straw Sippers</a></li>
                                    <li><a href="#">Tumblers</a></li>
                                    <li><a href="#">Mugs</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>TEETHERS & PACIFIERS</h4>
                                    </li>
                                    <li><a href="#">Silicone Teethers</a></li>
                                    <li><a href="#">Water Filled Silicone Teethers</a></li>
                                    <li><a href="#">Orthodontic Pacifiers</a></li>
                                    <li><a href="#">Pacifiers</a></li>
                                    <li><a href="#">Rattle Teethers</a></li>
                                    <li><a href="#">Wooden Teethers</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>KIDS FOODS & SUPPLEMENTS</h4>
                                    </li>
                                    <li><a href="#">Health Drinks & Powders</a></li>
                                    <li><a href="#">Breakfast & Cereals</a></li>
                                    <li><a href="">Ready to Cook</a></li>
                                    <li><a href="#">Dry Fruits, Nuts & Seeds</a></li>
                                    <li><a href="#">Snacks & Finger Food</a></li>
                                    <li><a href="#">Biscuits & Cookies</a></li>
                                    <li><a href="#">Chocolates, Candies & Sweets</a></li>
                                    <li><a href="#">Vitamin Gummies</a></li>
                                    <li><a href="#">Spreads, Jams & Ketchup</a></li>
                                    <li><a href="#">Ghee & Cooking Oils</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>DISHES & UTENSILS</h4>
                                    </li>
                                    <li><a href="#">Bowls, Containers & Dispensers</a></li>
                                    <li><a href="#">Cutlery</a></li>
                                    <li><a href="#">Feeding Sets</a></li>
                                    <li><a href="#">Pacifiers</a></li>
                                    <li><a href="#">Dishes</a></li>
                                    <li><a href="#">Milk Powder Containers</a></li>
                                    <li><a href="#">Milk Tableware</a></li>
                                    <li><a href="#">Milk Drinkware</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>KITCHEN APPLIANCES</h4>
                                    </li>
                                    <li><a href="#">High Chairs and Booster Sheets</a></li>
                                    <li><a href="#">TOP BRANDS</a></li>
                                    <li><a href="">Babyhug</a></li>
                                    <li><a href="#">Nestle</a></li>
                                    <li><a href="#">Medela</a></li>
                                    <li><a href="#">Chicco</a></li>
                                    <li><a href="#">Pigeon</a></li>
                                    <li><a href="#">Aptamil</a></li>
                                    <li><a href="#">Enfagrow</a></li>
                                    <li><a href="#">Enfamil</a></li>
                                    <li><a href="#">PediaSure</a></li>
                                    <li><a href="#">Similac</a></li>
                                    <li><a href="#">Mee Mee</a></li>
                                    <li><a href="#">Rattle Teethers</a></li>
                                    <li><a href="#">Luv Lap</a></li>
                                    <li><a href="#">Early Foods</a></li>
                                    <li><a href="#">timios</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                {{-- <div class="z-depth-1 polariod">
                                    <img src="" alt="" class="theme responsive-img">

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </li>
                <li> <a href="#" class="drp-btn">Bath</a>

                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Baby Food & <br>Infant Formula</a></li>
                                    <li><a href="#">Feeding Bottles & Teats</a></li>
                                    <li><a href="">Breast Feeding</a></li>
                                    <li><a href="#">Sippers & Cupsa</li>
                                    <li><a href="#">Bibs & Hankies</a></li>
                                    <li><a href="#">Kids Foods & Supplements</a></li>
                                    <li><a href="#">Dishes & Utensils</a></li>
                                    <li><a href="#">Teethers & Pacifiers</a></li>
                                    <li><a href="#">Sterilizers & Warmers</a></li>
                                    <li><a chref="#">Feeding Accessories</a></li>
                                    <li><a href="#">Feeding Bottle Cleaning</a></li>
                                    <li><a href="#">Kitchen Appliances</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BABY FOOD & INFANT FORMULA</h4>
                                    </li>
                                    <li><a href="#">Dry Milk Powder / Formula</a></li>
                                    <li><a href="#">Porridge/Cereals/Grains </a></li>
                                    <li><a href="">MPuree - Fruits & Vegetables</a></li>
                                    <li><a href="#">Finger Food / Snacks</a></li>
                                    <li><a href="#">Add on Nutritional Mix</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>FEEDING BOTTLE CLEANING</h4>
                                    </li>
                                    <li><a href="#">Bottle & Nipple Cleaning Brushes</a></li>
                                    <li><a href="#">Drying Racks</a></li>
                                    <li><a href="#">Cleaning Combo Sets</a></li>
                                    <li><a href="#">Bottle Tongs</a></li>
                                    <li><a href="#"></a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>STERLIZERS & WARMERS</h4>
                                    </li>
                                    <li><a href="#">Bottle Sterilizers</a></li>
                                    <li><a href="#">Bottle & Food Warmers</a></li>
                                    <li><a href="#">Multipurpose Sterilizers</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BREAST FEEDING</h4>
                                    </li>
                                    <li><a href="#">Breast Pumps</a></li>
                                    <li><a href="#">Electric Breast Pump</a></li>
                                    <li><a href="">Manual Breast Pump</a></li>
                                    <li><a href="#">Breast Pads</a></li>
                                    <li><a href="#">Nipple Shields</span></a></li>
                                    <li><a href="#">Nipple Pullers</a></li>
                                    <li><a href="#">Breast Milk Storage</a></li>
                                    <li><a href="#">Feeding Pillows <br> & Covers</a></li>
                                    <li><a href="#">Nursing Covers & Bibs</a></li>
                                    <li><a href="#">Nursing Bras</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>BIBS & HANKY</h4>
                                    </li>
                                    <li><a href="#">Bibs</a></li>
                                    <li><a href="#">Burp/Wash Clothes</a></li>
                                    <li><a href="#">Hanky / Napkins</a></li>
                                    <li><a href="#">Aprons</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SUPER SAVERS</h4>
                                    </li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>FEEDING BOTTLES & ACC.</h4>
                                    </li>
                                    <li><a href="#">Feeding Bottles</a></li>
                                    <li><a href="#">Nipples & Teats</a></li>
                                    <li><a href="">Food Feeder</a></li>
                                    <li><a href="#">Fruit & Food Nibbler</a></li>
                                    <li><a href="#">Bottle Covers & Insulated Bags</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SIPPERS & CUPS</h4>
                                    </li>
                                    <li><a href="#">Spout Sippers</a></li>
                                    <li><a href="#">Straw Sippers</a></li>
                                    <li><a href="#">Tumblers</a></li>
                                    <li><a href="#">Mugs</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>TEETHERS & PACIFIERS</h4>
                                    </li>
                                    <li><a href="#">Silicone Teethers</a></li>
                                    <li><a href="#">Water Filled Silicone Teethers</a></li>
                                    <li><a href="#">Orthodontic Pacifiers</a></li>
                                    <li><a href="#">Pacifiers</a></li>
                                    <li><a href="#">Rattle Teethers</a></li>
                                    <li><a href="#">Wooden Teethers</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>KIDS FOODS & SUPPLEMENTS</h4>
                                    </li>
                                    <li><a href="#">Health Drinks & Powders</a></li>
                                    <li><a href="#">Breakfast & Cereals</a></li>
                                    <li><a href="">Ready to Cook</a></li>
                                    <li><a href="#">Dry Fruits, Nuts & Seeds</a></li>
                                    <li><a href="#">Snacks & Finger Food</a></li>
                                    <li><a href="#">Biscuits & Cookies</a></li>
                                    <li><a href="#">Chocolates, Candies & Sweets</a></li>
                                    <li><a href="#">Vitamin Gummies</a></li>
                                    <li><a href="#">Spreads, Jams & Ketchup</a></li>
                                    <li><a href="#">Ghee & Cooking Oils</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>DISHES & UTENSILS</h4>
                                    </li>
                                    <li><a href="#">Bowls, Containers & Dispensers</a></li>
                                    <li><a href="#">Cutlery</a></li>
                                    <li><a href="#">Feeding Sets</a></li>
                                    <li><a href="#">Pacifiers</a></li>
                                    <li><a href="#">Dishes</a></li>
                                    <li><a href="#">Milk Powder Containers</a></li>
                                    <li><a href="#">Milk Tableware</a></li>
                                    <li><a href="#">Milk Drinkware</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>KITCHEN APPLIANCES</h4>
                                    </li>
                                    <li><a href="#">High Chairs and Booster Sheets</a></li>
                                    <li><a href="#">TOP BRANDS</a></li>
                                    <li><a href="">Babyhug</a></li>
                                    <li><a href="#">Nestle</a></li>
                                    <li><a href="#">Medela</a></li>
                                    <li><a href="#">Chicco</a></li>
                                    <li><a href="#">Pigeon</a></li>
                                    <li><a href="#">Aptamil</a></li>
                                    <li><a href="#">Enfagrow</a></li>
                                    <li><a href="#">Enfamil</a></li>
                                    <li><a href="#">PediaSure</a></li>
                                    <li><a href="#">Similac</a></li>
                                    <li><a href="#">Mee Mee</a></li>
                                    <li><a href="#">Rattle Teethers</a></li>
                                    <li><a href="#">Luv Lap</a></li>
                                    <li><a href="#">Early Foods</a></li>
                                    <li><a href="#">timios</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                {{-- <div class="z-depth-1 polariod">
                                    <img src="" alt="" class="theme responsive-img">

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </li>

                <li> <a href="#" class="drp-btn">Feeding</a>

                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Baby Food & <br>Infant Formula</a></li>
                                    <li><a href="#">Feeding Bottles & Teats</a></li>
                                    <li><a href="">Breast Feeding</a></li>
                                    <li><a href="#">Sippers & Cupsa</li>
                                    <li><a href="#">Bibs & Hankies</a></li>
                                    <li><a href="#">Kids Foods & Supplements</a></li>
                                    <li><a href="#">Dishes & Utensils</a></li>
                                    <li><a href="#">Teethers & Pacifiers</a></li>
                                    <li><a href="#">Sterilizers & Warmers</a></li>
                                    <li><a chref="#">Feeding Accessories</a></li>
                                    <li><a href="#">Feeding Bottle Cleaning</a></li>
                                    <li><a href="#">Kitchen Appliances</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BABY FOOD & INFANT FORMULA</h4>
                                    </li>
                                    <li><a href="#">Dry Milk Powder / Formula</a></li>
                                    <li><a href="#">Porridge/Cereals/Grains </a></li>
                                    <li><a href="">MPuree - Fruits & Vegetables</a></li>
                                    <li><a href="#">Finger Food / Snacks</a></li>
                                    <li><a href="#">Add on Nutritional Mix</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>FEEDING BOTTLE CLEANING</h4>
                                    </li>
                                    <li><a href="#">Bottle & Nipple Cleaning Brushes</a></li>
                                    <li><a href="#">Drying Racks</a></li>
                                    <li><a href="#">Cleaning Combo Sets</a></li>
                                    <li><a href="#">Bottle Tongs</a></li>
                                    <li><a href="#"></a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>STERLIZERS & WARMERS</h4>
                                    </li>
                                    <li><a href="#">Bottle Sterilizers</a></li>
                                    <li><a href="#">Bottle & Food Warmers</a></li>
                                    <li><a href="#">Multipurpose Sterilizers</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BREAST FEEDING</h4>
                                    </li>
                                    <li><a href="#">Breast Pumps</a></li>
                                    <li><a href="#">Electric Breast Pump</a></li>
                                    <li><a href="">Manual Breast Pump</a></li>
                                    <li><a href="#">Breast Pads</a></li>
                                    <li><a href="#">Nipple Shields</span></a></li>
                                    <li><a href="#">Nipple Pullers</a></li>
                                    <li><a href="#">Breast Milk Storage</a></li>
                                    <li><a href="#">Feeding Pillows <br> & Covers</a></li>
                                    <li><a href="#">Nursing Covers & Bibs</a></li>
                                    <li><a href="#">Nursing Bras</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>BIBS & HANKY</h4>
                                    </li>
                                    <li><a href="#">Bibs</a></li>
                                    <li><a href="#">Burp/Wash Clothes</a></li>
                                    <li><a href="#">Hanky / Napkins</a></li>
                                    <li><a href="#">Aprons</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SUPER SAVERS</h4>
                                    </li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>FEEDING BOTTLES & ACC.</h4>
                                    </li>
                                    <li><a href="#">Feeding Bottles</a></li>
                                    <li><a href="#">Nipples & Teats</a></li>
                                    <li><a href="">Food Feeder</a></li>
                                    <li><a href="#">Fruit & Food Nibbler</a></li>
                                    <li><a href="#">Bottle Covers & Insulated Bags</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SIPPERS & CUPS</h4>
                                    </li>
                                    <li><a href="#">Spout Sippers</a></li>
                                    <li><a href="#">Straw Sippers</a></li>
                                    <li><a href="#">Tumblers</a></li>
                                    <li><a href="#">Mugs</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>TEETHERS & PACIFIERS</h4>
                                    </li>
                                    <li><a href="#">Silicone Teethers</a></li>
                                    <li><a href="#">Water Filled Silicone Teethers</a></li>
                                    <li><a href="#">Orthodontic Pacifiers</a></li>
                                    <li><a href="#">Pacifiers</a></li>
                                    <li><a href="#">Rattle Teethers</a></li>
                                    <li><a href="#">Wooden Teethers</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>KIDS FOODS & SUPPLEMENTS</h4>
                                    </li>
                                    <li><a href="#">Health Drinks & Powders</a></li>
                                    <li><a href="#">Breakfast & Cereals</a></li>
                                    <li><a href="">Ready to Cook</a></li>
                                    <li><a href="#">Dry Fruits, Nuts & Seeds</a></li>
                                    <li><a href="#">Snacks & Finger Food</a></li>
                                    <li><a href="#">Biscuits & Cookies</a></li>
                                    <li><a href="#">Chocolates, Candies & Sweets</a></li>
                                    <li><a href="#">Vitamin Gummies</a></li>
                                    <li><a href="#">Spreads, Jams & Ketchup</a></li>
                                    <li><a href="#">Ghee & Cooking Oils</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>DISHES & UTENSILS</h4>
                                    </li>
                                    <li><a href="#">Bowls, Containers & Dispensers</a></li>
                                    <li><a href="#">Cutlery</a></li>
                                    <li><a href="#">Feeding Sets</a></li>
                                    <li><a href="#">Pacifiers</a></li>
                                    <li><a href="#">Dishes</a></li>
                                    <li><a href="#">Milk Powder Containers</a></li>
                                    <li><a href="#">Milk Tableware</a></li>
                                    <li><a href="#">Milk Drinkware</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>KITCHEN APPLIANCES</h4>
                                    </li>
                                    <li><a href="#">High Chairs and Booster Sheets</a></li>
                                    <li><a href="#">TOP BRANDS</a></li>
                                    <li><a href="">Babyhug</a></li>
                                    <li><a href="#">Nestle</a></li>
                                    <li><a href="#">Medela</a></li>
                                    <li><a href="#">Chicco</a></li>
                                    <li><a href="#">Pigeon</a></li>
                                    <li><a href="#">Aptamil</a></li>
                                    <li><a href="#">Enfagrow</a></li>
                                    <li><a href="#">Enfamil</a></li>
                                    <li><a href="#">PediaSure</a></li>
                                    <li><a href="#">Similac</a></li>
                                    <li><a href="#">Mee Mee</a></li>
                                    <li><a href="#">Rattle Teethers</a></li>
                                    <li><a href="#">Luv Lap</a></li>
                                    <li><a href="#">Early Foods</a></li>
                                    <li><a href="#">timios</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                {{-- <div class="z-depth-1 polariod">
                                    <img src="" alt="" class="theme responsive-img">

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </li>

                <li> <a href="#" class="drp-btn">Health</a>
                    <div class="mega-menu-container">
                        <div class="mega-menu-grid">
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>SHOP BY CATEGORY</h4>
                                    </li>
                                    <li><a href="#">Baby Food & <br>Infant Formula</a></li>
                                    <li><a href="#">Feeding Bottles & Teats</a></li>
                                    <li><a href="">Breast Feeding</a></li>
                                    <li><a href="#">Sippers & Cupsa</li>
                                    <li><a href="#">Bibs & Hankies</a></li>
                                    <li><a href="#">Kids Foods & Supplements</a></li>
                                    <li><a href="#">Dishes & Utensils</a></li>
                                    <li><a href="#">Teethers & Pacifiers</a></li>
                                    <li><a href="#">Sterilizers & Warmers</a></li>
                                    <li><a chref="#">Feeding Accessories</a></li>
                                    <li><a href="#">Feeding Bottle Cleaning</a></li>
                                    <li><a href="#">Kitchen Appliances</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BABY FOOD & INFANT FORMULA</h4>
                                    </li>
                                    <li><a href="#">Dry Milk Powder / Formula</a></li>
                                    <li><a href="#">Porridge/Cereals/Grains </a></li>
                                    <li><a href="">MPuree - Fruits & Vegetables</a></li>
                                    <li><a href="#">Finger Food / Snacks</a></li>
                                    <li><a href="#">Add on Nutritional Mix</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>FEEDING BOTTLE CLEANING</h4>
                                    </li>
                                    <li><a href="#">Bottle & Nipple Cleaning Brushes</a></li>
                                    <li><a href="#">Drying Racks</a></li>
                                    <li><a href="#">Cleaning Combo Sets</a></li>
                                    <li><a href="#">Bottle Tongs</a></li>
                                    <li><a href="#"></a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>STERLIZERS & WARMERS</h4>
                                    </li>
                                    <li><a href="#">Bottle Sterilizers</a></li>
                                    <li><a href="#">Bottle & Food Warmers</a></li>
                                    <li><a href="#">Multipurpose Sterilizers</a></li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>BREAST FEEDING</h4>
                                    </li>
                                    <li><a href="#">Breast Pumps</a></li>
                                    <li><a href="#">Electric Breast Pump</a></li>
                                    <li><a href="">Manual Breast Pump</a></li>
                                    <li><a href="#">Breast Pads</a></li>
                                    <li><a href="#">Nipple Shields</span></a></li>
                                    <li><a href="#">Nipple Pullers</a></li>
                                    <li><a href="#">Breast Milk Storage</a></li>
                                    <li><a href="#">Feeding Pillows <br> & Covers</a></li>
                                    <li><a href="#">Nursing Covers & Bibs</a></li>
                                    <li><a href="#">Nursing Bras</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>BIBS & HANKY</h4>
                                    </li>
                                    <li><a href="#">Bibs</a></li>
                                    <li><a href="#">Burp/Wash Clothes</a></li>
                                    <li><a href="#">Hanky / Napkins</a></li>
                                    <li><a href="#">Aprons</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SUPER SAVERS</h4>
                                    </li>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>FEEDING BOTTLES & ACC.</h4>
                                    </li>
                                    <li><a href="#">Feeding Bottles</a></li>
                                    <li><a href="#">Nipples & Teats</a></li>
                                    <li><a href="">Food Feeder</a></li>
                                    <li><a href="#">Fruit & Food Nibbler</a></li>
                                    <li><a href="#">Bottle Covers & Insulated Bags</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>SIPPERS & CUPS</h4>
                                    </li>
                                    <li><a href="#">Spout Sippers</a></li>
                                    <li><a href="#">Straw Sippers</a></li>
                                    <li><a href="#">Tumblers</a></li>
                                    <li><a href="#">Mugs</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>TEETHERS & PACIFIERS</h4>
                                    </li>
                                    <li><a href="#">Silicone Teethers</a></li>
                                    <li><a href="#">Water Filled Silicone Teethers</a></li>
                                    <li><a href="#">Orthodontic Pacifiers</a></li>
                                    <li><a href="#">Pacifiers</a></li>
                                    <li><a href="#">Rattle Teethers</a></li>
                                    <li><a href="#">Wooden Teethers</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>KIDS FOODS & SUPPLEMENTS</h4>
                                    </li>
                                    <li><a href="#">Health Drinks & Powders</a></li>
                                    <li><a href="#">Breakfast & Cereals</a></li>
                                    <li><a href="">Ready to Cook</a></li>
                                    <li><a href="#">Dry Fruits, Nuts & Seeds</a></li>
                                    <li><a href="#">Snacks & Finger Food</a></li>
                                    <li><a href="#">Biscuits & Cookies</a></li>
                                    <li><a href="#">Chocolates, Candies & Sweets</a></li>
                                    <li><a href="#">Vitamin Gummies</a></li>
                                    <li><a href="#">Spreads, Jams & Ketchup</a></li>
                                    <li><a href="#">Ghee & Cooking Oils</a></li>
                                    <div class="box"></div>
                                    <li class="collection-item">
                                        <h4>DISHES & UTENSILS</h4>
                                    </li>
                                    <li><a href="#">Bowls, Containers & Dispensers</a></li>
                                    <li><a href="#">Cutlery</a></li>
                                    <li><a href="#">Feeding Sets</a></li>
                                    <li><a href="#">Pacifiers</a></li>
                                    <li><a href="#">Dishes</a></li>
                                    <li><a href="#">Milk Powder Containers</a></li>
                                    <li><a href="#">Milk Tableware</a></li>
                                    <li><a href="#">Milk Drinkware</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <h4>KITCHEN APPLIANCES</h4>
                                    </li>
                                    <li><a href="#">High Chairs and Booster Sheets</a></li>
                                    <li><a href="#">TOP BRANDS</a></li>
                                    <li><a href="">Babyhug</a></li>
                                    <li><a href="#">Nestle</a></li>
                                    <li><a href="#">Medela</a></li>
                                    <li><a href="#">Chicco</a></li>
                                    <li><a href="#">Pigeon</a></li>
                                    <li><a href="#">Aptamil</a></li>
                                    <li><a href="#">Enfagrow</a></li>
                                    <li><a href="#">Enfamil</a></li>
                                    <li><a href="#">PediaSure</a></li>
                                    <li><a href="#">Similac</a></li>
                                    <li><a href="#">Mee Mee</a></li>
                                    <li><a href="#">Rattle Teethers</a></li>
                                    <li><a href="#">Luv Lap</a></li>
                                    <li><a href="#">Early Foods</a></li>
                                    <li><a href="#">timios</a></li>
                                    <div class="box"></div>
                                </ul>
                            </div>
                            <div class="sub-nav-column">
                                {{-- <div class="z-depth-1 polariod">
                                    <img src="" alt="" class="theme responsive-img">

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
