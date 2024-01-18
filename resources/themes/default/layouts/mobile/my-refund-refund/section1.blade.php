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
    height: 5px;
    background-color: rgba(0, 0, 0, 0.13);
        }
        .line1 {
    width: 95%;
    height: 1px;
    background-color: #80868E;
        }
        .refund_text{
            font-size: 12px;
        }
        .refund_text1{
            font-size: 12px;
            color: blueviolet;
        }
        .refund_text2{
            color: #F8931B;
            font-size: 12px;
        }
    }
    </style>
    <body>
        <div class="line mt-3"></div>
        <div class="mt-3 ms-3 pe-3">
            <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">My Refunds</h6>
        </div>
        <div class="d-flex justify-content-between p-3 pb-0">
       <p class="mb-0 refund_text">Amount: <br>Date:.</p>
       <div>
       <p class="mb-0 refund_text text-end">1900 <br>12-Oct-2020</p>
    </div>
</div>
<div class="d-flex justify-content-between ps-3 pe-3 pt-2 pb-2">
    <p class="mb-0 refund_text">Status</p>
    <div>
    <p class="mb-0 fw-semibold refund_text1">Refunded</p>
 </div>
</div>
<div class="line1 mt-3 ms-2"></div>
<div class="d-flex justify-content-between p-3 pb-0">
    <p class="mb-0 refund_text">Amount: <br>Date:.</p>
    <div>
    <p class="mb-0 refund_text text-end">1900 <br>12-Oct-2020</p>
 </div>
</div>
<div class="d-flex justify-content-between ps-3 pe-3 pt-2 pb-2">
 <p class="mb-0 refund_text">Status</p>
 <div>
 <p class="mb-0 fw-semibold refund_text2">Processing</p>
</div>
</div>
<div class="line1 mt-3 ms-2"></div>
<div class="d-flex justify-content-between p-3 pb-0">
    <p class="mb-0 refund_text">Amount: <br>Date:.</p>
    <div>
    <p class="mb-0 refund_text text-end">1900 <br>12-Oct-2020</p>
 </div>
</div>
<div class="d-flex justify-content-between ps-3 pe-3 pt-2 pb-2">
 <p class="mb-0 refund_text">Status</p>
 <div>
 <p class="mb-0 fw-semibold refund_text1 text-danger">Refunded</p>
</div>
</div>
    </body>
    </html>