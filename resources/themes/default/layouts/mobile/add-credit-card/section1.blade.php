<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
    @media screen and (max-width: 768px){
    .overlay-content {
      
      
      
      width: 100%;

    }
    .line {
      width: 99%;
      height: 2px;
      background-color: rgba(0, 0, 0, 0.13);
    }
    .box {
      width: 100%;
      height: 12px;

      background-color: rgba(0, 0, 0, 0.13);
    }
    .circle {
      border: 1px solid #5B6066;
      border-radius: 25px;
      
    }
    .card-1 {
      font-size: 12px;
      font-family: 'poppins';
    }
    .card-1 img {

      width:30px;
      height: 19px;
    }
    .card-2 {
      font-size: 12px;
      font-family: 'poppins';
    }
    .card-2 img {
      width: 34px;
      height: 24px;
    }
    
    .m-head {
      font-size: 19px;
      font-family: 'poppins';
    }
    .m-head p{
      font-size: 10px;
    }
    input[type="radio"] {
  width: 1.2em;
  height: 1.2em;
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
.round-1{
  width: 100%;
border: 1px solid #5B6066;
}
.switch {
  width: 60px;
  height: 25px;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ddd;
  transition: .4s;
  border: 0.5px solid #292D32;
}

.slider:before {
  position: absolute;
  content: "";
  height: 23px;
  width: 23px;
  left: 4px;
  bottom: 3px;
  background-color:#8456B6;
  transition: .4s;
}

input:checked + .slider {
  background-color: #fff;
  border: 0.5px solid #292D32;
}



input:checked + .slider:before {
  -webkit-transform: translateX(26px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
.btn-4 p{
font-size: 12px;
}
.btn-3{
  position: absolute;
  left: 300px;
  top: 70px;
}
.image{

}
.col-1{
  margin: 0px 0px 0px 179px; 
}
.col a{
  color: #8456B6;
}

.dropbtn {
  
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

.dropbtn img{
  width: 20px;
  height: 20px;
}

.dropdown {
    position: absolute; 
 left: 300px;
 top:560px;
}
.dropdown:hover{
 background-color: red;
}

.dropdown-content {
    display: none;
    position: absolute;
  right: 10px;
    background-color: #f9f9f9;
    min-width: 160px;
    overflow: auto;
    
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.show {display:block;}

    }
</style>
</head>

<body>
  
    
    <div class="overlay-content mt-5">
     <div class="col d-flex justify-content-between">
      <h2 class="m-head fw-bold">Save Cards</h2>
      
      <a class="fw-semibold" href="">Edit</a>
   
    </div>
      <div class="line mt-4 mb-4"></div>
      <div class="ps-3 pe-3">
      <div class=" d-flex align-items-center justify-content-between circle rounded-pill ps-3 pt-3 pb-3  mb-3">
          <div class="card-1 fw-bold">
            <img class="me-2" src="./visa-cion.png" alt="" width="100%" height="100%">2222-3333-4444-5555
          </div>
          <div class="imge">
            <input type="radio" name="group-1" class=""> <span class="me-4"></span>
          </div>
        </div>
      </div>
      <div class="ps-3 pe-3">
      <div class=" d-flex justify-content-between align-items-center circle rounded-pill ps-3 pt-3 pb-3">
        <div class="card-2 fw-bold">
          <img class="me-2" src="./visa.png" alt="" width="100%" height="100%">2222-3333-4444-5555
        </div>
        <div class="imge">
            <input type="radio" name="group-1""> <span class="me-4"></span>
        </div>
      </div>
    </div>
      <div class="box mb-4  mt-4"></div>
      <h3 class="m-head fw-bold">Add New Card</h3>
      <div class="line mb-5 mt-3"></div>
      <div class="ps-3 pe-3">
        <input type="text" placeholder="Card Number" class="round-1 rounded-pill ps-3 pt-3 pb-3  mb-3">
        <input type="text" placeholder="Name on Card" class="round-1 rounded-pill pt-3 pb-3 ps-3 mb-3">
      <div class="date d-flex">
        <input type="text" placeholder="Expiry Date" class="round-1 rounded-pill pt-3 pb-3 ps-3">
        
        <input type="text" placeholder="CVV" class="round-1 rounded-pill pt-3 pb-3 ps-3 ms-2">
        <div class="dropdown">
          
          <img id="myBtn" class="dropbtn" src="./Group 788.svg" alt="">
            <div id="myDropdown" class="dropdown-content">
              <p> Make easy payments for future, your </p>
            </div>
          </div>
      </div>
    </div>
      <div class="three-item d-flex position-relative justify-content-between">
        <div class="btn-4">  
      <h3 class="m-head mt-5 fs-5 fw-bold">Save Card</h3>
      <p class="lh-1">Make easy payments for future, your <br> card will be saved in you account.</p>
    </div>
    
      
    
      <div class="btn-3">
        
        <label class="switch">
        <input class="d-none" type="checkbox">
        <span class="slider round"></span>
      </label>
    </div>
  </div>
     
    </div>
  </div>
  </div>
  

<script>
  // Get the button, and when the user clicks on it, execute myFunction
document.getElementById("myBtn").onclick = function() {myFunction()};

/* myFunction toggles between adding and removing the show class, which is used to hide and show the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
      
    for (let i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

</body>

</html>