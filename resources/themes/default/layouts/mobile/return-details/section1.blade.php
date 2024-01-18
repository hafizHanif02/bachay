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
        .order_details{
        font-size: 10px;
    }
    .lables_btn{
        width:90%;
        background-color: blueviolet;
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
        .square1{
            width: 3px;
            height: 60px;
            background-color: rgba(41, 45, 50, 0.25);


            margin-left: 27px;
            margin-top: -18px; 
        }
        .Delived_img{
background-color: #CCCCCC;
border: 1px solid #000;
width: 30px;
height: 30px;
padding: 10px;
        }
        .manage_icon{
           
        }
        .record-btn{
            background-color: #845DC2;
            font-size: 10px;
            padding: 0px 40px 0px 40px;
        }
        .concer_btn{
            font-size: 10px;
            padding: 0px 40px 0px 40px;
        }
}
    </style>
    <body>
        <div class="line mt-3"></div>
        <div class="mt-3 ms-3 pe-3">
            <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">Returns Details</h6>
        </div> 
        <div class=" order_details mt-3 p-3">
            <p class="mb-2">Order Number: <span class="fw-semibold">18833462IZTF58B012</span> </p>
                <p class="mb-2">Order Placed: <span class="fw-semibold">Sun, 8th Oct 23, 12:38 AM - 4 Items</span></p>
                <p class="mb-2">Order Status: <span class="fw-semibold">Shipped</span></p>
               <p class="mb-3"> Order Total: <span class="fw-semibold">Rs.3900</span></p>
               <p class="mb-0 fw-semibold">Returned Via Bachay Wallet</p>
        </div>
        <button class="lables_btn rounded-pill p-3 border-0 text-white ms-4">Print Labels</button>
        <div class="line mt-3"></div>
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

        <div class="d-flex align-items-center p-3 justify-content-between">
            <button class="record-btn rounded-pill pt-2 pb-2 me-3 border-0 text-white">
                <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-dash" viewBox="0 0 16 16">
                    <path d="M6.5 7a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                  </svg> Reorder All
            </button>
            <div>
                <button class="concer_btn rounded-pill pt-2 pb-2 border-0">
                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                        <path d="M10.4976 5.06837V7.56777C10.4976 10.0672 9.49783 11.0669 6.99843 11.0669H3.99915C1.49976 11.0669 0.5 10.0672 0.5 7.56777V4.56849C0.5 2.06909 1.49976 1.06934 3.99915 1.06934H6.49855" stroke="#292D32" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.5 5.06837H8.50049C7.00086 5.06837 6.50098 4.56849 6.50098 3.06885V1.06934L10.5 5.06837Z" stroke="#292D32" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 6.56738H5.99927" stroke="#292D32" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 8.56738H4.99952" stroke="#292D32" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>Raise Your Concern
                </button>
            </div>
        </div>
        <div class="line"></div>
        <div class="d-flex align-items-center p-3">
            <img class="me-2" src="./check.png" alt="" width="24px" height="24px">
            <div>
                <p class="ship_text mb-0 fw-semibold">Request Received</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
        <!-- <div class="square"></div> -->
        <div class="manage_icon d-flex align-items-center p-3 position-absolute">
            <img class="me-2" src="./check.png" alt="" width="24px" height="24px">
            <div>
                <p class="ship_text mb-0 fw-semibold">Pick Up Address</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
        <div class="square"></div>
        <div class="d-flex align-items-center p-3 position-absolute">
            <img class="me-2" src="./check.png" alt="" width="24px" height="24px">
            <div>
                <p class="ship_text mb-0 fw-semibold">Logistic Facility</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
        <div class="square"></div>
        <div class="d-flex align-items-center p-3 position-absolute">
            <img class="me-2" src="./croos.png" alt="" width="24px" height="24px">
            <div>
                <p class="ship_text mb-0 fw-semibold">Package Recived</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
        <div class="square"></div>
        <div class="d-flex align-items-center p-3 position-absolute">
            <img class="me-2" src="./alert.png" alt="" width="24px" height="24px">
            <div>
                <p class="ship_text mb-0 fw-semibold">Refund Processing</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
        <div class="square1"></div>
        <div class="d-flex align-items-center p-3 position-absolute">
            <div class="Delived_img rounded-circle me-2"></div>
            <div>
                <p class="ship_text mb-0 fw-semibold font-secondary">Delived</p>
                <p class="shipping_date mb-0">Sunday, 8th Oct-23, 05:45 PM</p>
            </div>
        </div>
    </body>
    </html>