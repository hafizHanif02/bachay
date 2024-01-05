<div class="products mt-4 pb-5 container-xxl">

    <div class="MyProfile-heading font-poppins bottom-border pb-3">
        <span>Home ></span> <span>My Account ></span> <span>My Profile</span>
    </div>

    <div class="font-poppins bottom-border pb-3 pt-3">
        <h4 class="fw-bold m-0">
            My Account
        </h4>
    </div>

    <div class="row mt-4">
        @include('layouts.front-end.my-profile.aside')
        <div class="col-9 ps-4">
            <div class="MyAccount font-poppins">
                <h6 class="fw-bold m-0 rounded-pill">
                    Invites & Friends
                </h6>
            </div>
            <div class="mt-5 bottom-border pb-5">
                <img class="object-fit-cover rounded-5" src="{{ asset('public /images/banner-credits.png') }}"
                    alt="" width="100%" height="100%">
            </div>
            <form action="" class="mt-5 font-poppins">

                <input class="col-12 rounded-pill p-4 mb-4 for-border3 bg-transparent" type="email" name="Email"
                    id="email" placeholder="Enter Email Address Here" required>

                <div>
                    <textarea class="col-12 rounded-5 p-4 mb-4 for-border3 bg-transparent" name="Message" id="message" cols="30"
                        rows="8" placeholder="message:" required></textarea>
                </div>
                <button class="col-12 rounded-pill text-white bg-purple border-0 pt-4 pb-4 ">Send Invites</button>
            </form>
            <div class="MyAccount font-poppins mt-5">
                <h6 class="fw-bold m-0 rounded-pill">
                    Invites & Credits
                </h6>
            </div>
            <div
                class="d-flex justify-content-between align-items-center  rounded-pill for-border3 pt-3 pb-3 ps-4 pe-4 mb-4 font-poppins mt-4">
                <div class="col">Contact</div>
                <div class="col">Registered On</div>
                <div class="col">Order Details</div>
                <div class="col">Cashback Details</div>


            </div>
            <div class="MyAccount font-poppins mt-5">
                <h6 class="fw-bold m-0 rounded-pill">
                    How Does It Work?
                </h6>
            </div>

            <ol class="invitesCredits mt-4">
                <li>To invite your friends to Bachay, enter their email address in the box provided and send the invite
                    or share the customize link. </li>
                <li> You can invite 50 of your friends at one go by importing your contact list, choosing your friends
                    to refer and sending the invite.</li>
                <li> Once you send an invite, you can visit the dashboard anytime to check the status of your referrals.
                    The dashboard may take up to 24 hours to reflect the status.</li>
                <li> Your friends will get an invite with coupons worth 2500 to shop on Bachay. You can preview the
                    invitation here.</li>
                <li>Your referrals who are previously registered with Bachay will not receive an invite. </li>
                <li> Every time a referred friend registers, we send you and your friend a coupon worth Rs. 200 as a
                    token of our appreciation. </li>
                <li>Once your referred friend makes their first purchase at Bachay & once the order is delivered, you
                    will get a Coupon worth 20% of the order value of your referred friend which will be capped to a max
                    of Rs. 1000 per order. This will be sent to you at the end of the month in which the order was
                    delivered.</li>
                <li> <a class="text-dark fw-bold text-decoration-none" href="">Click here</a>, to write to our customer care team if you have any queries regarding invite and
                    credits.</li>

            </ol>
            <div class="MyAccount font-poppins mt-5">
                <h6 class="fw-bold m-0 rounded-pill text-center">
                    There is no Gift Certificate which has been gifted to you.
                </h6>
            </div>
        </div>



    </div>

</div>
