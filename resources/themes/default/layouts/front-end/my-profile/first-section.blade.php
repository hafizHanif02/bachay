<div class="products mt-4 pb-5">

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
                    My Profile
                </h6>
            </div>
            <div id="personalDetails" class="d-flex justify-content-between align-items-center mt-5">
                <div class="MyProfile-con d-flex align-items-center">
                    <div class="MyProfile-img col-4 rounded-circle me-3">
                        <img class="object-fit-cover rounded-circle" src="{{ asset('public/images/profile-img.png') }}"
                            alt="" width="100%" height="100%">
                    </div>
                    <div class="MyProfile-info font-poppins">
                        <h4 class="fw-bold m-0">
                            
                            {{ $userData->f_name }}
                            @dd()
                            
                         
                        </h4>
                        <h6 class="m-0">
                            <img src="{{ asset('public/images/mother-icon.svg') }}" alt=""> Mother Of 03
                        </h6>
                        <h6 class="m-0">
                            <img src="{{ asset('public/images/child-icon.svg') }}" alt=""> 2 Boys 1 Girl
                        </h6>
                    </div>
                </div>
                <div class="profile-edit">
                    <a class="font-poppins" href=""> <img src="{{ asset('public/images/edit-icon.svg') }}"
                            alt=""> Edit</a>
                </div>
            </div>
            <div id="contactDetails" class="MyContact mt-5 font-poppins d-flex justify-content-between align-items-center rounded-pill">
                <h6 class="fw-bold m-0  ps-4">
                    My Account
                </h6>
                <div class="contact-edit">
                    <a class="font-poppins me-4" href=""> <img class="cntct-edit"
                            src="{{ asset('public/images/edit-colored-icon.svg') }}" alt=""> Edit</a>
                </div>
            </div>
            <div class="contact-details col-12 d-flex mt-4">
                <ul class="font-poppins col-6 mt-4">
                    <li class="">
                        <div class="d-flex">
                            <div class="font-gray">
                                <h6 class="mb-4"> Email Id:</h6>
                                <h6 class="mb-4"> Mobile No:</h6>
                            </div>
                            <div class="ms-5 font-color">
                                <h6 class="mb-4">{{ $userData->email }}</h6>
                                <h6 class="mb-4">{{ (!empty($userData->mobile)?$userData->mobile:'-') }}</h6>

                            </div>
                        </div>
                    </li>
                    <li class="mb-4"><img src="{{ asset('public/images/check-sign-small.png') }}" alt="">
                        Your
                        Mobile Number has
                        been Verified
                    </li>
                    <li><a class="text-decoration-none text-dark" href="">Find a Bachay Store Near You</a></li>
                </ul>
                <ul class="col-6 font-poppins mt-4">
                    <li class="mb-4">
                        <h6 class="m-0">Your Mobile Number is Verified</h6>
                    </li>
                    <li>By verifying your mobile number with us you can now Shop'n'Earn Club Cash at our FirstCry.com
                        stores too! To earn Club Cash on store purchases, simply provide your verified mobile number at
                        the time of billing. <br> <a class="fw-bold" href="">T&C Apply</a> </li>
                </ul>
            </div>

            <div id="childDetails" class="MyContact mt-5 font-poppins d-flex justify-content-between align-items-center rounded-pill">
                <h6 class="fw-bold m-0  ps-4">
                    Child Details
                </h6>
                <div class="contact-edit">
                    <a class="font-poppins me-4" href=""> <img class="cntct-edit"
                            src="{{ asset('public/images/plus-sign.svg') }}" alt=""> Add Child</a>
                </div>
            </div>

            <div class=" align-items-center mt-5">
                <ul class="child-details">
                    <li class="mt-4">
                        <div class="d-flex justify-content-between">
                            <div class="MyProfile-con d-flex align-items-center">
                                <div class="Boy-img col-4 rounded-circle me-3">
                                    <img class="object-fit-cover rounded-circle"
                                        src="{{ asset('public/images/boy-img.png') }}" alt="" width="100%"
                                        height="100%">
                                </div>
                                <div class="child-details-info font-poppins">
                                    <h4 class="fw-bold m-0">
                                        Child Name 01
                                    </h4>
                                    <h6 class="m-0">
                                        Age 3 Years 6 Months
                                    </h6>
                                    <h6 class="m-0">
                                        Male - 13 Kg
                                    </h6>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="mt-2 btn-delete ps-4 pe-4 p-2 rounded-pill text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13"
                                        viewBox="0 0 14 13" fill="none">
                                        <path d="M7.83164 9.71592L6.18164 8.06592" stroke="#EC1515"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M7.81602 8.08392L6.16602 9.73392" stroke="#EC1515"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5.08411 0.5L2.91211 2.678" stroke="#EC1515" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8.91211 0.5L11.0841 2.678" stroke="#EC1515" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M1 4.01006C1 2.90006 1.594 2.81006 2.332 2.81006H11.668C12.406 2.81006 13 2.90006 13 4.01006C13 5.30006 12.406 5.21006 11.668 5.21006H2.332C1.594 5.21006 1 5.30006 1 4.01006Z"
                                            stroke="#EC1515" />
                                        <path
                                            d="M1.90039 5.29999L2.74639 10.484C2.93839 11.648 3.40039 12.5 5.11639 12.5H8.73439C10.6004 12.5 10.8764 11.684 11.0924 10.556L12.1004 5.29999"
                                            stroke="#EC1515" stroke-linecap="round" />
                                    </svg> Delete</button>

                                <button class="mt-2 btn-edit ps-4 pe-4 p-2 rounded-pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                        viewBox="0 0 13 13" fill="none">
                                        <path
                                            d="M5.88862 1.13647H4.80226C2.08636 1.13647 1 2.22283 1 4.93874V8.19782C1 10.9137 2.08636 12.0001 4.80226 12.0001H8.06134C10.7772 12.0001 11.8636 10.9137 11.8636 8.19782V7.11146"
                                            stroke="#292D32" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M8.62644 1.69051L4.34618 5.97077C4.18322 6.13372 4.02027 6.4542 3.98768 6.68776L3.75411 8.32274C3.6672 8.9148 4.08545 9.32762 4.67752 9.24614L6.31249 9.01258C6.54062 8.97998 6.8611 8.81703 7.02949 8.65408L11.3097 4.37382C12.0485 3.63509 12.3961 2.77687 11.3097 1.69051C10.2234 0.604146 9.36516 0.951781 8.62644 1.69051Z"
                                            stroke="#292D32" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M8.0127 2.30426C8.37663 3.60246 9.39237 4.61821 10.696 4.98757"
                                            stroke="#292D32" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg> Edit</button>


                            </div>
                        </div>
                    </li>
                    <li class="mt-4">
                        <div class="d-flex justify-content-between">
                            <div class="MyProfile-con d-flex align-items-center">
                                <div class="Boy-img col-4 rounded-circle me-3">
                                    <img class="object-fit-cover rounded-circle"
                                        src="{{ asset('public/images/boy-img.png') }}" alt="" width="100%"
                                        height="100%">
                                </div>
                                <div class="child-details-info font-poppins">
                                    <h4 class="fw-bold m-0">
                                        Child Name 01
                                    </h4>
                                    <h6 class="m-0">
                                        Age 3 Years 6 Months
                                    </h6>
                                    <h6 class="m-0">
                                        Male - 13 Kg
                                    </h6>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="mt-2 btn-delete ps-4 pe-4 p-2 rounded-pill text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13"
                                        viewBox="0 0 14 13" fill="none">
                                        <path d="M7.83164 9.71592L6.18164 8.06592" stroke="#EC1515"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M7.81602 8.08392L6.16602 9.73392" stroke="#EC1515"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5.08411 0.5L2.91211 2.678" stroke="#EC1515" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8.91211 0.5L11.0841 2.678" stroke="#EC1515" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M1 4.01006C1 2.90006 1.594 2.81006 2.332 2.81006H11.668C12.406 2.81006 13 2.90006 13 4.01006C13 5.30006 12.406 5.21006 11.668 5.21006H2.332C1.594 5.21006 1 5.30006 1 4.01006Z"
                                            stroke="#EC1515" />
                                        <path
                                            d="M1.90039 5.29999L2.74639 10.484C2.93839 11.648 3.40039 12.5 5.11639 12.5H8.73439C10.6004 12.5 10.8764 11.684 11.0924 10.556L12.1004 5.29999"
                                            stroke="#EC1515" stroke-linecap="round" />
                                    </svg> Delete</button>

                                <button class="mt-2 btn-edit ps-4 pe-4 p-2 rounded-pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                        viewBox="0 0 13 13" fill="none">
                                        <path
                                            d="M5.88862 1.13647H4.80226C2.08636 1.13647 1 2.22283 1 4.93874V8.19782C1 10.9137 2.08636 12.0001 4.80226 12.0001H8.06134C10.7772 12.0001 11.8636 10.9137 11.8636 8.19782V7.11146"
                                            stroke="#292D32" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M8.62644 1.69051L4.34618 5.97077C4.18322 6.13372 4.02027 6.4542 3.98768 6.68776L3.75411 8.32274C3.6672 8.9148 4.08545 9.32762 4.67752 9.24614L6.31249 9.01258C6.54062 8.97998 6.8611 8.81703 7.02949 8.65408L11.3097 4.37382C12.0485 3.63509 12.3961 2.77687 11.3097 1.69051C10.2234 0.604146 9.36516 0.951781 8.62644 1.69051Z"
                                            stroke="#292D32" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M8.0127 2.30426C8.37663 3.60246 9.39237 4.61821 10.696 4.98757"
                                            stroke="#292D32" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg> Edit</button>


                            </div>
                        </div>
                    </li>
                    <li class="mt-4">
                        <div class="d-flex justify-content-between">
                            <div class="MyProfile-con d-flex align-items-center">
                                <div class="Boy-img col-4 rounded-circle me-3">
                                    <img class="object-fit-cover rounded-circle"
                                        src="{{ asset('public/images/boy-img.png') }}" alt="" width="100%"
                                        height="100%">
                                </div>
                                <div class="child-details-info font-poppins">
                                    <h4 class="fw-bold m-0">
                                        Child Name 01
                                    </h4>
                                    <h6 class="m-0">
                                        Age 3 Years 6 Months
                                    </h6>
                                    <h6 class="m-0">
                                        Male - 13 Kg
                                    </h6>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="mt-2 btn-delete ps-4 pe-4 p-2 rounded-pill text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13"
                                        viewBox="0 0 14 13" fill="none">
                                        <path d="M7.83164 9.71592L6.18164 8.06592" stroke="#EC1515"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M7.81602 8.08392L6.16602 9.73392" stroke="#EC1515"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5.08411 0.5L2.91211 2.678" stroke="#EC1515" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8.91211 0.5L11.0841 2.678" stroke="#EC1515" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M1 4.01006C1 2.90006 1.594 2.81006 2.332 2.81006H11.668C12.406 2.81006 13 2.90006 13 4.01006C13 5.30006 12.406 5.21006 11.668 5.21006H2.332C1.594 5.21006 1 5.30006 1 4.01006Z"
                                            stroke="#EC1515" />
                                        <path
                                            d="M1.90039 5.29999L2.74639 10.484C2.93839 11.648 3.40039 12.5 5.11639 12.5H8.73439C10.6004 12.5 10.8764 11.684 11.0924 10.556L12.1004 5.29999"
                                            stroke="#EC1515" stroke-linecap="round" />
                                    </svg> Delete</button>

                                <button class="mt-2 btn-edit ps-4 pe-4 p-2 rounded-pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                        viewBox="0 0 13 13" fill="none">
                                        <path
                                            d="M5.88862 1.13647H4.80226C2.08636 1.13647 1 2.22283 1 4.93874V8.19782C1 10.9137 2.08636 12.0001 4.80226 12.0001H8.06134C10.7772 12.0001 11.8636 10.9137 11.8636 8.19782V7.11146"
                                            stroke="#292D32" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M8.62644 1.69051L4.34618 5.97077C4.18322 6.13372 4.02027 6.4542 3.98768 6.68776L3.75411 8.32274C3.6672 8.9148 4.08545 9.32762 4.67752 9.24614L6.31249 9.01258C6.54062 8.97998 6.8611 8.81703 7.02949 8.65408L11.3097 4.37382C12.0485 3.63509 12.3961 2.77687 11.3097 1.69051C10.2234 0.604146 9.36516 0.951781 8.62644 1.69051Z"
                                            stroke="#292D32" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M8.0127 2.30426C8.37663 3.60246 9.39237 4.61821 10.696 4.98757"
                                            stroke="#292D32" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg> Edit</button>


                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div id="myAddress" class="MyAccount font-poppins mt-5">
                <h6 class="fw-bold m-0 rounded-pill">
                    My Address Book
                </h6>
            </div>
            <div class="AddressDelivery mt-4 mb-4 ">
                <ul>
                    <li>Add an Address for delivery in your address book and make checkout faster.</li>
                </ul>
            </div>
            <div class="">
                <form class="MyProfileForm font-poppins" id="addAddressForm" action="{{ route('address.store') }}" method="POST" >
                    @csrf
                    @auth('customer')
                    <input type="hidden" name="customer_id" value="{{ auth('customer')->user()->id }}">
                    @endauth
                    <input type="text" id="house_no" name="house_no" value="{{$userData->house_no}}" placeholder="Flat/House No/Building"
                        required><br>
                    <input type="text" id="street_address" name="street_address" value="{{$userData->street_address}}" placeholder="Street Address/Colony"
                        required><br>
                    <input type="text" id="country" name="country" value="{{$userData->country}}"  placeholder="Country"
                        required><br>
                    <input type="text" id="state" name="state" value="Pakistan"  placeholder="State"
                        required><br>
                    <input type="text" id="state" name="address_type"   placeholder="Address Type"
                        required><br>
                    <div class="form-group">
                        <input type="text" id="zip" name="zip" value="{{$userData->zip}}"  placeholder="Zip" required>
                        <input type="text" id="city" name="city" value="{{$userData->city}}"  placeholder="City" required>
                    </div>
                    <input type="text" id="apartment_no" name="apartment_no" value="{{$userData->apartment_no}}"  placeholder="Apartment No" required><br>
                    <div class="form-group">
                        <button type="submit" class="rounded-pill text-white" type="submit">Save</button>
                        <button class="rounded-pill fw-semibold" type="button">Cancel</button>

                    </div>
                </form>
            </div>

            <div id="changePassword" class="MyAccount font-poppins mt-5">
                <h6 class="fw-bold m-0 rounded-pill">
                    Change Password
                </h6>
            </div>

            <div class="ChangePassword mt-5 font-poppins">
                <form action="{{ route('change-password') }}" method="POST" >
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ auth('customer')->user()->id }}">
                    <div class="currentPassword d-flex justify-content-between align-items-center mb-3">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" id="currentPassword" name="current_password" placeholder="Previous Password" required>
                    </div>
                    <div class="newPassword d-flex justify-content-between align-items-center mb-3">
                        <label for="newPassword">New Password</label>
                        <input type="password" id="newPassword" name="new_password" placeholder="New Password"  required>
                    </div>
                    <div class="confirmPassword d-flex justify-content-between align-items-center mb-3">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Re-type Password" required>
                    </div>
                    <div id="passwordMatchError" style="color: red;"></div>
                    <a class="text-decoration-none text-purple fw-semibold" href="">Note: Password must be at
                        least 8 characters long with 1 Uppercase, 1 Lowercase & 1 Numeric character.</a>
                    <div class="form-group mt-4">
                        <button type="submit" class="rounded-pill text-white" type="submit">Save</button>
                        <button class="rounded-pill fw-semibold" type="button">Cancel</button>

                    </div>

                </form>
            </div>

            <div id="manageSubs" class="MyAccount font-poppins mt-5">
                <h6 class="fw-bold m-0 rounded-pill">
                    My Subscription
                </h6>
            </div>
            <div class="toggle-btn font-poppins fw-semibold">
                <ul>
                    <li class="d-flex align-items-center mt-4">
                        Receive our Top Offer Details Via Emails <label class="ms-3 switch">
                            <input name="checkbox1" id="CheckBox1" type="checkbox">
                            <span class="se round"></span>
                        </label>
                    </li>
                    <li class="d-flex align-items-center mt-4">
                        Receive Top Deals Via SMS <label class="ms-3 switch">
                            <input name="checkbox2" id="CheckBox2" type="checkbox">
                            <span class="se round"></span>
                        </label>
                    </li>
                </ul>
            </div>


        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $("#confirmPassword").keyup(function () {
            var newPassword = $("#newPassword").val();
            var confirmPassword = $(this).val();

            if (newPassword !== confirmPassword) {
                $("#passwordMatchError").text("Password does not match").css("color", "red");
            } else {
                $("#passwordMatchError").text(""); // Clear the error message
            }
        });
    });
</script>

