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
        .Details_textimg{
            background: rgba(249, 147, 39, 0.25);
        }
        .details_text{
        font-size: 9px;
        }
        .help_btn{
border: 1px solid rgba(255, 107, 0, 0.50);
        }
        .order_details{
            font-size: 10px;
        }
        .cancel_btn{
            border: 0.5px solid var(--Colors-System-delete-stroke, #F9B9B9);
            background-color: var(--Colors-System-delete-bg, #FDE8E8);;
            color: #EC1515;
        }
        .record-btn{
            background-color: #845DC2;
        }
        .Order_text{
            font-size: 12px;
        }
        .Order_text1{
            font-size: 9.500px;
        }
        .color_box{
            width:10px ;
            height:10px ;
        }
        .Order_text2{
            font-size: 7.500px;
        }
        .order_text3{
            font-size: 6px;
        }
        .Order_cancel{
font-size: 11px;
        }
        .cancel_detail{
    font-size: 9px;
        }
        .concern_text{
            font-size: 10px;
        }
        .view_text{
            font-size: 10px;
            color: #845DC2;
        }
        .line-1{
    width: 90%;
    height: 1px;
}
.shipping_text{
    font-size: 14px;
}
.change_text{
    font-size: 10px;
}
.name_text{
    font-size: 12px;
}
.Info_text{
    border-bottom: dashed 2px rgba(0, 0, 0, 0.13);
}
.name_text1{
    font-size: 12px;
    color: #F99327;
}
.name_text2{
    font-size: 10px;
}
    }
    </style>
    <body>
        <div class="line mt-3"></div>
        <div class="mt-3 ms-3 pe-3">
            <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">Order Details</h6>
        </div>  
        <div class="Details_textimg p-3 rounded m-3">
        <div class=" d-flex  justify-content-between align-items-center ">
            <img class="me-2" src="./question-img.svg" alt="" width="" height="">
            <div>
                <p class="details_text mb-0">
                    If you need any additional help related to your order, please click on 'Need Help', select the product and refer to the related FAQs.
                </p>
                
            </div>
            
        </div>
        <button class="help_btn rounded-pill bg-white ps-3 pe-3 mt-3">Need Help?</button>
    </div>
    <div class="line mt-3"></div>
    <div class=" order_details mt-3 p-3">
        <p class="mb-2">Order Number: <span class="fw-semibold">18833462IZTF58B012</span> </p>
            <p class="mb-2">Order Placed: <span class="fw-semibold">Sun, 8th Oct 23, 12:38 AM - 4 Items</span></p>
            <p class="mb-2">Order Status: <span class="fw-semibold">Shipped</span></p>
           <p class="mb-0"> Order Total: <span class="fw-semibold">Rs.3900</span></p>
    </div>
    <div class="d-flex align-items-center p-3">
        <img class="me-2" src="./mail.svg" alt="">
        <div>
            <p class="mb-0 order_details">Email Invoice</p>
        </div>
    </div>
    <div class="d-flex align-items-center p-3">
        <button class="cancel_btn rounded-pill ps-5 pe-5 pt-2 pb-2 me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
              </svg> Cancel
        </button>
        <div>
            <button class="record-btn rounded-pill ps-5 pe-5 pt-2 pb-2 text-white border-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-dash" viewBox="0 0 16 16">
                    <path d="M6.5 7a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                  </svg> Reorder All
            </button>
        </div>
    </div>
    <div class="line mt-3"></div>
    <div class="d-flex align-items-center p-3 justify-content-between">
        <img class="rounded" src="shoes.jpeg" alt="" width="107px" height="107px">
        <div>
            <p class="Order_text fw-semibold mb-2">Pine Kids Lace Up Casual Shoes Color <br>Block - White</p>
            <p class="Order_text1 mb-0">Rs.17789</p>
            <div class="d-flex align-items-center">
                <p class="mb-0 me-2 Order_text1">colors</p>
                <div class="color_box bg-danger rounded-circle me-3"></div>
                <p class="mb-0 me-2 Order_text1">Size</p>
                <p class="border border-dark mb-0 rounded Order_text2">UK 12 <span class="Order_text3">(19.5 CM)</span></p>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between p-3 align-items-center">
    <div class="d-flex align-items-center"> 
        <img class="me-2" src="./cancel-img.png" alt="" width="28px" height="28px">
        <div>
            <p class="mb-0 Order_cancel fw-semibold">Cancelled</p>
            <p class="mb-0 cancel_detail">Wed, 11th Oct 23, 03:01 PM</p>
        </div>
      </div>
      <div class="d-flex align-items-center">
        <img class="me-2" src="./raise concern.svg" alt="" width="16px" height="16px">
        <div>
            <p class="mb-0 fw-semibold concern_text">Raise Your Concern</p>
        </div>
      </div>
    </div>
    <div class="d-flex align-items-center p-3">
        <button class="cancel_btn rounded-pill ps-5 pe-5 pt-2 pb-2 me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
              </svg> Cancel
        </button>
        <div>
            <button class="record-btn rounded-pill ps-5 pe-5 pt-2 pb-2 text-white border-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-dash" viewBox="0 0 16 16">
                    <path d="M6.5 7a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                  </svg> Reorder All
            </button>
        </div>
    </div>
    <p class="view_text mb-0  fw-semibold text-center">View All Tracking Details -></p>
    <div class="line-1 bg-secondary ms-3 mt-3"></div>
    <div class="d-flex align-items-center p-3 justify-content-between">
        <img class="rounded" src="shoes.jpeg" alt="" width="107px" height="107px">
        <div>
            <p class="Order_text fw-semibold mb-2">Pine Kids Lace Up Casual Shoes Color <br>Block - White</p>
            <p class="Order_text1 mb-0">Rs.17789</p>
            <div class="d-flex align-items-center">
                <p class="mb-0 me-2 Order_text1">colors</p>
                <div class="color_box bg-danger rounded-circle me-3"></div>
                <p class="mb-0 me-2 Order_text1">Size</p>
                <p class="border border-dark mb-0 rounded Order_text2">UK 12 <span class="Order_text3">(19.5 CM)</span></p>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between p-3 align-items-center">
    <div class="d-flex align-items-center"> 
        <img class="me-2" src="./check.png" alt="" width="28px" height="28px">
        <div>
            <p class="mb-0 Order_cancel fw-semibold">Delivered</p>
            <p class="mb-0 cancel_detail">Wed, 11th Oct 23, 03:01 PM</p>
        </div>
      </div>
      <div class="d-flex align-items-center">
        <img class="me-2" src="./raise concern.svg" alt="" width="16px" height="16px">
        <div>
            <p class="mb-0 fw-semibold concern_text">Raise Your Concern</p>
        </div>
      </div>
    </div>
    <div class="d-flex align-items-center p-3">
        <button class="cancel_btn rounded-pill ps-5 pe-5 pt-2 pb-2 me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
              </svg> Cancel
        </button>
        <div>
            <button class="record-btn rounded-pill ps-5 pe-5 pt-2 pb-2 text-white border-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-dash" viewBox="0 0 16 16">
                    <path d="M6.5 7a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                  </svg> Reorder All
            </button>
        </div>
    </div>
    <p class="view_text mb-0  fw-semibold text-center">View All Tracking Details -></p>
    <div class="line-1 bg-secondary ms-3 mt-3"></div>
    <div class="d-flex align-items-center p-3 justify-content-between">
        <img class="rounded" src="shoes.jpeg" alt="" width="107px" height="107px">
        <div>
            <p class="Order_text fw-semibold mb-2">Pine Kids Lace Up Casual Shoes Color <br>Block - White</p>
            <p class="Order_text1 mb-0">Rs.17789</p>
            <div class="d-flex align-items-center">
                <p class="mb-0 me-2 Order_text1">colors</p>
                <div class="color_box bg-danger rounded-circle me-3"></div>
                <p class="mb-0 me-2 Order_text1">Size</p>
                <p class="border border-dark mb-0 rounded Order_text2">UK 12 <span class="Order_text3">(19.5 CM)</span></p>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between p-3 align-items-center">
    <div class="d-flex align-items-center"> 
        <img class="me-2" src="./error.png" alt="" width="28px" height="28px">
        <div>
            <p class="mb-0 Order_cancel fw-semibold">Error Accrued</p>
            <p class="mb-0 cancel_detail">Wed, 11th Oct 23, 03:01 PM</p>
        </div>
      </div>
      <div class="d-flex align-items-center">
        <img class="me-2" src="./raise concern.svg" alt="" width="16px" height="16px">
        <div>
            <p class="mb-0 fw-semibold concern_text">Raise Your Concern</p>
        </div>
      </div>
    </div>
    <div class="d-flex align-items-center p-3">
        <button class="cancel_btn rounded-pill ps-5 pe-5 pt-2 pb-2 me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
              </svg> Cancel
        </button>
        <div>
            <button class="record-btn rounded-pill ps-5 pe-5 pt-2 pb-2 text-white border-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-dash" viewBox="0 0 16 16">
                    <path d="M6.5 7a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                  </svg> Reorder All
            </button>
        </div>
    </div>
    <p class="view_text mb-0  fw-semibold text-center">View All Tracking Details -></p>
    <div class="line-1 bg-secondary ms-3 mt-3"></div>
    <div class="d-flex align-items-center p-3 justify-content-between">
        <img class="rounded" src="shoes.jpeg" alt="" width="107px" height="107px">
        <div>
            <p class="Order_text fw-semibold mb-2">Pine Kids Lace Up Casual Shoes Color <br>Block - White</p>
            <p class="Order_text1 mb-0">Rs.17789</p>
            <div class="d-flex align-items-center">
                <p class="mb-0 me-2 Order_text1">colors</p>
                <div class="color_box bg-danger rounded-circle me-3"></div>
                <p class="mb-0 me-2 Order_text1">Size</p>
                <p class="border border-dark mb-0 rounded Order_text2">UK 12 <span class="Order_text3">(19.5 CM)</span></p>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between p-3 align-items-center">
    <div class="d-flex align-items-center"> 
        <img class="me-2" src="./way.png" alt="" width="28px" height="28px">
        <div>
            <p class="mb-0 Order_cancel fw-semibold">On The Way</p>
            <p class="mb-0 cancel_detail">Wed, 11th Oct 23, 03:01 PM</p>
        </div>
      </div>
      <div class="d-flex align-items-center">
        <img class="me-2" src="./raise concern.svg" alt="" width="16px" height="16px">
        <div>
            <p class="mb-0 fw-semibold concern_text">Raise Your Concern</p>
        </div>
      </div>
    </div>
    <div class="d-flex align-items-center p-3">
        <button class="cancel_btn rounded-pill ps-5 pe-5 pt-2 pb-2 me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
              </svg> Cancel
        </button>
        <div>
            <button class="record-btn rounded-pill ps-5 pe-5 pt-2 pb-2 text-white border-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-dash" viewBox="0 0 16 16">
                    <path d="M6.5 7a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                  </svg> Reorder All
            </button>
        </div>
    </div>
    <p class="view_text mb-0  fw-semibold text-center">View All Tracking Details -></p>
    <div class="line mt-3"></div>
    <div class="d-flex justify-content-between align-items-center mt-3 p-3">
        <p class="shipping_text fw-semibold mb-0">Shipping Address</p>
        <div>
            <a class="change_text text-primary fw-semibold" href="">Change</a>
        </div>
    </div>
    <p class="name_text mb-0 fw-semibold p-3">Talha Ahmed</p>
        <p class="name_text mb-0 p-3">Mobile Number: <span class="name_text fw-semibold">+92 021 234 5678</span></p>
        <p class="name_text mb-0 p-3">R-153, Tikona Park, N I T, R-153, Tikona Park, N I T,, Faislabad, Pakistan - 121001</p>
        <div class="Details_textimg d-flex align-items-center p-3 m-3 rounded">
            <img class="me-2" src="./alert.svg" alt="" width="" height="">
            <div>
                <p class="details_text mb-0">
                    The Address of the order cannot be changed if the order is <br>
                    an Exchange or a Replacement Order , or if the status of <br>
                    the order is Shipped or Delivered.
                </p>
            </div>
        </div>
        <div class="line-1 bg-secondary ms-3 mt-3"></div>
        <div>
            <p class="shipping_text Info_text fw-semibold p-3 border-bottom">Payment Information</p>
        </div>
        <div class="d-flex justify-content-between align-items-center p-3">
            <p class="name_text mb-0">Value of Product(s)</p>
            <div>
                <p class="mb-0 name_text fw-semibold">Rs. 48900</p>  
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center p-3">
            <p class="name_text mb-0">Discount</p>
            <div>
                <p class="name_text fw-semibold mb-0 text-success">Rs. 1247</p>  
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center p-3">
            <p class="name_text mb-0">Estimated GST (+)</p>
            <div>
                <p class="mb-0 name_text fw-semibold text-danger">Rs. 390.74</p>  
            </div>
        </div>
         <div class="d-flex justify-content-between align-items-center p-3 Info_text">
            <p class="name_text mb-0">Shipping (+)</p>
            <div>
               
                <p class="mb-0 name_text fw-semibold text-success">FREE</p>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center p-3 Info_text">
            <p class="mb-0 name_text">Sub Total</p>
            <div>
                <p class="mb-0 name_text fw-semibold">Rs.3946.26</p>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center p-3">
            <p class="name_text fw-semibold mb-0">Final Payment</p>
            <div>
                <p class="name_text fw-semibold mb-0">Rs.3946.02</p>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center p-3">
            <p class="name_text mb-0">Payment Mode</p>
            <div>
                <p class="name_text mb-0 fw-semibold">Cash On Delivery</p>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center ps-3 pe-3 pt-0 pb-3">
            <p class="name_text mb-0">Payment Status</p>
            <div>
                <p class=" name_text1 fw-semibold mb-0">Pending</p>
            </div>
        </div>
        <p class="name_text2 p-3">Stay Alert! Stay Safe. Bachay only accepts payments through its <br>
            official App/Website. <a class="fw-semibold text-primary" href="">Click</a> to know more</p>
    </body>
    </html>