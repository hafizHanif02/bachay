$(".slider").slick({
    autoplay: true,
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

$(".sliderForSmall").slick({
    autoplay: true,
    arrows: false,
    autoplaySpeed: 5000,
    slidesToShow: 6,
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

const $readMoreButton = $("#read-more");
const $readLessButton = $("#read-less");
const $moreContent = $(".more-content");

$readMoreButton.on("click", function () {
    $moreContent.show();
    $readMoreButton.hide();
    $readLessButton.css("display", "inline-block");
});

$readLessButton.on("click", function () {
    $moreContent.hide();
    $readMoreButton.css("display", "inline-block");
    $readLessButton.hide();
});

const $mainImage = $("#main-image");
const $smallImages = $(".small-image");

$smallImages.first().addClass("active");

$smallImages.click(function () {
    $mainImage.attr("src", $(this).attr("src"));
    $smallImages.removeClass("active");
    $(this).addClass("active");
});

function logout() {
    $.ajax({
        type: "POST",
        url: "/customer/auth/logout",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            window.location = "/";
        },
    });
}

$(document).ready(function () {
    $(".minus").click(function () {
        var $input = $(this).parent().find("input");
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $(".plus").click(function () {
        var $input = $(this).parent().find("input");
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });
});

$(".card-slider").slick({
    infinite: false,
    speed: 300,
    arrows: true,
    slidesToShow: 5,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true,
            },
        },
    ],
});

// function addToWishlist(productId) {
//     $.ajax({
//         type: "POST",
//         url: "/add-to-wishlist",
//         data: {
//             _token: $('meta[name="csrf-token"]').attr("content"),
//             productId: productId,
//         },
//         dataType: "json",
//         success: function (data, status, code) {
//             if (code.status == 200) {
//                 $("#wishlist-btn-" + productId + " i").removeClass("bi-heart");
//                 $("#wishlist-btn-" + productId + " i").addClass(
//                     "bi-heart-fill"
//                 );
//             } else if (code.status === 201) {
//                 $("#wishlist-btn-" + productId + " i").removeClass(
//                     "bi-heart-fill"
//                 );
//                 $("#wishlist-btn-" + productId + " i").addClass("bi-heart");
//             }
//         },
//         error: function (response) {
//             if (response.status === 401) {
//                 window.location = "/customer/auth/login";
//             }
//         },
//     });
// }
function addToWishlist(button) {
    var productId = $(button).data('product-id');
    $.ajax({
        type: "POST",
        url: "/add-to-wishlist",
        data: {
            productId: productId,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(data, status, xhr) {
            var heartIcon = $(button).find('i');
            if (xhr.status === 200) {
                heartIcon.toggleClass('bi-heart bi-heart-fill text-danger');
                if (heartIcon.hasClass('bi-heart')) {
                    deleteFromWishlist(productId);
                }
            } else if (xhr.status === 201) {
                alert("Something went wrong");
            }
        },
        error: function(response) {
            alert("Error occurred while adding on wishlist");
        }
    });
}

function deleteFromWishlist(productId) {
    $.ajax({
        type: "POST",
        url: "/delete-wishlist",
        data: {
            productId: productId,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(data, status, xhr) {
            if (xhr.status === 200) {
                Swal.fire(
                    'Deleted!',
                    'Your product has been removed from Wishlist.',
                    'success'
                );
            } else {
                alert("Failed to delete from wishlist. Server returned: " + xhr.status + " " + xhr
                    .statusText);
            }
        },
        error: function(xhr, status, error) {
            alert("Error occurred while deleting from wishlist");
        }
    });
}


$("#location").keydown(function () {
    var area = $("input[name='location']").val();
    if (area != "") {
        $.ajax({
            type: "POST",
            url: "/area-location",
            data: {
                _token: $("meta[name='csrf-token']").attr("content"),
                area: area,
            },
            success: function (response) {
                $("#location-result").empty();
                if (response.areas.length == 0) {
                    $("#location-result").text("No location found!");
                } else {
                    $.each(response.areas, function (index, value) {
                        $("#location-result").append(`
                            <li><a href="">${value.name}</a></li>
                         `);
                    });
                }
            },
        });
    }
});
$("#search").keydown(function () {
    var search = $("input[name='search']").val();
    if (search != "") {
        $.ajax({
            type: "POST",
            url: "/search",
            data: {
                _token: $("meta[name='csrf-token']").attr("content"),
                search: search,
            },
            success: function (response) {
                $("#search-result").empty();
                if (response.searches.length == 0) {
                    $("#search-result").text("No search found!");
                } else {
                    $.each(response.searches, function (index, value) {
                        $("#search-result").append(`
                            <li><a href="">${value.name}</a></li>
                         `);
                    });
                }
            },
        });
    }
});

function addToCart(productId) {
    $.ajax({
        type: "POST",
        url: "/add-to-cart",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            productId: productId,
            size: $("input[name='size']").val(),
            color: $("input[name='color']").val(),
            material: $("input[name='material']").val(),
            quantity: $("input[name='quantity']").val(),
        },
        dataType: "json",
        success: function (data, status, xhr) {
            if (xhr.status === 200) {
                $("#cart-btn i").removeClass("bi-cart");
                $("#cart-btn i").addClass("bi-cart-fill");
                $("#modalId").modal("hide");
            }
        },
        error: function (xhr, status, error) {
            if (xhr.status === 401) {
                window.location = "/customer/auth/login";
            } else if (xhr.status === 422) {
                $("#errors").empty();
                var errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    $("#errors").append(value);
                });
            }
        },
    });
}

function removeCartItem(cartItemId) {
    $.ajax({
        type: "DELETE",
        url: "/remove-cart-item/" + cartItemId,
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
        },
        dataType: "json",
        success: function (data, status, xhr) {
            if (xhr.status == 200) {
                $("#cartItem" + cartItemId).remove();
            }
        },
    });
}

