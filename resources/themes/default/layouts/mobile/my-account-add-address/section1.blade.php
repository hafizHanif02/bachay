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
        .address_name{
            font-size: 10px;
            font-weight: 400;
            width: 100%;
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
.type_text{
    font-size:10px;
    font-weight: 500;
}
.imge{
    font-size: 10px;
    font-weight: 500;
}
.cancel-btn{
font-size: 8px;
width: 100%;
padding: 0px 70px 0px 70px;
}
.save-btn{
    background-color: #8456B6;
    padding: 0px 70px 0px 70px;
    width: 100%;
}
    }
    </style>
    <body>
        <div class="line mt-3"></div>
        <div class="mt-3 ms-3 pe-3">
            <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">Add Address</h6>
        </div> 
        <div class="m-3">
            <input class=" address_name rounded-pill p-3 border border-secondary" type="text" placeholder="Enter Name">
        </div>
        <div class="m-3">
            <input class=" address_name rounded-pill p-3 border border-secondary" type="text" placeholder="Flat No, House/Building">
        </div>
        <div class="m-3">
            <input class=" address_name rounded-pill p-3 border border-secondary" type="text" placeholder="Street Address/Colony">
        </div>
        <div class="m-3">
            <input class=" address_name rounded-pill p-3 border border-secondary" type="text" placeholder="Landmark">
        </div>
        <div class="m-3">
            <input class=" address_name rounded-pill p-3 border border-secondary" type="text" placeholder="Pincode">
        </div>
        <div class="m-3">
            <input class=" address_name rounded-pill p-3 border border-secondary" type="text" placeholder="City">
        </div>
        <div class="m-3">
            <input class=" address_name rounded-pill p-3 border border-secondary" type="text" placeholder="Status">
        </div>
        <div class="m-3">
            <input class=" address_name rounded-pill p-3 border border-secondary" type="text" placeholder="+92 | Mobile No">
        </div>
        <div class="d-flex align-items-center p-3">
            <p class="type_text mb-0 me-3">Address Type:</p>
            <div class="imge">
                <input type="radio" name="group-1"> <span class="me-4"> Home</span>
              </div>
              <div class="imge">
                <input type="radio" name="group-1"> <span class="me-4"> Home</span>
              </div>
        </div>
        <div class="d-flex align-items-center m-3">
            <a class="cancel-btn rounded-pill text-decoration-none border border-dark text-dark pt-3 pb-3 me-3" href="">Cancel</a>
            <div>
                <a class="save-btn rounded-pill text-decoration-none text-dark pt-3 pb-3" href="">Save</a>  
            </div>
        </div>
    </body>
    </html>