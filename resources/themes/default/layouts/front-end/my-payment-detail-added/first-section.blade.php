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
                    My Payment Details
                </h6>
            </div>
            <div class="btn-con mt-4 col-12 row justify-content-between ps-3">
                <button class="col-5 mt-2 btn-f rounded-pill p-3 bg-purple text-white border-0">Bank Account Details</button>
                <button class="col-5 mt-2 btn-f rounded-pill p-3 bg-white text-purple border-0">Save Cards & Wallets</button>
            </div>
            <div class="for-border3 rounded-pill d-flex align-items-center justify-content-between mt-5 pt-3 pb-3 ps-4 pe-4">
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        <img class="object-fit-cover" src="{{ asset('public/images/hblbg.png') }}" alt="" width="100%" height="100%">
                        
                    </div>
                    <div class="font-poppins">
                        <h6 class="m-0">
                            **** ********* ****** 657
                        </h6>
                    </div>
    
                </div>
              
                <input type="radio" name="group-1" class="">
    
              
                
    
            </div>
            <div class="MyAccount font-poppins mt-5">
                <h6 class="fw-bold m-0 rounded-pill">
                    Add Bank Account
                </h6>
            </div>  
            <div class="mt-5">
                <form class="MyProfileForm font-poppins">
                    <input type="text" id="full-name" name="full-name" placeholder="Bank Name" required><br>
                    <input type="text" id="house" name="house" placeholder="Bank Account Number" required><br>
                    <input type="text" id="street" name="street" placeholder="Re-Enter Bank Account Number" required><br>
                    <input type="text" id="landmark" name="landmark" placeholder="Account Holder Name" required><br>
                    <div class="radio-container d-flex align-items-center mt-2 mb-4">
                        <input type="radio" id="terms-N-condition" name="termsNcondition" class="m-0 me-2">
                        
                        <label class="fw-bold font-poppins" for="termsNcondition">I agree to Terms & Conditions and here by, confirm that the above details provided by me are correct.</label><br>
                    </div>
                    <button class="rounded-pill bg-purple border-0 text-white col-12 pt-3 pb-3" type="submit">Get OTP</button>
                    <button class="rounded-pill fw-semibold col-12 pt-3 pb-3 mt-3" type="button">Cancel</button>
                </form>
            
     
                
               
            </div>
        </div>



    </div>

</div>
