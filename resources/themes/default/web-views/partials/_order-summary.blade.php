@push('css_or_js')
<style>
    .cart_title {
        font-weight: 400 !important;
        font-size: 16px;
    }

    .cart_value {
        font-weight: 600 !important;
        font-size: 16px;
    }

    @media (max-width: 575px) {
        .cart_title,
        .cart_value {
            font-size: 14px;
        }
    }

    .cart_total_value {
        font-weight: 700 !important;
        font-size: 25px !important;
        color: {{$web_config['primary_color']}}     !important;
    }

    .__cart-total_sticky {
        position: sticky;
        top: 80px;
    }
    /**/
</style>

@endpush
<style>
    .textClr {
        font-family: 'Poppins';
        background: linear-gradient(90.27deg, #845dc2 -27.96%, #f99327 -27.94%, #d55fad 28.41%, #845dc2 82.13%, #845dc2 130.57%);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: normal;
    }
</style>
<aside class="col-lg-4 pt-4 pt-lg-2 px-max-md-0">
    <div class="__cart-total __cart-total_sticky">
        <div class="cart_total p-0">
            @php($shippingMethod=\App\CPU\Helpers::get_business_settings('shipping_method'))
            @php($sub_total=0)
            @php($total_tax=0)
            @php($total_shipping_cost=0)
            @php($order_wise_shipping_discount=\App\CPU\CartManager::order_wise_shipping_discount())
            @php($total_discount_on_product=0)
            @php($cart=\App\CPU\CartManager::get_cart())
            @php($cart_group_ids=\App\CPU\CartManager::get_cart_group_ids())
            @php($shipping_cost=\App\CPU\CartManager::get_shipping_cost())
            @php($get_shipping_cost_saved_for_free_delivery=\App\CPU\CartManager::get_shipping_cost_saved_for_free_delivery())
            @if($cart->count() > 0)
                @foreach($cart as $key => $cartItem)
                    @php($sub_total+=$cartItem['price']*$cartItem['quantity'])
                    @php($total_tax+=$cartItem['tax_model']=='exclude' ? ($cartItem['tax']*$cartItem['quantity']):0)
                    @php($total_discount_on_product+=$cartItem['discount']*$cartItem['quantity'])
                @endforeach

                @if(session()->missing('coupon_type') || session('coupon_type') !='free_delivery')
                    @php($total_shipping_cost=$shipping_cost - $get_shipping_cost_saved_for_free_delivery)
                @else
                    @php($total_shipping_cost=$shipping_cost)
                @endif
            @endif

            @if($total_discount_on_product > 0)
            <h6 class="textClr text-center text-primary mb-4 d-flex align-items-center justify-content-center gap-2">
                <img src="{{asset('public/images/offer_pic.png')}}" alt="" width="30px" height="30px">
                {{translate('you_have_Saved')}} <strong>{{\App\CPU\Helpers::currency_converter($data->discount_amount)}}!</strong>
            </h6>
            @endif

            <div class="d-flex justify-content-between">
                <span class="cart_title">{{translate('sub_total')}}</span>
                <span class="cart_value">
                    {{\App\CPU\Helpers::currency_converter($data->total_price)}}
                </span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="cart_title">{{translate('tax')}}</span>
                <span class="cart_value">
                    {{\App\CPU\Helpers::currency_converter($total_tax)}}
                </span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="cart_title">{{translate('shipping')}}</span>
                <span class="cart_value">
                    {{\App\CPU\Helpers::currency_converter($total_shipping_cost)}}
                </span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="cart_title">{{translate('discount_on_product')}}</span>
                <span class="cart_value">
                    - {{\App\CPU\Helpers::currency_converter($data->discount_amount)}}
                </span>
            </div>
            @php($coupon_dis=0)
            @if(auth('customer')->check())
                @if(session()->has('coupon_discount'))
                    @php($coupon_discount = session()->has('coupon_discount')?session('coupon_discount'):0)
                    <div class="d-flex justify-content-between">
                        <span class="cart_title">{{translate('coupon_discount')}}</span>
                        <span class="cart_value" id="coupon-discount-amount">
                            - {{\App\CPU\Helpers::currency_converter($coupon_discount+$order_wise_shipping_discount)}}
                        </span>
                    </div>
                    @php($coupon_dis=session('coupon_discount'))
                @else
                    <div class="pt-2">
                        <form class="needs-validation coupon-code-form" action="javascript:" method="post" novalidate id="coupon-code-ajax">
                            <div class="d-flex form-control rounded-pill pl-3 p-1">
                                <img src="http://localhost/public /images/gif.gif" alt="" width="35px" height="35px">
                                <input class="input_code border-0 px-2 text-dark bg-transparent outline-0 w-100" type="text" name="code" placeholder="{{translate('coupon_code')}}" required>
                                <button class="btn btn--primary rounded-pill text-uppercase py-1 fs-12" type="button" onclick="couponCode()">{{translate('apply')}}</button>
                            </div>
                            <div class="invalid-feedback">{{translate('please_provide_coupon_code')}}</div>
                        </form>
                    </div>
                    @php($coupon_dis=0)
                @endif
            @endif
            <hr class="my-2">
            <div class="d-flex justify-content-between">
                <span class="textClr cart_title text-primary font-weight-bold">{{translate('total')}}</span>
                <span class="cart_value">
                {{-- {{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product-$order_wise_shipping_discount)}} --}}
                {{\App\CPU\Helpers::currency_converter($data->final_payment)}}
                </span>
            </div>
        </div>
        @php($company_reliability = \App\CPU\Helpers::get_business_settings('company_reliability'))
        @if($company_reliability != null)
            <div class="mt-5">
                <div class="row justify-content-center g-4">
                    @foreach ($company_reliability as $key=>$value)
                        @if ($value['status'] == 1 && !empty($value['title']))
                            <div class="col-sm-3 px-0 text-center mobile-padding">
                                <img class="order-summery-footer-image" src="{{asset("/storage/app/public/company-reliability").'/'.$value['image']}}"
                                onerror="this.src='{{asset('/public/assets/front-end/img').'/'.$value['item'].'.png'}}'" alt="">
                                <div class="deal-title">{{translate($value['title'] ?? 'title_not_found')}}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        {{-- <button onclick="SubmitShippingAddress()" class="btn btn-primary rounded-pill mt-2"  id="address_submit">Update Address</button> --}}
        <form action="{{ 'checkout-payment' }}" id="order-form" method="Get">
            @csrf
            <input type="hidden" name="seller_id" value="1">
            <input type="hidden" name="seller_is" value="admin">
            <div class="row justify-content-center g-4 mt-4 mb-2">
                <div class="deal-title">Payment Method</div>
                        <div class="col-sm-12 px-0 text-center mobile-padding">
                            <select class="form-control" name="payment_method" id="">
                                <option value="cash" selected>Cash On Delivery</option>
                                <option value="card">Card Payment</option>
                            </select>
                        </div>
            </div>
            <input type="hidden" name="customer_id" value="{{ $data->customer_id }}">
            <input type="hidden" name="cart_group_id" value="{{ $data->cart_group_id }}">
            <input type="hidden" name="shipping_address" id="shipping_address" >
            <input type="hidden" name="shipping_address_data" id="shipping_address_data" >
            <input type="hidden" name="billing_address" id="billing_address" >
            <input type="hidden" name="billing_address_data" id="billing_address_data" >
            <input type="hidden" name="total_price" value="{{ $data->total_price }}">
            <input type="hidden" name="final_payment" value="{{ $data->final_payment }}">
            <input type="hidden" name="discount_amount" value="{{ $data->discount_amount }}">
            @foreach($data->product as $product)
            {{-- {{ dd($product) }} --}}
            <input type="hidden" name="product[{{ $loop->iteration }}][product_id]" value="{{ ($product['product_id'] ?? '') }}">
            <input type="hidden" name="product[{{ $loop->iteration }}][tax]" value="{{ ($product['tax'] ?? '') }}">
            <input type="hidden" name="product[{{ $loop->iteration }}][tax_model]" value="{{ ($product['tax_model'] ?? '') }}">
            <input type="hidden" name="product[{{ $loop->iteration }}][color]" value="{{ ($product['color'] ?? '') }}">
            <input type="hidden" name="product[{{ $loop->iteration }}][variant]" value="{{ ($product['variant'] ?? '') }}">
            <input type="hidden" name="product[{{ $loop->iteration }}][discount]" value="{{ ($product['discount'] ?? '') }}">
            <input type="hidden" name="product[{{ $loop->iteration }}][discount_amount]" value="{{ ($product['discount_amount'] ?? '') }}">
            <input type="hidden" name="product[{{ $loop->iteration }}][actual_price]" value="{{ ($product['actual_price'] ?? '') }}">
            <input type="hidden" name="product[{{ $loop->iteration }}][price]" value="{{ ($product['price'] ?? '') }}">
            <input type="hidden" name="product[{{ $loop->iteration }}][quantity]" value="{{ ($product['quantity'] ?? '') }}">      
            @endforeach

            <div class="mt-4">
                @if($web_config['guest_checkout_status'] || auth('customer')->check())
                {{-- <a  style="background: var( --greadient-normal, linear-gradient( 270deg, #845dc2 -0.09%, #d55fad 36.37%, #fc966c 72.82%, #f99327 100.48%, #ffc55d 145.17% ) ); border: 0px;" onclick="checkout()" class="col-12 btn btn--primary rounded-pill text-light btn-block proceed_to_next_button {{$cart->count() <= 0 ? 'disabled' : ''}}" >{{translate('proceed_to_Next')}}</a> --}}
                <button type="button" onclick="CheckoutFormSubmit()"  style="background: var( --greadient-normal, linear-gradient( 270deg, #845dc2 -0.09%, #d55fad 36.37%, #fc966c 72.82%, #f99327 100.48%, #ffc55d 145.17% ) ); border: 0px;" onclick="checkout()" class="col-12 btn btn--primary rounded-pill text-light btn-block proceed_to_next_button {{$cart->count() <= 0 ? 'disabled' : ''}}" >Place Order</button>
                @else
                    <a href="{{route('customer.auth.login')}}" class="btn btn--primary btn-block proceed_to_next_button {{$cart->count() <= 0 ? 'disabled' : ''}}" >Place Order</a>
                @endif
            </div>
        </form>
        @if( $cart->count() != 0)

        <div class="d-flex justify-content-center mt-3">
            <h5 class="border rounded-pill col-12">
                <a style="background: var( --greadient-normal, linear-gradient( 270deg, #845dc2 -0.09%, #d55fad 36.37%, #fc966c 72.82%, #f99327 100.48%, #ffc55d 145.17% ) ); border: 0px;" href="{{ route('home') }}" class="d-flex align-items-center justify-content-center text-decoration-none gap-2 font-weight-bold text-light rounded-pill p-2">
                    <i class="tio-back-ui fs-12"></i>
                    {{ translate('continue_Shopping') }}
                </a>

            </h5>
        </div>
        
        @endif

    </div>
