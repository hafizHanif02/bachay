<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bachay Online Shopping | Coming Soon</title>
    <style>
        @font-face {
            font-family: myfont;
            src: url(Aristotelica\ Display\ ExtraLight\ Trial.ttf);
            src: url(Aristotelica\ Display\ DemiBold\ Trial.ttf);
        }

        body {
            font-family: myfont;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-top: 40px
        }

        .heading {
            display: flex;
            justify-content: center;

            font-size: 50px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            background: var(--Linear, linear-gradient(270deg, #845DC2 -0.09%, #D55FAD 36.37%, #FC966C 72.82%, #F99327 100.48%, #FFC55D 145.17%));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-img {
            display: flex;
            justify-content: space-between;
            padding: 0;
            width: fit-content;
            animation: rotateImage 2s ease-in-out infinite;
        }

        .bg-img2 {
            position: absolute;
            right: 40%;
            top: 24%;
            width: fit-content;
            animation: rotateImage 2s ease-in-out infinite;
        }

        .bg-img3 {
            position: absolute;
            right: 40%;
            width: fit-content;
            animation: rotateImage 2s ease-in-out infinite;
        }

        .bg-img4 {
            animation: rotateImage 2s ease-in-out infinite;
            width: fit-content;
            position: absolute;
            right: 10%;
            top: 10%;
        }

        .bg-img5 {
            animation: rotateImage 2s ease-in-out infinite;
            width: fit-content;
            position: absolute;
            right: 10%;
        }

        @keyframes rotateImage {
            0% {
                transform: rotate(20deg);
            }

            50% {
                transform: rotate(-20deg);
            }

            100% {
                transform: rotate(20deg);
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {

            /* Your tablet-specific styles go here */
            .heading {
                font-size: 30px;
                margin-top: 50px;
            }
        }

        @media (max-width: 767px) {

            /* Your mobile-specific styles go here */
            .heading {
                font-size: 24px;
                margin-top: 50px;
            }
        }
    </style>
</head>

<body data-new-gr-c-s-check-loaded="14.1136.0" data-gr-ext-installed="">
    <div class="container">
        <div class="logo">
            <img src="{{ asset('public/images/logo.png') }}" alt="">
        </div>
        <div class="bg-img">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>
        <div class="bg-img2">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>
        <div class="bg-img4">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>

        <div class="heading">
            <h1>
                Coming Soon....
            </h1>
        </div>
        <div class="bg-img">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>

        <div class="bg-img3">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>
        <div class="bg-img5">
            <img src="{{ asset('public/images/rotate_star.png') }}" alt="">
        </div>
    </div>

</body>

</html>
