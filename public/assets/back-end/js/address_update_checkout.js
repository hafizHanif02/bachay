function SubmitShippingAddress() {
    console.log('Function called!');
    var formData = $('#shipping_address_form').serialize();

$.ajax({
    url: '/update_shipping_address',
    method: 'POST',
    data: formData,
    success: function (response) {
        showSuccessPopup(response.message);
    },
    error: function (error) {
        console.log(error);
    }
});
}

function billing-address-form() {
    console.log('Function called!');
    var formData = $('#shipping_address_form').serialize();

$.ajax({
    url: '/update_shipping_address',
    method: 'POST',
    data: formData,
    success: function (response) {
        showSuccessPopup(response.message);
    },
    error: function (error) {
        console.log(error);
    }
});
}

function showSuccessPopup(message) {
var popup = $('<div class="popup">').html(`<div class="tick-animation"></div><p> ${message} </p>
<style>   
.tick-animation {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 5px solid #28a745; /* Bootstrap success color */
    border-top: 5px solid transparent;
    border-right: 5px solid transparent;
    animation: rotate 1s infinite linear;
}

@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Popup styles */
.popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ffffff;
    border: 1px solid #28a745;
    padding: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}
</style>`);
$('body').append(popup);
setTimeout(function() {
    popup.remove();
}, 3000);
}