function addToUrl(type, value1, value2 = null) {
    let params = new URLSearchParams(window.location.search);
    let fromParams, toParams, fromIndex, filter;

    if (type == "price") {
        fromParams = params.getAll("filter[prices][from][]");
        toParams = params.getAll("filter[prices][to][]");
        fromIndex = fromParams.length > 0 ? fromParams.length : 0;
        if (fromIndex > 0) {
            fromIndex = parseInt(fromParams[fromIndex - 1]) + 1;
        }
        filter = `filter[prices][from][${fromIndex}]=${value1}&filter[prices][to][${fromIndex}]=${value2}`;
    } else {
        fromParams = params.getAll(`filter[${type}s]`);
        toParams = params.getAll(`filter[${type}s]`);
        fromIndex = fromParams.length > 0 ? fromParams.length : 0;
        filter = `filter[${type}s][${fromIndex}]=${value1}`;
    }

    let separator = window.location.search ? "&" : "?";
    let url =
        window.location.pathname + window.location.search + separator + filter;

    history.pushState(null, null, url);
}

function removeFromUrl(type) {
    let params = new URLSearchParams(window.location.search);
    let url = window.location.pathname;
    if (params.has(`filter[${type}]`)) {
        params.delete(`filter[${type}]`);
    }
    history.pushState(null, null, url + "?" + params.toString());
}

