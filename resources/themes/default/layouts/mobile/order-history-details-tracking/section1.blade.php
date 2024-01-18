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
        .tracking_text{
            font-size: 12px ;
        }
        .trake_price{
font-size: 10px;
        }
        .ship_text{
            font-size: 10px;
        }
        .shipping_date{
            font-size: 8px;
            font-weight: 400;
        }
        .square{
            width: 3px;
            height: 60px;
            background-color: #845DC2;
            margin-left: 27px;
            margin-top: -18px;
        }
    }
    </style>
    <body>
        <div class="line mt-3"></div>
        <div class="mt-3 ms-3 pe-3">
            <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">Tracking Order Details</h6>
        </div>  
        <div class="d-flex align-items-center p-3">
            <img class="rounded me-2" src="shoes.jpeg" alt="" width="107px" height="107px">
            <div>
                <p class="tracking_text fw-semibold mb-0">Pine Kids Lace Up Casual Shoes Color <br>Block - White</p>
                <p class="trake_price mb-0 fw-semibold">Rs.17789</p>
                <p class="trake_price mb-0">Order Quantity: 02</p>
                <p class="trake_price mb-0">Arrived on Tuesday 10 Oct 23</p>
                <p class="trake_price mb-0">Tracking ID: 111856544875</p>
        </div>
        </div>
        <div class="line"></div>
        <div class="d-flex align-items-center p-3">
            <img class="me-2" src="./check.png" alt="" width="24px" height="24px">
            <div>
                <p class="ship_text mb-0 fw-semibold">Shipment Ready</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
        <div class="square"></div>
        <div class="d-flex align-items-center p-3">
            <img class="me-2" src="./check.png" alt="" width="24px" height="24px">
            <div>
                <p class="ship_text mb-0 fw-semibold">Dispatched</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
        <div class="square"></div>
        <div class="d-flex align-items-center p-3">
            <img class="me-2" src="./check.png" alt="" width="24px" height="24px">
            <div>
                <p class="ship_text mb-0 fw-semibold">Product In Transit</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
        <div class="square"></div>
        <div class="d-flex align-items-center p-3">
            <img class="me-2" src="./croos.png" alt="" width="24px" height="24px">
            <div>
                <p class="ship_text mb-0 fw-semibold">Leave the Warehouse</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
        <div class="square"></div>
        <div class="d-flex align-items-center p-3">
            <img class="me-2" src="./alert.png" alt="" width="24px" height="24px">
            <div>
                <p class="ship_text mb-0 fw-semibold">On the Way</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
        <div class="square"></div>
        <div class="d-flex align-items-center p-3">
            <img class="me-2" src="./way.png" alt="" width="24px" height="24px">
            <div>
                <p class="ship_text mb-0 fw-semibold font-secondary">Delived</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
       
    </body>