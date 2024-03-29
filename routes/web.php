<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Payment_Methods\SslCommerzPaymentController;
use App\Http\Controllers\Payment_Methods\StripePaymentController;
use App\Http\Controllers\Payment_Methods\PaymobController;
use App\Http\Controllers\Payment_Methods\FlutterwaveV3Controller;
use App\Http\Controllers\Payment_Methods\PaytmController;
use App\Http\Controllers\Payment_Methods\PaypalPaymentController;
use App\Http\Controllers\Payment_Methods\PaytabsController;
use App\Http\Controllers\Payment_Methods\LiqPayController;
use App\Http\Controllers\Payment_Methods\RazorPayController;
use App\Http\Controllers\Payment_Methods\SenangPayController;
use App\Http\Controllers\Payment_Methods\MercadoPagoController;
use App\Http\Controllers\Payment_Methods\BkashPaymentController;
use App\Http\Controllers\Payment_Methods\PaystackController;
use App\Http\Controllers\Auth\SocialController;

//for maintenance mode
Route::get('maintenance-mode', 'Web\WebController@maintenance_mode')->name('maintenance-mode');
route::get('naveedyousuf', function () {
    return view('naveedyousufcard');
});

Route::group(['namespace' => 'Web', 'middleware' => ['maintenance_mode', 'guestCheck']], function () {
    // Route::get('/', 'HomeController@commingsoon');
    Route::get('/', 'HomeController@index')->name('home');

    Route::post('/add-to-wishlist', 'WebController@addToWishlist')->name('wishlist.add');
    // Route::post('/delete-from-wishlist', 'WebController@deleteFromWishlist')->name('wishlist.delete');
    Route::post('/add-to-cart', 'WebController@addToCart')->name('carts.add');

    Route::get('switch-child', 'WebController@switch_child')->name('switch-child');
    Route::get('quick-view', 'WebController@quick_view')->name('quick-view');
    Route::get('searched-products', 'WebController@searched_products')->name('searched-products');

    Route::group(['middleware' => ['customer']], function () {
        Route::get('submit-review/{id}', 'UserProfileController@submit_review')->name('submit-review');
        Route::post('review', 'ReviewController@store')->name('review.store');
        Route::get('deliveryman-review/{id}', 'ReviewController@delivery_man_review')->name('deliveryman-review');
        Route::post('submit-deliveryman-review', 'ReviewController@delivery_man_submit')->name('submit-deliveryman-review');
        Route::post('update-profile-detail', 'UserProfileController@UpdateProfileDetail')->name('customer.update-profile-detail');
    });

    Route::get('checkout-details', 'WebController@checkout_details')->name('checkout-details');
    Route::post('update_shipping_address', 'WebController@update_shipping_address')->name('update_shipping_address');
    Route::post('update_billing_address', 'WebController@update_billing_address')->name('update_billing_address');
    // Route::get('checkout-shipping', 'WebController@checkout_shipping')->name('checkout-shipping');
    Route::post('checkout-payment', 'WebController@checkout_payment')->name('checkout-payment');
    Route::post('cart/checkout-payment', 'WebController@checkout_payment')->name('cart.checkout-payment');
    Route::get('checkout-review', 'WebController@checkout_review')->name('checkout-review');
    Route::get('checkout-complete', 'WebController@checkout_complete')->name('checkout-complete');
    Route::post('offline-payment-checkout-complete', 'WebController@offline_payment_checkout_complete')->name('offline-payment-checkout-complete');
    Route::get('order-placed', 'WebController@order_placed')->name('order-placed');
    Route::get('shop-cart', 'WebController@shop_cart')->name('shop-cart');
    Route::post('order_note', 'WebController@order_note')->name('order_note');
    Route::get('digital-product-download/{id}', 'WebController@digital_product_download')->name('digital-product-download');
    Route::post('digital-product-download-otp-verify', 'WebController@digital_product_download_otp_verify')->name('digital-product-download-otp-verify');
    Route::post('digital-product-download-otp-reset', 'WebController@digital_product_download_otp_reset')->name('digital-product-download-otp-reset');
    Route::get('pay-offline-method-list', 'WebController@pay_offline_method_list')->name('pay-offline-method-list')->middleware('guestCheck');

    //wallet payment
    Route::get('checkout-complete-wallet', 'WebController@checkout_complete_wallet')->name('checkout-complete-wallet');

    Route::post('subscription', 'WebController@subscription')->name('subscription');
    Route::get('search-shop', 'WebController@search_shop')->name('search-shop');

    Route::get('categories', 'WebController@all_categories')->name('categories');
    Route::get('category/{Slug}', 'WebController@single_categories')->name('single.category');
    // Route::get('categories/{category}', 'WebController@category_product')->name('categories');

    // Route::get('/categories/{category}', [WebController::class, 'showCategoryProducts'])->name('category.products');
    Route::get('sub-category', 'WebController@sub_categories')->name('sub-categories');
    Route::get('category-ajax/{id}', 'WebController@categories_by_category')->name('category-ajax');

    Route::get('brands', 'WebController@all_brands')->name('brands');
    Route::get('sellers', 'WebController@all_sellers')->name('sellers');
    Route::get('seller-profile/{id}', 'WebController@seller_profile')->name('seller-profile');

    Route::get('flash-deals/{id}', 'WebController@flash_deals')->name('flash-deals');

    /** Pages */
    Route::get('terms', 'PageController@termsand_condition')->name('terms');
    Route::get('privacy-policy', 'PageController@privacy_policy')->name('privacy-policy');
    Route::get('refund-policy', 'PageController@refund_policy')->name('refund-policy');
    Route::get('return-policy', 'PageController@return_policy')->name('return-policy');
    Route::get('cancellation-policy', 'PageController@cancellation_policy')->name('cancellation-policy');
    Route::get('helpTopic', 'PageController@helpTopic')->name('helpTopic');
    Route::get('contact-us', 'PageController@contacts')->name('contacts');
    Route::get('about-us', 'PageController@about_us')->name('about-us');

    // Route::get('/product/{slug}', 'ProductDetailsController@product')->name('product');
    // Route::get('products', 'ProductListController@products')->name('products');

    // Social login routes
    // Route::get('/login/{provider}', [SocialController::class, 'redirectToProvider'])->name('social.redirect');
    // Route::get('/login/{provider}/callback', [SocialController::class, 'handleProviderCallback'])->name('social.callback');

    Route::get('product-list', 'ProductListController@default_theme')->name('product-list');
    Route::get('product-list/{slug}', 'WebController@flash_deals')->name('product-list-slug');

    Route::get('product-detail/{product}', 'ProductDetailsController@product')->name('product-detail');


    Route::get('my-cart-address', 'CartController@cart_address')->name('my-cart-address');
    Route::post('add-to-cart', 'CartController@addToCart')->name('add-to-cart');
    Route::get('my-cart-added', 'CartController@cart_added')->name('my-cart-added');
    Route::get('add-payment', 'CartController@add_payment')->name('add-payment');
    Route::get('my-shortlist', 'CartController@my_shortlist')->name('my-shortlist');

    Route::post('ajax-filter-products', 'ShopViewController@ajax_filter_products')->name('ajax-filter-products'); // Theme fashion, ALl purpose
    route::get('my-order', 'WebController@my_order')->name('my-order');
    route::get('manage-returns', 'WebController@manage_returns')->name('manage-returns');
    route::get('return-detail', 'WebController@return_detail')->name('return-detail');
    route::get('quick-reorder', 'WebController@quick_reorder')->name('quick-reorder');
    route::get('order-available', 'WebController@order_available')->name('order-available');
    route::get('track-orders', 'WebController@track_order')->name('track-orders');
    route::get('your-query', 'WebController@your_query')->name('your-query');
    route::get('club-cash', 'WebController@club_cash')->name('club-cash');
    route::get('cash-refund', 'WebController@cash_refund')->name('cash-refund');
    route::get('my-payment-detail-not-added', 'WebController@payments_not_added')->name('my-payment-detail-not-added');
    route::get('my-payment-detail-added', 'WebController@payments_added')->name('my-payment-detail-added');
    route::get('save-cards', 'WebController@save_cards')->name('save-cards');
    route::get('cash-coupons', 'WebController@cash_coupons')->name('cash-coupons');
    route::get('cash-back-codes', 'WebController@cash_back_codes')->name('cash-back-codes');
    route::get('my-refund-no-refund', 'WebController@no_refund')->name('my-refund-no-refund');
    route::get('my-refund', 'WebController@my_refund')->name('my-refund');
    route::get('my-bpl-vouchers', 'WebController@bpl_vouchers')->name('my-bpl-vouchers');
    route::get('guaranteed-savings', 'WebController@guaranteed_savings')->name('guaranteed-savings');
    route::get('guaranteed-savings-offer', 'WebController@guaranteed_savings_offer')->name('guaranteed-savings-offer');
    route::get('guaranteed-savings-offer-brand', 'WebController@guaranteed_savings_offer_brand')->name('guaranteed-savings-offer-brand');
    route::get('intelli-education', 'WebController@intelli_education')->name('intelli-education');
    route::get('gift-certification', 'WebController@gift_certification')->name('gift-certification');
    route::get('invites-credits', 'WebController@invites_credits')->name('invites-credits');
    route::get('my-reviews-upload', 'WebController@my_reviews_upload')->name('my-reviews-upload');





    Route::get('orderDetails', 'WebController@orderdetails')->name('orderdetails');
    Route::get('discounted-products', 'WebController@discounted_products')->name('discounted-products');
    Route::post('/products-view-style', 'WebController@product_view_style')->name('product_view_style');

    Route::post('review-list-product', 'WebController@review_list_product')->name('review-list-product');
    Route::post('review-list-shop', 'WebController@review_list_shop')->name('review-list-shop'); // theme fashion
    //Chat with seller from product details
    Route::get('chat-for-product', 'WebController@chat_for_product')->name('chat-for-product');

    Route::get('wishlists', 'WebController@viewWishlist')->name('wishlists')->middleware('customer');
    Route::post('store-wishlist', 'WebController@storeWishlist')->name('store-wishlist');
    Route::post('delete-wishlist', 'WebController@deleteWishlist')->name('delete-wishlist');
    Route::get('delete-wishlist-all', 'WebController@delete_wishlist_all')->name('delete-wishlist-all')->middleware('customer');

    Route::post('/add-to-cart', 'WebController@addToCart')->name('carts.add');
    Route::get('cart', 'WebController@viewCart')->name('cart')->middleware('customer');
    Route::post('store-cart', 'WebController@storeCart')->name('store-cart');
    Route::post('delete-cart', 'WebController@deleteCart')->name('delete-cart');
    Route::get('delete-cart-all', 'WebController@delete_cart_all')->name('delete-cart-all')->middleware('customer');



    Route::post('/currency', 'CurrencyController@changeCurrency')->name('currency.change');

    // theme_aster compare list
    Route::get('compare-list', 'CompareController@index')->name('compare-list');
    Route::get('delete-compare-list-all', 'CompareController@delete_compare_list_all')->name('delete-compare-list-all');
    Route::any('store-compare-list', 'CompareController@store_compare_list')->name('store-compare-list');
    // end theme_aster compare list
    Route::get('searched-products-for-compare', 'WebController@searched_products_for_compare_list')->name('searched-products-compare'); // theme fashion compare list
    Route::get('delete-compare-list', 'CompareController@delete_compare_list')->name('delete-compare-list');

    //profile Route
    route::get('my-profile', 'UserProfileController@default_theme')->name('my-profile');
    route::post('address-store', 'UserProfileController@AddressStore')->name('address.store');
    route::post('change-password', 'UserProfileController@ChangePassword')->name('change-password');
    Route::get('user-profile', 'UserProfileController@user_profile')->name('user-profile')->middleware('customer'); //theme_aster
    Route::get('user-account', 'UserProfileController@user_account')->name('user-account')->middleware('customer');
    Route::post('user-account-update', 'UserProfileController@user_update')->name('user-update');
    Route::post('user-account-picture', 'UserProfileController@user_picture')->name('user-picture');
    Route::get('account-address-add', 'UserProfileController@account_address_add')->name('account-address-add');
    Route::get('account-address', 'UserProfileController@account_address')->name('account-address');
    Route::post('account-address-store', 'UserProfileController@address_store')->name('address-store');
    Route::get('account-address-delete', 'UserProfileController@address_delete')->name('address-delete');
    ROute::get('account-address-edit/{id}', 'UserProfileController@address_edit')->name('address-edit');
    Route::post('account-address-update', 'UserProfileController@address_update')->name('address-update');
    Route::get('account-payment', 'UserProfileController@account_payment')->name('account-payment');
    Route::get('account-oder', 'UserProfileController@account_oder')->name('account-oder')->middleware('customer');
    Route::get('account-order-details', 'UserProfileController@account_order_details')->name('account-order-details')->middleware('customer');
    Route::get('account-order-details-seller-info', 'UserProfileController@account_order_details_seller_info')->name('account-order-details-seller-info')->middleware('customer');
    Route::get('account-order-details-delivery-man-info', 'UserProfileController@account_order_details_delivery_man_info')->name('account-order-details-delivery-man-info')->middleware('customer');
    Route::get('account-order-details-reviews', 'UserProfileController@account_order_details_reviews')->name('account-order-details-reviews')->middleware('customer');
    Route::get('generate-invoice/{id}', 'UserProfileController@generate_invoice')->name('generate-invoice');
    Route::get('account-wishlist', 'UserProfileController@account_wishlist')->name('account-wishlist'); //add to card not work
    Route::get('refund-request/{id}', 'UserProfileController@refund_request')->name('refund-request');
    Route::get('refund-details/{id}', 'UserProfileController@refund_details')->name('refund-details');
    Route::post('refund-store', 'UserProfileController@store_refund')->name('refund-store');
    Route::get('account-tickets', 'UserProfileController@account_tickets')->name('account-tickets');
    Route::get('order-cancel/{id}', 'UserProfileController@order_cancel')->name('order-cancel');
    Route::post('ticket-submit', 'UserProfileController@ticket_submit')->name('ticket-submit');
    Route::get('account-delete/{id}', 'UserProfileController@account_delete')->name('account-delete');
    Route::get('refer-earn', 'UserProfileController@refer_earn')->name('refer-earn')->middleware('customer');
    Route::get('user-coupons', 'UserProfileController@user_coupons')->name('user-coupons')->middleware('customer');
    // Chatting start
    Route::get('chat/{type}', 'ChattingController@chat_list')->name('chat')->middleware('customer');
    Route::get('messages', 'ChattingController@messages')->name('messages');
    Route::post('messages-store', 'ChattingController@messages_store')->name('messages_store');

    // chatting end

    //Support Ticket
    Route::group(['prefix' => 'support-ticket', 'as' => 'support-ticket.'], function () {
        Route::get('{id}', 'UserProfileController@single_ticket')->name('index');
        Route::post('{id}', 'UserProfileController@comment_submit')->name('comment');
        Route::get('delete/{id}', 'UserProfileController@support_ticket_delete')->name('delete');
        Route::get('close/{id}', 'UserProfileController@support_ticket_close')->name('close');
    });

    Route::get('account-transaction', 'UserProfileController@account_transaction')->name('account-transaction');
    Route::get('account-wallet-history', 'UserProfileController@account_wallet_history')->name('account-wallet-history');

    Route::get('wallet-account', 'UserWalletController@my_wallet_account')->name('wallet-account'); //theme fashion
    Route::get('wallet', 'UserWalletController@index')->name('wallet')->middleware('customer');
    Route::get('loyalty', 'UserLoyaltyController@index')->name('loyalty')->middleware('customer');
    Route::post('loyalty-exchange-currency', 'UserLoyaltyController@loyalty_exchange_currency')->name('loyalty-exchange-currency');
    Route::get('ajax-loyalty-currency-amount', 'UserLoyaltyController@ajax_loyalty_currency_amount')->name('ajax-loyalty-currency-amount');

    Route::group(['prefix' => 'track-order', 'as' => 'track-order.'], function () {
        Route::get('', 'UserProfileController@track_order')->name('index');
        Route::get('result-view', 'UserProfileController@track_order_result')->name('result-view');
        Route::get('last', 'UserProfileController@track_last_order')->name('last');
        Route::any('result', 'UserProfileController@track_order_result')->name('result');
        Route::get('order-wise-result-view', 'UserProfileController@track_order_wise_result')->name('order-wise-result-view');
    });

    // Route::group(['prefix' => 'child', 'middleware' => 'auth:api'], function () {
    //     Route::get('/', 'CustomerController@Mychild');
    //     Route::post('add-child', 'CustomerController@Addchild');
    //     Route::get('detail/{id}', 'CustomerController@Detailchild');
    //     Route::post('update', 'CustomerController@Updatechild');
    //     Route::delete('delete/{id}', 'CustomerController@Deletechild');
    // });

    //sellerShop
    Route::get('shopView/{id}', 'ShopViewController@seller_shop')->name('shopView');
    Route::get('ajax-shop-vacation-check', 'ShopViewController@ajax_shop_vacation_check')->name('ajax-shop-vacation-check'); //theme fashion
    Route::post('shopView/{id}', 'WebController@seller_shop_product');
    Route::post('shop-follow', 'ShopFollowerController@shop_follow')->name('shop_follow');

    //top Rated
    Route::get('top-rated', 'WebController@top_rated')->name('topRated');
    Route::get('best-sell', 'WebController@best_sell')->name('bestSell');
    Route::get('new-product', 'WebController@new_product')->name('newProduct');

    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
        Route::post('store', 'WebController@contact_store')->name('store');
        Route::get('/code/captcha/{tmp}', 'WebController@captcha')->name('default-captcha');
    });
});

