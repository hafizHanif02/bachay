<?php

namespace App\Http\Controllers\Web;

use App\User;
use Carbon\Carbon;
use App\Model\Cart;
use App\Model\Shop;
use App\CPU\Convert;
use App\CPU\Helpers;
use App\Model\Admin;
use App\Model\Brand;
use App\Model\Color;
use App\Model\Order;
use App\Model\Banner;
use App\Model\Coupon;
use App\Model\Review;
use App\Model\Seller;
use App\Model\Contact;
use App\Model\Product;
use App\Model\Setting;
use App\CPU\SMS_module;
use App\Model\Category;
use App\Model\Currency;
use App\Model\Wishlist;
use App\CPU\CartManager;
use App\Model\FlashDeal;
use App\Model\HelpTopic;
use App\CPU\OrderManager;
use App\Model\OrderDetail;
use App\Model\Transaction;
use App\Model\Translation;
use App\Models\HomeLayout;
use App\Traits\SmsGateway;
use Carbon\CarbonInterval;
use App\CPU\ProductManager;
use App\Model\CartShipping;
use App\Model\DealOfTheDay;
use App\Model\ShippingType;
use App\Model\ShopFollower;
use App\Model\Subscription;
use App\Traits\CommonTrait;
use Illuminate\Support\Arr;
use App\CPU\CustomerManager;
use Illuminate\Http\Request;
use App\Model\ProductCompare;
use App\Model\ShippingMethod;
use App\Model\BusinessSetting;
use App\Model\DeliveryZipCode;
use App\Model\ShippingAddress;
use App\Models\familyRelation;
use App\Model\FlashDealProduct;
use function App\CPU\translate;
use App\Model\DeliveryCountryCode;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\DB;
use App\Model\OfflinePaymentMethod;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Facade\FlareClient\Http\Response;
use function App\CPU\payment_gateways;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Model\DigitalProductOtpVerification;

class WebController extends Controller
{
    use CommonTrait;

    public function __construct(
        private OrderDetail $order_details,
        private Product $product,
        private Wishlist $wishlist,
        private Order $order,
        private Category $category,
        private Brand $brand,
        private Seller $seller,
        private ProductCompare $compare,
    ) {
    }