function productsFilter(checkbox, type, value1, value2 = null) {
    var filter = "";

    if (checkbox.checked) {
        addToUrl(type, value1, value2);
        $("#filter-btns").append(`
            <button class="boys rounded-3 btn-style" id="filter-btns-${type}"><i class="bi bi-x-lg"></i> ${type}</button>
        `);
    } else {
        removeFromUrl();
        $("#filter-btns-" + type).remove();
    }

    $.ajax({
        type: "GET",
        url: "/filter-products?" + filter,
        dataType: "json",
        success: function (data, status, xhr) {
            $("#product-list").empty();
            $.each(data.products, function (index, product) {
                $("#product-list").append(`
                    <div class="col-md-6 col-lg-3 mb-4 pb-3">
                        <div class="rounded-3">
                            <div class="card1">
                                <div class="first-sec card1">
                                    <div class="image-container">
                                        <a href="/product-detail/${product.id}">
                                            <img src="/storage/${
                                                product.product_images[0].image
                                            }" alt="Product image" class="img-fluid"
                                                width="100%" height="100%">
                                        </a>
                                        <div class="sec-best-seller mt-3">
                                            <p>${
                                                product?.product_badge?.badge
                                                    ?.name
                                            }</p>
                                        </div>
                                        <div class="wish-list mt-3 me-2">
                                            <button id="wishlist-btn-${
                                                product.id
                                            }" class="p-0 bg-transparent rounded-circle forBorder"
                                                onclick="addToWishlist('${
                                                    product.id
                                                }')">
                                                <i
                                                    class="bi ${
                                                        product.is_in_wishlist
                                                            ? "bi-heart-fill"
                                                            : "bi-heart"
                                                    } text-danger"></i>
                                            </button>
                                        </div>
                                        <p class="product-text mt-3">${
                                            product.name
                                        }</p>
                                        <div class="d-flex">
                                            <p class="product-price me-2">${
                                                product.product_attributes[0]
                                                    .currency.symbol +
                                                " " +
                                                salePrice(product)
                                            }</p>
                                            <p class="card-text"><span class="discount">${
                                                product.product_attributes[0]
                                                    .currency.symbol +
                                                " " +
                                                product.product_attributes[0]
                                                    .price
                                            }</span> <span
                                                    class="text-success">-${
                                                        product
                                                            .product_attributes[0]
                                                            .discount_percentage
                                                    }% Off</span></p>
                                        </div>
                                        <div class="d-flex justify-content-between for-border-g">
                                            <div class="ratings-reviews d-flex">
                                                <img class="me-2" src="/web/images/vector-star.svg"
                                                    alt="">
                                                <p class="m-0">${
                                                    product.average_rating ?? ""
                                                }<span class="Reviews">(${product.reviews_count})</span></p>
                                            </div>
                                            <a href="#" class="delivery-btn">${
                                                product.delivery_type.name
                                            }</a>
                                        </div>
        
                                        <div class="d-flex justify-content-between mt-3">
                                            <button class="buy-now rounded-pill text-white">Buy Now</button>
                                                    <button id="cart-btn" class="p-0 bg-transparent rounded-circle forBorder"
                                                    data-bs-toggle="modal" data-bs-target="#modalId" >
                                                    <i
                                                        class="bi ${
                                                            product.is_in_cart
                                                                ? "bi-cart-fill"
                                                                : "bi-cart"
                                                        } text-purple"></i>
                                                </button>
                                                <x-web.product.product-detail-modal :product="${product}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `);
            });
        },
    });
}

function salePrice(product) {
    var onePercent = (1 / 100) * product.product_attributes[0].price;
    var percentValue =
        product.product_attributes[0].discount_percentage * onePercent;
    var priceAfterSale = product.product_attributes[0].price - percentValue;

    return priceAfterSale.toFixed(2);
}

function notificationSubscription(type) {
    $.ajax({
        type: "PUT",
        url: "update-notification-subscription",
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            type: type,
        },
        dataType: "json",
        success: function (data, status, xhr) {
            if (xhr.status == 200) {
                sweetAlert(data.message);
            }
        },
        error: function (response) {
            if (response.status == 422) {
                $("#subscription-response").html(response.errors);
            }
        },
    });
}

function sweetAlert(message) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    Toast.fire({
        icon: "success",
        title: message,
    });
}

function getStates(countryId) {
    $.ajax({
        type: "GET",
        url: "/states-by-country/" + countryId,
        dataType: "json",
        success: function (data, status, xhr) {
            $("#state_id").empty();
            $.each(data.states, function (index, value) {
                $("#state_id").append(`
                    <option value="${value.id}">${value.name}</option>
                `);
            });
        },
    });
}

