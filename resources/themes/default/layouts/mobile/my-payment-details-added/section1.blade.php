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
        .Bank_details{
background-color: #845DC2;
font-size: 8px;
padding: 0px 53px 0px;
        }
        .save_card{
font-size: 8px;
padding: 0px 53px 0px;
        }
        .bank-account{
        }
        input[type="radio"] {
  width: 1em;
  height: 1em;
  background-color: white;
  border-radius: 50%;
  border: 2px solid white;
  box-shadow: 0 0 0 2px #ddd;
  appearance: none;
  cursor: pointer;
}
input[type="radio"]:checked {
  background-color: #8456B6;
} 
.account_detail{
    font-size: 10px;
            font-weight: 400;
            width: 100%;
}
.address_name{
           
        }
        .Condition_text{
            font-size: 10px;
        }
        .addnew_bank{
            border: 1px solid blueviolet;
            font-size: 8px;
    
            width: 90%;
            background-color: #8456B6;
        }
        .cancel_btn{
            font-size: 8px;
    width: 90%;   
        }
    }
    </style>
    <body>
        <div class="line mt-3"></div>
        <div class="mt-3 ms-3 pe-3">
            <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">My Payment Details</h6>
        </div>
        <div class="d-flex align-items-center p-3">
            <button class="Bank_details rounded-pill pt-3 pb-3 me-3 border-0 text-white fw-semibold">Bank Account Detail</button>
            <div>
                <button class="save_card rounded-pill pt-3 pb-3 border-dark">Save Card & Wallets</button>
            </div> 
        </div>
        <div class="bank-account rounded-pill d-flex justify-content-between align-items-center border border-secondary p-3 m-3">
            <img src="./hbl.png" alt="" width="40px" height="25px">
        
        <div>
            <p class="mb-0">**** ********* ****** 657</p>
        </div>
        <div class="imge">
            <input type="radio" name="group-1"> <span class="me-4"></span>
          </div>
    </div>
    <div class="mt-5 ms-3 pe-3">
   <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">Add Bank Account</h6>
</div>
<div class="m-3">
    <input class=" account_detail rounded-pill p-3 border border-secondary" type="text" placeholder="Enter Name">
</div>
<div class="m-3">
    <input class=" account_detail rounded-pill p-3 border border-secondary" type="text" placeholder="Flat No, House/Building">
</div>
<div class="m-3">
    <input class=" account_detail rounded-pill p-3 border border-secondary" type="text" placeholder="Street Address/Colony">
</div>
<div class="m-3">
    <input class=" account_detail rounded-pill p-3 border border-secondary" type="text" placeholder="Landmark">
</div>
<div class="imge d-flex align-items-center p-3">
    <input type="radio" name="group-1"> <span class="me-2"></span>
    <div>
        <p class="mb-0 Condition_text fw-normal">I agree to Terms & Conditions and here by, confirm that the <br>above details provided by me are correct.</p>
    </div>
  </div>
  <div>
    <button class="addnew_bank rounded-pill p-3 ms-3 fw-semibold text-white">Get OTP</button>
    <button class="cancel_btn rounded-pill pt-3 pb-3 border-dark mt-2 ms-3">Cancel</button>
  </div>
    </body>
    </html>