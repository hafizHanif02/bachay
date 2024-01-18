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
        .not_details{
            font-size: 12px;
        }
        .addnew_bank{
            border: 1px solid blueviolet;
            font-size: 8px;
            color: #845DC2;
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
            <div class="text-center mt-3">
                <img class="" src="./bank.svg" alt="" width="57px" height="52px">
                <p class="not_details fw-semibold mt-3">You have not added any bank account <br>details yet!</p>
                <button class="addnew_bank rounded-pill p-3 ms-1 fw-semibold">+ Add New Bank Account</button>
            </div>
        </body>
        </html>