    public function my_order()
    {

        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });
        return view(VIEW_FILE_NAMES['my-order'], compact('home_categories'));
    }

    public function manage_returns()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }

        return view(VIEW_FILE_NAMES['manage-returns'], compact('wishlistProductsArray', 'products', 'home_categories'));
    }
    public function return_detail()
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
        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['return-detail'], compact('wishlistProductsArray','products', 'home_categories'));
    }
    public function quick_reorder()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['quick-reorder'], compact('wishlistProductsArray','products', 'home_categories'));
    }
    public function order_available()
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
        return view(VIEW_FILE_NAMES['order-available'], compact('products', 'home_categories'));
    }
    public function track_order()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['track-orders'], compact('wishlistProductsArray','products', 'home_categories'));
    }
    public function your_query()
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
        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['your-query'], (compact('wishlistProductsArray','products', 'home_categories')));
    }
    public function club_cash()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['club-cash'], compact('wishlistProductsArray','products', 'home_categories'));
    }
    public function cash_refund()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['cash-refund'], (compact('wishlistProductsArray','products', 'home_categories')));
    }
    public function payments_not_added()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['my-payment-detail-not-added'], (compact('wishlistProductsArray','products', 'home_categories')));
    }
    public function payments_added()
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });
        return view(VIEW_FILE_NAMES['my-payment-detail-added'], (compact('home_categories')));
    }
    public function save_cards()
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
        return view(VIEW_FILE_NAMES['save-cards'], (compact('products', 'home_categories')));
    }
    public function cash_coupons()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['cash-coupons'], (compact('wishlistProductsArray','products', 'home_categories')));
    }
    public function cash_back_codes()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['cash-back-codes'], (compact('wishlistProductsArray','products', 'home_categories')));
    }
    public function no_refund()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['my-refund-no-refund'], (compact('wishlistProductsArray','products', 'home_categories')));
    }
    public function my_refund()
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });
        return view(VIEW_FILE_NAMES['my-refund'], (compact('home_categories')));
    }
    public function bpl_vouchers()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['my-bpl-vouchers'], (compact('wishlistProductsArray','products', 'home_categories')));
    }
    public function guaranteed_savings()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['guaranteed-savings'], (compact('wishlistProductsArray','products', 'home_categories')));
    }
    public function guaranteed_savings_offer()
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });
        return view(VIEW_FILE_NAMES['guaranteed-savings-offer'], (compact('home_categories')));
    }
    public function guaranteed_savings_offer_brand()
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });
        return view(VIEW_FILE_NAMES['guaranteed-savings-offer-brand'], (compact('home_categories')));
    }
    public function intelli_education()
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

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['intelli-education'], (compact('wishlistProductsArray','products', 'home_categories')));
    }
    public function gift_certification()
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
        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['gift-certification'], (compact('wishlistProductsArray','products', 'home_categories')));
    }
    public function invites_credits()
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
        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        return view(VIEW_FILE_NAMES['invites-credits'], (compact('wishlistProductsArray','products', 'home_categories')));
    }
    public function my_reviews_upload()
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
        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }

        return view(VIEW_FILE_NAMES['my-reviews-upload'], (compact('wishlistProductsArray','products', 'home_categories')));
    }

    public function maintenance_mode()
    {
        $maintenance_mode = Helpers::get_business_settings('maintenance_mode') ?? 0;
        if ($maintenance_mode) {
            return view(VIEW_FILE_NAMES['maintenance_mode']);
        }
        return redirect()->route('home');
    }

    public function flash_deals(Request $request)
    {
        
        $current_date = Carbon::now();
        $current_date = $current_date->format('Y-m-d');
        $deal = FlashDeal::with(['products.product.reviews', 'products.product' => function ($query) {
            $query->active();
        }])
            ->where(['slug' => $request['slug'],'status' => 1])
            ->whereDate('start_date', '<=', $current_date)
            ->whereDate('end_date', '>=', $current_date)
            ->first();
        $discountPrice = FlashDealProduct::with(['product'])->whereHas('product', function ($query) {
            $query->active();
        })->get()->map(function ($data) {
            return [
                'discount' => $data->discount,
                'sellPrice' => isset($data->product->unit_price) ? $data->product->unit_price : 0,
                'discountedPrice' => isset($data->product->unit_price) ? $data->product->unit_price - $data->discount : 0,

            ];
        })->toArray();
         $home_categories = Category::where('home_status', true)->priority()->get();
            $home_categories->map(function ($data) {
                $id = '"' . $data['id'] . '"';
                $data['products'] = Product::active()
                    ->where('category_ids', 'like', "%{$id}%")
                    ->inRandomOrder()->take(12)->get();
            });
        $deals_products = $deal->products;
        
        // return $deal_products->products->product->thumbnail;

        if (isset($deal)) {
            return view(VIEW_FILE_NAMES['deals_products'], compact('home_categories','deals_products','deal', 'discountPrice'));
        }
        Toastr::warning(translate('not_found'));
        return back();
    }

    public function search_shop(Request $request)
    {
        $key = explode(' ', $request['shop_name']);
        $sellers = Shop::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->whereHas('seller', function ($query) {
            return $query->where(['status' => 'approved']);
        })->paginate(30);
        return view(VIEW_FILE_NAMES['all_stores_page'], compact('sellers'));
    }
    public function all_categories(Request $request)
    {
        $theme_name = theme_root_path();

        // Get the user agent from the request headers
        $userAgent = $request->header('User-Agent');

        // Check if the user agent indicates a mobile device
        if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false) {
            // User is using a mobile device, load the mobile view
            return match ($theme_name) {
                'default' => self::all__categories("categories_mobile"),
                'theme_aster' => self::theme_aster(),
                'theme_fashion' => self::theme_fashion(),
                'theme_all_purpose' => self::theme_all_purpose(),
            };
        } else {
            return match ($theme_name) {
                'default' => self::all__categories("categories"),
                'theme_aster' => self::theme_aster(),
                'theme_fashion' => self::theme_fashion(),
                'theme_all_purpose' => self::theme_all_purpose(),
            };
        }

        
    }
    public function all__categories($viewName)
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });
        $main_banner = DB::table('banners')->where('banner_type', 'Main Banner')->get();
        $main_section_banner = DB::table('banners')->where('banner_type', 'Main Section Banner')->get();
        $productsInFlashDeal = FlashDealProduct::with('product')->get();
        $categories = $this->category->with('childes.childes')->where(['position' => 0,'home_status' => true])->priority()->get();
        return view(VIEW_FILE_NAMES[$viewName], (compact('categories', 'productsInFlashDeal', 'main_section_banner', 'main_banner', 'home_categories')));
        
    }

    public function single_categories($slug, Request $request){
        $theme_name = theme_root_path();

        // Get the user agent from the request headers
        $userAgent = $request->header('User-Agent');

        // Check if the user agent indicates a mobile device
        if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false) {
            // User is using a mobile device, load the mobile view
            return match ($theme_name) {
                'default' => self::single__category("single_categories_mobile",$slug),
                'theme_aster' => self::theme_aster(),
                'theme_fashion' => self::theme_fashion(),
                'theme_all_purpose' => self::theme_all_purpose(),
            };
        } else {
            return match ($theme_name) {
                'default' => self::single__category("single_categories",$slug),
                'theme_aster' => self::theme_aster(),
                'theme_fashion' => self::theme_fashion(),
                'theme_all_purpose' => self::theme_all_purpose(),
            };
        }
        // $category = Category::where('slug', $slug)->first();
        // $sub_category = Category::where('parent_id',$category->id)->get();
        // return $sub_category;

    }

    public function single__category($viewName,$slug){
        $category = Category::where('slug', $slug)->first();
        $category_banners = Banner::where([
            'resource_type' => 'category',
            'resource_id' => $category->id
        ])->get();
        $sub_category = Category::where('parent_id',$category->id)->get();
        $products = Product::where('category_id', $category->id)->get();

        if (Auth::guard('customer')->check()) {
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
        } else {
            $wishlistProductsArray = [];
            $cartProductsArray = [];
        }
        // return $sub_category;
        return view(VIEW_FILE_NAMES[$viewName], (compact('category','sub_category','products','category_banners','wishlistProductsArray')));
    }

    public function switch_child(Request $request){
        if(Auth::guard('customer')->check()){
            $child = familyRelation::where([
                'id'=> $request->id,
                'user_id'=> Auth::guard('customer')->user()->id,
                ])->first();
            $child->tag = ($child->gender == 1)?'Boy':'Girl';

            $allProducts = Product::with('tags')->get();

            $filteredProducts = [];
            foreach ($allProducts as $product) {
                if ($product->tags != null) {
                    foreach ($product->tags as $tag) {
                        if ($tag->tag == $child->tag) {
                            $filteredProducts[] = $product;
                        }
                    }
                }
            }
            
            $featured_products = collect($filteredProducts)
                ->where('featured', 1)
                ->values(); // Re-index the collection keys
            
            $latest_products = collect($filteredProducts)
                ->sortByDesc('id')
                ->take(8)
                ->values(); // Re-index the collection keys
            
            $products = collect($filteredProducts)
                ->sortBy('id')
                ->take(16)
                ->values(); // Re-index the collection keys
            
            $product = collect($filteredProducts)
                ->shuffle()
                ->first();
            
            $productsInFlashDeal = collect($filteredProducts)
                ->whereIn('id', $product->id)
                ->values(); // Re-index the collection keys
            

                

                $theme_name = theme_root_path();

                $userAgent = $request->header('User-Agent');
        
                if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false) {
                        $viewName = "home_mobile";
                } else {
                        $viewName ="home" ;
                }

                $theme_name = theme_root_path();
                $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;
                $home_categories = Category::where('home_status', true)->priority()->get();
                $home_categories->map(function ($data) {
                    $id = '"' . $data['id'] . '"';
                    $data['products'] = Product::active()
                        ->where('category_ids', 'like', "%{$id}%")
                        ->inRandomOrder()->take(12)->get();
                });
        
                $current_date = date('Y-m-d H:i:s');
                //products based on top seller
                $top_sellers = $this->seller->approved()->with(['shop', 'orders', 'product.reviews'])
                    ->whereHas('orders', function ($query) {
                        $query->where('seller_is', 'seller');
                    })
                    ->withCount(['orders', 'product' => function ($query) {
                        $query->active();
                    }])->orderBy('orders_count', 'DESC')->take(12)->get();
        
                $top_sellers?->map(function ($seller) {
                    $seller->product?->map(function ($product) {
                        $product['rating'] = $product?->reviews->pluck('rating')->sum();
                        $product['review_count'] = $product->reviews->count();
                    });
                    $seller['total_rating'] = $seller?->product->pluck('rating')->sum();
                    $seller['review_count'] = $seller->product->pluck('review_count')->sum();
                    $seller['average_rating'] = $seller['total_rating'] / ($seller['review_count'] == 0 ? 1 : $seller['review_count']);
                });
        
                //end
        
                //feature products finding based on selling
                // $featured_products = $products->with(['reviews'])->active()
                //     ->where('featured', 1)
                //     ->withCount(['order_details'])->orderBy('order_details_count', 'DESC')
                //     ->take(12)
                //     ->get();
                //end

                // dd($featured_products);
        
                $home_layouts = HomeLayout::where('web_status', 1)->orderBy('web_order', 'asc')->get();
        
        
                // $latest_products = $products->with(['reviews'])->active()->orderBy('id', 'desc')->take(8)->get();
        
                // $products = $products->with(['reviews'])->active()->orderBy('id')->take(16)->get();
        
                $categories = $this->category->with('childes.childes')->where(['position' => 0])->priority()->take(8)->get();
                
                $brands = Brand::active()->take(15)->get();
                
                $bestSellProduct = $this->order_details->with('product.reviews')
                    ->whereHas('product', function ($query) {
                        $query->active();
                    })
                    ->select('product_id', DB::raw('COUNT(product_id) as count'))
                    ->groupBy('product_id')
                    ->orderBy("count", 'desc')
                    ->take(6)
                    ->get();
        
                
                $topRated = Review::with('product')
                    ->whereHas('product', function ($query) {
                        $query->active();
                    })
                    ->select('product_id', DB::raw('AVG(rating) as count'))
                    ->groupBy('product_id')
                    ->orderBy("count", 'desc')
                    ->take(6)
                    ->get();
        
                if ($bestSellProduct->count() == 0) {
                    $bestSellProduct = $latest_products;
                }
        
                if ($topRated->count() == 0) {
                    $topRated = $bestSellProduct;
                }
        
                $deal_of_the_day = DealOfTheDay::join('products', 'products.id', '=', 'deal_of_the_days.product_id')->select('deal_of_the_days.*', 'products.unit_price')->where('products.status', 1)->where('deal_of_the_days.status', 1)->first();
                $main_banner = Banner::where(['banner_type' => 'Main Banner', 'theme' => $theme_name, 'published' => 1])->latest()->get();
                $main_section_banner =  Banner::where(['banner_type' => 'Main Section Banner', 'theme' => $theme_name, 'published' => 1])->orderBy('id', 'desc')->latest()->get();
        
                // $product = $products->active()->inRandomOrder()->first();
        
                $footer_banner = Banner::
                    where('banner_type', 'Footer Banner')
                    ->where('theme', theme_root_path())
                    ->where('published', 1)
                    ->orderBy('id', 'desc')
                    ->take(6)
                    ->get();
        
                // Use null coalescing operator to provide an empty array if $footer_banner is null
                $footer_banner = $footer_banner ?? [];
        
                // return  $footer_banner;
        
        
                // $flash_deals = FlashDeal::with(['products'=>function($query){
                //     $query->with(['product.wish_list'=>function($query){
                //         return $query->where('customer_id', Auth::guard('customer')->user()->id ?? 0);
                //     }, 'product.compare_list'=>function($query){
                //         return $query->where('user_id', Auth::guard('customer')->user()->id ?? 0);
                //     }])->whereHas('product',function($q){
                //         $q->active();
                //     });
                // }])
                // ->where(['deal_type'=>'flash_deal', 'status'=>1])
                // ->whereDate('start_date','<=',date('Y-m-d'))
                // ->whereDate('end_date','>=',date('Y-m-d'))
                // ->first();
        
                $flash_deal = FlashDeal::where(['deal_type' => 'flash_deal', 'status' => 1])->get();
                
        
        
                $flash_deals_products = [];
                $productIds = null;
                if (isset($flash_deal->id)) {
        
                    $flash_deals_products = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->get();
                    $productIds = $flash_deals_products->pluck('product_id')->toArray();
                }
        
        
                $productsInFlashDeal = [];
                if (isset($productIds)) {
        
                    $productsInFlashDeal = $products->active()->whereIn('id', $productIds)->get();
                }
                if (Auth::guard('customer')->check()) {
                    $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
        
                    $wishlistProductsArray = $wishlistProducts->toArray();
        
                    $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
                    $cartProductsArray = $cartProducts->toArray();
                } else {
                    $wishlistProductsArray = [];
                    $cartProductsArray = [];
                }
                
                // $current_date = Carbon::now();
                // $current_date = $current_date->format('Y-m-d');
                // $deal = FlashDeal::with(['products.product.reviews', 'products.product' => function ($query) {
                //     $query->active();
                // }])
                //     ->where(['slug' => $request['slug'],'status' => 1])
                //     ->whereDate('start_date', '<=', $current_date)
                //     ->whereDate('end_date', '>=', $current_date)
                //     ->first();
                // $discountPrice = FlashDealProduct::with(['product'])->whereHas('product', function ($query) {
                //     $query->active();
                // })->get()->map(function ($data) {
                //     return [
                //         'discount' => $data->discount,
                //         'sellPrice' => isset($data->product->unit_price) ? $data->product->unit_price : 0,
                //         'discountedPrice' => isset($data->product->unit_price) ? $data->product->unit_price - $data->discount : 0,
        
                //     ];
                // })->toArray();
               
                // $deals_products = $deal->products;
                
                // return $deal_products->products->product->thumbnail;
                // dd($wishlistProducts);
        
                // return $flash_deals_products;
        
                return view(
                    VIEW_FILE_NAMES[$viewName],
                    compact(
                        'wishlistProductsArray',
                        'featured_products',
                        'topRated',
                        'bestSellProduct',
                        'latest_products',
                        'categories',
                        'brands',
                        'deal_of_the_day',
                        'top_sellers',
                        'home_categories',
                        'brand_setting',
                        'main_banner',
                        'main_section_banner',
                        'current_date',
                        'product',
                        'footer_banner',
                        'home_layouts',
                        'flash_deal',
                        'flash_deals_products',
                        'productIds',
                        'productsInFlashDeal',
                        'products',
                        'footer_banner',
                    )
                );

        }else{
            return redirect()->back()->with(['message' => 'Please Login First !', 'status' => 0]);
        }
    }


    
    public function sub_categories()
    {
        $home_categories = Category::where('home_status', true)->priority()->get();
        $home_categories->map(function ($data) {
            $id = '"' . $data['id'] . '"';
            $data['products'] = Product::active()
                ->where('category_ids', 'like', "%{$id}%")
                ->inRandomOrder()->take(12)->get();
        });

        $main_banner = DB::table('banners')->where('banner_type', 'Main Banner')->get();
        $main_section_banner = DB::table('banners')->where('banner_type', 'Main Section Banner')->get();
        $productsInFlashDeal = FlashDealProduct::with('product')->get();
        $categories = $this->category->with('childes.childes')->where(['position' => 0])->priority()->get();

        return view(VIEW_FILE_NAMES['sub-category'], (compact('categories', 'productsInFlashDeal', 'main_section_banner', 'main_banner', 'home_categories')));

        // return view('layouts.front-end.partials.sub-category', compact('categories', 'home_categories'));
    }

    public function categories_by_category($id)
    {
        $category = Category::with(['childes.childes'])->where('id', $id)->first();
        return response()->json([
            'view' => view('web-views.partials._category-list-ajax', compact('category'))->render(),
        ]);
    }

    public function all_brands(Request $request)
    {
        $brand_status = BusinessSetting::where(['type' => 'product_brand'])->value('value');
        session()->put('product_brand', $brand_status);
        if ($brand_status == 1) {
            $order_by = $request->order_by ?? 'desc';
            $brands = Brand::active()->withCount('brandProducts')->orderBy('name', $order_by)
                ->when($request->has('search'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%');
                })->latest()->paginate(15)->appends(['order_by' => $order_by, 'search' => $request->search]);

            return view(VIEW_FILE_NAMES['all_brands'], compact('brands'));
        } else {
            return redirect()->route('home');
        }
    }

    public function all_sellers(Request $request)
    {
        $business_mode = Helpers::get_business_settings('business_mode');
        if (isset($business_mode) && $business_mode == 'single') {
            Toastr::warning(translate('access_denied!!'));
            return back();
        }
        $sellers = Shop::active()->with(['seller.product'])
            ->withCount(['product' => function ($query) {
                $query->active();
            }])
            ->when($request->has('order_by') && ($request->order_by == 'asc' || $request->order_by == 'desc'), function ($query) use ($request) {
                $query->orderBy('name', $request->order_by);
            })->when($request->has('order_by') && $request->order_by == 'highest-products', function ($query) {
                $query->orderBy('product_count', 'desc');
            })->when($request->has('order_by') && $request->order_by == 'lowest-products', function ($query) {
                $query->orderBy('product_count', 'asc');
            })->get();
        if (theme_root_path() == 'theme_fashion') {

            $sellers?->map(function ($seller) {
                $rating = 0;
                $count = 0;
                foreach ($seller->seller->product as $item) {
                    foreach ($item->reviews as $review) {
                        if ($review->status == 1) {
                            $rating += $review->rating;
                            $count++;
                        }
                    }
                }
                $avg_rating = $rating / ($count == 0 ? 1 : $count);
                $rating_count = $count;
                $seller['average_rating'] = $avg_rating;
                $seller['rating_count'] = $rating_count;
                return $seller;
            });
            if ($request->has('order_by') && ($request->order_by == 'rating-high-to-low' || $request->order_by == 'rating-low-to-high')) {
                if ($request->order_by == 'rating-high-to-low') {
                    $sellers = $sellers->sortByDesc('average_rating');
                } else {
                    $sellers = $sellers->sortBy('rating_count');
                }
            }
        }

        $sellers = $sellers->paginate(12);

        $sellers?->map(function ($seller) {
            $seller->product?->map(function ($product) {
                $product['rating'] = $product?->reviews->pluck('rating')->sum();
                $product['review_count'] = $product->reviews->count();
            });
            $seller['total_rating'] = $seller?->product->pluck('rating')->sum();
            $seller['review_count'] = $seller->product->pluck('review_count')->sum();
            $seller['average_rating'] = $seller['total_rating'] / ($seller['review_count'] == 0 ? 1 : $seller['review_count']);
        });

        $order_by = $request->order_by;

        return view(VIEW_FILE_NAMES['all_stores_page'], compact('sellers', 'order_by'));
    }

    public function seller_profile($id)
    {
        $seller_info = Seller::find($id);
        return view('web-views.seller-profile', compact('seller_info'));
    }

    public function searched_products(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Product name is required!',
        ]);

        $result = ProductManager::search_products_web($request['name'], $request['category_id'] ?? 'all');
        $products = $result['products'];

        if ($products == null) {
            $result = ProductManager::translated_product_search_web($request['name'], $request['category_id'] ?? 'all');
            $products = $result['products'];
        }

        $sellers = Shop::where(function ($q) use ($request) {
            $q->orWhere('name', 'like', "%{$request['name']}%");
        })->whereHas('seller', function ($query) {
            return $query->where(['status' => 'approved']);
        })->with('product', function ($query) {
            return $query->active()->where('added_by', 'seller');
        })->get();

        $product_ids = [];
        foreach ($sellers as $seller) {
            if (isset($seller->product) && $seller->product->count() > 0) {
                $ids = $seller->product->pluck('id');
                array_push($product_ids, ...$ids);
            }
        }

        $inhouse_product = [];
        $company_name = Helpers::get_business_settings('company_name');

        if (strpos($request['name'], $company_name) !== false) {
            $ids = Product::active()->Where('added_by', 'admin')->pluck('id');
            array_push($product_ids, ...$ids);
        }

        $seller_products = Product::active()->whereIn('id', $product_ids)->get();

        return response()->json([
            'result' => view(VIEW_FILE_NAMES['product_search_result'], compact('products', 'seller_products'))->render(),
            'seller_products' => $seller_products->count(),
        ]);
    }

    // global search for theme fashion compare list
    public function searched_products_for_compare_list(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Product name is required!',
        ]);
        $compare_id = $request['compare_id'];
        $result = ProductManager::search_products_web($request['name']);
        $products = $result['products'];
        if ($products == null) {
            $result = ProductManager::translated_product_search_web($request['name']);
            $products = $result['products'];
        }
        return response()->json([
            'result' => view(VIEW_FILE_NAMES['product_search_result_for_compare_list'], compact('products', 'compare_id'))->render(),
        ]);
    }

    public function checkout_details(Request $request)
    {
        if(Auth::guard('customer')->check()){
            $shippingAddress = DB::table('shipping_addresses')->where('customer_id', $request->customer_id)->first();
            if ($shippingAddress !== null) {
                $exsisting_cart_shipping = DB::table('cart_shippings')->where('cart_group_id', $request->cart_group_id)->first();
                if (!($exsisting_cart_shipping)) {
                    DB::table('cart_shippings')->insert([
                        'cart_group_id' => $request->cart_group_id,
                        'shipping_cost' => $request->customer_id,
                    ]);
                }
                if (!(Auth::guard('customer')->check())) 
                {
                    Toastr::error(translate('invalid_access'));
                    return redirect('/');
                }
    
                $cart_group_ids = CartManager::get_cart_group_ids();
                $shippingMethod = Helpers::get_business_settings('shipping_method');
    
                $verify_status = OrderManager::minimum_order_amount_verify($request);
    
    
                if ($verify_status['status'] == 0) {
                    Toastr::info(translate('check_Minimum_Order_Amount_Requirment'));
                    return redirect()->route('shop-cart');
                }
    
                $cartItems = Cart::where(['customer_id' => auth('customer')->id()])->withCount(['all_product' => function ($query) {
                    return $query->where('status', 0);
                }])->get();
    
    
    
                foreach ($cartItems as $cart) {
                    if (isset($cart->all_product_count) && $cart->all_product_count != 0) {
                        Toastr::info(translate('check_Cart_List_First'));
                        return redirect()->route('shop-cart');
                    }
                }
    
    
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
                            if ($physical_product && $shipping_type == 'order_wise') {
                                $cart_shipping = CartShipping::where('cart_group_id', $cart->cart_group_id)->first();
                                if (!isset($cart_shipping)) {
                                    Toastr::info(translate('select_shipping_method_first'));
                                    return redirect('shop-cart');
                                }
                            }
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
                $customer = Auth::guard('customer')->user();

                $shipping_addresses = ShippingAddress::where([
                    'customer_id' => $customer->id,
                    'is_default' => 'true',
                ])->first();
    
                $billing_addresses = ShippingAddress::where([
                    'customer_id' => $user == 'offline' ? session('guest_id') : auth('customer')->id(),
                    'is_guest' => $user == 'offline' ? 1 : '0',
                    'is_billing' => 1,
                ])->get();

                if (!empty((array)$shippingAddress)) {
                    $shipping_address = DB::table('shipping_addresses')->where('customer_id', $request->customer_id)->first();
                    $customer_data = DB::table('users')->where('id', $request->customer_id)->first();
                    $data = $request;
                    return view(VIEW_FILE_NAMES['order_shipping'], compact(
                        'shipping_address',
                        'customer_data',
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
                } else {
                    return redirect()->back()->with(['message' => 'Kindly Add Your Address First', 'status' => 0]);
                }
            }
        }else{
            return redirect()->back()->with(['message' => 'Please Login First', 'status' => 0]);
        }

        Toastr::info(translate('no_items_in_basket'));
        return redirect('/');
    }

    public function update_shipping_address(Request $request)
    {
        DB::table('shipping_addresses')
            ->where('customer_id', $request->customer_id)
            ->update([
                'contact_person_name' => $request->contact_person_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address_type' => $request->address_type,
                'country' => $request->country,
                'city' => $request->city,
                'zip' => $request->zip,
                'address' => $request->address,
            ]);

        return response()->json(['message' => 'Address updated successfully']);
    }

    public function update_billing_address(Request $request)
    {

        $existing_billing_address = DB::table('billing_addresses')->where('customer_id', $request->customer_id)->first();
        if (empty($existing_billing_address)) {
            DB::table('billing_addresses')
                ->insert([
                    'customer_id' => $request->customer_id,
                    'contact_person_name' => $request->billing_contact_person_name,
                    'address_type' => $request->billing_address_type,
                    'phone' => $request->billing_phone,
                    'country' => $request->billing_country,
                    'address' => $request->billing_address,
                    'city' => $request->billing_city,
                    'zip' => $request->billing_zip,
                ]);
        } else {
            DB::table('billing_addresses')
                ->where('customer_id', $request->customer_id)
                ->update([
                    'customer_id' => $request->customer_id,
                    'contact_person_name' => $request->billing_contact_person_name,
                    'address_type' => $request->billing_address_type,
                    'phone' => $request->billing_phone,
                    'country' => $request->billing_country,
                    'address' => $request->billing_address,
                    'city' => $request->billing_city,
                    'zip' => $request->billing_zip,
                ]);
        }
        return response()->json(['message' => 'Address updated successfully']);
    }
    public function checkout_payment(Request $request)
    {


        // dd($request);
        // if (
        //     (!auth('customer')->check() || Cart::where(['customer_id' => auth('customer')->id()])->count() < 1)
        //     && (!Helpers::get_business_settings('guest_checkout') || !session()->has('guest_id') || !session('guest_id'))
        // ){
        //     Toastr::error(translate('invalid_access'));
        //     return redirect('/');
        // }

        $existingOrder = DB::table('orders')->pluck('id')->toArray();



        $order = DB::table('orders')->insertGetId([
            'customer_id' => $request->customer_id,
            // 'customer_type',			
            // 'payment_status',			
            // 'order_status',
            'payment_method' => $request->payment_method,
            // 'transaction_ref',
            'payment_by' => $request->payment_by,
            // 'payment_note',
            'order_amount' => $request->final_payment,
            // 'admin_commission',
            // 'is_pause',
            // 'cause',
            'discount_amount' => $request->discount_amount,
            // 'discount_type' ,
            // 'coupon_code',
            // 'coupon_discount_bearer',
            // 'shipping_method_id' ,
            // 'shipping_cost',
            // 'is_shipping_free',
            // 'order_group_id' ,
            // 'verification_code',
            // 'verification_status',
            'seller_id' => $request->seller_id,
            'seller_is' => $request->seller_is,
            'shipping_address' => $request->shipping_address,
            'shipping_address_data' => $request->shipping_address_data,
            // 'delivery_man_id',
            // 'deliveryman_charge',
            // 'expected_delivery_date',
            // 'order_note',
            'billing_address' => $request->billing_address,
            'billing_address_data' => $request->billing_address_data,
            // 'order_type',
            // 'extra_discount',
            // 'extra_discount_type',
            // 'checked',
            // 'shipping_type',
            // 'delivery_type',
            // 'delivery_service_name',
            // 'third_party_delivery_tracking_id',
        ]);
        foreach ($request->product as $product) {
            DB::table('order_details')->insert([
                'order_id' => $order,
                'product_id' => $product['product_id'],
                'seller_id' => 1,
                // 'digital_file_after_sell' => $product[', 
                // 'product_details' => $product['product_details'], 
                'qty' => $product['quantity'],
                'price' => $product['price'],
                'tax' => $product['tax'],
                'discount' => $product['discount'],
                'tax_model' => $product['tax_model'],
                // 'delivery_status' => $product[', 
                // 'payment_status' => $product[', 
                // 'shipping_method_id' => $product[', 
                'variant' => $product['variant'],
                // 'variation' => $product[', 
                // 'discount_type' => $product[', 
                'is_stock_decreased' => $product['quantity'],
                // 'refund_request' => $product[''], 
            ]);
        }



        $cart_group_ids = CartManager::get_cart_group_ids();

        $shippingMethod = Helpers::get_business_settings('shipping_method');


        $verify_status = OrderManager::minimum_order_amount_verify($request);

        if ($verify_status['status'] == 0) {
            Toastr::info(translate('check_Minimum_Order_Amount_Requirment'));
            return redirect()->route('shop-cart');
        }

        $cartItems = Cart::where(['customer_id' => auth('customer')->id()])->withCount(['all_product' => function ($query) {
            return $query->where('status', 0);
        }])->get();
        foreach ($cartItems as $cart) {
            if ($cart->all_product_count != 0) {
                Toastr::info(translate('check_Cart_List_First'));
                return redirect()->route('shop-cart');
            }
        }

        $physical_products[] = false;
        foreach ($cart_group_ids as $group_id) {
            $carts = Cart::where('cart_group_id', $group_id)->get();
            $physical_product = false;
            foreach ($carts as $cart) {
                if ($cart->product_type == 'physical') {
                    $physical_product = true;
                }
            }
            $physical_products[] = $physical_product;
        }
        unset($physical_products[0]);

        $cod_not_show = in_array(false, $physical_products);


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
                    if ($shipping_type == 'order_wise') {
                        $cart_shipping = CartShipping::where('cart_group_id', $cart->cart_group_id)->first();

                        // if (!isset($cart_shipping)) {
                        //     dd($cart_shipping);
                        //     Toastr::info(translate('select_shipping_method_first'));
                        //     return redirect('shop-cart');
                        // }
                    }
                }
            }
        }

        // $order = Order::find(session('order_id'));
        // dd($order);
        $coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $order_wise_shipping_discount = CartManager::order_wise_shipping_discount();
        $get_shipping_cost_saved_for_free_delivery = CartManager::get_shipping_cost_saved_for_free_delivery();
        $amount = CartManager::cart_grand_total() - $coupon_discount - $order_wise_shipping_discount - $get_shipping_cost_saved_for_free_delivery;
        $inr = Currency::where(['symbol' => '₹'])->first();
        $usd = Currency::where(['code' => 'USD'])->first();
        $myr = Currency::where(['code' => 'MYR'])->first();

        // dd($coupon_discount);
        $cash_on_delivery = Helpers::get_business_settings('cash_on_delivery');
        $digital_payment = Helpers::get_business_settings('digital_payment');
        $wallet_status = Helpers::get_business_settings('wallet_status');
        $offline_payment = Helpers::get_business_settings('offline_payment');

        $payment_gateways_list = payment_gateways();

        $offline_payment_methods = OfflinePaymentMethod::where('status', 1)->get();
        $payment_published_status = config('get_payment_publish_status');
        $payment_gateway_published_status = isset($payment_published_status[0]['is_published']) ? $payment_published_status[0]['is_published'] : 0;

        $data = $request;
        // if (session()->has('address_id') && session()->has('billing_address_id') && count($cart_group_ids) > 0) {
        // return view(
        //     VIEW_FILE_NAMES['order_complete'],
        //     compact('data','order',
        //         'cod_not_show','order','cash_on_delivery','digital_payment','offline_payment',
        //         'wallet_status','coupon_discount','amount','inr','usd','myr','payment_gateway_published_status','payment_gateways_list','offline_payment_methods'
        //     ));
        // }
        return redirect()->route('checkout-complete');
        // Toastr::error(translate('incomplete_info'));
        // return back();
    }

    public function checkout_complete(Request $request)
    {
        // dd($request->all());
        // if($request->payment_method != 'cash_on_delivery'){
        //     return back()->with('error', 'Something went wrong!');
        // }
        $unique_id = OrderManager::gen_unique_id();
        $order_ids = [];
        $cart_group_ids = CartManager::get_cart_group_ids();
        $carts = Cart::whereIn('cart_group_id', $cart_group_ids)->get();

        $product_stock = CartManager::product_stock_check($carts);

        if (!$product_stock) {
            Toastr::error(translate('the_following_items_in_your_cart_are_currently_out_of_stock'));
            return redirect()->route('shop-cart');
        }

        $physical_product = false;
        foreach ($carts as $cart) {
            if ($cart->product_type == 'physical') {
                $physical_product = true;
            }
        }

        if ($physical_product) {
            foreach ($cart_group_ids as $group_id) {
                $data = [
                    'payment_method' => 'cash_on_delivery',
                    'order_status' => 'pending',
                    'payment_status' => 'unpaid',
                    'transaction_ref' => '',
                    'order_group_id' => $unique_id,
                    'cart_group_id' => $group_id
                ];
                // dd($data);
                $order_id = OrderManager::generate_order($data);
                array_push($order_ids, $order_id);
            }

            CartManager::cart_clean();

            // dd($order_id);
            return view(VIEW_FILE_NAMES['order_complete'], compact('order_ids'));
        }

        return back()->with('error', 'Something went wrong!');
    }

    public function offline_payment_checkout_complete(Request $request)
    {
        if ($request->payment_method != 'offline_payment') {
            return back()->with('error', 'Something went wrong!');
        }
        $unique_id = OrderManager::gen_unique_id();
        $order_ids = [];
        $cart_group_ids = CartManager::get_cart_group_ids();
        $carts = Cart::whereIn('cart_group_id', $cart_group_ids)->get();

        $product_stock = CartManager::product_stock_check($carts);
        if (!$product_stock) {
            Toastr::error(translate('the_following_items_in_your_cart_are_currently_out_of_stock'));
            return redirect()->route('shop-cart');
        }

        $offline_payment_info = [];
        $method = OfflinePaymentMethod::where(['id' => $request->method_id, 'status' => 1])->first();

        if (isset($method)) {
            $fields = array_column($method->method_informations, 'customer_input');
            $values = $request->all();

            $offline_payment_info['method_id'] = $request->method_id;
            $offline_payment_info['method_name'] = $method->method_name;
            foreach ($fields as $field) {
                if (key_exists($field, $values)) {
                    $offline_payment_info[$field] = $values[$field];
                }
            }
        }

        foreach ($cart_group_ids as $group_id) {
            $data = [
                'payment_method' => 'offline_payment',
                'order_status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_note' => $request->payment_note,
                'order_group_id' => $unique_id,
                'cart_group_id' => $group_id,
                'offline_payment_info' => $offline_payment_info,
            ];
            $order_id = OrderManager::generate_order($data);
            array_push($order_ids, $order_id);
        }

        CartManager::cart_clean();


        return view(VIEW_FILE_NAMES['order_complete'], compact('order_ids'));
    }
    public function checkout_complete_wallet(Request $request = null)
    {
        $cartTotal = CartManager::cart_grand_total();
        $user = Helpers::get_customer($request);
        if ($cartTotal > $user->wallet_balance) {
            Toastr::warning(translate('inefficient balance in your wallet to pay for this order!!'));
            return back();
        } else {
            $unique_id = OrderManager::gen_unique_id();
            $cart_group_ids = CartManager::get_cart_group_ids();
            $carts = Cart::whereIn('cart_group_id', $cart_group_ids)->get();

            $product_stock = CartManager::product_stock_check($carts);
            if (!$product_stock) {
                Toastr::error(translate('the_following_items_in_your_cart_are_currently_out_of_stock'));
                return redirect()->route('shop-cart');
            }

            $order_ids = [];
            foreach ($cart_group_ids as $group_id) {
                $data = [
                    'payment_method' => 'pay_by_wallet',
                    'order_status' => 'confirmed',
                    'payment_status' => 'paid',
                    'transaction_ref' => '',
                    'order_group_id' => $unique_id,
                    'cart_group_id' => $group_id
                ];
                $order_id = OrderManager::generate_order($data);
                array_push($order_ids, $order_id);
            }

            CustomerManager::create_wallet_transaction($user->id, Convert::default($cartTotal), 'order_place', 'order payment');
            CartManager::cart_clean();
        }

        if (session()->has('payment_mode') && session('payment_mode') == 'app') {
            return redirect()->route('payment-success');
        }
        return view(VIEW_FILE_NAMES['order_complete'], compact('order_ids'));
    }

    public function order_placed()
    {
        return view(VIEW_FILE_NAMES['order_complete']);
    }

    public function shop_cart(Request $request)
    {
        // dd($request); 

        $top_rated_shops = [];
        $new_sellers = [];
        $current_date = date('Y-m-d H:i:s');
        if (theme_root_path() === "theme_fashion") {
            /*
            * Top rated store and new seller
            */
            $seller_list = $this->seller->approved()->with(['shop', 'product.reviews'])
                ->withCount(['product' => function ($query) {
                    $query->active();
                }])->get();
            $seller_list?->map(function ($seller) {
                $rating = 0;
                $count = 0;
                foreach ($seller->product as $item) {
                    foreach ($item->reviews as $review) {
                        $rating += $review->rating;
                        $count++;
                    }
                }
                $avg_rating = $rating / ($count == 0 ? 1 : $count);
                $rating_count = $count;
                $seller['average_rating'] = $avg_rating;
                $seller['rating_count'] = $rating_count;

                $product_count = $seller->product->count();
                $random_product = Arr::random($seller->product->toArray(), $product_count < 3 ? $product_count : 3);
                $seller['product'] = $random_product;
                return $seller;
            });
            $new_sellers     =  $seller_list->sortByDesc('id')->take(12);
            $top_rated_shops =  $seller_list->where('rating_count', '!=', 0)->sortByDesc('average_rating')->take(12);

            /*
            * end Top Rated store and new seller
            */
        }
        return view(VIEW_FILE_NAMES['cart_list'], compact('top_rated_shops', 'new_sellers', 'current_date', 'request'));
    }

    //ajax filter (category based)
    public function seller_shop_product(Request $request, $id)
    {
        $products = Product::active()->with('shop')->where(['added_by' => 'seller'])
            ->where('user_id', $id)
            ->whereJsonContains('category_ids', [
                ['id' => strval($request->category_id)],
            ])
            ->paginate(12);
        $shop = Shop::where('seller_id', $id)->first();
        if ($request['sort_by'] == null) {
            $request['sort_by'] = 'latest';
        }

        if ($request->ajax()) {
            return response()->json([
                'view' => view(VIEW_FILE_NAMES['products__ajax_partials'], compact('products'))->render(),
            ], 200);
        }

        return view(VIEW_FILE_NAMES['shop_view_page'], compact('products', 'shop'))->with('seller_id', $id);
    }

    public function quick_view(Request $request)
    {
        $product = ProductManager::get_product($request->product_id);
        $order_details = OrderDetail::where('product_id', $product->id)->get();
        $wishlists = Wishlist::where('product_id', $product->id)->get();
        $wishlist_status = Wishlist::where(['product_id' => $product->id, 'customer_id' => auth('customer')->id()])->count();
        $countOrder = count($order_details);
        $countWishlist = count($wishlists);
        $relatedProducts = Product::with(['reviews'])->where('category_ids', $product->category_ids)->where('id', '!=', $product->id)->limit(12)->get();
        $current_date = date('Y-m-d');
        $seller_vacation_start_date = ($product->added_by == 'seller' && isset($product->seller->shop->vacation_start_date)) ? date('Y-m-d', strtotime($product->seller->shop->vacation_start_date)) : null;
        $seller_vacation_end_date = ($product->added_by == 'seller' && isset($product->seller->shop->vacation_end_date)) ? date('Y-m-d', strtotime($product->seller->shop->vacation_end_date)) : null;
        $seller_temporary_close = ($product->added_by == 'seller' && isset($product->seller->shop->temporary_close)) ? $product->seller->shop->temporary_close : false;

        $temporary_close = Helpers::get_business_settings('temporary_close');
        $inhouse_vacation = Helpers::get_business_settings('vacation_add');
        $inhouse_vacation_start_date = $product->added_by == 'admin' ? $inhouse_vacation['vacation_start_date'] : null;
        $inhouse_vacation_end_date = $product->added_by == 'admin' ? $inhouse_vacation['vacation_end_date'] : null;
        $inhouse_vacation_status = $product->added_by == 'admin' ? $inhouse_vacation['status'] : false;
        $inhouse_temporary_close = $product->added_by == 'admin' ? $temporary_close['status'] : false;

        // Newly Added From Blade
        $overallRating = ProductManager::get_overall_rating($product->reviews);
        $rating = ProductManager::get_rating($product->reviews);
        $reviews_of_product = Review::where('product_id', $product->id)->latest()->paginate(2);
        $decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings');
        $more_product_from_seller = Product::active()->where('added_by', $product->added_by)->where('id', '!=', $product->id)->where('user_id', $product->user_id)->latest()->take(5)->get();

        return response()->json([
            'success' => 1,
            'product' => $product,
            'view' => view(VIEW_FILE_NAMES['product_quick_view_partials'], compact(
                'product',
                'countWishlist',
                'countOrder',
                'relatedProducts',
                'current_date',
                'seller_vacation_start_date',
                'seller_vacation_end_date',
                'seller_temporary_close',
                'inhouse_vacation_start_date',
                'inhouse_vacation_end_date',
                'inhouse_vacation_status',
                'inhouse_temporary_close',
                'wishlist_status',
                'overallRating',
                'rating'
            ))->render(),
        ]);
    }


    public function discounted_products(Request $request)
    {
        $request['sort_by'] == null ? $request['sort_by'] == 'latest' : $request['sort_by'];

        $porduct_data = Product::active()->with(['reviews']);

        if ($request['data_from'] == 'category') {
            $products = $porduct_data->get();
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $request['id']) {
                        array_push($product_ids, $product['id']);
                    }
                }
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'brand') {
            $query = $porduct_data->where('brand_id', $request['id']);
        }

        if ($request['data_from'] == 'latest') {
            $query = $porduct_data->orderBy('id', 'DESC');
        }

        if ($request['data_from'] == 'top-rated') {
            $reviews = Review::select('product_id', DB::raw('AVG(rating) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')->get();
            $product_ids = [];
            foreach ($reviews as $review) {
                array_push($product_ids, $review['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'best-selling') {
            $details = OrderDetail::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'most-favorite') {
            $details = Wishlist::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'featured') {
            $query = Product::with(['reviews'])->active()->where('featured', 1);
        }

        if ($request['data_from'] == 'search') {
            $key = explode(' ', $request['name']);
            $query = $porduct_data->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });
        }

        if ($request['data_from'] == 'discounted_products') {
            $query = Product::with(['reviews'])->active()->where('discount', '!=', 0);
        }

        if ($request['sort_by'] == 'latest') {
            $fetched = $query->latest();
        } elseif ($request['sort_by'] == 'low-high') {
            return "low";
            $fetched = $query->orderBy('unit_price', 'ASC');
        } elseif ($request['sort_by'] == 'high-low') {
            $fetched = $query->orderBy('unit_price', 'DESC');
        } elseif ($request['sort_by'] == 'a-z') {
            $fetched = $query->orderBy('name', 'ASC');
        } elseif ($request['sort_by'] == 'z-a') {
            $fetched = $query->orderBy('name', 'DESC');
        } else {
            $fetched = $query;
        }

        if ($request['min_price'] != null || $request['max_price'] != null) {
            $fetched = $fetched->whereBetween('unit_price', [Helpers::convert_currency_to_usd($request['min_price']), Helpers::convert_currency_to_usd($request['max_price'])]);
        }

        $data = [
            'id' => $request['id'],
            'name' => $request['name'],
            'data_from' => $request['data_from'],
            'sort_by' => $request['sort_by'],
            'page_no' => $request['page'],
            'min_price' => $request['min_price'],
            'max_price' => $request['max_price'],
        ];

        $products = $fetched->paginate(5)->appends($data);

        if ($request->ajax()) {
            return response()->json([
                'view' => view(VIEW_FILE_NAMES['products__ajax_partials'], compact('products'))->render()
            ], 200);
        }
        if ($request['data_from'] == 'category') {
            $data['brand_name'] = Category::find((int)$request['id'])->name;
        }
        if ($request['data_from'] == 'brand') {
            $data['brand_name'] = Brand::active()->find((int)$request['id'])->name;
        }

        return view(VIEW_FILE_NAMES['products_view_page'], compact('products', 'data'), $data);
    }

    public function viewCart(Request $request)
    {
        $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;

        $carts = Cart::with([
            'product_full_info',
            'product_full_info.compare_list' => function ($query) {
                return $query->where('user_id', auth('customer')->id() ?? 0);
            }
        ])
            ->whereHas('cartProduct', function ($q) use ($request) {
                $q->when($request['search'], function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request['search']}%")
                        ->orWhereHas('category', function ($qq) use ($request) {
                            $qq->where('name', 'like', "%{$request['search']}%");
                        });
                });
            })
            ->where('customer_id', auth('customer')->id())->paginate(15);

        return view(VIEW_FILE_NAMES['account_cart'], compact('carts', 'brand_setting'));
    }

    public function addToCart(Request $request)
    {
        if(Auth::check()) {
        
        $userId = Auth::guard('customer')->user()->id;
        $productId = $request->product_id;

        // Retrieve data from the request sent by JavaScript
        $name = $request->name;
        $price = $request->price;
        $discount = $request->discount;
        $tax = $request->tax;
        $thumbnail = $request->thumbnail;
        $color = $request->color;
        $variant = $request->variant;
        $slug = $request->slug;
        $quantity = $request->quantity;

        if ($userId) {
            if (!Cart::where('customer_id', $userId)->where('product_id', $productId)->exists()) {
                Cart::create([
                    'customer_id' => $userId,
                    'product_id' => $productId,
                    'name' => $name,
                    'price' => $price,
                    'discount' => $discount,
                    'tax' => $tax,
                    'thumbnail' => $thumbnail,
                    'color' => $color,
                    'variant' => $variant,
                    'slug' => $slug,
                    'quantity' => $quantity,
                    // Include other necessary fields
                ]);

                return response()->json(['status' => 'success', 'message' => 'Product added to cart']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Product already in cart']);
            }
        }
        } else {
            $cart = $request->session()->get('cart', []);
            $cart[] = $request->product_id;
            $request->session()->put('cart', $cart);
            return response()->json(['status' => 'success', 'message' => 'Product added to cart']);
            // return response()->json(['status' => 'error', 'message' => 'Please Login First']);
        }

        return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
    }

    public function storeCart(Request $request)
    {
        if ($request->ajax()) {
            if (auth('customer')->check()) {
                $cart = Cart::where('customer_id', auth('customer')->id())->where('product_id', $request->product_id)->first();
                if ($cart) {
                    $cart->delete();

                    $countCart = Cart::whereHas('cartProduct', function ($q) {
                        return $q;
                    })->where('customer_id', auth('customer')->id())->count();
                    $product_count = Cart::where(['product_id' => $request->product_id])->count();
                    session()->put('cart', Cart::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());

                    return response()->json([
                        'error' => translate("cart_Removed"),
                        'value' => 2,
                        'count' => $countCart,
                        'product_count' => $product_count
                    ]);
                } else {
                    $cart = new Cart;
                    $cart->customer_id = auth('customer')->id();
                    $cart->product_id = $request->product_id;
                    $cart->save();

                    $countCart = Cart::whereHas('cartProduct', function ($q) {
                        return $q;
                    })->where('customer_id', auth('customer')->id())->count();

                    $product_count = Cart::where(['product_id' => $request->product_id])->count();
                    session()->put('cart', Cart::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());

                    return response()->json([
                        'success' => translate("Product has been added to cart"),
                        'value' => 1, 'count' => $countCart,
                        'id' => $request->product_id,
                        'product_count' => $product_count
                    ]);
                }
            } else {
                return response()->json(['error' => translate('login_first'), 'value' => 0]);
            }
        }
    }

    public function deleteCart(Request $request)
    {
        $cart = Cart::where(['product_id' => $request->productId, 'customer_id' => auth('customer')->id()])->delete();
        $data = translate('product_has_been_remove_from_cart') . '!';
        return response()->json(['success' => $data]);
    }

    public function delete_cart_all()
    {
        $this->cart->where('customer_id', auth('customer')->id())->delete();
        session()->put('cart', $this->cart->where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());
        return redirect()->back();
    }


    public function viewWishlist(Request $request)
    {
        $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;

        $wishlists = Wishlist::with([
            'product_full_info',
            'product_full_info.compare_list' => function ($query) {
                return $query->where('user_id', auth('customer')->id() ?? 0);
            }
        ])
            ->whereHas('wishlistProduct', function ($q) use ($request) {
                $q->when($request['search'], function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request['search']}%")
                        ->orWhereHas('category', function ($qq) use ($request) {
                            $qq->where('name', 'like', "%{$request['search']}%");
                        });
                });
            })
            ->where('customer_id', auth('customer')->id())->paginate(15);

        return view(VIEW_FILE_NAMES['account_wishlist'], compact('wishlists', 'brand_setting'));
    }

    public function addToWishlist(Request $request)
    {

        $userId = Auth::guard('customer')->user()->id;
        $productId = $request->productId;
        if ($userId) {
            if (!Wishlist::where('customer_id', $userId)->where('product_id', $productId)->exists()) {
                Wishlist::create([
                    'customer_id' => $userId,
                    'product_id' => $productId,
                ]);

                return response()->json(['status' => 'success', 'message' => 'Product added to wishlist']);
                // return redirect()->back();
            } else {
                return response()->json(['status' => 'error', 'message' => 'Product already in wishlist']);
            }
        } else {
            return response()->json(['status' => 'success', 'message' => 'Please Login First']);
        }


        return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
    }

    public function storeWishlist(Request $request)
    {
        if ($request->ajax()) {
            if (auth('customer')->check()) {
                $wishlist = Wishlist::where('customer_id', auth('customer')->id())->where('product_id', $request->product_id)->first();
                if ($wishlist) {
                    $wishlist->delete();

                    $countWishlist = Wishlist::whereHas('wishlistProduct', function ($q) {
                        return $q;
                    })->where('customer_id', auth('customer')->id())->count();
                    $product_count = Wishlist::where(['product_id' => $request->product_id])->count();
                    session()->put('wish_list', Wishlist::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());

                    return response()->json([
                        'error' => translate("wishlist_Removed"),
                        'value' => 2,
                        'count' => $countWishlist,
                        'product_count' => $product_count
                    ]);
                } else {
                    $wishlist = new Wishlist;
                    $wishlist->customer_id = auth('customer')->id();
                    $wishlist->product_id = $request->product_id;
                    $wishlist->save();

                    $countWishlist = Wishlist::whereHas('wishlistProduct', function ($q) {
                        return $q;
                    })->where('customer_id', auth('customer')->id())->count();

                    $product_count = Wishlist::where(['product_id' => $request->product_id])->count();
                    session()->put('wish_list', Wishlist::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());

                    return response()->json([
                        'success' => translate("Product has been added to wishlist"),
                        'value' => 1, 'count' => $countWishlist,
                        'id' => $request->product_id,
                        'product_count' => $product_count
                    ]);
                }
            } else {
                return response()->json(['error' => translate('login_first'), 'value' => 0]);
            }
        }
    }

    public function deleteWishlist(Request $request)
    {
        $wishlist = Wishlist::where(['product_id' => $request->productId, 'customer_id' => auth('customer')->id()])->delete();
        $data = translate('product_has_been_remove_from_wishlist') . '!';
        // $wishlists = $this->wishlist->where('customer_id', auth('customer')->id())->paginate(15);
        // $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;
        // session()->put('wish_list', $this->wishlist->where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());
        // return response()->json([
        //     'success' => $data,
        //     'count' => count($wishlists),
        //     'id' => $request->id,
        //     'wishlist' => view(VIEW_FILE_NAMES['account_wishlist_partials'], compact('wishlists', 'brand_setting'))->render(),
        // ]);
        return response()->json([
            'success' => 'deleted successfully'
        ]);
    }

    public function delete_wishlist_all()
    {
        $this->wishlist->where('customer_id', auth('customer')->id())->delete();
        session()->put('wish_list', $this->wishlist->where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());
        return redirect()->back();
    }

    //order Details

    public function orderdetails()
    {
        return view('web-views.orderdetails');
    }

    public function chat_for_product(Request $request)
    {
        return $request->all();
    }

    public function supportChat()
    {
        return view('web-views.users-profile.profile.supportTicketChat');
    }

    public function error()
    {
        return view('web-views.404-error-page');
    }

    public function contact_store(Request $request)
    {
        //recaptcha validation
        $recaptcha = Helpers::get_business_settings('recaptcha');
        if (isset($recaptcha) && $recaptcha['status'] == 1) {

            try {
                $request->validate([
                    'g-recaptcha-response' => [
                        function ($attribute, $value, $fail) {
                            $secret_key = Helpers::get_business_settings('recaptcha')['secret_key'];
                            $response = $value;
                            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response;
                            $response = \file_get_contents($url);
                            $response = json_decode($response);
                            if (!$response->success) {
                                $fail(\App\CPU\translate('ReCAPTCHA Failed'));
                            }
                        },
                    ],
                ]);
            } catch (\Exception $exception) {
                return back()->withErrors(\App\CPU\translate('Captcha Failed'))->withInput($request->input());
            }
        } else {
            if (strtolower($request->default_captcha_value) != strtolower(Session('default_captcha_code'))) {
                Session::forget('default_captcha_code');
                return back()->withErrors(\App\CPU\translate('Captcha Failed'))->withInput($request->input());
            }
        }

        $request->validate([
            'mobile_number' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'email' => 'email',
        ], [
            'mobile_number.required' => 'Mobile Number is Empty!',
            'subject.required' => ' Subject is Empty!',
            'message.required' => 'Message is Empty!',
        ]);
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->mobile_number = $request->mobile_number;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        Toastr::success(translate('Your Message Send Successfully'));
        return back();
    }

    public function captcha($tmp)
    {

        $phrase = new PhraseBuilder;
        $code = $phrase->build(4);
        $builder = new CaptchaBuilder($code, $phrase);
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        $builder->build($width = 100, $height = 40, $font = null);
        $phrase = $builder->getPhrase();

        if (Session::has('default_captcha_code')) {
            Session::forget('default_captcha_code');
        }
        Session::put('default_captcha_code', $phrase);
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    public function order_note(Request $request)
    {
        if ($request->has('order_note')) {
            session::put('order_note', $request->order_note);
        }
        return response()->json();
    }

    public function digital_product_download($id, Request $request)
    {
        $order_details_data = OrderDetail::with('order.customer')->find($id);
        if ($order_details_data) {
            if ($order_details_data->order->payment_status !== "paid") {
                return response()->json([
                    'status' => 0,
                    'message' => translate('Payment_must_be_confirmed_first') . ' !!',
                ]);
            };

            if ($order_details_data->order->is_guest) {
                $customer_email = $order_details_data->order->shipping_address_data ? json_decode($order_details_data->order->shipping_address_data)->email : ($order_details_data->order->billing_address_data ? json_decode($order_details_data->order->billing_address_data)->email : '');

                $customer_phone = $order_details_data->order->shipping_address_data ? json_decode($order_details_data->order->shipping_address_data)->phone : ($order_details_data->order->billing_address_data ? json_decode($order_details_data->order->billing_address_data)->phone : '');

                $customer_data = ['email' => $customer_email, 'phone' => $customer_phone];
                return self::digital_product_download_process($order_details_data, $customer_data);
            } else {
                if (auth('customer')->check() && auth('customer')->user()->id == $order_details_data->order->customer->id) {
                    $file_name = '';
                    if ($order_details_data->product->digital_product_type == 'ready_product' && $order_details_data->product->digital_file_ready) {
                        $file_path = asset('storage/app/public/product/digital-product/' . $order_details_data->product->digital_file_ready);
                        $file_name = $order_details_data->product->digital_file_ready;
                    } else {
                        $file_path = asset('storage/app/public/product/digital-product/' . $order_details_data->digital_file_after_sell);
                        $file_name = $order_details_data->digital_file_after_sell;
                    }

                    if (File::exists(base_path('storage/app/public/product/digital-product/' . $file_name))) {
                        return response()->json([
                            'status' => 1,
                            'file_path' => $file_path,
                            'file_name' => $file_name,
                        ]);
                    } else {
                        return response()->json([
                            'status' => 0,
                            'message' => translate('file_not_found'),
                        ]);
                    }
                } else {
                    $customer_data = ['email' => $order_details_data->order->customer->email ?? '', 'phone' => $order_details_data->order->customer->phone ?? ''];
                    return self::digital_product_download_process($order_details_data, $customer_data);
                }
            }
        } else {
            return response()->json([
                'status' => 0,
                'message' => translate('order_Not_Found') . ' !',
            ]);
        }
    }

    public function digital_product_download_otp_verify(Request $request)
    {
        $verification = DigitalProductOtpVerification::where(['token' => $request->otp, 'order_details_id' => $request->order_details_id])->first();
        $order_details_data = OrderDetail::with('order.customer')->find($request->order_details_id);

        if ($verification) {
            if ($order_details_data) {
                $file_name = '';
                if ($order_details_data->product->digital_product_type == 'ready_product' && $order_details_data->product->digital_file_ready) {
                    $file_path = asset('storage/app/public/product/digital-product/' . $order_details_data->product->digital_file_ready);
                    $file_name = $order_details_data->product->digital_file_ready;
                } else {
                    $file_path = asset('storage/app/public/product/digital-product/' . $order_details_data->digital_file_after_sell);
                    $file_name = $order_details_data->digital_file_after_sell;
                }
            }

            DigitalProductOtpVerification::where(['token' => $request->otp, 'order_details_id' => $request->order_details_id])->delete();

            if (File::exists(base_path('storage/app/public/product/digital-product/' . $file_name))) {
                return response()->json([
                    'status' => 1,
                    'file_path' => $file_path ?? '',
                    'file_name' => $file_name ?? '',
                    'message' => translate('successfully_verified'),
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => translate('file_not_found'),
                ]);
            }
        } else {
            return response()->json([
                'status' => 0,
                'message' => translate('the_OTP_is_incorrect') . ' !',
            ]);
        }
    }

    public function digital_product_download_otp_reset(Request $request)
    {
        $token_info = DigitalProductOtpVerification::where(['order_details_id' => $request->order_details_id])->first();
        $otp_interval_time = Helpers::get_business_settings('otp_resend_time') ?? 1; //minute
        if (isset($token_info) &&  Carbon::parse($token_info->created_at)->diffInSeconds() < $otp_interval_time) {
            $time_count = $otp_interval_time - Carbon::parse($token_info->created_at)->diffInSeconds();

            return response()->json([
                'status' => 0,
                'time_count' => CarbonInterval::seconds($time_count)->cascade()->forHumans(),
                'message' => 'Please try again after ' . CarbonInterval::seconds($time_count)->cascade()->forHumans()
            ]);
        } else {
            $guest_email = '';
            $guest_phone = '';
            $token = rand(1000, 9999);

            $order_details_data = OrderDetail::with('order.customer')->find($request->order_details_id);

            try {
                if ($order_details_data->order->shipping_address_data) {
                    $guest_email = $order_details_data->order->shipping_address_data ? json_decode($order_details_data->order->shipping_address_data)->email : null;
                    $guest_phone = $order_details_data->order->shipping_address_data ? json_decode($order_details_data->order->shipping_address_data)->phone : null;
                } else {
                    $guest_email = $order_details_data->order->billing_address_data ? json_decode($order_details_data->order->billing_address_data)->email : null;
                    $guest_phone = $order_details_data->order->billing_address_data ? json_decode($order_details_data->order->billing_address_data)->phone : null;
                }
            } catch (\Throwable $th) {
            }

            $verify_data = [
                'order_details_id' => $order_details_data->id,
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DigitalProductOtpVerification::updateOrInsert(['identity' => $guest_email, 'order_details_id' => $order_details_data->id], $verify_data);
            DigitalProductOtpVerification::updateOrInsert(['identity' => $guest_phone, 'order_details_id' => $order_details_data->id], $verify_data);

            $emailServices_smtp = Helpers::get_business_settings('mail_config');
            if ($emailServices_smtp['status'] == 0) {
                $emailServices_smtp = Helpers::get_business_settings('mail_config_sendgrid');
            }
            if ($emailServices_smtp['status'] == 1) {
                try {
                    Mail::to($guest_email)->send(new \App\Mail\DigitalProductOtpVerificationMail($token));
                    $mail_status = 1;
                } catch (\Exception $exception) {
                    $mail_status = 0;
                }
            } else {
                $mail_status = 0;
            }

            $published_status = 0;
            $payment_published_status = config('get_payment_publish_status');
            if (isset($payment_published_status[0]['is_published'])) {
                $published_status = $payment_published_status[0]['is_published'];
            }

            $response = '';
            if ($published_status == 1) {
                $response = SmsGateway::send($guest_phone, $token);
            } else {
                $response = SMS_module::send($guest_phone, $token);
            }

            $sms_status = $response == "not_found" ? 0 : 1;

            return response()->json([
                'mail_status' => $mail_status,
                'sms_status' => $sms_status,
                'status' => ($mail_status || $sms_status) ? 1 : 0,
                'new_time' => $otp_interval_time,
                'message' => 'OTP sent successfully',
            ]);
        }
    }

    public function digital_product_download_process($order_details_data, $customer)
    {
        $status = 2;
        $emailServices_smtp = Helpers::get_business_settings('mail_config');
        if ($emailServices_smtp['status'] == 0) {
            $emailServices_smtp = Helpers::get_business_settings('mail_config_sendgrid');
        }

        $payment_published_status = config('get_payment_publish_status');
        $published_status = isset($payment_published_status[0]['is_published']) ? $payment_published_status[0]['is_published'] : 0;

        if ($published_status == 1) {
            $sms_config_status = Setting::where(['settings_type' => 'sms_config', 'is_active' => 1])->count() > 0 ? 1 : 0;
        } else {
            $sms_config_status = Setting::where(['settings_type' => 'sms_config', 'is_active' => 1])->whereIn('key_name', Helpers::default_sms_gateways())->count() > 0 ? 1 : 0;
        }

        if ($emailServices_smtp['status'] || $sms_config_status) {
            $token = rand(1000, 9999);
            if ($customer['email'] == '' && $customer['phone'] == '') {
                return response()->json([
                    'status' => $status,
                    'file_path' => '',
                    'view' => view(VIEW_FILE_NAMES['digital_product_order_otp_verify_failed'])->render(),
                ]);
            }

            $verification_data = DigitalProductOtpVerification::where('identity', $customer['email'])->orWhere('identity', $customer['phone'])->where('order_details_id', $order_details_data->id)->latest()->first();
            $otp_interval_time = Helpers::get_business_settings('otp_resend_time') ?? 1; //second

            if (isset($verification_data) &&  Carbon::parse($verification_data->created_at)->diffInSeconds() < $otp_interval_time) {
                $time_count = $otp_interval_time - Carbon::parse($verification_data->created_at)->diffInSeconds();
                return response()->json([
                    'status' => $status,
                    'file_path' => '',
                    'view' => view(VIEW_FILE_NAMES['digital_product_order_otp_verify'], ['orderDetailID' => $order_details_data->id, 'time_count' => $time_count])->render(),
                ]);
            } else {
                $verify_data = [
                    'order_details_id' => $order_details_data->id,
                    'token' => $token,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                DigitalProductOtpVerification::updateOrInsert(['identity' => $customer['email'], 'order_details_id' => $order_details_data->id], $verify_data);
                DigitalProductOtpVerification::updateOrInsert(['identity' => $customer['phone'], 'order_details_id' => $order_details_data->id], $verify_data);

                $reset_data = DigitalProductOtpVerification::where('identity', $customer['email'])->orWhere('identity', $customer['phone'])->where('order_details_id', $order_details_data->id)->latest()->first();
                $otp_resend_time = Helpers::get_business_settings('otp_resend_time') > 0 ? Helpers::get_business_settings('otp_resend_time') : 0;
                $token_time = Carbon::parse($reset_data->created_at);
                $convert_time = $token_time->addSeconds($otp_resend_time);
                $time_count = $convert_time > Carbon::now() ? Carbon::now()->diffInSeconds($convert_time) : 0;
                $mail_status = 0;

                if ($emailServices_smtp['status'] == 1) {
                    try {
                        Mail::to($customer['email'])->send(new \App\Mail\DigitalProductOtpVerificationMail($token));
                        $mail_status = 1;
                    } catch (\Exception $exception) {
                    }
                }

                $response = '';
                if ($sms_config_status && $published_status == 1) {
                    $response = SmsGateway::send($customer['phone'], $token);
                } else if ($sms_config_status && $published_status == 0) {
                    $response = SMS_module::send($customer['phone'], $token);
                }

                $sms_status = ($response == "not_found" || $sms_config_status == 0) ? 0 : 1;
                if ($mail_status || $sms_status) {
                    return response()->json([
                        'status' => $status,
                        'file_path' => '',
                        'view' => view(VIEW_FILE_NAMES['digital_product_order_otp_verify'], ['orderDetailID' => $order_details_data->id, 'time_count' => $time_count])->render(),
                    ]);
                } else {
                    return response()->json([
                        'status' => $status,
                        'file_path' => '',
                        'view' => view(VIEW_FILE_NAMES['digital_product_order_otp_verify_failed'])->render(),
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => $status,
                'file_path' => '',
                'view' => view(VIEW_FILE_NAMES['digital_product_order_otp_verify_failed'])->render(),
            ]);
        }
    }


    public function subscription(Request $request)
    {
        $subscription_email = Subscription::where('email', $request->subscription_email)->first();
        if (isset($subscription_email)) {
            Toastr::info(translate('You already subscribed this site!!'));
            return back();
        } else {
            $new_subcription = new Subscription;
            $new_subcription->email = $request->subscription_email;
            $new_subcription->save();

            Toastr::success(translate('Your subscription successfully done!!'));
            return back();
        }
    }
    public function review_list_product(Request $request)
    {
        $reviews_of_product = Review::where('product_id', $request->product_id)->latest()->paginate(2, ['*'], 'page', $request->offset + 1);
        $checkReviews = Review::where('product_id', $request->product_id)->latest()->paginate(2, ['*'], 'page', ($request->offset + 1));
        return response()->json([
            'productReview' => view(VIEW_FILE_NAMES['product_reviews_partials'], compact('reviews_of_product'))->render(),
            'not_empty' => $reviews_of_product->count(),
            'checkReviews' => $checkReviews->count(),
        ]);
    }
    public function review_list_shop(Request $request)
    {
        $seller_id = 0;
        if ($request->shop_id != 0) {
            $seller_id = Shop::where('id', $request->shop_id)->first()->seller_id;
        }
        $product_ids = Product::when($request->shop_id == 0, function ($query) {
            return $query->where(['added_by' => 'admin']);
        })
            ->when($request->shop_id != 0, function ($query) use ($seller_id) {
                return $query->where(['added_by' => 'seller'])
                    ->where('user_id', $seller_id);
            })
            ->pluck('id')->toArray();

        $reviews_of_product = Review::active()->whereIn('product_id', $product_ids)->latest()->paginate(4, ['*'], 'page', $request->offset + 1);
        $checkReviews = Review::active()->whereIn('product_id', $product_ids)->latest()->paginate(4, ['*'], 'page', ($request->offset + 1));

        return response()->json([
            'productReview' => view(VIEW_FILE_NAMES['product_reviews_partials'], compact('reviews_of_product'))->render(),
            'not_empty' => $reviews_of_product->count(),
            'checkReviews' => $checkReviews->count(),
        ]);
    }
    public function product_view_style(Request $request)
    {
        Session::put('product_view_style', $request->value);
        return response()->json([
            'message' => translate('View_style_updated') . "!",
        ]);
    }


    public function pay_offline_method_list(Request $request)
    {

        $method = OfflinePaymentMethod::where(['id' => $request->method_id, 'status' => 1])->first();

        return response()->json([
            'methodHtml' => view(VIEW_FILE_NAMES['pay_offline_method_list_partials'], compact('method'))->render(),
        ]);
    }
}
