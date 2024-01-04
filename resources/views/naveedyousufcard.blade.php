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

        .flip-card-front {
            background-color: #bbb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .flip-card-back {
            background-color: #2980b9;
            transform: rotateY(180deg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .Flip_con {
            display: flex;
            justify-content: center;
            margin-top: 20px;
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
                width: 90%;
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
        <div class="flip-card" onclick="flipCard(this)">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <img src="{{ asset('public/images/Business-Card-Front.jpg') }}" alt="" width="100%"
                        height="100%">
                </div>
                <div class="flip-card-back">
                    <img src="{{ asset('public/images/Business-Card-Back.jpg') }}" alt="" width="100%"
                        height="100%">
                </div>
            </div>
        </div>
    </div>

    <script>
        function flipCard(element) {
            element.classList.toggle('flipped');
        }
        setTimeout(function() {
            flipCard(document.querySelector('.flip-card'));
        }, 3000);
    </script>

</body>

</html>
