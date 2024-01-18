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
        .reorder_text{
font-size: 12px;
        }
        .price_text{
font-size: 10px;
        }
        .reorder_btn{
            font-size: 10px;
            background-color: blueviolet;
            width: 90%;
        }

    }
    </style>
    <body>
        <div class="line mt-3"></div>
        <div class="mt-3 ms-3 pe-3">
            <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">Quick Orders</h6>
        </div> 
        <div class="d-flex align-items-center p-3">
            <img class="rounded me-3" src="./shoes.jpeg" alt="" width="80px" height="80px">
            <div>
                <p class="reorder_text mb-0 fw-semibold">Pine Kids Lace Up Casual Shoes Color <br>Block - White</p>
                <p class="mb-0 price_text fw-semibold">Rs.17789</p>
            </div>
        </div> 
        <button class="rounded-pill text-white reorder_btn p-3 border-0 ms-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M2.40572 7.00796C2.33409 7.8419 2.99408 8.55817 3.83314 8.55817H9.28191C10.0186 8.55817 10.6633 7.95447 10.7196 7.22285L10.9958 3.38569C11.0572 2.5364 10.4126 1.8457 9.55818 1.8457H2.95316" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M1 0.883789H1.89022C2.44278 0.883789 2.87765 1.3596 2.83161 1.90703L2.5758 5.00234" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8.28992 11.116C8.64312 11.116 8.92944 10.8296 8.92944 10.4764C8.92944 10.1232 8.64312 9.83691 8.28992 9.83691C7.93672 9.83691 7.65039 10.1232 7.65039 10.4764C7.65039 10.8296 7.93672 11.116 8.28992 11.116Z" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M4.19617 11.116C4.54937 11.116 4.83569 10.8296 4.83569 10.4764C4.83569 10.1232 4.54937 9.83691 4.19617 9.83691C3.84297 9.83691 3.55664 10.1232 3.55664 10.4764C3.55664 10.8296 3.84297 11.116 4.19617 11.116Z" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M4.58496 3.95312H10.7244" stroke="white" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> Reorder
        </button>
    </body>
    </html>