//Seller shop apply
Route::group(['prefix' => 'shop', 'as' => 'shop.', 'namespace' => 'Seller\Auth'], function () {
    Route::get('apply', 'RegisterController@create')->name('apply');
    Route::post('apply', 'RegisterController@store');
});


Route::get('login/{tab}', 'LoginController@login')->name('login');
Route::post('login_submit', 'LoginController@submit')->name('login_post')->middleware('actch');
Route::get('auth/captcha/{tmp}', 'LoginController@captcha')->name('auth-default-captcha');


//check done
Route::group(['prefix' => 'cart', 'as' => 'cart.', 'namespace' => 'Web'], function () {
    Route::post('variant_price', 'CartController@variant_price')->name('variant_price');
    Route::post('add', 'CartController@addToCart')->name('add');
    Route::post('buy-now', 'CartController@BuyNow')->name('buy-now');
    Route::post('update-variation', 'CartController@update_variation')->name('update-variation'); //theme fashion
    Route::get('remove/{id}', 'CartController@removeFromCart')->name('remove');
    Route::post('remove-product/{product_id}/{customer_id}', 'CartController@removeCartProduct')->name('removeproduct');
    Route::get('remove-all', 'CartController@remove_all_cart')->name('remove-all'); //theme fashion
    Route::post('nav-cart-items', 'CartController@updateNavCart')->name('nav-cart');
    Route::post('floating-nav-cart-items', 'CartController@update_floating_nav')->name('floating-nav-cart-items'); // theme fashion floating nav
    Route::post('updateQuantity', 'CartController@updateQuantity')->name('updateQuantity');
    Route::post('updateQuantity-guest', 'CartController@updateQuantity_guest')->name('updateQuantity.guest');
    Route::post('order-again', 'CartController@order_again')->name('order-again')->middleware('customer');
});

