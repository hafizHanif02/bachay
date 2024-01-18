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
      padding: 0px 20px 20px 20px;
      position: relative;
      top: 15%;
      width: 100%;

    } 
    .line {
      width: 99%;
      height: 2px;
      background-color: rgba(0, 0, 0, 0.13);
    }
  
    .circle {
      border: 1px solid #5B6066;
      border-radius: 25px;
      
     
    }
    .card-1 {
      font-size: 18px;
      font-family: 'poppins';
    }
    .card-1 img {

      width:30px;
      height: 19px;
    }
    .card-2 {
      font-size: 18px;
      font-family: 'poppins';
    }
    .card-2 img {
      width: 34px;
      height: 30px;
    }
    .m-head {
      font-size: 29px;
      font-family: 'poppins';
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
.round{
  background-color: red;
}
.round-1{
  background-color: red; 
  margin-top: 300px;
}
    }

</style>
</head>

<body>
  <div id="myNav" class="overlay">
   
    <div class="overlay-content mt-5">
      <h3 class="m-head fw-normal">Save Cards</h3>
      <div class="line mt-5 mb-5"></div>
      <div class="circle rounded-pill ps-3  pt-4 pb-4 mb-3">
        <a class="d-flex justify-content-between text-decoration-none" href="">
          <div class="card-1 text-dark fw-bold">
            <img class="me-2" src="./visa-cion.png" alt="" width="100%" height="100%">2222-3333-4444-5555
          </div>
          <div class="imge">
            <input type="radio" name="group-1"> <span class="me-4"></span>
          </div>
        </a>
        </div>
      <div class="circle rounded-pill ps-3 pt-4 pb-4  mb-5">
        <a class="d-flex align-items-center justify-content-between text-decoration-none" href="">
        <div class="card-2 text-dark fw-bold">
          <img class="me-2" src="./visa.png" alt="" width="100%" height="100%">2222-3333-4444-5555
        </div>
        <div class="imge">
          <input type="radio" name="group-1"> <span class="me-4"></span>
        </div>
      </a>
      </div>
      <div class="round-1 rounded-pill pt-4 pb-4  mb-3">
        <a class="d-flex justify-content-center align-items-center text-decoration-none" href="">
        <div class="card-2 text-light fs-6">
            <img class="me-2" src="./Group 187.svg" alt="" width="100%" height="100%">Delete
          </div>
        </a>
        </div>
     
      
      
    </div>
  </div>
  </div>


</body>

</html>