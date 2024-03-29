<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\Customer\CMS\HomeController;
use App\Http\Controllers\api\v1\ProductController;





Route::group(['namespace' => 'api\v1', 'prefix' => 'v1', 'middleware' => ['api_lang']], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/categories', [HomeController::class, 'NewArrtival']);
    Route::get('/categories/all', [HomeController::class, 'AllCategorys']);
    Route::get('/categories/{id}', [HomeController::class, 'CategoryDetail']);

    Route::get('/promo', [HomeController::class, 'categoriesPromo']);
    Route::get('/promo/{id}', [HomeController::class, 'categoriesPromoSingle']);


    Route::get('/main-banner', [HomeController::class, 'MainBanner']);
    Route::get('/main-banner-section', [HomeController::class, 'MainBannerSection']);
    Route::get('/flash-deals', [HomeController::class, 'FlashDeals']);
    Route::get('/flash-deal/{id}', [HomeController::class, 'FlashDealProduct']);
    Route::get('/footer-banner', [HomeController::class, 'FooterBanner']);

    Route::group(['prefix' => 'article'], function () {
        Route::get('category/all', [HomeController::class, 'allCategoryArticle']);
        Route::get('category/{id}', [HomeController::class, 'ArticleByCategory']);
        Route::get('/{id}', [HomeController::class, 'ArticleDetail']);
    });

    Route::group(['prefix' => 'brand'], function () {
        Route::get('/', [HomeController::class, 'AllBrands']);
        Route::get('/{id}', [HomeController::class, 'BrandDetails']);
    });

    Route::group(['prefix' => 'shop'], function () {
        Route::get('/', [HomeController::class, 'AllShops']);
        Route::get('/{id}', [HomeController::class, 'ShopDetails']);
    });
    Route::group(['middleware' => 'auth:api','prefix' => 'auth', 'namespace' => 'auth'], function () {
        Route::group(['prefix' => 'quiz'],function(){
            Route::get('category','QuizController@AllQuizCategory')->name('category.all');
            Route::get('category/{id}','QuizController@QuizCategoryDetail')->name('category.detail');
            Route::get('/{id}','QuizController@Quiz')->name('quiz.detail');
            Route::post('submit','QuizController@SubmitQuiz')->name('quiz.submit');
        });
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('switch-user/{id}',[HomeController::class, 'SwitchUser']);
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('/list', [ProductController::class, 'list'])->name('list');
        Route::get('/detail/{id}', [ProductController::class, 'show'])->name('detail');
    });



    Route::group(['prefix' => 'auth', 'namespace' => 'auth'], function () {
        Route::get('user', 'PassportAuthController@details');
        Route::post('register', 'PassportAuthController@register');
        Route::post('login', 'PassportAuthController@code');
        Route::post('code', 'PassportAuthController@login')->name('login');
        Route::post('logout', 'PassportAuthController@logout')->middleware('auth:api');

        Route::post('check-phone', 'PhoneVerificationController@check_phone');
        Route::post('resend-otp-check-phone', 'PhoneVerificationController@resend_otp_check_phone');
        Route::post('verify-phone', 'PhoneVerificationController@verify_phone');

        Route::post('check-email', 'EmailVerificationController@check_email');
        Route::post('resend-otp-check-email', 'EmailVerificationController@resend_otp_check_email');
        Route::post('verify-email', 'EmailVerificationController@verify_email');

        Route::post('forgot-password', 'ForgotPassword@reset_password_request');
        Route::post('verify-otp', 'ForgotPassword@otp_verification_submit');
        Route::put('reset-password', 'ForgotPassword@reset_password_submit');

        Route::any('social-login', 'SocialAuthController@social_login');
        Route::post('update-phone', 'SocialAuthController@update_phone');
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('profile/update-user', 'SocialAuthController@update_user');
        });

    });

    Route::group(['prefix' => 'config'], function () {
        Route::get('/', 'ConfigController@configuration');
    });

    Route::group(['prefix' => 'shipping-method','middleware'=>'apiGuestCheck'], function () {
        Route::get('detail/{id}', 'ShippingMethodController@get_shipping_method_info');
        Route::get('by-seller/{id}/{seller_is}', 'ShippingMethodController@shipping_methods_by_seller');
        Route::post('choose-for-order', 'ShippingMethodController@choose_for_order');
        Route::get('chosen', 'ShippingMethodController@chosen_shipping_methods');

        Route::get('check-shipping-type','ShippingMethodController@check_shipping_type');
    });

    Route::group(['prefix' => 'cart','middleware'=>'auth:api'], function () {
        Route::get('/', 'CartController@cart');
        Route::post('add', 'CartController@add_to_cart');
        Route::put('update/{id}', 'CartController@update_cart');
        Route::delete('remove/{id}', 'CartController@remove_from_cart');
        Route::delete('remove-all/{id}','CartController@remove_all_from_cart');

    });



    Route::group(['prefix' => 'customer/order', 'middleware'=>'apiGuestCheck'], function () {
        Route::get('get-order', 'CustomerController@get_order_by_id');
    });

    Route::get('faq', 'GeneralController@faq');

    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', 'NotificationController@list');
        Route::get('/seen', 'NotificationController@notification_seen')->middleware('auth:api');
    });

    Route::group(['prefix' => 'attributes'], function () {
        Route::get('/', 'AttributeController@get_attributes');
    });



    // Route::group(['prefix' => 'flash-deals'], function () {
    //     Route::get('/', 'FlashDealController@get_flash_deal');
    //     Route::get('products/{deal_id}', 'FlashDealController@get_products');
    // });

    Route::group(['prefix' => 'deals'], function () {
        Route::get('featured', 'DealController@get_featured_deal');
    });

    Route::group(['prefix' => 'dealsoftheday'], function () {
        Route::get('deal-of-the-day', 'DealOfTheDayController@get_deal_of_the_day_product');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('reviews/{product_id}', [ProductController::class, 'get_product_reviews']);
        Route::get('rating/{product_id}', [ProductController::class, 'get_product_rating']);
        Route::get('counter/{product_id}', [ProductController::class, 'counter']);
        Route::get('shipping-methods', [ProductController::class, 'get_shipping_methods']);
        Route::get('social-share-link/{product_id}', [ProductController::class, 'social_share_link']);
        Route::post('reviews/submit', [ProductController::class, 'submit_product_review'])->middleware('auth:api');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'products'], function () {
            Route::get('latest', [ProductController::class, 'get_latest_products']);
            Route::get('featured', [ProductController::class, 'get_featured_products']);
            Route::get('top-rated', [ProductController::class, 'get_top_rated_products']);
            Route::any('search', [ProductController::class, 'get_searched_products']);
            Route::post('filter', [ProductController::class, 'product_filter']);
            Route::any('suggestion-product', [ProductController::class, 'get_suggestion_product']);
            Route::get('details/{slug}', [ProductController::class, 'get_product']);
            Route::get('related-products/{product_id}', [ProductController::class, 'get_related_products']);
            Route::get('best-sellings', [ProductController::class, 'get_best_sellings']);
            Route::get('home-categories', [ProductController::class, 'get_home_categories']);
            Route::get('discounted-product', [ProductController::class, 'get_discounted_product']);
            Route::get('most-demanded-product', [ProductController::class, 'get_most_demanded_product']);
            Route::get('shop-again-product', [ProductController::class, 'get_shop_again_product'])->middleware('auth:api');
            Route::get('just-for-you', [ProductController::class, 'just_for_you']);
            Route::get('most-searching', [ProductController::class, 'get_most_searching_products']);
        });

        Route::group(['prefix' => 'seller'], function () {
            Route::get('{seller_id}/products', 'SellerController@get_seller_products');
            Route::get('{seller_id}/seller-best-selling-products', 'SellerController@get_seller_best_selling_products');
            Route::get('{seller_id}/seller-featured-product', 'SellerController@get_sellers_featured_product');
            Route::get('{seller_id}/seller-recommended-products', 'SellerController@get_sellers_recommended_products');
        });

        // Route::group(['prefix' => 'categories'], function () {
        //     Route::get('/', 'CategoryController@get_categories');
        //     Route::get('products/{category_id}', 'CategoryController@get_products');
        //     Route::get('/find-what-you-need', 'CategoryController@find_what_you_need');
        // });

        Route::group(['prefix' => 'brands'], function () {
            Route::get('/', 'BrandController@get_brands');
            Route::get('products/{brand_id}', 'BrandController@get_products');
        });

        Route::group(['prefix' => 'customer'], function () {
            Route::put('cm-firebase-token', 'CustomerController@update_cm_firebase_token');

            Route::get('get-restricted-country-list', 'CustomerController@get_restricted_country_list');
            Route::get('get-restricted-zip-list', 'CustomerController@get_restricted_zip_list');

            Route::group(['prefix' => 'address'], function () {
                Route::post('add', 'CustomerController@add_new_address');
                Route::get('list', 'CustomerController@address_list');
                Route::delete('/', 'CustomerController@delete_address');
            });

            Route::group(['prefix' => 'order'], function () {
                Route::get('list', 'CustomerController@get_order_list');
                Route::get('procede-to-next', 'OrderController@ProcedeToNext');
                Route::post('place', 'OrderController@place_order');
                Route::get('offline-payment-method-list', 'OrderController@offline_payment_method_list');
                Route::post('place-by-offline-payment', 'OrderController@place_order_by_offline_payment');
                // Route::get('details', 'CustomerController@get_order_details');
                Route::get('detail/{id}', 'CustomerController@get_order_by_id');
            });
        });
    });
    Route::group(['prefix' => 'auth', 'middleware' => 'auth:api'], function () {
        Route::get('user', 'CustomerController@info');
    });

    Route::group(['prefix' => 'child', 'middleware' => 'auth:api'], function () {
        Route::get('/', 'CustomerController@Mychild');
        Route::get('list', 'CustomerController@Mychild');
        Route::post('add-child', 'CustomerController@Addchild');
        Route::put('update/{id}', 'CustomerController@Updatechild');
        Route::get('detail/{id}', 'CustomerController@Detailchild');
        Route::post('update', 'CustomerController@Updatechild');
        Route::delete('delete/{id}', 'CustomerController@Deletechild');
        Route::group(['prefix' => 'growth'], function () {
            Route::get('/{id}', 'CustomerController@GrowthGet');
            Route::post('add/{id}', 'CustomerController@GrowthUpdate');
        });
        Route::group(['prefix' => 'vaccination'], function () {
            Route::get('/{id}', 'CustomerController@Vaccination');
            Route::post('add/{id}', 'CustomerController@VaccinationSubmission');
        });
        Route::group(['prefix' => 'vaccination_submission'], function () {
            Route::get('/{id}', 'CustomerController@VaccinationSubmissionGet');
        });
    });
    Route::group(['prefix' => 'customer', 'middleware' => 'auth:api'], function () {
        Route::get('info', 'CustomerController@info');
        Route::post('add-address', 'CustomerController@AddAdress');
        Route::put('update-address/{id}', 'CustomerController@UpdateAdress');
        Route::delete('delete-address/{id}', 'CustomerController@DeleteAddress');
        Route::get('address-detail/{id}', 'CustomerController@GetAdress');
        Route::get('address', 'CustomerController@Address');
        Route::get('address/list', 'CustomerController@Address');
        Route::put('update-profile', 'CustomerController@update_profile');
        Route::post('change-avatar', 'CustomerController@ChangeAvatar');
        Route::get('account-delete/{id}','CustomerController@account_delete');
        Route::group(['prefix' => 'qna'], function () {
            Route::get('question/', 'CustomerController@AllQuestion');
            Route::post('question/add', 'CustomerController@AddQuestion');
            Route::post('answer/add', 'CustomerController@AddAnswer');
        });

        Route::group(['prefix' => 'address'], function () {
            Route::get('get/{id}', 'CustomerController@get_address');
            Route::put('update', 'CustomerController@update_address');
        });

        Route::group(['prefix' => 'support-ticket'], function () {
            Route::post('create', 'CustomerController@create_support_ticket');
            Route::get('get', 'CustomerController@get_support_tickets');
            Route::get('conv/{ticket_id}', 'CustomerController@get_support_ticket_conv');
            Route::post('reply/{ticket_id}', 'CustomerController@reply_support_ticket');
            Route::get('close/{id}', 'CustomerController@support_ticket_close');
        });

        Route::group(['prefix' => 'compare'], function () {
            Route::get('list', 'CompareController@list');
            Route::post('product-store', 'CompareController@compare_product_store');
            Route::delete('clear-all', 'CompareController@clear_all');
            Route::get('product-replace', 'CompareController@compare_product_replace');
        });

        Route::group(['prefix' => 'wish-list'], function () {
            Route::get('/', 'CustomerController@wish_list');
            Route::post('add', 'CustomerController@add_to_wishlist');
            Route::delete('remove', 'CustomerController@remove_from_wishlist');
        });

        Route::group(['prefix' => 'order'], function () {
            Route::get('place-by-wallet', 'OrderController@place_order_by_wallet');
            Route::get('refund', 'OrderController@refund_request');
            Route::post('refund-store', 'OrderController@store_refund');
            Route::get('refund-details', 'OrderController@refund_details');
            Route::get('list', 'CustomerController@get_order_list');
            Route::post('deliveryman-reviews/submit', [ProductController::class, 'submit_deliveryman_review'])->middleware('auth:api');
            Route::post('again', 'OrderController@order_again');
        });
        // Chatting
        Route::group(['prefix' => 'chat'], function () {
            Route::get('list/{type}', 'ChatController@list');
            Route::get('get-messages/{type}/{id}', 'ChatController@get_message');
            Route::post('send-message/{type}', 'ChatController@send_message');
            Route::post('seen-message/{type}', 'ChatController@seen_message');
            Route::get('search/{type}', 'ChatController@search');
        });

        //wallet
        Route::group(['prefix' => 'wallet'], function () {
            Route::get('list', 'UserWalletController@list');
            Route::get('bonus-list', 'UserWalletController@bonus_list');
        });
        //loyalty
        Route::group(['prefix' => 'loyalty'], function () {
            Route::get('list', 'UserLoyaltyController@list');
            Route::post('loyalty-exchange-currency', 'UserLoyaltyController@loyalty_exchange_currency');
        });
    });


    Route::group(['prefix' => 'customer', 'middleware' => 'apiGuestCheck'], function () {
        Route::group(['prefix' => 'order'], function () {
            Route::get('digital-product-download/{id}', 'OrderController@digital_product_download');
            Route::get('digital-product-download-otp-verify', 'OrderController@digital_product_download_otp_verify');
            Route::post('digital-product-download-otp-resend', 'OrderController@digital_product_download_otp_resend');
        });
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('track', 'OrderController@track_by_order_id');
        Route::get('cancel-order','OrderController@order_cancel');
        Route::post('track-order','OrderController@track_order');
    });

    Route::group(['prefix' => 'banners'], function () {
        Route::get('/', 'BannerController@get_banners');
    });

    Route::group(['prefix' => 'seller'], function () {
        Route::get('/', 'SellerController@get_seller_info');
        Route::get('top', 'SellerController@get_top_sellers');
        Route::get('all', 'SellerController@get_all_sellers');
        Route::get('more', 'SellerController@more_sellers');
    });

    Route::group(['prefix' => 'coupon','middleware' => 'auth:api'], function () {
        Route::get('apply', 'CouponController@apply');
    });
    Route::get('coupon/list', 'CouponController@list')->middleware('auth:api');
    Route::get('coupon/applicable-list', 'CouponController@applicable_list')->middleware('auth:api');
    Route::get('coupons/{seller_id}/seller-wise-coupons', 'CouponController@get_seller_wise_coupon');

    Route::get('get-guest-id', 'GeneralController@get_guest_id');

    //map api
    Route::group(['prefix' => 'mapapi'], function () {
        Route::get('place-api-autocomplete', 'MapApiController@place_api_autocomplete');
        Route::get('distance-api', 'MapApiController@distance_api');
        Route::get('place-api-details', 'MapApiController@place_api_details');
        Route::get('geocode-api', 'MapApiController@geocode_api');
    });

    Route::post('contact-us', 'GeneralController@contact_store');
    Route::put('customer/language-change', 'CustomerController@language_change')->middleware('auth:api');
});