//Seller shop apply
Route::group(['prefix' => 'coupon', 'as' => 'coupon.', 'namespace' => 'Web'], function () {
    Route::post('apply', 'CouponController@apply')->name('apply');
});
//check done

$is_published = 0;
try {
    $full_data = include('Modules/Gateways/Addon/info.php');
    $is_published = $full_data['is_published'] == 1 ? 1 : 0;
} catch (\Exception $exception) {
}

if (!$is_published) {
    Route::group(['prefix' => 'payment'], function () {

        //SSLCOMMERZ
        Route::group(['prefix' => 'sslcommerz', 'as' => 'sslcommerz.'], function () {
            Route::get('pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
            Route::post('success', [SslCommerzPaymentController::class, 'success'])
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::post('failed', [SslCommerzPaymentController::class, 'failed'])
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::post('canceled', [SslCommerzPaymentController::class, 'canceled'])
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //STRIPE
        Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function () {
            Route::get('pay', [StripePaymentController::class, 'index'])->name('pay');
            Route::get('token', [StripePaymentController::class, 'payment_process_3d'])->name('token');
            Route::get('success', [StripePaymentController::class, 'success'])->name('success');
        });

        //RAZOR-PAY
        Route::group(['prefix' => 'razor-pay', 'as' => 'razor-pay.'], function () {
            Route::get('pay', [RazorPayController::class, 'index']);
            Route::post('payment', [RazorPayController::class, 'payment'])->name('payment')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //PAYPAL
        Route::group(['prefix' => 'paypal', 'as' => 'paypal.'], function () {
            Route::get('pay', [PaypalPaymentController::class, 'payment']);
            Route::any('success', [PaypalPaymentController::class, 'success'])->name('success')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::any('cancel', [PaypalPaymentController::class, 'cancel'])->name('cancel')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //SENANG-PAY
        Route::group(['prefix' => 'senang-pay', 'as' => 'senang-pay.'], function () {
            Route::get('pay', [SenangPayController::class, 'index']);
            Route::any('callback', [SenangPayController::class, 'return_senang_pay']);
        });

        //PAYTM
        Route::group(['prefix' => 'paytm', 'as' => 'paytm.'], function () {
            Route::get('pay', [PaytmController::class, 'payment']);
            Route::any('response', [PaytmController::class, 'callback'])->name('response')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //FLUTTERWAVE
        Route::group(['prefix' => 'flutterwave-v3', 'as' => 'flutterwave-v3.'], function () {
            Route::get('pay', [FlutterwaveV3Controller::class, 'initialize'])->name('pay');
            Route::get('callback', [FlutterwaveV3Controller::class, 'callback'])->name('callback');
        });

        //PAYSTACK
        Route::group(['prefix' => 'paystack', 'as' => 'paystack.'], function () {
            Route::get('pay', [PaystackController::class, 'index'])->name('pay');
            Route::post('payment', [PaystackController::class, 'redirectToGateway'])->name('payment');
            Route::get('callback', [PaystackController::class, 'handleGatewayCallback'])->name('callback');
        });

        //BKASH

        Route::group(['prefix' => 'bkash', 'as' => 'bkash.'], function () {
            // Payment Routes for bKash
            Route::get('make-payment', [BkashPaymentController::class, 'make_tokenize_payment'])->name('make-payment');
            Route::any('callback', [BkashPaymentController::class, 'callback'])->name('callback');
        });

        //Liqpay
        Route::group(['prefix' => 'liqpay', 'as' => 'liqpay.'], function () {
            Route::get('payment', [LiqPayController::class, 'payment'])->name('payment');
            Route::any('callback', [LiqPayController::class, 'callback'])->name('callback');
        });

        //MERCADOPAGO
        Route::group(['prefix' => 'mercadopago', 'as' => 'mercadopago.'], function () {
            Route::get('pay', [MercadoPagoController::class, 'index'])->name('index');
            Route::post('make-payment', [MercadoPagoController::class, 'make_payment'])->name('make_payment');
        });

        //PAYMOB
        Route::group(['prefix' => 'paymob', 'as' => 'paymob.'], function () {
            Route::any('pay', [PaymobController::class, 'credit'])->name('pay');
            Route::any('callback', [PaymobController::class, 'callback'])->name('callback');
        });

        //PAYTABS
        Route::group(['prefix' => 'paytabs', 'as' => 'paytabs.'], function () {
            Route::any('pay', [PaytabsController::class, 'payment'])->name('pay');
            Route::any('callback', [PaytabsController::class, 'callback'])->name('callback');
            Route::any('response', [PaytabsController::class, 'response'])->name('response');
        });

        //Pay Fast
        Route::group(['prefix' => 'payfast', 'as' => 'payfast.'], function () {
            Route::get('pay', [PayFastController::class, 'payment'])->name('payment');
            Route::any('callback', [PayFastController::class, 'callback'])->name('callback');
        });
    });
}

Route::get('web-payment', 'Customer\PaymentController@web_payment_success')->name('web-payment-success');
Route::get('payment-success', 'Customer\PaymentController@success')->name('payment-success');
Route::get('payment-fail', 'Customer\PaymentController@fail')->name('payment-fail');

Route::get('/test', function () {
    return view('welcome');
});