function getCities(stateId) {
    $.ajax({
        type: "GET",
        url: "/cities-by-country/" + stateId,
        dataType: "json",
        success: function (data, status, xhr) {
            $("#city_id").empty();
            $.each(data.cities, function (index, value) {
                $("#city_id").append(`
                    <option value="${value.id}">${value.name}</option>
                `);
            });
        },
    });
}

function sendEmailOtp() {
    $.ajax({
        type: "POST",
        url: "/send-email-otp",
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
        },
        dataType: "json",
        success: function (data, status, xhr) {
            $("#email-opt-success").html(data.message);
        },
    });
}

function verifyEmailOtp() {
    $.ajax({
        type: "POST",
        url: "/verify-email-otp",
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            code: $("#otp_code").val(),
        },
        dataType: "json",
        success: function (data, status, xhr) {
            sweetAlert("Email verified successfully!");
            window.location = "/my-profile";
        },
        error: function (response) {
            $("#email-opt-error").html("Invalid opt code");
        },
    });
}

$("#Overly-popupLocation").click(function () {
    $(".popupbox").eq(0).css("display", "block");
});

$("#closepopup").click(function () {
    $(".popupbox").eq(0).css("display", "none");
});

$("#fromDate, #toDate").change(function () {
    const fromDate = $("#fromDate").val();
    const toDate = $("#toDate").val();
    if (fromDate && toDate) {
        window.location =
            "?filters[from]=" + fromDate + "&filters[to]=" + toDate;
    } else if (fromDate) {
        window.location = "?filters[from]=" + fromDate;
    } else if (toDate) {
        window.location = "?filters[to]=" + toDate;
    }
});

var $scroll = $(".scroll-cards");
var isDown = false;
var scrollX;
var scrollLeft;

$scroll.on("mouseup", function () {
    isDown = false;
    $scroll.removeClass("active");
});

$scroll.on("mouseleave", function () {
    isDown = false;
    $scroll.removeClass("active");
});

$scroll.on("mousedown", function (e) {
    e.preventDefault();
    isDown = true;
    $scroll.addClass("active");
    scrollX = e.pageX - $scroll.offset().left;
    scrollLeft = $scroll.scrollLeft();
});

$scroll.on("mousemove", function (e) {
    if (!isDown) return;
    e.preventDefault();
    var element = e.pageX - $scroll.offset().left;
    var scrolling = (element - scrollX) * 2;
    $scroll.scrollLeft(scrollLeft - scrolling);
});
$(".MyProfile-ul li").on("click", function () {
    $(".MyProfile-ul li").removeClass("active");
    $(this).addClass("active");
});

$("input").on("input", function () {
    $(this).closest("tr").addClass("row-changed");
});

// $("#readmore").click(function () {
//     var dots = $("#dots");
//     var moreText = $("#more");
//     var btnText = $("#readmore");

//     if (dots.css("display") === "none") {
//         dots.css("display", "inline");
//         btnText.html(" Read More");
//         moreText.css("display", "none");
//     } else {
//         dots.css("display", "none");
//         btnText.html(" ... read less");
//         moreText.css("display", "inline");
//     }
// });

// $('.save-button').on('click', function () {
//     var row = $(this).closest('tr');
//     var webOrder = row.find('.web-order').val();
//     var webStatus = row.find('.web-status-switch').prop('checked');
//     var mobileOrder = row.find('.mobile-order').val();
//     var mobileStatus = row.find('.mobile-status-switch').prop('checked');
//     $.ajax({
//         url: '/admin/business-settings/home-layout',
//         method: 'POST',
//         data: {
//             webOrder: webOrder,
//             webStatus: webStatus,
//             mobileOrder: mobileOrder,
//             mobileStatus: mobileStatus,
//         },
//         success: function (response) {
//             console.log('Data saved successfully!');
//             row.removeClass('row-changed');
//             $('.save-button').prop('disabled', true);
//         },
//         error: function (xhr, status, error) {
//             console.error('Error:', status, error);
//         }
//     });
// });
