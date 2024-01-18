<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
        crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <title>edit-profile</title>
    </head>
    <style>
        @media screen and (max-width: 768px){
    body{
        font-family: 'poppins';
        padding: 0 10px;
    }
.profile-image{
    border: 2px solid #000;
}
.Browse_image{
    top: 125px;
right: 135px;
}
.Profile-name{
    border: 1px solid #5B6066;
}
input[type="radio"] {
  width: .8em;
  height: .8em;
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
.save_button{
    width: 100%;
    background-color: #845DC2;
    color: #fff;
}
.profile-details{
    font-size: 12px;
}
        }
    </style>
<body>
    <div class="text-center pt-5">
        <img class="rounded-circle profile-image" src="./profile_image.jpeg" alt="" width="110px" height="110px">
            <img class="Browse_image position-absolute" src="./browse.svg" alt="">
    </div>
    
        <div class="Profile-name d-flex align-items-center rounded-pill p-3 mt-3">
            <img class="me-2" src="./profile.svg" alt="" width="15px" height="15px">
            <div>
                <p class="mb-0 fw-semibold profile-details">Rabia Kausar</p>
            </div>
        </div>
        <div class=" Profile-name d-flex justify-content-between align-items-center rounded-pill p-3 mt-3">
        <div class="d-flex align-items-center">
            <img class="me-2" src="./profile-2.svg" alt="" width="12px" height="12px">
            <div>
                <p class="mb-0 fw-semibold profile-details">Mother Of 03</p>
            </div> 
        </div>
        <div>
            <img src="./right-arrow.svg" alt="" width="15px" height="15px">
        </div>
    </div>
    <div class=" Profile-name d-flex justify-content-between align-items-center rounded-pill p-3 mt-3">
        <div class="d-flex align-items-center">
            <img class="me-2" src="./garduain.svg" alt="" width="12px" height="12px">
            <div>
                <p class="mb-0 fw-semibold profile-details">Guardian</p>
            </div> 
        </div>
        <div>
            <img src="./right-arrow.svg" alt="" width="15px" height="15px">
        </div>
    </div>
    <div class=" Profile-name d-flex justify-content-between align-items-center rounded-pill p-3 mt-3">
        <div class="d-flex align-items-center">
            <img class="me-2" src="./gender.svg" alt="" width="12px" height="12px">
            <div>
                <p class="mb-0 fw-semibold profile-details">Gender</p>
            </div> 
        </div>
        <div class="imge">
            <div class="d-flex">
                <div class="profile-details">
                    <input class="me-2" type="radio" name="group-1"> <span class="me-3"> Male</span>
                  </div>
            <div class="profile-details">
                <input class="me-2" type="radio" name="group-1"> <span class="me-1"> Female</span>
              </div>
          </div>
          </div>
    </div>
    <button class="save_button rounded-pill p-3 mt-3 border-0 profile-details">Save</button>
</body>
</html>