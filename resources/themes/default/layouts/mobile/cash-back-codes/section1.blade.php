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
        padding: 0 10px;
    }
    .line {
    width: 100%;
    height: 5px;
    background-color: rgba(0, 0, 0, 0.13);
        }
.dropdown {
  min-width: 15em;
  position: relative;
  margin: 2em;
}

.select {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: 1px #292D32 solid;
}
.caret {

  
  transition: 0.3s;
}
.menu {
  list-style: none;
  padding: 0.2em 0.5em;
  border-radius: 0.5em;
  position: absolute;
  top: 5em;
  left: 50%;
  width: 100%;
  transform: translateX(-50%);
  opacity: 0;
  display: none;
  transition: 0.2s;
  z-index: 1;
}
.menu-open {
  display: block;
  opacity: 1;
}
.cashback-color{
    color:blueviolet;
}
.cashback_text{
    font-size: 12px;
}
.cashback_text1{
font-size: 12px;
}
    }
    </style>
    <body>
        <div class="line mt-3"></div>
        <div class="mt-3 ms-3 pe-3">
            <h6 class="mb-0 border-bottom border-dark pb-3 fw-semibold">Cash Coupons</h6>
        </div>
        <div class="dropdown">
            <div class="select rounded-pill p-3">
              <p class="mb-0 cashback_text1">Sorted By:<span class="fw-semibold">Active</span></p>
              <!-- <div class="caret"></div> -->
              <svg class="caret" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
              </svg>
            </div>
            <ul class="menu">
              <p class="cashback_text fw-semibold text-center">You Don’t have Cash Coupons Available <br>with you. <span class="cashback-color">Shop Now</span></p>
            </ul>
          </div>
            
    </body>
    <script>
        const dropdowns = document.querySelectorAll('.dropdown');

dropdowns.forEach(dropdown => {
    const select = dropdown.querySelector('.select');
    const caret = dropdown.querySelector('.caret');
    const menu = dropdown.querySelector('.menu');
    const options = dropdown.querySelectorAll('.menu li');
    const selected = dropdown.querySelector('.selected');

  
select.addEventListener('click', () => {
  select.classList.toggle('select-clicked');
  caret.classList.toggle('caret-rotate');
  menu.classList.toggle('menu-open');
});

options.forEach(option => {
  option.addEventListener('click', () => {
      selected.innerText = option.innerText;
      select.classList.remove('select-clicked');
      caret.classList.remove('caret-rotate');
      menu.classList.remove('menu-open');
    
      options.forEach(option => {
        option.classList.remove('active');
        });
          option.classList.add('active');
  });
});
});

    </script>
    </html>