</aside>

<div class="bottom-sticky3 bg-white p-3 shadow-sm w-100 d-lg-none">
    <div class="d-flex justify-content-center align-items-center fs-14 mb-2">
        <div class="product-description-label fw-semibold text-capitalize">{{translate('total_price')}} : </div>
        &nbsp; <strong  class="text-base">{{\App\CPU\Helpers::currency_converter($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product-$order_wise_shipping_discount)}}</strong>
    </div>
    @if($web_config['guest_checkout_status'] || auth('customer')->check())
        <a onclick="checkout()" class="btn btn--primary btn-block proceed_to_next_button text-capitalize {{$cart->count() <= 0 ? 'disabled' : ''}}">{{translate('Place_order')}}</a>
    @else
        <a href="{{route('customer.auth.login')}}" class="btn btn--primary btn-block proceed_to_next_button text-capitalize {{$cart->count() <= 0 ? 'disabled' : ''}}">{{translate('Place_order')}}</a>
    @endif
</div>
@push('script')
    <script>
        $(document).ready(function() {
            const $stickyElement = $('.bottom-sticky3');
            const $offsetElement = $('.__cart-total_sticky');

            $(window).on('scroll', function() {
                const elementOffset = $offsetElement.offset().top;
                const scrollTop = $(window).scrollTop();
                console.log("scrollTop:", scrollTop, "elementOffset:", elementOffset);

                if (scrollTop >= elementOffset) {
                    $stickyElement.addClass('stick');
                } else {
                    $stickyElement.removeClass('stick');
                }
            });
        });

    </script>
@endpush
