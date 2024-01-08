document.getElementById("Overly-popup").addEventListener("click", function(){
    var e =document.getElementsByClassName("modalbox");
   
           e[0].style.display = 'block';
      
   })	;
   document.getElementById("close").addEventListener("click", function(){
      var e =document.getElementsByClassName("modalbox");
    e[0].style.display= 'none';
   });

   $(".slider").slick({
    // autoplay: true,
    arrows: false,
    autoplaySpeed: 5000,
    slidesToShow: 1,
    infinite: true,
    responsive: [
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2,
            },
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1.06,
                centerMode: true,
                centerPadding: "5%",
            },
        },
    ],
});

   $(".slider-cards").slick({
    // autoplay: true,
    arrows: false,
    autoplaySpeed: 5000,
    slidesToShow: 1,
    infinite: true,
    responsive: [
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2,
            },
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1.22,
                centerMode: true,
                centerPadding: "15%",
            },
        },
    ],
});

$(".slider-parenting").slick({
    // autoplay: true,
    arrows: false,
    autoplaySpeed: 5000,
    slidesToShow: 1,
    infinite: true,
    responsive: [
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2,
            },
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1.6,
                centerMode: true,
            },
        },
    ],
});

$(".slider-main").slick({
    // autoplay: true,
    arrows: false,
    autoplaySpeed: 5000,
    slidesToShow: 1,
    infinite: true,
    responsive: [
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 2,
                margin: 0,
            },
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                margin: 0,
            },
        },
    ],
});

$(".slider-nav").slick({
    slidesToShow: 3.18,
    arrows: false,
    slidesToScroll: 1,
    centerMode: true,
    centerPadding: "5%",
    autoplaySpeed: 2000,
    initialSlide: 0,
});
$(".circleCard").on("click", function () {
    $(".circleCard").removeClass("active");
    $(this).addClass("active");
});

const $mainImage = $("#main-image");
const $smallImages = $(".small-image");

$smallImages.first().addClass("active");

$smallImages.click(function () {
    $mainImage.attr("src", $(this).attr("src"));
    $smallImages.removeClass("active");
    $(this).addClass("active");
});