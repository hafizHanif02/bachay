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
        padding: 0 10px;
    }
    .line {
    width: 100%;
    height: 5px;
    background-color: rgba(0, 0, 0, 0.13);
        }
        .Refund_text{
font-size: 12px;
        }
        .Button{
            color: #D15EAA;
        }
        .Refund_Text{
            background-color: blueviolet;
            font-size: 14px;
        }
        .Refund{
            color: blueviolet;
        }
    }
    </style>
    <body>
        <div class="line mt-3"></div>
        <div class="mt-3 ms-3 pe-3">
            <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">Cash Refund</h6>
        </div>
        <div class="Refund_text rounded-pill bg-dark mt-3">
        <p class="text-white mb-0 p-3 border-0 fw-semibold">You have Rs. 0.00 Cash Refund <span class="Button">Show Now</span> </p>
        </div>
        <p class="p-3 text-center fw-semibold Refund_text">Balance Amount: <span class="Refund"> Rs. 0.00</span></p>
        <div class="Refund_Text rounded-pill">
            <p class="text-white text-center mb-0 p-3 border-0 fw-semibold">Refund Amount</p>
            </div>
            <p class="text-center Refund_text mt-2">You have insufficient balance to initiate <br> cash refund. <span class="Refund"> Refund Policy </span></p>
    </body>
    </html>