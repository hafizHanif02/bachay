<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
        crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <title>cash-refund</title>
    </head>
    <style>
        @media screen and (max-width: 768px){
    body{
        font-family: 'poppins';
        /* padding: 0 10px; */
    }
    .line {
    width: 100%;
    height: 7px;
    background-color: rgba(0, 0, 0, 0.13);
        }
        .email_text{
            font-size: 12px;
        }
        .cancel_text{
            font-size: 8px;
            padding: 0px 80px 0px 80px;
        }
        .verify_btn{
            background-color: blueviolet;
            font-size: 10px;
            padding: 0px 80px 0px 80px;
        }
        .otp_text{
            font-size: 9.500px;
            font-weight: 400;
        }
        .verify_text{
            font-size: 12px;
        }
        .shopping_text{
            background-color: rgba(249, 147, 39, 0.25);
        }
        .apply_text{
            font-size: 9px;
            font-weight: 400;
        }
        .apply_text span{
            color: blueviolet;
            font-weight: 500;
        }
    }
    </style>
    <body>
        <div class="line mt-3"></div>
        <div class="mt-3 ms-3 pe-3">
            <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">Contact Details</h6>
        </div> 
        <div class="d-flex rounded-pill p-3 border border-secondary mt-3 m-3 align-items-center">
            <img class="me-2" src="./msg.svg" alt="" width="10px" height="10px">
            <div>    
        <p class="email_text mb-0">youremail@company.com </p>
        </div>
    </div>
    <div class="d-flex align-items-center p-3 justify-content-between">
        <a class="cancel_text rounded-pill border border-dark pt-3 pb-3 text-decoration-none text-black" href="">Cancel</a>
        <div>
            <a class="verify_btn rounded-pill pt-3 pb-3 text-decoration-none border-0 text-white" href="">Verify</a>
        </div>
    </div>
    <p class="otp_text p-3">A one time password (OTP) will be sent to the above mobile number and <br>email</p>
    <p class="p-3 verify_text fw-semibold">Why should I verify my mobile number</p>
    <div class="shopping_text d-flex p-3 m-3 rounded">
        <img class="me-3" src="./alert.svg" alt="">
        <div>
            <p class="apply_text mb-0">By verifying your mobile number with us you can now <br>
                Shop’n’Earn Club Cash at our Bachay Store too! To earn Club <br>
                Cash on store purchases, simple provided verified mobile <br>
                number at the time of billing. <span>T&C Apply</span></p>
        </div>
    </div>
    </body>
    </html>