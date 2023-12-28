<?php

namespace App\Http\Controllers\Web;


use App\Model\Cart;
use App\Model\Shop;
use App\CPU\Helpers;
use App\Model\Color;
use App\Model\Order;
use App\Model\Product;
use App\Model\Category;
use App\Model\Wishlist;
use App\CPU\CartManager;
use App\CPU\OrderManager;
use App\Model\OrderDetail;
use App\CPU\ProductManager;
use App\Model\CartShipping;
use App\Model\ShippingType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\ShippingAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

// class CartController extends Controller
// {
//     public function index()
//     {
//         return view('my-cart-address'); 
//     }
// }


class CartController extends Controller
{
    public function cart_address()
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            // $data['products'] = Product::active()
            //     ->where('category_ids', 'like', "%{$id}%")
            //     ->inRandomOrder()->take(12)->get();
        });

        if (Auth::guard('customer')->user()) {
            $myCartProducts = Cart::where('customer_id', Auth::guard('customer')->user()->id)->with('product')->get();
        } else {
            return redirect()->back()->with(['message' => 'Login First', 'status' => 0]);
        }



        if ($myCartProducts->isNotEmpty()) {
            $cartGroupIds = Cart::where('customer_id', Auth::guard('customer')->user()->id)
                ->first()
                ->pluck('cart_group_id');
            $cartGroupId = $cartGroupIds[0];
        } else {
            $cartGroupId = 0;
        }

        $total_product_price = Cart::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('product')
            ->sum('price');
        $totalDiscount = Cart::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('product')
            ->selectRaw('SUM(price * discount / 100) as total_discount')
            ->first()
            ->total_discount;


        $userData = DB::table('users')->where('id', Auth::guard('customer')->user()->id)->first();
        $shippingAddress = DB::table('shipping_addresses')->where('customer_id', Auth::guard('customer')->user()->id)->first();
        // dd($userData);
        if (isset($request->filter) && isset($request->filterprice)) {
            $brandIds = [];
            $shippings = [];
            $colors = [];
            $tag = [];


            foreach ($request->filter as $tagFilter) {
                if (isset($tagFilter['tag'])) {
                    if (is_array($tagFilter['tag'])) {
                        $tag = array_merge($tag, $tagFilter['tag']);
                    } else {
                        $tag[] = $tagFilter['tag'];
                    }
                }
            }


            foreach ($request->filter as $colorFilter) {
                if (isset($colorFilter['color'])) {
                    if (is_array($colorFilter['color'])) {
                        $colors = array_merge($colors, $colorFilter['color']);
                    } else {
                        $colors[] = $colorFilter['color'];
                    }
                }
            }






            foreach ($request->filter as $filter) {
                if (isset($filter['brand_id'])) {
                    if (is_array($filter['brand_id'])) {
                        $brandIds = array_merge($brandIds, $filter['brand_id']);
                    } else {
                        $brandIds[] = $filter['brand_id'];
                    }
                }

                if (isset($filter['free_shipping'])) {
                    if (is_array($filter['free_shipping'])) {
                        $shippings = array_merge($shippings, $filter['free_shipping']);
                    } else {
                        $shippings[] = $filter['free_shipping'];
                    }
                }
            }

            $max_price = intval(explode("-", $request->filterprice)[1]);
            $min_price = intval(explode("-", $request->filterprice)[0]);

            if (!empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereIn('free_shipping', $shippings)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (!empty($shippings) && empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } else {
                $products = Product::where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            }
        } elseif (isset($request->filter)) {
            $brandIds = [];

            foreach ($request->filter as $filter) {
                if (is_array($filter['brand_id'])) {
                    $brandIds = array_merge($brandIds, $filter['brand_id']);
                } else {
                    $brandIds[] = $filter['brand_id'];
                }
            }
            $products = Product::whereIn('brand_id', $brandIds)
                ->with(['reviews', 'brand'])->active()->orderBy('id')->get();
        } elseif (isset($request->filterprice)) {
            $max_price = intval(explode("-", $request->filterprice)[1]);
            $min_price = intval(explode("-", $request->filterprice)[0]);

            $products = Product::where('unit_price', '>=', $min_price)
                ->where('unit_price', '<=', $max_price)
                ->with(['reviews', 'brand'])->get();
        } else {
            $products = Product::with(['reviews', 'brand', 'tags'])->active()->orderBy('id')->get();

            // dd($products);
        }

        $color = [
            'Red',
            'Blue',
            'Purple',
            'White',
            'Black',
            'Aqua',
            'Amethyst'
        ];

        // $brands = Brand::get();
        $colors = Color::whereIn('name', $color)->get();
        $pricefilter = ceil(Product::orderBy('unit_price', 'DESC')->value('unit_price') / 300);



        return view(VIEW_FILE_NAMES['my-cart-address'], (compact('products', 'cartGroupId', 'shippingAddress', 'totalDiscount', 'total_product_price', 'myCartProducts', 'home_categories')));
    }



    public function add_cart(Request $request)
    {

        $existingCart = Cart::where('customer_id', $request->customer_id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingCart) {
            $existingCart->update([
                'price' => $request->price,
                'discount' => $request->discount,
                'color' => $request->color,
                'variant' => $request->variant,
            ]);
        } else {
            Cart::create([
                'product_id' => $request->product_id,
                'customer_id' => $request->customer_id,
                'name' => $request->name,
                'price' => $request->price,
                'discount' => $request->discount,
                'tax' => (($request->tax != null) ? $request->tax : 0),
                'thumbnail' => $request->thumbnail,
                'color' => $request->color,
                'variant' => $request->variant,
                'slug' => $request->slug,
                'shipping_cost' => 0,
            ]);
        }

        return redirect()->back()->with('message', 'Product Has Been Added to Cart !');
    }

    public function cart_added()
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });
        if (Auth::guard('customer')->user()) {
            $myCartProducts = Cart::where('customer_id', Auth::guard('customer')->user()->id)->with('product')->get();
        } else {
            return redirect()->back()->with(['message' => 'Login First', 'status' => 0]);
        }



        if ($myCartProducts->isNotEmpty()) {
            $cartGroupIds = Cart::where('customer_id', Auth::guard('customer')->user()->id)
                ->first()
                ->pluck('cart_group_id');
            $cartGroupId = $cartGroupIds[0];
        } else {
            $cartGroupId = 0;
        }

        $total_product_price = Cart::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('product')
            ->sum('price');
        $totalDiscount = Cart::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('product')
            ->selectRaw('SUM(price * discount / 100) as total_discount')
            ->first()
            ->total_discount;


        $userData = DB::table('users')->where('id', Auth::guard('customer')->user()->id)->first();
        $shippingAddress = DB::table('shipping_addresses')->where('customer_id', Auth::guard('customer')->user()->id)->first();
        // dd($userData);
        if (isset($request->filter) && isset($request->filterprice)) {
            $brandIds = [];
            $shippings = [];
            $colors = [];
            $tag = [];


            foreach ($request->filter as $tagFilter) {
                if (isset($tagFilter['tag'])) {
                    if (is_array($tagFilter['tag'])) {
                        $tag = array_merge($tag, $tagFilter['tag']);
                    } else {
                        $tag[] = $tagFilter['tag'];
                    }
                }
            }


            foreach ($request->filter as $colorFilter) {
                if (isset($colorFilter['color'])) {
                    if (is_array($colorFilter['color'])) {
                        $colors = array_merge($colors, $colorFilter['color']);
                    } else {
                        $colors[] = $colorFilter['color'];
                    }
                }
            }






            foreach ($request->filter as $filter) {
                if (isset($filter['brand_id'])) {
                    if (is_array($filter['brand_id'])) {
                        $brandIds = array_merge($brandIds, $filter['brand_id']);
                    } else {
                        $brandIds[] = $filter['brand_id'];
                    }
                }

                if (isset($filter['free_shipping'])) {
                    if (is_array($filter['free_shipping'])) {
                        $shippings = array_merge($shippings, $filter['free_shipping']);
                    } else {
                        $shippings[] = $filter['free_shipping'];
                    }
                }
            }

            $max_price = intval(explode("-", $request->filterprice)[1]);
            $min_price = intval(explode("-", $request->filterprice)[0]);

            if (!empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereIn('free_shipping', $shippings)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (!empty($shippings) && empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } else {
                $products = Product::where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            }
        } elseif (isset($request->filter)) {
            $brandIds = [];

            foreach ($request->filter as $filter) {
                if (is_array($filter['brand_id'])) {
                    $brandIds = array_merge($brandIds, $filter['brand_id']);
                } else {
                    $brandIds[] = $filter['brand_id'];
                }
            }
            $products = Product::whereIn('brand_id', $brandIds)
                ->with(['reviews', 'brand'])->active()->orderBy('id')->get();
        } elseif (isset($request->filterprice)) {
            $max_price = intval(explode("-", $request->filterprice)[1]);
            $min_price = intval(explode("-", $request->filterprice)[0]);

            $products = Product::where('unit_price', '>=', $min_price)
                ->where('unit_price', '<=', $max_price)
                ->with(['reviews', 'brand'])->get();
        } else {
            $products = Product::with(['reviews', 'brand', 'tags'])->active()->orderBy('id')->get();

            // dd($products);
        }

        $color = [
            'Red',
            'Blue',
            'Purple',
            'White',
            'Black',
            'Aqua',
            'Amethyst'
        ];

        // $brands = Brand::get();
        $colors = Color::whereIn('name', $color)->get();
        $pricefilter = ceil(Product::orderBy('unit_price', 'DESC')->value('unit_price') / 300);
        return view(VIEW_FILE_NAMES['my-cart-added'], (compact('products', 'home_categories')));
    }
    public function add_payment()
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });
        if (Auth::guard('customer')->user()) {
            $myCartProducts = Cart::where('customer_id', Auth::guard('customer')->user()->id)->with('product')->get();
        } else {
            return redirect()->back()->with(['message' => 'Login First', 'status' => 0]);
        }



        if ($myCartProducts->isNotEmpty()) {
            $cartGroupIds = Cart::where('customer_id', Auth::guard('customer')->user()->id)
                ->first()
                ->pluck('cart_group_id');
            $cartGroupId = $cartGroupIds[0];
        } else {
            $cartGroupId = 0;
        }

        $total_product_price = Cart::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('product')
            ->sum('price');
        $totalDiscount = Cart::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('product')
            ->selectRaw('SUM(price * discount / 100) as total_discount')
            ->first()
            ->total_discount;


        $userData = DB::table('users')->where('id', Auth::guard('customer')->user()->id)->first();
        $shippingAddress = DB::table('shipping_addresses')->where('customer_id', Auth::guard('customer')->user()->id)->first();
        // dd($userData);
        if (isset($request->filter) && isset($request->filterprice)) {
            $brandIds = [];
            $shippings = [];
            $colors = [];
            $tag = [];


            foreach ($request->filter as $tagFilter) {
                if (isset($tagFilter['tag'])) {
                    if (is_array($tagFilter['tag'])) {
                        $tag = array_merge($tag, $tagFilter['tag']);
                    } else {
                        $tag[] = $tagFilter['tag'];
                    }
                }
            }


            foreach ($request->filter as $colorFilter) {
                if (isset($colorFilter['color'])) {
                    if (is_array($colorFilter['color'])) {
                        $colors = array_merge($colors, $colorFilter['color']);
                    } else {
                        $colors[] = $colorFilter['color'];
                    }
                }
            }






            foreach ($request->filter as $filter) {
                if (isset($filter['brand_id'])) {
                    if (is_array($filter['brand_id'])) {
                        $brandIds = array_merge($brandIds, $filter['brand_id']);
                    } else {
                        $brandIds[] = $filter['brand_id'];
                    }
                }

                if (isset($filter['free_shipping'])) {
                    if (is_array($filter['free_shipping'])) {
                        $shippings = array_merge($shippings, $filter['free_shipping']);
                    } else {
                        $shippings[] = $filter['free_shipping'];
                    }
                }
            }

            $max_price = intval(explode("-", $request->filterprice)[1]);
            $min_price = intval(explode("-", $request->filterprice)[0]);

            if (!empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereIn('free_shipping', $shippings)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (!empty($shippings) && empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } else {
                $products = Product::where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            }
        } elseif (isset($request->filter)) {
            $brandIds = [];

            foreach ($request->filter as $filter) {
                if (is_array($filter['brand_id'])) {
                    $brandIds = array_merge($brandIds, $filter['brand_id']);
                } else {
                    $brandIds[] = $filter['brand_id'];
                }
            }
            $products = Product::whereIn('brand_id', $brandIds)
                ->with(['reviews', 'brand'])->active()->orderBy('id')->get();
        } elseif (isset($request->filterprice)) {
            $max_price = intval(explode("-", $request->filterprice)[1]);
            $min_price = intval(explode("-", $request->filterprice)[0]);

            $products = Product::where('unit_price', '>=', $min_price)
                ->where('unit_price', '<=', $max_price)
                ->with(['reviews', 'brand'])->get();
        } else {
            $products = Product::with(['reviews', 'brand', 'tags'])->active()->orderBy('id')->get();

            // dd($products);
        }

        $color = [
            'Red',
            'Blue',
            'Purple',
            'White',
            'Black',
            'Aqua',
            'Amethyst'
        ];

        // $brands = Brand::get();
        $colors = Color::whereIn('name', $color)->get();
        $pricefilter = ceil(Product::orderBy('unit_price', 'DESC')->value('unit_price') / 300);
        return view(VIEW_FILE_NAMES['add-payment'], (compact('products', 'home_categories')));
    }


    public function my_shortlist()
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });
        if (Auth::guard('customer')->user()) {
            $myCartProducts = Cart::where('customer_id', Auth::guard('customer')->user()->id)->with('product')->get();
        } else {
            return redirect()->back()->with(['message' => 'Login First', 'status' => 0]);
        }



        if ($myCartProducts->isNotEmpty()) {
            $cartGroupIds = Cart::where('customer_id', Auth::guard('customer')->user()->id)
                ->first()
                ->pluck('cart_group_id');
            $cartGroupId = $cartGroupIds[0];
        } else {
            $cartGroupId = 0;
        }

        $total_product_price = Cart::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('product')
            ->sum('price');
        $totalDiscount = Cart::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('product')
            ->selectRaw('SUM(price * discount / 100) as total_discount')
            ->first()
            ->total_discount;


        $userData = DB::table('users')->where('id', Auth::guard('customer')->user()->id)->first();
        $shippingAddress = DB::table('shipping_addresses')->where('customer_id', Auth::guard('customer')->user()->id)->first();
        // dd($userData);
        if (isset($request->filter) && isset($request->filterprice)) {
            $brandIds = [];
            $shippings = [];
            $colors = [];
            $tag = [];


            foreach ($request->filter as $tagFilter) {
                if (isset($tagFilter['tag'])) {
                    if (is_array($tagFilter['tag'])) {
                        $tag = array_merge($tag, $tagFilter['tag']);
                    } else {
                        $tag[] = $tagFilter['tag'];
                    }
                }
            }


            foreach ($request->filter as $colorFilter) {
                if (isset($colorFilter['color'])) {
                    if (is_array($colorFilter['color'])) {
                        $colors = array_merge($colors, $colorFilter['color']);
                    } else {
                        $colors[] = $colorFilter['color'];
                    }
                }
            }






            foreach ($request->filter as $filter) {
                if (isset($filter['brand_id'])) {
                    if (is_array($filter['brand_id'])) {
                        $brandIds = array_merge($brandIds, $filter['brand_id']);
                    } else {
                        $brandIds[] = $filter['brand_id'];
                    }
                }

                if (isset($filter['free_shipping'])) {
                    if (is_array($filter['free_shipping'])) {
                        $shippings = array_merge($shippings, $filter['free_shipping']);
                    } else {
                        $shippings[] = $filter['free_shipping'];
                    }
                }
            }

            $max_price = intval(explode("-", $request->filterprice)[1]);
            $min_price = intval(explode("-", $request->filterprice)[0]);

            if (!empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereIn('free_shipping', $shippings)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ->get();
            } elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (!empty($shippings) && empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('free_shipping', $shippings)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                $products = Product::whereIn('brand_id', $brandIds)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                $products = Product::whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            } elseif (empty($shippings) && empty($brandIds) && empty($colors) && !empty($tag)) {
                $products = Product::where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                            $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])->get();
            } else {
                $products = Product::where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand'])->get();
            }
        } elseif (isset($request->filter)) {
            $brandIds = [];

            foreach ($request->filter as $filter) {
                if (is_array($filter['brand_id'])) {
                    $brandIds = array_merge($brandIds, $filter['brand_id']);
                } else {
                    $brandIds[] = $filter['brand_id'];
                }
            }
            $products = Product::whereIn('brand_id', $brandIds)
                ->with(['reviews', 'brand'])->active()->orderBy('id')->get();
        } elseif (isset($request->filterprice)) {
            $max_price = intval(explode("-", $request->filterprice)[1]);
            $min_price = intval(explode("-", $request->filterprice)[0]);

            $products = Product::where('unit_price', '>=', $min_price)
                ->where('unit_price', '<=', $max_price)
                ->with(['reviews', 'brand'])->get();
        } else {
            $products = Product::with(['reviews', 'brand', 'tags'])->active()->orderBy('id')->get();

            // dd($products);
        }

        $color = [
            'Red',
            'Blue',
            'Purple',
            'White',
            'Black',
            'Aqua',
            'Amethyst'
        ];

        // $brands = Brand::get();
        $colors = Color::whereIn('name', $color)->get();
        $whishlistproducts = Wishlist::where('customer_id', Auth::guard('customer')->user()->id)->with('product')->get();
        $pricefilter = ceil(Product::orderBy('unit_price', 'DESC')->value('unit_price') / 300);
        return view(VIEW_FILE_NAMES['my-shortlist'], (compact('whishlistproducts', 'products', 'home_categories')));
    }
    public function __construct(
        private OrderDetail $order_details,
        private Product $product,
    ) {
    }
    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;
        $price = 0;
        $color_name = '';

        if ($request->has('color')) {
            $str = Color::where('code', $request['color'])->first()->name;
        }

        foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
            if ($str != null) {
                $str .= '-' . str_replace(' ', '', $request[$choice->name]);
            } else {
                $str .= str_replace(' ', '', $request[$choice->name]);
            }
        }

        if ($str != null) {
            $count = count(json_decode($product->variation));
            for ($i = 0; $i < $count; $i++) {
                if (json_decode($product->variation)[$i]->type == $str) {
                    $tax = $product->tax_model == 'exclude' ? Helpers::tax_calculation(json_decode($product->variation)[$i]->price, $product['tax'], $product['tax_type']) : 0;
                    $update_tax = $tax * $request->quantity;
                    $discount = Helpers::get_product_discount($product, json_decode($product->variation)[$i]->price);
                    $price = json_decode($product->variation)[$i]->price - $discount + $tax;
                    $unit_price = json_decode($product->variation)[$i]->price;
                    $quantity = json_decode($product->variation)[$i]->qty;
                }
            }
        } else {
            $tax = $product->tax_model == 'exclude' ? Helpers::tax_calculation($product->unit_price, $product['tax'], $product['tax_type']) : 0;
            $update_tax = $tax * $request->quantity;
            $discount = Helpers::get_product_discount($product, $product->unit_price);
            $price = $product->unit_price - $discount + $tax;
            $unit_price = $product->unit_price;
            $quantity = $product->current_stock;
        }

        $delivery_info = [];

        $stock_limit = 0;
        if (theme_root_path() == 'theme_fashion') {
            $delivery_info = ProductManager::get_products_delivery_charge($product, $request->quantity);
            $stock_limit = \App\Model\BusinessSetting::where('type', 'stock_limit')->first()->value;
            if ($request->has('color')) {
                $color_name = Color::where(['code' => $request->color])->first()->name;
            }
        }

        return [
            'price' => \App\CPU\Helpers::currency_converter($price * $request->quantity),
            'discount' => \App\CPU\Helpers::currency_converter($discount),
            'discount_amount' => $discount,
            'tax' => $product->tax_model == 'exclude' ? \App\CPU\Helpers::currency_converter($tax) : 'incl.',
            'update_tax' => $product->tax_model == 'exclude' ? \App\CPU\Helpers::currency_converter($update_tax) : 'incl.', // for others theme
            'quantity' => $product['product_type'] == 'physical' ? $quantity : 100,
            'delivery_cost' => isset($delivery_info['delivery_cost']) ? \App\CPU\Helpers::currency_converter($delivery_info['delivery_cost']) : 0,
            'unit_price' => \App\CPU\Helpers::currency_converter($price), //fasion theme
            'total_unit_price' => \App\CPU\Helpers::currency_converter($unit_price), //fasion theme
            'color_name' => $color_name,
            'stock_limit' => $stock_limit,

        ];
    }

    public function addToCart(Request $request)
    {

        $cart = CartManager::add_to_cart($request);
        if ($cart['message'] == 'Out of stock!') {
            return redirect()->back()->with(['message' => 'Product is Out of Stock!', 'status' => 0]);
        }
        session()->forget('coupon_code');
        session()->forget('coupon_type');
        session()->forget('coupon_bearer');
        session()->forget('coupon_discount');
        session()->forget('coupon_seller_id');
        // return response()->json($cart);
        return redirect()->back()->with(['message' => 'Product Has Been Added to Cart !', 'status' => 1]);
    }

    public function BuyNow(Request $request)
    {

        if (Auth::guard('customer')->user()) {
            $shippingAddress = DB::table('shipping_addresses')->where('customer_id', Auth::guard('customer')->user()->id)->first();
            if ($shippingAddress != null) {

                $cart = CartManager::add_to_cart($request);
                if ($cart['message'] == 'Out of stock!') {
                    return redirect()->back()->with(['message' => 'Product is Out of Stock!', 'status' => 0]);
                }
                session()->forget('coupon_code');
                session()->forget('coupon_type');
                session()->forget('coupon_bearer');
                session()->forget('coupon_discount');
                session()->forget('coupon_seller_id');

                $response = CartManager::update_cart_qty($request);

                session()->forget('coupon_code');
                session()->forget('coupon_type');
                session()->forget('coupon_bearer');
                session()->forget('coupon_discount');
                session()->forget('coupon_seller_id');

                if ($response['status'] == 0) {
                    return response()->json($response);
                }


                $exsisting_cart_shipping = DB::table('cart_shippings')->where('cart_group_id', $request->cart_group_id)->first();
                if (!($exsisting_cart_shipping)) {
                    DB::table('cart_shippings')->insert([
                        'cart_group_id' => $request->cart_group_id,
                        'shipping_cost' => 0,
                    ]);
                }
                if (
                    (!auth('customer')->check() || Cart::where(['customer_id' => auth('customer')->id()])->count() < 1)
                    && (!Helpers::get_business_settings('guest_checkout') || !session()->has('guest_id') || !session('guest_id'))
                ) {
                    Toastr::error(translate('invalid_access'));
                    return redirect('/');
                }

                $cart_group_ids = CartManager::get_cart_group_ids();
                $shippingMethod = Helpers::get_business_settings('shipping_method');

                $verify_status = OrderManager::minimum_order_amount_verify($request);


                // if ($verify_status['status'] == 0) {
                //     Toastr::info(translate('check_Minimum_Order_Amount_Requirment'));
                //     return redirect()->route('shop-cart');
                // }

                $cartItems = Cart::where(['customer_id' => auth('customer')->id()])->withCount(['all_product' => function ($query) {
                    return $query->where('status', 0);
                }])->get();



                // foreach ($cartItems as $cart) {
                //     if (isset($cart->all_product_count) && $cart->all_product_count != 0) {
                //         Toastr::info(translate('check_Cart_List_First'));
                //         return redirect()->route('shop-cart');
                //     }
                // }


                $physical_product_view = false;
                foreach ($cart_group_ids as $group_id) {
                    $carts = Cart::where('cart_group_id', $group_id)->get();
                    foreach ($carts as $cart) {
                        if ($cart->product_type == 'physical') {
                            $physical_product_view = true;
                        }
                    }
                }

                foreach ($cart_group_ids as $group_id) {
                    $carts = Cart::where('cart_group_id', $group_id)->get();

                    $physical_product = false;
                    foreach ($carts as $cart) {
                        if ($cart->product_type == 'physical') {
                            $physical_product = true;
                        }
                    }
                    if ($physical_product) {
                        foreach ($carts as $cart) {
                            if ($shippingMethod == 'inhouse_shipping') {
                                $admin_shipping = ShippingType::where('seller_id', 0)->first();
                                $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                            } else {
                                if ($cart->seller_is == 'admin') {
                                    $admin_shipping = ShippingType::where('seller_id', 0)->first();
                                    $shipping_type = isset($admin_shipping) == true ? $admin_shipping->shipping_type : 'order_wise';
                                } else {
                                    $seller_shipping = ShippingType::where('seller_id', $cart->seller_id)->first();
                                    $shipping_type = isset($seller_shipping) == true ? $seller_shipping->shipping_type : 'order_wise';
                                }
                            }

                            // dd('Test');
                            // if ($physical_product && $shipping_type == 'order_wise') {
                            //     $cart_shipping = CartShipping::where('cart_group_id', $cart->cart_group_id)->first();
                            //     if (!isset($cart_shipping)) {
                            //         Toastr::info(translate('select_shipping_method_first'));
                            //         return redirect('shop-cart');
                            //     }
                            // }
                        }
                    }
                }

                $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');
                $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');

                if ($country_restrict_status) {
                    $countries = $this->get_delivery_country_array();
                } else {
                    $countries = COUNTRIES;
                }

                if ($zip_restrict_status) {
                    $zip_codes = DeliveryZipCode::all();
                } else {
                    $zip_codes = 0;
                }

                $billing_input_by_customer = Helpers::get_business_settings('billing_input_by_customer');
                $default_location = Helpers::get_business_settings('default_location');

                $user = Helpers::get_customer($request);
                $shipping_addresses = ShippingAddress::where([
                    'customer_id' => $user == 'offline' ? session('guest_id') : auth('customer')->id(),
                    'is_guest' => $user == 'offline' ? 1 : '0',
                    'is_billing' => 0,
                ])->get();

                $billing_addresses = ShippingAddress::where([
                    'customer_id' => $user == 'offline' ? session('guest_id') : auth('customer')->id(),
                    'is_guest' => $user == 'offline' ? 1 : '0',
                    'is_billing' => 1,
                ])->get();

                if (count($cart_group_ids) > 0) {
                    $cart = Cart::where(['customer_id' => Auth::guard('customer')->user()->id])->get()->groupBy('cart_group_id');
                    $product_data = Product::where('id', $request->product_id)->first();
                    $shipping_address = DB::table('shipping_addresses')->where('customer_id', Auth::guard('customer')->user()->id)->first();
                    $customer_data = DB::table('users')->where('id', Auth::guard('customer')->user()->id)->first();
                    $data = $request;
                    $data->cart_group_id = $cart_group_ids[0];
                    $data->total_price = $product_data->unit_price;
                    $data->final_payment = ($product_data->unit_price - ($product_data->unit_price * $product_data->discount) / 100);
                    $data->discount_amount = (($product_data->unit_price * $product_data->discount) / 100);
                    $data->tax = $product_data->tax;

                    return view(VIEW_FILE_NAMES['order_shipping'], compact(
                        'shipping_address',
                        'customer_data',
                        'cart',
                        'data',
                        'physical_product_view',
                        'zip_codes',
                        'country_restrict_status',
                        'zip_restrict_status',
                        'countries',
                        'billing_input_by_customer',
                        'default_location',
                        'shipping_addresses',
                        'billing_addresses'
                    ));
                }

                Toastr::info(translate('no_items_in_basket'));
                return redirect('/');
            } else {
                return redirect()->back()->with(['message' => 'Please Add Address Frist !', 'status' => 0]);
            }
        } else {
            return redirect()->back()->with(['message' => 'Please Login First !', 'status' => 0]);
        }
    }

    public function updateNavCart()
    {
        return response()->json(['data' => view(VIEW_FILE_NAMES['products_cart_partials'])->render(), 'mobile_nav' => view(VIEW_FILE_NAMES['products_mobile_nav_partials'])->render()]);
    }
    /**
     * For theme fashion flaoting nav
     */
    public function update_floating_nav()
    {
        return response()->json(['floating_nav' => view(VIEW_FILE_NAMES['products_floating_nav_partials'])->render()]);
    }

    /**
     * removes from Cart
     */
    public function removeFromCart($id)
    {
        // dd($request);
        $user = Helpers::get_customer();

        $cart = Cart::where(['id' => $id, 'customer_id' => ($user == 'offline' ? session('guest_id') : auth('customer')->id())])->first();

        $cart->delete();

        // Cart::where(['id' => $request->cart_id, 'customer_id' => ($user == 'offline' ? session('guest_id') : auth('customer')->id())])->delete();

        session()->forget('coupon_code');
        session()->forget('coupon_type');
        session()->forget('coupon_bearer');
        session()->forget('coupon_discount');
        session()->forget('coupon_seller_id');
        session()->forget('shipping_method_id');
        session()->forget('order_note');

        // return response()->json(['data' => view(VIEW_FILE_NAMES['products_cart_details_partials'], compact('request'))->render(), 'message'=>translate('Item_has_been_removed_from_cart')]);
        return redirect()->back()->with(['message' => 'Product has Been Removed from Cart', 'status' => 1]);
    }

    public function removeCartProduct($product_id, $customer_id)
    {
        $user = Helpers::get_customer();

        $cart = Cart::where(['product_id' => $product_id, 'customer_id' => $customer_id])->first();

        $cart->delete();

        // Cart::where(['id' => $request->cart_id, 'customer_id' => ($user == 'offline' ? session('guest_id') : auth('customer')->id())])->delete();

        session()->forget('coupon_code');
        session()->forget('coupon_type');
        session()->forget('coupon_bearer');
        session()->forget('coupon_discount');
        session()->forget('coupon_seller_id');
        session()->forget('shipping_method_id');
        session()->forget('order_note');

        // return response()->json(['data' => view(VIEW_FILE_NAMES['products_cart_details_partials'], compact('request'))->render(), 'message'=>translate('Item_has_been_removed_from_cart')]);
        return response()->json([
            'success' => 'deleted successfully'
        ]);
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $response = CartManager::update_cart_qty($request);

        session()->forget('coupon_code');
        session()->forget('coupon_type');
        session()->forget('coupon_bearer');
        session()->forget('coupon_discount');
        session()->forget('coupon_seller_id');

        if ($response['status'] == 0) {
            return response()->json($response);
        }
        return response()->json(view(VIEW_FILE_NAMES['products_cart_details_partials'], compact('request'))->render());
    }

    //updated the quantity for a cart item
    public function updateQuantity_guest(Request $request)
    {
        $sub_total = 0;
        $response = CartManager::update_cart_qty($request);
        $cart = CartManager::get_cart();
        session()->forget('coupon_code');
        session()->forget('coupon_type');
        session()->forget('coupon_bearer');
        session()->forget('coupon_discount');
        session()->forget('coupon_seller_id');

        $product = Cart::find($request->key);
        $quantity_price = Helpers::currency_converter($product['price'] * (int)$product['quantity']);
        $discount_price = Helpers::currency_converter(($product['price'] - $product['discount']) * (int)$product['quantity']);
        $total_discount = 0;
        foreach ($cart as $cartItem) {
            $sub_total += ($cartItem['price'] - $cartItem['discount']) * $cartItem['quantity'];
            $total_discount += $cartItem['discount'] * $cartItem['quantity'];
        }
        $total_price = Helpers::currency_converter($sub_total);
        $total_discount_price = Helpers::currency_converter($total_discount);

        if ($response['status'] == 0) {
            return response()->json([
                'status' => $response['status'],
                'message' => $response['message'],
                'qty' => $response['status'] == 0 ? $response['qty'] : $request->quantity,
            ]);
        }
        /** for default theme nav cart ,showing free delivery amount */
        $free_delivery_status = OrderManager::free_delivery_order_amount($cart[0]->cart_group_id);

        return response()->json([
            'status' => $response['status'],
            'message' => translate('successfully_updated!'),
            'qty' => $response['status'] == 0 ? $response['qty'] : $request->quantity,
            'total_price' => $total_price,
            'discount_price' => $discount_price,
            'quantity_price' => $quantity_price,
            'total_discount_price' => $total_discount_price,
            'free_delivery_status' => $free_delivery_status,
        ]);
    }

    public function order_again(Request $request)
    {
        $data = OrderManager::order_again($request);
        $order_product_count = $data['order_product_count'];
        $add_to_cart_count = $data['add_to_cart_count'];

        if ($order_product_count == $add_to_cart_count) {
            session()->forget('coupon_code');
            session()->forget('coupon_type');
            session()->forget('coupon_bearer');
            session()->forget('coupon_discount');
            session()->forget('coupon_seller_id');
            session()->forget('shipping_method_id');
            session()->forget('order_note');

            if (auth('customer')->check()) {
                return [
                    'status' => 1,
                    'redirect_url' => route('shop-cart'),
                    'message' => translate('added_to_cart_successfully!')
                ];
            } else {
                return response()->json(['message' => 'Added to cart successfully'], 200);
            }
        } elseif ($add_to_cart_count > 0) {
            if (auth('customer')->check()) {
                return [
                    'status' => 1,
                    'redirect_url' => route('shop-cart'),
                    'message' => translate($add_to_cart_count . '_item_added_to_cart_successfully!')
                ];
            } else {
                return response()->json(['message' => $add_to_cart_count . ' item added to cart successfully!'], 200);
            }
        } {
            if (auth('customer')->check()) {
                return [
                    'status' => 0,
                    'message' => translate('all_items_were_not_added_to_cart_as_they_are_currently_unavailable_for_purchase!')
                ];
            } else {
                return response()->json(['message' => 'All items were not added to cart as they are currently unavailable for purchase'], 403);
            }
        }
    }

    function update_variation(Request $request)
    {
        $product = Product::find($request->product_id);
        $user = Helpers::get_customer($request);
        $str = '';
        $variations = [];
        $price = 0;
        $discount = 0;
        if ($request->has('color')) {
            $str = Color::where('code', $request['color'])->first()->name;
            $variations['color'] = $str;
        }

        //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
        $choices = [];
        foreach (json_decode($product->choice_options) as $key => $choice) {

            $choices[$choice->name] = $request[$choice->name];
            $variations[$choice->title] = $request[$choice->name];
            if ($str != null) {
                $str .= '-' . str_replace(' ', '', $request[$choice->name]);
            } else {
                $str .= str_replace(' ', '', $request[$choice->name]);
            }
        }

        if ($str != null) {
            $count = count(json_decode($product->variation));
            for ($i = 0; $i < $count; $i++) {
                if (json_decode($product->variation)[$i]->type == $str) {
                    $tax = $product->tax_model == 'exclude' ? Helpers::tax_calculation(json_decode($product->variation)[$i]->price, $product['tax'], $product['tax_type']) : 0;
                    $discount = Helpers::get_product_discount($product, json_decode($product->variation)[$i]->price);
                    $price = json_decode($product->variation)[$i]->price - $discount + $tax;
                    $quantity = json_decode($product->variation)[$i]->qty;
                }
            }
        } else {
            $tax = $product->tax_model == 'exclude' ? Helpers::tax_calculation($product->unit_price, $product['tax'], $product['tax_type']) : 0;
            $discount = Helpers::get_product_discount($product, $product->unit_price);
            $price = $product->unit_price - $discount + $tax;
            $quantity = $product->current_stock;
        }
        $cart = Cart::where([
            'product_id' => $request->product_id,
            'customer_id' => $user == 'offline' ? session('guest_id') : $user->id,
            'is_guest' => $user == 'offline' ? 1 : '0',
            'variant' => $str
        ])->first();
        if (isset($cart) == false) {
            $cart = Cart::find($request->id);
            $cart['color']          = $request->has('color') ? $request['color'] : null;
            $cart['choices']        = json_encode($choices);

            $cart['variations']     = json_encode($variations);
            $cart['variant']        = $str;

            //Check the string and decreases quantity for the stock
            if ($str != null) {
                $count = count(json_decode($product->variation));
                for ($i = 0; $i < $count; $i++) {
                    if (json_decode($product->variation)[$i]->type == $str) {
                        $price = json_decode($product->variation)[$i]->price;
                        if (json_decode($product->variation)[$i]->qty < $request['quantity']) {
                            return [
                                'status' => 0,
                                'message' => translate('out_of_stock!')
                            ];
                        }
                    }
                }
            } else {
                $price = $product->unit_price;
            }
            $cart['price'] = $price;
            $cart['discount'] = $discount;
            $cart['tax'] = $tax;
            $cart['quantity'] = $request['quantity'];
            $cart->save();

            return [
                'status' => 1,
                'message' => translate('successfully_added!'),
                'price' => \App\CPU\Helpers::currency_converter($price),
                'discount' => \App\CPU\Helpers::currency_converter($discount * $request['quantity']),
                'data' => view(VIEW_FILE_NAMES['products_cart_details_partials'], compact('request'))->render()
            ];
        } else {
            return [
                'status' => 0,
                'message' => translate('already_added!')
            ];
        }
    }
    public function remove_all_cart()
    {
        $user = Helpers::get_customer();

        Cart::where([
            'customer_id' => ($user == 'offline' ? session('guest_id') : auth('customer')->id()),
            'is_guest' => ($user == 'offline' ? 1 : '0'),
        ])->delete();
        return redirect()->back();
    }
}
