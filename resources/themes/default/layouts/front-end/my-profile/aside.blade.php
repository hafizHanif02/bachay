<div class="col-3 border-right font-poppins">
    <div class="MyProfile">
        <a href="{{ route('my-profile') }}">

            <button
                class="col-12 border-0 rounded-pill text-start p-3 {{ request()->routeIs('my-profile') ? 'buttons-active' : 'buttons' }}">
                My Profile
            </button>

        </a>
    </div>
    {{-- <div class="MyProfile">
        <a href="{{ route('my-profile.index') }}">
            <button
                class="col-12 border-0 rounded-pill text-start p-3 {{ request()->routeIs('my-profile.index') ? 'buttons-active' : 'buttons' }}">
                My Profile
            </button>
        </a>
    </div> --}}
    <div class="col-12 mt-3">
        <ul class="MyProfile-ul p-0 ps-3">
            <li><a href="#personalDetails">Personal Details</a></li>
            <li><a href="#contactDetails">Contact Details</a></li>
            <li><a href="#childDetails">Child Details</a></li>
            <li><a href="#myAddress">My Address Book</a></li>
            <li><a href="#changePassword">Change Password</a></li>
            <li><a href="#manageSubs">Manage Subscription</a></li>
        </ul>
    </div>

    <div class="MyProfile mt-2">
        <a href="{{ route('my-order') }}">
            <button
                class="col-12 border-0 rounded-pill text-start p-3 {{ request()->routeIs('my-order') ? 'buttons-active' : 'buttons' }}">My
                Orders</button>
        </a>
    </div>
    <div class="col-12 mt-3">
        <ul class="MyProfile-ul p-0 ps-3">
            <li><a class="{{ request()->routeIs('my-orders') ? 'active' : '' }}" href="{{ route('my-order') }}">Order
                    History</a></li>
            <li><a class="{{ request()->routeIs('manage-returns') ? 'active' : '' }}"
                    href="#">Manage Returns</a></li>
            <li><a class="{{ request()->routeIs('quick-reorder') ? 'active' : '' }}"
                    href="#">Quick Reorder</a></li>
            <li><a class="{{ request()->routeIs('track-order') ? 'active' : '' }}"
                    href="#">Track Order</a></li>
            <li><a class="{{ request()->routeIs('your-queries') ? 'active' : '' }}"
                    href="#">Your Queries</a></li>
        </ul>
    </div>
    <div class="MyProfile mt-2">
        <a href="#">
            <button class="buttons col-12 border-0 rounded-pill text-start p-3">Cash in My Account</button>
        </a>
    </div>
    <div class="col-12 mt-3">
        <ul class="MyProfile-ul p-0 ps-3">
            <li><a href="">Club Cash</a></li>
            <li><a href="">Cash Refund</a></li>
            <li><a href="">My Payment Details</a></li>
            <li><a href="">Cash Coupons</a></li>
            <li><a href="">Cashback Codes</a></li>
            <li><a href="">My Refunds</a></li>
            <li><a href="">MY BPL Vouchers</a></li>
        </ul>
    </div>
    <div class="MyProfile mt-2">
        <a href="">
            <button class="buttons col-12 border-0 rounded-pill text-start p-3">Guaranteed Savings</button>
        </a>
    </div>
    <div class="MyProfile mt-2">
        <a href="">
            <button class="buttons col-12 border-0 rounded-pill text-start p-3">Intelli Education</button>
        </a>
    </div>
    <div class="col-12 mt-3">
        <ul class="MyProfile-ul p-0 ps-3">
            <li><a href="">Club Cash</a></li>
            <li><a href="">Cash Refund</a></li>
        </ul>
    </div>

    <div class="MyProfile mt-2">

        <button class="buttons col-12 border-0 rounded-pill text-start p-3">FitJunior Subscriptions</button>
    </div>
    <div class="MyProfile mt-2">

        <button class="buttons col-12 border-0 rounded-pill text-start p-3">Gift Certificates</button>
    </div>
    <div class="MyProfile mt-2">

        <button class="buttons col-12 border-0 rounded-pill text-start p-3">Invites & Credits</button>
    </div>
    <div class="MyProfile mt-2">

        <button class="buttons col-12 border-0 rounded-pill text-start p-3">My Reviews & Uploads</button>
    </div>

    <div class="col-12 mt-3">
        <ul class="MyProfile-ul p-0 ps-3">
            <li><a href="">Notify Me</a></li>
            <li><a href="">My Shortlist</a></li>
        </ul>
    </div>


    <div class="MyProfile mt-2">
        <form action="#" method="POST">
            @csrf
            <button type="submit" class="logout col-12 border-0 rounded-pill text-start p-3 text-white">Logout</button>
        </form>
    </div>

</div>
