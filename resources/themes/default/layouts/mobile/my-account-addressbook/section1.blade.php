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
        .book_name{
            font-size: 12px;
        }
        .address_edit{
            font-size: 10px;
        }
        .home_address{
            font-size: 12px;
            color: blueviolet;
        }
        .mobile_text{
font-size: 10px;
font-weight: 400;
        }
        .address_btn{
background-color: blueviolet;
width: 90%;
        }
    }
    </style>
    <body>
        <div class="line mt-3"></div>
        <div class="mt-3 ms-3 pe-3">
            <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">Add Address</h6>
        </div> 
        <div class="d-flex align-items-center justify-content-between p-3">
            <p class="book_name mb-0 fw-semibold">Talha Ahmed</p>
            <div>
                <a class="address_edit fw-semibold" href="">Edit</a>
            </div>
        </div>
        <div>
            <p class="home_address ps-3 pe-3 pt-2 mb-0">Home - Default Address</p>
            <p class="mobile_text ps-3 pe-3 pt-2 mb-0">Mobile Number: <span class="fw-semibold">+92 021 234 5678</span></p>
            <p class="mobile_text ps-3 pe-3 pt-2 fw-normal">R-153, Tikona Park, N I T, R-153, Tikona Park, N I T,, Faislabad, Pakistan - 121001</p>
        </div>
        <div class="address_btn rounded-pill m-3 p-3 text-center">
            <a class="p-3 border-0 text-white text-decoration-none" href="">+ Add Address</a>
        </div>
    </body>
    </html>