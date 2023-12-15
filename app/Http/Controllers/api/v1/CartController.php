<?php

namespace App\Http\Controllers\api\v1;

use App\Model\Cart;
use App\CPU\Helpers;
use App\Model\Order;
use App\Model\Product;
use App\CPU\CartManager;
use App\CPU\OrderManager;
use App\Model\MostDemanded;
use Illuminate\Http\Request;
use function App\CPU\translate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function __construct(
        private Order        $order,
    ){}

    public function cart(Request $request)
    {
        $user = Helpers::get_customer($request);
        $cart_query = Cart::with('product:id,name,slug,current_stock,minimum_order_qty,variation');
        if($user == 'offline'){
            $cart = $cart_query->where(['customer_id' => $request->guest_id, 'is_guest'=>1])->get();
        }else{
            $cart = $cart_query->where(['customer_id' => $user->id, 'is_guest'=>'0'])->get();
        }


        if($cart) {
            foreach($cart as $key => $value){
                if(!isset($value['product'])){
                    $cart_data = Cart::find($value['id']);
                    $cart_data->delete();

                    unset($cart[$key]);
                }
                foreach($cart as $cartproduct){
                    $thumbnailUrl = asset('storage/app/public/product/thumbnail/' . $cartproduct->thumbnail);
                    $cartproduct->thumbnail = $thumbnailUrl;
                }
            

            }

            $cart->map(function ($data) use($request) {
                $data['choices'] = json_decode($data['choices']);
                $data['variations'] = json_decode($data['variations']);

                $data['minimum_order_amount_info'] = OrderManager::minimum_order_amount_verify($request, $data['cart_group_id'])['minimum_order_amount'];

                $cart_group = Cart::where(['product_type'=>'physical'])->where('cart_group_id', $data['cart_group_id'])->get()->groupBy('cart_group_id');
                if(isset($cart_group[$data['cart_group_id']])){
                    $data['free_delivery_order_amount'] = OrderManager::free_delivery_order_amount($data['cart_group_id']);
                }else{
                    $data['free_delivery_order_amount'] = [
                        'status'=> 0,
                        'amount'=> 0,
                        'percentage'=> 0,
                        'shipping_cost_saved' => 0,
                    ];
                }

                $data['product']['total_current_stock'] = isset($data['product']['current_stock']) ? $data['product']['current_stock'] : 0;
                if (isset($data['product']['variation']) && !empty($data['product']['variation'])) {
                    $variants = json_decode($data['product']['variation']);
                    foreach ($variants as $var) {
                        if ($data['variant'] == $var->type) {
                            $data['product']['total_current_stock'] = $var->qty;
                        }
                    }
                }
                unset($data['product']['variation']);

                return $data;
            });
        }

        return response()->json($cart, 200);
    }

    public function add_to_cart(Request $request)
    {
        // return $request;
        
        $validator = Validator::make($request->all(), [
            'product_id' => ['required','exists:products,id'],
            'quantity' => 'required',
            'customer_id' => 'required',
        ], [
            'product_id.required' => translate('Product ID is required!')
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $cart = CartManager::add_to_cart($request);
        return response()->json($cart, 200);
    }

    public function update_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => ['required', 'exists:carts,id'],
            'customer_id' => ['required', 'exists:users,id'],
            'product_id' => [
                'required',
                Rule::exists('carts', 'product_id')->where(function ($query) use ($request) {
                    $query->where(['customer_id'=> $request->customer_id, 'product_id' => $request->product_id]);
                }),
            ],
            'quantity' => ['required', 'numeric'], 
        ], [
            'key.required' => translate('Cart key or ID is required!'),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        DB::table('carts')->where([
            'id' => $request->key,
            'product_id' => $request->product_id,
            'customer_id' => $request->customer_id,
        ])->update([
            'quantity' => $request->quantity,
        ]);

        $response = 'Cart has been Updated';
        return response()->json($response);
    }


    public function remove_from_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => ['required','exists:carts,id']
        ], [
            'key.required' => translate('Cart key or ID is required!')
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $user = Helpers::get_customer($request);
        Cart::where([
            'id' => $request->key,
            'customer_id' => ($user == 'offline' ? (session('guest_id') ?? $request->guest_id) : $user->id),
            'is_guest' => ($user == 'offline' ? 1 : '0'),
        ])->delete();
        return response()->json(translate('successfully_removed'));
    }
    public function remove_all_from_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => ['required','exists:carts,id']
        ], [
            'key.required' => translate('Cart key or ID is required!')
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $user = Helpers::get_customer($request);
        Cart::where([
            'customer_id'=> ($user == 'offline' ? $request->guest_id : $user->id),
            'is_guest' => ($user == 'offline' ? 1 : '0'),
        ])->delete();
        return response()->json(translate('successfully_removed'));
    }


}
