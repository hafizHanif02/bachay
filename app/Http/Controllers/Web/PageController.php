<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\HelpTopic;
use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function __construct(
        private BusinessSetting $business_settings,
    ) {

    }
    public function helpTopic()
    {
        $helps = HelpTopic::Status()->latest()->get();
        $page_title_banner = $this->business_settings->where('type', 'banner_faq_page')->whereJsonContains('value', ['status' => '1'])->first('value');
        return view(VIEW_FILE_NAMES['faq'], compact('helps','page_title_banner'));
    }

    public function contacts(Request $request)
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });


        if(Auth::guard('customer')->check()){
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
            }else{
                $totalDiscount = 0;
                $totalProductPrice = 0;

                $productIds = $request->session()->get('cart', []);
                $productIds = array_filter($productIds, 'is_numeric');
                $myCartProducts = Product::whereIn('id', $productIds)->get();

                foreach ($myCartProducts as $product) {
                    $totalProductPrice += $product->unit_price;
                    $discountAmount = ($product->discount / 100) * $product->unit_price;
                    $totalDiscount += $discountAmount;
                }

                $totalDiscountedPrice = $totalProductPrice - $totalDiscount;
                $total_product_price = $totalProductPrice;
                $wishlistProductsArray = [];
                $products = Product::get();
                $cartGroupId = null;
                $shippingAddress = [];
                $cartProductsArray = $productIds;
            }

        $recaptcha = \App\CPU\Helpers::get_business_settings('recaptcha');
        return view(VIEW_FILE_NAMES['contacts'],compact('recaptcha', 'home_categories', 'cartProductsArray'));
    }

    public function about_us()
    {
        $about_us = BusinessSetting::where('type', 'about_us')->first();
        $page_title_banner = $this->business_settings->where('type', 'banner_about_us')->whereJsonContains('value', ['status' => '1'])->first('value');
        return view(VIEW_FILE_NAMES['about_us'], [
            'about_us' => $about_us,
            'page_title_banner' => $page_title_banner,
        ]);
    }

    public function termsand_condition()
    {
        $page_title_banner = $this->business_settings->where('type', 'banner_terms_conditions')->whereJsonContains('value', ['status' => '1'])->first('value');
        $terms_condition = BusinessSetting::where('type', 'terms_condition')->first();
        return view(VIEW_FILE_NAMES['terms_conditions_page'], compact('terms_condition','page_title_banner'));
    }

    public function privacy_policy(Request $request)
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });
        $page_title_banner = $this->business_settings->where('type', 'banner_privacy_policy')->whereJsonContains('value', ['status' => '1'])->first('value');
        $privacy_policy = BusinessSetting::where('type', 'privacy_policy')->first();
        if(Auth::guard('customer')->check()){
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
            }else{
                $totalDiscount = 0;
                $totalProductPrice = 0;

                $productIds = $request->session()->get('cart', []);
                $productIds = array_filter($productIds, 'is_numeric');
                $myCartProducts = Product::whereIn('id', $productIds)->get();

                foreach ($myCartProducts as $product) {
                    $totalProductPrice += $product->unit_price;
                    $discountAmount = ($product->discount / 100) * $product->unit_price;
                    $totalDiscount += $discountAmount;
                }

                $totalDiscountedPrice = $totalProductPrice - $totalDiscount;
                $total_product_price = $totalProductPrice;
                $wishlistProductsArray = [];
                $products = Product::get();
                $cartGroupId = null;
                $shippingAddress = [];
                $cartProductsArray = $productIds;
            }
        return view(VIEW_FILE_NAMES['privacy_policy_page'], compact('privacy_policy','page_title_banner', 'home_categories', 'cartProductsArray'));
    }

    public function refund_policy()
    {
        $refund_policy = json_decode(BusinessSetting::where('type', 'refund-policy')->first()->value);
        if(!$refund_policy->status){
            return back();
        }
        $refund_policy = $refund_policy->content;
        $page_title_banner = $this->business_settings->where('type', 'banner_refund_policy')->whereJsonContains('value', ['status' => '1'])->first('value');
        return view(VIEW_FILE_NAMES['refund_policy_page'], compact('refund_policy','page_title_banner'));
    }

    public function return_policy()
    {
        $return_policy = json_decode(BusinessSetting::where('type', 'return-policy')->first()->value);
        if(!$return_policy->status){
            return back();
        }
        $return_policy = $return_policy->content;
        $page_title_banner = $this->business_settings->where('type', 'banner_return_policy')->whereJsonContains('value', ['status' => '1'])->first('value');
        return view(VIEW_FILE_NAMES['return_policy_page'], compact('return_policy','page_title_banner'));
    }

    public function cancellation_policy()
    {
        $cancellation_policy = json_decode(BusinessSetting::where('type', 'cancellation-policy')->first()->value);
        if(!$cancellation_policy->status){
            return back();
        }
        $cancellation_policy = $cancellation_policy->content;
        $page_title_banner = $this->business_settings->where('type', 'banner_cancellation_policy')->whereJsonContains('value', ['status' => '1'])->first('value');
        return view(VIEW_FILE_NAMES['cancellation_policy_page'], compact('cancellation_policy','page_title_banner'));
    }
}
