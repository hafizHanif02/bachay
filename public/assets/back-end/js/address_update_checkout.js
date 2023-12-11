function SubmitShippingAddress() {
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

function UpdateBillingAddress(){
    var formData = $('#billing_address_form').serialize();

$.ajax({
    url: '/update_billing_address',
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

function CheckoutFormSubmit(){
    var billing_address_data = $('#billing_address_form').serialize();
    var shipping_address_data = $('#shipping_address_form').serialize();
    var billing_address = $('#billing_address_input').val();
    var shipping_address = $('#shipping_address_input').val();

    // console.log(billing_address);

    $('#shipping_address').val(shipping_address);
    $('#shipping_address_data').val(shipping_address_data);
    $('#billing_address').val(billing_address);
    $('#billing_address_data').val(billing_address_data);


    $('#order-form').submit();
}

// function billing-address-form() {
//     console.log('Function called!');
//     var formData = $('#shipping_address_form').serialize();

// $.ajax({
//     url: '/update_shipping_address',
//     method: 'POST',
//     data: formData,
//     success: function (response) {
//         showSuccessPopup(response.message);
//     },
//     error: function (error) {
//         console.log(error);
//     }
// });
// }

function showSuccessPopup(message) {
    var popup = $('<div class="popup">').html('<img src="../public/assets/back-end/img/orderPlacedGif.gif" alt="Checked Mark" style="width: 70px; height: 70px;"><div><p>' + message + '</p></div>');

    // Add styles to the popup
    popup.css({
        position: 'fixed',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        backgroundColor: '#ffffff',
        border: '1px solid #ffffff',
        padding: '15px',
        boxShadow: '0 0 10px 1px #808080',
        'border-radius': '5px',
    });
    
    

    // Append the popup to the body
    $('body').append(popup);

    // Remove the popup after 5 seconds
    setTimeout(function () {
        popup.remove();
    }, 2200);
}

