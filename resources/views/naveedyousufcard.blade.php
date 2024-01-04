<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: rgba(41, 45, 50, 0.05);
        }
        .logo_con {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .flip-card {
            perspective: 1000px;
            width: 60%;
            height: 70vh;
            }

        .flip-card-inner {
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 0.6s;
            
        }
        .image_card{
            object-fit: contain;
           
        }
        .flipped .flip-card-inner {
            transform: rotateY(-180deg);
        }
        .flip-card-front,
        .flip-card-back {
            width: 100%;
            height: 100%;
            position: absolute;
            backface-visibility: hidden;
        }
        .flip-card-back {
            transform: rotateY(180deg);      
        }
       .Flip_con {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .bg-img1 {
            animation: rotateImage 2s ease-in-out infinite;
            width: fit-content;
            position: absolute;
            left: 4%;
            z-index: -1;
        }
        .bg-img3 {
            animation: rotateImage 2s ease-in-out infinite;
            width: fit-content;
            position: absolute;
            left: 7%;
            z-index: -1;
            top: 50%;
        }
        .bg-img6 {
            animation: rotateImage 2s ease-in-out infinite;
            width: fit-content;
            position: absolute;
            left: 3%;
            top: 80%;
            z-index: -1;
        }
        .bg-img4 {
            animation: rotateImage 2s ease-in-out infinite;
            width: fit-content;
            position: absolute;
            right: 12%;
            top: 30%;
            z-index: -1;
        }
        .bg-img5 {
            animation: rotateImage 2s ease-in-out infinite;
            width: fit-content;
            position: absolute;
            right: 8%;
            top: 70%;
            z-index: -1;
        }
        .bg-img2 {
            animation: rotateImage 2s ease-in-out infinite;
            width: fit-content;
            position: absolute;
            top: 2%;
            right: 5%;
            z-index: -1;
        }   
        @keyframes rotateImage {
            0% {
                transform: rotate(30deg);
            }

            50% {
                transform: rotate(-30deg);
            }

            100% {
                transform: rotate(30deg);
            }
        }
        @media only screen and (min-width: 768px) and (max-width: 1024px) {
            .flip-card {
                perspective: 1000px;
                width: 90%;
                height: 400px;
            }
        }

        @media only screen and (max-width: 767px) {
            .flip-card {
                perspective: 1000px;
                width: 100%;
                height: 200px;
            }

        }
    </style>
</head>
<body>
    <div class="logo_con">
        <img src="{{ asset('public/images/logo.png') }}" alt="">
    </div>

    <div class="Flip_con">
        <div class="bg-img1">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>
        <div class="bg-img3">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>
        <div class="bg-img6">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>
        <div class="flip-card" onclick="flipCard(this)">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <img class="image_card" src="{{ asset('public/images/Business-card-Front1.png') }}" alt="" width="100%"
                        height="100%">
                </div>
                <div class="flip-card-back">
                    <img class="image_card" src="{{ asset('public/images/Business-card-Back2.png') }}" alt="" width="100%"
                        height="100%">
                </div>
            </div>
        </div>
        <div class="bg-img2">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>
        <div class="bg-img4">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>
        <div class="bg-img5">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>
    </div>

    <script>
        function flipCard(element) {
            element.classList.toggle('flipped');
        }
        setTimeout(function() {
            flipCard(document.querySelector('.flip-card'));
        }, 1500);
    </script>

</body>

</html>
