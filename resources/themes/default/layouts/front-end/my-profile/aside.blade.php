<div class="col-3 border-right font-poppins">
    <div class="MyProfile">
        <a href="{{ route('my-profile') }}">

            <button
                class="col-12 border-0 rounded-pill text-start p-3 {{ request()->routeIs('my-profile') ? 'buttons-active' : 'buttons' }}">
                My Profile
            </button>

        </a>
    </div>
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
                class="col-12 border-0 rounded-pill text-start p-3 {{ request()->routeIs(['my-order'], ['manage-returns'], ['quick-reorder'], ['track-orders'], ['your-query']) ? 'buttons-active' : 'buttons' }}">My
                Orders</button>
        </a>
    </div>
    <div class="col-12 mt-3">
        <ul class="MyProfile-ul p-0 ps-3">
            <li><a class="{{ request()->routeIs('my-order') ? 'active' : '' }}" href="{{ route('my-order') }}">Order
                    History</a></li>
            <li><a class="{{ request()->routeIs('manage-returns') ? 'active' : '' }}"
                    href="{{ route('manage-returns') }}">Manage Returns</a></li>
            <li><a class="{{ request()->routeIs('quick-reorder') ? 'active' : '' }}"
                    href="{{ route('quick-reorder') }}">Quick Reorder</a></li>
            <li><a class="{{ request()->routeIs('track-orders') ? 'active' : '' }}"
                    href="{{ route('track-orders') }}">Track Order</a></li>
            <li><a class="{{ request()->routeIs('your-query') ? 'active' : '' }}"
                    href="{{ route('your-query') }}">Your Queries</a></li>
        </ul>
    </div>
    <div class="MyProfile mt-2">

        <a href="#">
            <button class="col-12 border-0 rounded-pill text-start p-3 {{ request()->routeIs(['club-cash', 'cash-refund', 'my-payment-detail-not-added', 'my-payment-detail-added', 'save-cards', 'cash-coupons', 'cash-back-codes', 'my-refund-no-refund', 'my-bpl-vouchers']) ? 'buttons-active' : 'buttons' }}">Cash in My Account</button>

        </a>

    </div>
    <div class="col-12 mt-3">
        <ul class="MyProfile-ul p-0 ps-3">
            <li><a href="#">Club Cash</a></li>
            <li><a class="{{ request()->routeIs('cash-refund') ? 'active' : '' }}"
                    href="{{ route('cash-refund') }}">Cash Refund</a></li>
            <li><a class="{{ request()->routeIs(['my-payment-detail-not-added', 'my-payment-detail-added', 'save-cards']) ? 'active' : '' }}"
                    href="{{ route('my-payment-detail-not-added') }}">My Payment Details</a>
            </li>
            <li><a class="{{ request()->routeIs('cash-coupons') ? 'active' : '' }}"
                    href="{{ route('cash-coupons') }}">Cash Coupons</a></li>
            <li><a class="{{ request()->routeIs('cash-back-codes') ? 'active' : '' }}"
                    href="{{ route('cash-back-codes') }}">Cashback Codes</a></li>
            <li><a class="{{ request()->routeIs('my-refund-no-refund') ? 'active' : '' }}"
                    href="{{ route('my-refund-no-refund') }}">My Refunds</a></li>
            <li><a class="{{ request()->routeIs('my-bpl-vouchers') ? 'active' : '' }}"
                    href="{{ route('my-bpl-vouchers') }}">MY BPL Vouchers</a></li>
        </ul>
    </div>
    <div class="MyProfile mt-2 mb-4">
        <a href="{{ route('guaranteed-savings') }}">
            <button class="buttons col-12 border-0 rounded-pill text-start p-3 {{ request()->routeIs('guaranteed-savings') ? 'buttons-active' : 'buttons' }}">Guaranteed Savings</button>
        </a>
    </div>
    <div class="MyProfile mt-2">
        <a href="{{ route('intelli-education') }}">
            <button class="buttons col-12 border-0 rounded-pill text-start p-3 {{ request()->routeIs('intelli-education') ? 'buttons-active' : 'buttons' }} ">Intelli Education</button>
        </a>
    </div>
    <div class="col-12 mt-3">
        <ul class="MyProfile-ul p-0 ps-3">
            <li><a class="{{ request()->routeIs('intelli-education') ? 'active' : '' }}"
                href="{{ route('intelli-education') }}">Intellibaby Subscriptions</a></li>
          
            <li><a href="">Intellikit Subscriptions</a></li>
        </ul>
    </div>

    <div class="MyProfile mt-2 mb-3">
        <a href="#">
            <button class="buttons col-12 border-0 rounded-pill text-start p-3">FitJunior Subscriptions</button>

        </a>
    </div>
    <div class="MyProfile mt-2 mb-3">
        <a href="{{ route('gift-certification') }}">
            <button class="buttons col-12 border-0 rounded-pill text-start p-3 {{ request()->routeIs('gift-certification') ? 'buttons-active' : 'buttons' }}">Gift Certificates</button>

        </a>
    </div>
    <div class="MyProfile mt-2 mb-3">
        <a href="{{ route('invites-credits') }}">
            <button class="buttons col-12 border-0 rounded-pill text-start p-3 {{ request()->routeIs('invites-credits') ? 'buttons-active' : 'buttons' }}">Invites & Credits</button>
        </a>
    </div>
    <div class="MyProfile mt-2 mb-3">
        <a href="{{ route('my-reviews-upload') }}">
            <button class="buttons col-12 border-0 rounded-pill text-start p-3 {{ request()->routeIs('my-reviews-upload') ? 'buttons-active' : 'buttons' }}">My Reviews & Uploads</button>
        </a>
    </div>

    <div class="col-12 mt-3">
        <ul class="MyProfile-ul p-0 ps-3">
            <li><a href="">Notify Me</a></li>
            <li><a href="">My Shortlist</a></li>
        </ul>
    </div>
    <div class="MyProfile mt-2">
        <form action="{{ route('customer.auth.logout') }}" method="GET">
            @csrf
            <button type="submit" class="logout col-12 border-0 rounded-pill text-start p-3 text-white">Logout</button>
        </form>
    </div>

</div>
