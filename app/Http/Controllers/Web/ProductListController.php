<?php

namespace App\Http\Controllers\Web;

use App\Model\Shop;
use App\CPU\Helpers;
use App\Model\Brand;
use App\Model\Color;
use App\Model\Review;
use App\Model\Product;
use App\Model\Category;
use App\Model\Wishlist;
use App\Model\FlashDeal;
use App\Model\OrderDetail;
use App\Model\Translation;
use Illuminate\Http\Request;
use App\Model\FlashDealProduct;
use function App\CPU\translate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class ProductListController extends Controller
{

    public function product_detail()
        {
            $home_categories = Category::where('home_status', true)->priority()->get();
                $home_categories->map(function ($data) {
                    $id = '"' . $data['id'] . '"';
                    $data['products'] = Product::active()
                        ->where('category_ids', 'like', "%{$id}%")
                        ->inRandomOrder()->take(12)->get();
                });
            return view(VIEW_FILE_NAMES['product-detail'],(compact('home_categories')));
        }
    public function __construct(
        private Product      $product,
        // private Order        $order,
        // private OrderDetail  $order_details,
        // private Category     $category,
        // private Seller       $seller,
        // private Review       $review,
        // private DealOfTheDay $deal_of_the_day,
        // private Banner       $banner,
        // private MostDemanded $most_demanded,
    )
    {
    }
    public function products(Request $request)
    {
        $theme_name = theme_root_path();

        return match ($theme_name){
            'default' => self::default_theme($request),
            'theme_aster' => self::theme_aster($request),
            'theme_fashion' => self::theme_fashion($request),
            'theme_all_purpose' => self::theme_all_purpose($request),
        };
    }

    public function default_theme(Request $request){
        // dd($request);
        // $user = Auth::guard('customer')->user();
        // dd($user);


        if(isset($request)){
            $request['sort_by'] == null ? $request['sort_by'] == 'latest' : $request['sort_by'];




            if (isset($request->filter) && isset($request->filterprice) ) {
                $brandIds = [];
                $shippings = [];
                $colors = [];
                $tag = [];

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
                    if (isset($filter['tag'])) {
                        if (is_array($filter['tag'])) {
                            $tag = array_merge($tag, $filter['tag']);
                        } else {
                            $tag[] = $filter['tag'];
                        }
                    }
                }

                


                foreach ($request->filter as $filter) {
                    if (isset($filter["brand_id"])) {                        
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
                    // dd($brandIds, $shippings, $colors, $tag); 
                }

                $max_price = intval(explode("-", $request->filterprice)[1]);
                $min_price = intval(explode("-", $request->filterprice)[0]);

                if (!empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                    
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
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
                    ;
                }
                elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                    
                    $porduct_data = Product::whereIn('free_shipping', $shippings)
                    ->whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                           $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ;
                }
                elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                    
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->whereIn('free_shipping', $shippings)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
                elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                    
                    $porduct_data = Product::whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                           $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ;
                }elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                    
                    $porduct_data = Product::whereIn('free_shipping', $shippings)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }elseif (!empty($shippings) && empty($brandIds) && empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereIn('free_shipping', $shippings)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                    // dd($tag, $brandIds, $colors, $min_price, $max_price);
                    $tags_products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                        dd($tags_products);
                        foreach($tags_products as $product){
                            foreach($tag as $value){
                                $tagdata = DB::table('tags')->where('tag', $value)->first();
                                $product_tag_table = DB::table('product_tag')->where('product_id', $product->id)->where('tag_id', $tagdata->id)->first();
                                dd($product_tag_table);
                                if($product_tag_table != null){
                                    $porduct_data[] = $product;
                                }
                            }
                    }
                       
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }elseif (empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->where(function ($query) use ($tag) {
                            foreach ($tag as $tagValue) {
                               $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                            }
                        })
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                    // dd($tag, $brandIds, $colors, $min_price, $max_price);
                    $tags_products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                        foreach($tags_products as $product){
                            foreach($tag as $value){
                                $tagdata = DB::table('tags')->where('tag', $value)->first();
                                $product_tag_table = DB::table('product_tag')->where('product_id', $product->id)->where('tag_id', $tagdata->id)->first();
                                if($product_tag_table != null){
                                    $porduct_data[] = $product;
                                }
                            }
                            // dd($porduct_data);
                    }
                       
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->where(function ($query) use ($tag) {
                            foreach ($tag as $tagValue) {
                               $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                            }
                        })
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && empty($brandIds) && empty($colors) && !empty($tag)) {
                    $porduct_data = Product::where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->where(function ($query) use ($tag) {
                            foreach ($tag as $tagValue) {
                               $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                            }
                        })
                        ->with(['reviews', 'brand']);
                }
                else {
                    $porduct_data = Product::where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
            }
            elseif(isset($request->filter)){
                $brandIds = [];

                foreach ($request->filter as $filter) {
                    if (is_array($filter['brand_id'])) {
                        $brandIds = array_merge($brandIds, $filter['brand_id']);
                    } else {
                        $brandIds[] = $filter['brand_id'];
                    }
                }
                $porduct_data = Product::whereIn('brand_id', $brandIds)
                    ->with(['reviews', 'brand']);
            }
            elseif(isset($request->filterprice)){
                $max_price = intval(explode("-", $request->filterprice)[1]);
                $min_price = intval(explode("-", $request->filterprice)[0]);

                $porduct_data = Product::where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand']);
            }
            else{
                $porduct_data = Product::active()->with(['reviews','brand'])->orderBy('unit_price');
            }



            if ($request['data_from'] == 'category') {
                $products = $porduct_data->get();
                return $products;
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
            // dd($porduct_data);

            if ($request['data_from'] == 'brand') {
                $query = $porduct_data->where('brand_id', $request['id']);
            }

            if (!$request->has('data_from') || $request['data_from'] == 'latest') {
                
                $query = $porduct_data;
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
                $query = Product::with(['reviews','brand'])->active()->where('featured', 1);
            }

            if ($request['data_from'] == 'featured_deal') {
                $featured_deal_id = FlashDeal::where(['status'=>1])->where(['deal_type'=>'feature_deal'])->pluck('id')->first();
                $featured_deal_product_ids = FlashDealProduct::where('flash_deal_id',$featured_deal_id)->pluck('product_id')->toArray();
                $query = Product::with(['reviews','brand'])->active()->whereIn('id', $featured_deal_product_ids);
            }

            if ($request['data_from'] == 'search') {
                $key = explode(' ', $request['name']);
                $product_ids = Product::where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('name', 'like', "%{$value}%")
                            ->orWhereHas('tags',function($query)use($value){
                                $query->where('tag', 'like', "%{$value}%");
                            });
                    }
                })->pluck('id');

                if($product_ids->count()==0)
                {
                    $product_ids = Translation::where('translationable_type', 'App\Model\Product')
                        ->where('key', 'name')
                        ->where(function ($q) use ($key) {
                            foreach ($key as $value) {
                                $q->orWhere('value', 'like', "%{$value}%");
                            }
                        })
                        ->pluck('translationable_id');


                }

                $query = $porduct_data->WhereIn('id', $product_ids);

            }

            if ($request['data_from'] == 'discounted') {
                $query = Product::with(['reviews','brand'])->active()->where('discount', '!=', 0);
            }

            // if ($request['sort_by'] == 'latest') {
            //     $fetched = $query->latest();
            // } elseif ($request['sort_by'] == 'low-high') {
            //     $fetched = $query->orderBy('unit_price', 'ASC');
            // } elseif ($request['sort_by'] == 'high-low') {
            //     $fetched = $query->orderBy('unit_price', 'DESC');
            // } elseif ($request['sort_by'] == 'a-z') {
            //     $fetched = $query->orderBy('name', 'ASC');
            // } elseif ($request['sort_by'] == 'z-a') {
            //     $fetched = $query->orderBy('name', 'DESC');
            // } else {
            //     $fetched = $query->latest();
            // }

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

            // $products = $fetched->paginate(20)->appends($data);

            if ($request['data_from'] == 'category') {
                $data['brand_name'] = Category::find((int)$request['id'])->name;
            }
            if ($request['data_from'] == 'brand') {
                $brand_data = Brand::active()->find((int)$request['id']);
                if($brand_data) {
                    $data['brand_name'] = $brand_data->name;
                }else {
                    Toastr::warning(translate('not_found'));
                    return redirect('/');
                }
            }
            $home_categories = Category::where('home_status', true)->priority()->get();
            $home_categories->map(function ($data) {
                $id = '"' . $data['id'] . '"';
                $data['products'] = Product::active()
                    ->where('category_ids', 'like', "%{$id}%")
                    ->inRandomOrder()->take(12)->get();
            });


            // if(isset($request->filter)){
            //     foreach($request->filter as $filter){
            //     $products = $this->product->where('brand_id',$filter['brand_id'])->with(['reviews','brand'])->active()->orderBy('id')->get();
            //     }
            // }
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
                }
                elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
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
                }
                elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                    $products = Product::whereIn('brand_id', $brandIds)
                        ->whereIn('free_shipping', $shippings)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
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
                }elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                    $products = Product::whereIn('free_shipping', $shippings)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }elseif (!empty($shippings) && empty($brandIds) && empty($colors) && empty($tag)) {
                    $products = Product::whereIn('free_shipping', $shippings)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                    // dd($tag, $brandIds, $colors, $min_price, $max_price);
                    $tags_products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                        foreach($tags_products as $product){
                            foreach($tag as $value){
                                $tagdata = DB::table('tags')->where('tag', $value)->first();
                                $product_tag_table = DB::table('product_tag')->where('product_id', $product->id)->where('tag_id', $tagdata->id)->first();
                                if($product_tag_table != null){
                                    $products[] = $product;
                                }
                            }
                            // dd($products);
                    }
                    
                       
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                    $products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }elseif (empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                    $products = Product::whereIn('brand_id', $brandIds)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->where(function ($query) use ($tag) {
                            foreach ($tag as $tagValue) {
                               $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                            }
                        })
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                    $products = Product::whereIn('brand_id', $brandIds)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                    // dd($tag, $brandIds, $colors, $min_price, $max_price);
                    $tags_products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                        foreach($tags_products as $product){
                            foreach($tag as $value){
                                $tagdata = DB::table('tags')->where('tag', $value)->first();
                                $product_tag_table = DB::table('product_tag')->where('product_id', $product->id)->where('tag_id', $tagdata->id)->first();
                                if($product_tag_table != null){
                                    $products[] = $product;
                                }
                            }
                            // dd($products);
                    }
                       
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                    $products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
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
                }
                elseif (empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                    $products = Product::whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (empty($shippings) && empty($brandIds) && empty($colors) && !empty($tag)) {
                    $products = Product::where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->where(function ($query) use ($tag) {
                            foreach ($tag as $tagValue) {
                               $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                            }
                        })
                        ->with(['reviews', 'brand'])->get();
                }
                else {
                    // dd('empty', $products);
                    if(empty($products)){
                        $products = Product::where('unit_price', '>=', $min_price)
                            ->where('unit_price', '<=', $max_price)
                            ->with(['reviews', 'brand'])->get();
                    }
                }


            }
            elseif(isset($request->filter)){
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
            }
            elseif(isset($request->filterprice)){
                $max_price = intval(explode("-", $request->filterprice)[1]);
                $min_price = intval(explode("-", $request->filterprice)[0]);

                $products = Product::where('unit_price', '>=', $min_price)
                ->where('unit_price', '<=', $max_price)
                ->with(['reviews', 'brand'])->get();
            }
            else{
                                    // dd('empty', $products);
                if(empty($products)){
                    $products = Product::with(['reviews','brand','tags'])->active()->orderBy('id')->get();
                }

            }
            
            // dd($products);
            $color = [
                'Red',
                'Blue',
                'Purple',
                'White',
                'Black',
                'Aqua',
                'Amethyst'
            ];

            $brands = Brand::get();
            $colors = Color::whereIn('name',$color)->get();
            $pricefilter = ceil(Product::orderBy('unit_price', 'DESC')->value('unit_price') / 300);
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
                if(empty($products)){
                    $products = Product::get();
                }
                $cartGroupId = null;
                $shippingAddress = [];
                $cartProductsArray = $productIds;
            }

            $filename = theme_root_path();

            // Get the user agent from the request headers
            $userAgent = $request->header('User-Agent');

            if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false) {
                // User is using a mobile device, load the mobile view
                $filename = 'products_mobile';
            } else {
                $filename = 'products';
            }

            foreach($products as $product){
                $productVariations = json_decode($product->variation, true);
                $categoryOptions = json_decode($product->choice_options, true);
                $groupedVariations = [];
                $product['size'] = [];
                foreach ($categoryOptions as $choice) {
                    if ($choice['title'] == 'Size') {
                        $product['size'] = $choice['options'];
                    }
                }
                foreach ($productVariations as $variation) {
                    $typeParts = explode('-', $variation['type']);
                    $color = $typeParts[0];
                    if (!isset($groupedVariations[$color])) {
                        $groupedVariations[$color] = [];
                    }
                    $groupedVariations[$color][] = $variation;
                }
                $product->variation = $groupedVariations;
            }


            return view(VIEW_FILE_NAMES[$filename], compact('cartProductsArray','wishlistProductsArray', 'data','products','home_categories','brands','pricefilter','colors','request'));
        }

    }
    public function deals_products(Request $request){
        $deal_product_list = FlashDeal::with('products')->where(['status' => 1, 'slug' => $request['slug']])->first();



        if(isset($request)){
            $request['sort_by'] == null ? $request['sort_by'] == 'latest' : $request['sort_by'];




            if (isset($request->filter) && isset($request->filterprice) ) {
                $brandIds = [];
                $shippings = [];
                $colors = [];
                $tag = [];

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
                    if (isset($filter['tag'])) {
                        if (is_array($filter['tag'])) {
                            $tag = array_merge($tag, $filter['tag']);
                        } else {
                            $tag[] = $filter['tag'];
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
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
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
                    ;
                }
                elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                    $porduct_data = Product::whereIn('free_shipping', $shippings)
                    ->whereIn('brand_id', $brandIds)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                           $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ;
                }
                elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->whereIn('free_shipping', $shippings)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
                elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                    $porduct_data = Product::whereIn('free_shipping', $shippings)
                    ->whereJsonContains('colors', $colors)
                    ->where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->where(function ($query) use ($tag) {
                        foreach ($tag as $tagValue) {
                           $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                        }
                    })
                    ->with(['reviews', 'brand'])
                    ;
                }elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereIn('free_shipping', $shippings)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }elseif (!empty($shippings) && empty($brandIds) && empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereIn('free_shipping', $shippings)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                    dd($tag, $brandIds, $colors, $min_price, $max_price);
                    $tags_products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                        foreach($tags_products as $product){
                            foreach($tag as $value){
                                $tagdata = DB::table('tags')->where('tag', $value)->first();
                                $product_tag_table = DB::table('product_tag')->where('product_id', $product->id)->where('tag_id', $tagdata->id)->first();
                                if($product_tag_table != null){
                                    $products[] = $product;
                                }
                            }
                            // dd($products);
                    }
                       
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }elseif (empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->where(function ($query) use ($tag) {
                            foreach ($tag as $tagValue) {
                               $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                            }
                        })
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                    // dd($tag, $brandIds, $colors, $min_price, $max_price);
                    $tags_products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                        foreach($tags_products as $product){
                            foreach($tag as $value){
                                $tagdata = DB::table('tags')->where('tag', $value)->first();
                                $product_tag_table = DB::table('product_tag')->where('product_id', $product->id)->where('tag_id', $tagdata->id)->first();
                                if($product_tag_table != null){
                                    $porduct_data[] = $product;
                                }
                            }
                            // dd($products);
                    }
                       
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
                    $porduct_data = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->where(function ($query) use ($tag) {
                            foreach ($tag as $tagValue) {
                               $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                            }
                        })
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                    $porduct_data = Product::whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
                elseif (empty($shippings) && empty($brandIds) && empty($colors) && !empty($tag)) {
                    $porduct_data = Product::where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->where(function ($query) use ($tag) {
                            foreach ($tag as $tagValue) {
                               $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                            }
                        })
                        ->with(['reviews', 'brand']);
                }
                else {
                    $porduct_data = Product::where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand']);
                }
            }
            elseif(isset($request->filter)){
                $brandIds = [];

                foreach ($request->filter as $filter) {
                    if (is_array($filter['brand_id'])) {
                        $brandIds = array_merge($brandIds, $filter['brand_id']);
                    } else {
                        $brandIds[] = $filter['brand_id'];
                    }
                }
                $porduct_data = Product::whereIn('brand_id', $brandIds)
                    ->with(['reviews', 'brand']);
            }
            elseif(isset($request->filterprice)){
                $max_price = intval(explode("-", $request->filterprice)[1]);
                $min_price = intval(explode("-", $request->filterprice)[0]);

                $porduct_data = Product::where('unit_price', '>=', $min_price)
                    ->where('unit_price', '<=', $max_price)
                    ->with(['reviews', 'brand']);
            }
            else{
                $porduct_data = Product::active()->with(['reviews','brand'])->orderBy('unit_price');
            }



            if ($request['data_from'] == 'category') {
                $products = $porduct_data->get();
                return $products;
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

            if (!$request->has('data_from') || $request['data_from'] == 'latest') {
                $query = $porduct_data;
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
                $query = Product::with(['reviews','brand'])->active()->where('featured', 1);
            }

            if ($request['data_from'] == 'featured_deal') {
                $featured_deal_id = FlashDeal::where(['status'=>1])->where(['deal_type'=>'feature_deal'])->pluck('id')->first();
                $featured_deal_product_ids = FlashDealProduct::where('flash_deal_id',$featured_deal_id)->pluck('product_id')->toArray();
                $query = Product::with(['reviews','brand'])->active()->whereIn('id', $featured_deal_product_ids);
            }

            if ($request['data_from'] == 'search') {
                $key = explode(' ', $request['name']);
                $product_ids = Product::where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('name', 'like', "%{$value}%")
                            ->orWhereHas('tags',function($query)use($value){
                                $query->where('tag', 'like', "%{$value}%");
                            });
                    }
                })->pluck('id');

                if($product_ids->count()==0)
                {
                    $product_ids = Translation::where('translationable_type', 'App\Model\Product')
                        ->where('key', 'name')
                        ->where(function ($q) use ($key) {
                            foreach ($key as $value) {
                                $q->orWhere('value', 'like', "%{$value}%");
                            }
                        })
                        ->pluck('translationable_id');


                }

                $query = $porduct_data->WhereIn('id', $product_ids);

            }

            if ($request['data_from'] == 'discounted') {
                $query = Product::with(['reviews','brand'])->active()->where('discount', '!=', 0);
            }

            // if ($request['sort_by'] == 'latest') {
            //     $fetched = $query->latest();
            // } elseif ($request['sort_by'] == 'low-high') {
            //     $fetched = $query->orderBy('unit_price', 'ASC');
            // } elseif ($request['sort_by'] == 'high-low') {
            //     $fetched = $query->orderBy('unit_price', 'DESC');
            // } elseif ($request['sort_by'] == 'a-z') {
            //     $fetched = $query->orderBy('name', 'ASC');
            // } elseif ($request['sort_by'] == 'z-a') {
            //     $fetched = $query->orderBy('name', 'DESC');
            // } else {
            //     $fetched = $query->latest();
            // }

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

            // $products = $fetched->paginate(20)->appends($data);

            if ($request['data_from'] == 'category') {
                $data['brand_name'] = Category::find((int)$request['id'])->name;
            }
            if ($request['data_from'] == 'brand') {
                $brand_data = Brand::active()->find((int)$request['id']);
                if($brand_data) {
                    $data['brand_name'] = $brand_data->name;
                }else {
                    Toastr::warning(translate('not_found'));
                    return redirect('/');
                }
            }
            $home_categories = Category::where('home_status', true)->priority()->get();
            $home_categories->map(function ($data) {
                $id = '"' . $data['id'] . '"';
                $data['products'] = Product::active()
                    ->where('category_ids', 'like', "%{$id}%")
                    ->inRandomOrder()->take(12)->get();
            });


            // if(isset($request->filter)){
            //     foreach($request->filter as $filter){
            //     $products = $this->product->where('brand_id',$filter['brand_id'])->with(['reviews','brand'])->active()->orderBy('id')->get();
            //     }
            // }
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
                }
                elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
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
                }
                elseif (!empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                    $products = Product::whereIn('brand_id', $brandIds)
                        ->whereIn('free_shipping', $shippings)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
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
                }elseif (!empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                    $products = Product::whereIn('free_shipping', $shippings)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }elseif (!empty($shippings) && empty($brandIds) && empty($colors) && empty($tag)) {
                    $products = Product::whereIn('free_shipping', $shippings)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                    // dd($tag, $brandIds, $colors, $min_price, $max_price);
                    $tags_products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                        foreach($tags_products as $product){
                            foreach($tag as $value){
                                $tagdata = DB::table('tags')->where('tag', $value)->first();
                                $product_tag_table = DB::table('product_tag')->where('product_id', $product->id)->where('tag_id', $tagdata->id)->first();
                                if($product_tag_table != null){
                                    $products[] = $product;
                                }
                            }
                            // dd($products);
                    }
                       
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                    $products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }elseif (empty($shippings) && !empty($brandIds) && empty($colors) && !empty($tag)) {
                    $products = Product::whereIn('brand_id', $brandIds)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->where(function ($query) use ($tag) {
                            foreach ($tag as $tagValue) {
                               $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                            }
                        })
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (empty($shippings) && !empty($brandIds) && empty($colors) && empty($tag)) {
                    $products = Product::whereIn('brand_id', $brandIds)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && !empty($tag)) {
                    dd($tag, $brandIds, $colors, $min_price, $max_price);
                    $tags_products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                        foreach($tags_products as $product){
                            foreach($tag as $value){
                                $tagdata = DB::table('tags')->where('tag', $value)->first();
                                $product_tag_table = DB::table('product_tag')->where('product_id', $product->id)->where('tag_id', $tagdata->id)->first();
                                if($product_tag_table != null){
                                    $products[] = $product;
                                }
                            }
                            // dd($products);
                    }
                       
                }
                elseif (empty($shippings) && !empty($brandIds) && !empty($colors) && empty($tag)) {
                    $products = Product::whereIn('brand_id', $brandIds)
                        ->whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (empty($shippings) && empty($brandIds) && !empty($colors) && !empty($tag)) {
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
                }
                elseif (empty($shippings) && empty($brandIds) && !empty($colors) && empty($tag)) {
                    $products = Product::whereJsonContains('colors', $colors)
                        ->where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }
                elseif (empty($shippings) && empty($brandIds) && empty($colors) && !empty($tag)) {
                    $products = Product::where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->where(function ($query) use ($tag) {
                            foreach ($tag as $tagValue) {
                               $data =  $query->orWhereJsonContains('choice_options', ['title' => $tagValue]);
                            }
                        })
                        ->with(['reviews', 'brand'])->get();
                }
                else {
                    $products = Product::where('unit_price', '>=', $min_price)
                        ->where('unit_price', '<=', $max_price)
                        ->with(['reviews', 'brand'])->get();
                }


            }
            elseif(isset($request->filter)){
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
            }
            elseif(isset($request->filterprice)){
                $max_price = intval(explode("-", $request->filterprice)[1]);
                $min_price = intval(explode("-", $request->filterprice)[0]);

                $products = Product::where('unit_price', '>=', $min_price)
                ->where('unit_price', '<=', $max_price)
                ->with(['reviews', 'brand'])->get();
            }
            else{
                $products = Product::with(['reviews','brand','tags'])->active()->orderBy('id')->get();

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

            $brands = Brand::get();
            $colors = Color::whereIn('name',$color)->get();
            $pricefilter = ceil(Product::orderBy('unit_price', 'DESC')->value('unit_price') / 300);
            if(Auth::guard('customer')->check()){
            $wishlistProducts = DB::table('wishlists')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');

            $wishlistProductsArray = $wishlistProducts->toArray();

            $cartProducts  = DB::table('carts')->where('customer_id', Auth::guard('customer')->user()->id)->pluck('product_id');
            $cartProductsArray = $cartProducts->toArray();
            }else{
                $wishlistProductsArray = [];
                $cartProductsArray = [];
            }
            $home_categories = Category::where('home_status', true)->priority()->get();
            $home_categories->map(function ($data) {
                $id = '"' . $data['id'] . '"';
                $data['products'] = Product::active()
                    ->where('category_ids', 'like', "%{$id}%")
                    ->inRandomOrder()->take(12)->get();
            });




        return view(VIEW_FILE_NAMES['deals_products'], compact('home_categories','deal_product_list','cartProductsArray','wishlistProductsArray', 'data','products','home_categories','brands','pricefilter','colors','request'));

    }}
    public function theme_aster($request){
        $request['sort_by'] == null ? $request['sort_by'] == 'latest' : $request['sort_by'];

        $porduct_data = Product::active()->with([
            'reviews','rating',
            'seller.shop',
            'wish_list'=>function($query){
                return $query->where('customer_id', Auth::guard('customer')->user()->id ?? 0);
            },
            'compare_list'=>function($query){
                return $query->where('user_id', Auth::guard('customer')->user()->id ?? 0);
            }
        ]);

        $product_ids = [];
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

        if ($request->has('search_category_value') && $request['search_category_value'] != 'all') {
            $products = $porduct_data->get();
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $request['search_category_value']) {
                        array_push($product_ids, $product['id']);
                    }
                }
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'brand') {
            $query = $porduct_data->where('brand_id', $request['id']);
        }

        if (!$request->has('data_from') || $request['data_from'] == 'latest') {
            $query = $porduct_data;
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
            $query = Product::with([
                'reviews','seller.shop',
                'wish_list'=>function($query){
                    return $query->where('customer_id', Auth::guard('customer')->user()->id ?? 0);
                },
                'compare_list'=>function($query){
                    return $query->where('user_id', Auth::guard('customer')->user()->id ?? 0);
                }
            ])->active()->where('featured', 1);
        }

        if ($request['data_from'] == 'featured_deal') {
            $featured_deal_id = FlashDeal::where(['status'=>1])->where(['deal_type'=>'feature_deal'])->pluck('id')->first();
            $featured_deal_product_ids = FlashDealProduct::where('flash_deal_id',$featured_deal_id)->pluck('product_id')->toArray();
            $query = Product::with([
                'reviews','seller.shop',
                'wish_list'=>function($query){
                    return $query->where('customer_id', Auth::guard('customer')->user()->id ?? 0);
                },
                'compare_list'=>function($query){
                    return $query->where('user_id', Auth::guard('customer')->user()->id ?? 0);
                }
            ])->active()->whereIn('id', $featured_deal_product_ids);
        }

        if ($request['data_from'] == 'search') {
            $key = explode(' ', $request['name']);
                $product_ids = Product::with([
                    'seller.shop',
                    'wish_list'=>function($query){
                        return $query->where('customer_id', Auth::guard('customer')->user()->id ?? 0);
                    },
                    'compare_list'=>function($query){
                        return $query->where('user_id', Auth::guard('customer')->user()->id ?? 0);
                    }
                ])
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('name', 'like', "%{$value}%")
                            ->orWhereHas('tags',function($query)use($value){
                                $query->where('tag', 'like', "%{$value}%");
                            });
                    }
                })->pluck('id');

            if($product_ids->count()==0)
            {
                $product_ids = Translation::where('translationable_type', 'App\Model\Product')
                    ->where('key', 'name')
                    ->where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('value', 'like', "%{$value}%");
                        }
                    })
                    ->pluck('translationable_id');
            }

            $query = $porduct_data->WhereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'discounted') {
            $query = Product::with([
                'reviews','seller.shop',
                'wish_list'=>function($query){
                    return $query->where('customer_id', Auth::guard('customer')->user()->id ?? 0);
                },
                'compare_list'=>function($query){
                    return $query->where('user_id', Auth::guard('customer')->user()->id ?? 0);
                }
            ])->active()->where('discount', '!=', 0);
        }

        if(!$request['data_from'] && !$request['name'] && $request['ratings']){
            $query = $query ?? $porduct_data;
        }

        if ($request['sort_by'] == 'latest') {
            $fetched = $query->latest();
        } elseif ($request['sort_by'] == 'low-high') {
            $fetched = $query->orderBy('unit_price', 'ASC');
        } elseif ($request['sort_by'] == 'high-low') {
            $fetched = $query->orderBy('unit_price', 'DESC');
        } elseif ($request['sort_by'] == 'a-z') {
            $fetched = $query->orderBy('name', 'ASC');
        } elseif ($request['sort_by'] == 'z-a') {
            $fetched = $query->orderBy('name', 'DESC');
        } else {
            $fetched = $query->latest();
        }

        if ($request['min_price'] != null || $request['max_price'] != null) {
            $fetched = $fetched->whereBetween('unit_price', [Helpers::convert_currency_to_usd($request['min_price']), Helpers::convert_currency_to_usd($request['max_price'])]);
        }

        if ($request['ratings'] != null)
        {
            $fetched->with('rating')->whereHas('rating', function($query) use($request){
                return $query;
            });
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
        $common_query = $fetched;

        $rating_1 = 0;
        $rating_2 = 0;
        $rating_3 = 0;
        $rating_4 = 0;
        $rating_5 = 0;

        foreach($common_query->get() as $rating){
            if(isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] >0 && $rating->rating[0]['average'] <2)){
                $rating_1 += 1;
            }elseif(isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] >=2 && $rating->rating[0]['average'] <3)){
                $rating_2 += 1;
            }elseif(isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] >=3 && $rating->rating[0]['average'] <4)){
                $rating_3 += 1;
            }elseif(isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] >=4 && $rating->rating[0]['average'] <5)){
                $rating_4 += 1;
            }elseif(isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] == 5)){
                $rating_5 += 1;
            }
        }
        $ratings = [
            'rating_1'=>$rating_1,
            'rating_2'=>$rating_2,
            'rating_3'=>$rating_3,
            'rating_4'=>$rating_4,
            'rating_5'=>$rating_5,
        ];

        $products = $common_query->paginate(20)->appends($data);

        if ($request['ratings'] != null)
        {
            $products = $products->map(function($product) use($request){
                $product->rating = $product->rating->pluck('average')[0];
                return $product;
            });
            $products = $products->where('rating','>=',$request['ratings'])
                ->where('rating','<',$request['ratings']+1)
                ->paginate(20)->appends($data);
        }

        if ($request->ajax()) {
            return response()->json([
                'total_product'=>$products->total(),
                'view' => view(VIEW_FILE_NAMES['products__ajax_partials'], compact('products','product_ids'))->render(),
            ], 200);
        }
        if ($request['data_from'] == 'category') {
            $data['brand_name'] = Category::find((int)$request['id'])->name;
        }
        if ($request['data_from'] == 'brand') {
            $brand_data = Brand::active()->find((int)$request['id']);
            if($brand_data) {
                $data['brand_name'] = $brand_data->name;
            }else {
                Toastr::warning(translate('not_found'));
                return redirect('/');
            }
        }

        return view(VIEW_FILE_NAMES['products_view_page'], compact('products', 'data', 'ratings', 'product_ids'));
    }

    public function theme_fashion(Request $request)
    {

        $tag_category = [];
        if($request->data_from == 'category')
        {
            $tag_category = Category::where('id',$request->id)->select('id', 'name')->get();
        }

        $tag_brand = [];
        if($request->data_from == 'brand')
        {
            $tag_brand = Brand::where('id', $request->id)->select('id','name')->get();
        }
        $request['sort_by'] == null ? $request['sort_by'] == 'latest' : $request['sort_by'];

        $porduct_data = Product::active()->withSum('order_details', 'qty', function ($query) {
                            $query->where('delivery_status', 'delivered');
                        })
                        ->with(['category','reviews','rating','wish_list'=>function($query){
                            return $query->where('customer_id', Auth::guard('customer')->user()->id ?? 0);
                        },
                        'compare_list'=>function($query){
                            return $query->where('user_id', Auth::guard('customer')->user()->id ?? 0);
                        }]);

        $product_ids = [];
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

        if ($request->has('search_category_value') && $request['search_category_value'] != 'all') {
            $products = $porduct_data->get();
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $request['search_category_value']) {
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
            $query = $porduct_data;
        }
        if (!$request->has('data_from') || $request['data_from'] == 'default') {
            $query = $porduct_data->orderBy('order_details_sum_qty', 'DESC');
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

        if ($request->has('shop_id') && $request['shop_id'] == 0) {
            $query = Product::active()
                    ->with(['reviews'])
                    ->where(['added_by'=>'admin','featured'=>1]);
        }elseif($request->has('shop_id') && $request['shop_id'] != 0){
            $query = Product::active()
                        ->where(['added_by' => 'seller', 'featured' => 1])
                        ->with(['reviews', 'seller.shop' => function($query) use ($request) {
                            $query->where('id', $request->shop_id);
                        }])
                        ->whereHas('seller.shop', function($query) use ($request) {
                            $query->where('id', $request->shop_id)->whereNotNull('id');
                        });
        }

        if ($request['data_from'] == 'featured_deal') {
            $featured_deal_id = FlashDeal::where(['status'=>1])->where(['deal_type'=>'feature_deal'])->pluck('id')->first();
            $featured_deal_product_ids = FlashDealProduct::where('flash_deal_id',$featured_deal_id)->pluck('product_id')->toArray();
            $query = Product::with(['reviews'])->active()->whereIn('id', $featured_deal_product_ids);
        }

        if ($request['data_from'] == 'search') {
            $key = explode(' ', $request['name']);
            $product_ids = Product::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                        ->orWhereHas('tags',function($query)use($value){
                            $query->where('tag', 'like', "%{$value}%");
                        });
                }
            })->pluck('id');

            $sellers = Shop::where(function ($q) use ($request) {
                $q->orWhere('name', 'like', "%{$request['name']}%");
            })->whereHas('seller', function ($query) {
                return $query->where(['status' => 'approved']);
            })->with('product', function($query){
                return $query->active()->where('added_by', 'seller');
            })->get();

            $seller_products = [];
            foreach($sellers as $seller){
                if(isset($seller->product) && $seller->product->count() > 0)
                {
                    $ids = $seller->product->pluck('id');
                    array_push($seller_products, ...$ids);
                }
            }

            $inhouse_product = [];
            $company_name = Helpers::get_business_settings('company_name');

            if (strpos($request['name'], $company_name) !== false) {
                $inhouse_product = Product::active()->Where('added_by', 'admin')->pluck('id');
            }

            $product_ids = $product_ids->merge($seller_products)->merge($inhouse_product);


            if($product_ids->count()==0)
            {
                $product_ids = Translation::where('translationable_type', 'App\Model\Product')
                    ->where('key', 'name')
                    ->where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('value', 'like', "%{$value}%");
                        }
                    })
                    ->pluck('translationable_id');
            }

            $query = $porduct_data->WhereIn('id', $product_ids);

        }

        if ($request['data_from'] == 'discounted') {
            $query = Product::with(['reviews'])->active()->where('discount', '!=', 0);
        }

        if ($request['sort_by'] == 'latest') {
            $fetched = $query->latest();
        } elseif ($request['sort_by'] == 'low-high') {
            $fetched = $query->orderBy('unit_price', 'ASC');
        } elseif ($request['sort_by'] == 'high-low') {
            $fetched = $query->orderBy('unit_price', 'DESC');
        } elseif ($request['sort_by'] == 'a-z') {
            $fetched = $query->orderBy('name', 'ASC');
        } elseif ($request['sort_by'] == 'z-a') {
            $fetched = $query->orderBy('name', 'DESC');
        } else {
            $fetched = $query->latest();
        }

        if ($request['min_price'] != null || $request['max_price'] != null) {
            $fetched = $fetched->whereBetween('unit_price', [Helpers::convert_currency_to_usd($request['min_price']), Helpers::convert_currency_to_usd($request['max_price'])]);
        }
        $common_query = $fetched;

        $products = $common_query->paginate(20);

        if ($request['ratings'] != null)
        {
            $products = $products->map(function($product) use($request){
                $product->rating = $product->rating->pluck('average')[0];
                return $product;
            });
            $products = $products->where('rating','>=',$request['ratings'])
                ->where('rating','<',$request['ratings']+1)
                ->paginate(20);
        }

        // Categories start
        $categories = Category::withCount(['product'=>function($query){
                $query->active();
            }])->with(['childes' => function ($query) {
                $query->with(['childes' => function ($query) {
                    $query->withCount(['sub_sub_category_product'])->where('position', 2);
                }])->withCount(['sub_category_product'])->where('position', 1);
            }, 'childes.childes'])
            ->where('position', 0)->get();
        // Categories End

        // Colors Start
        $colors_in_shop_merge = [];
        $colors_collection = Product::active()
            ->where('colors', '!=', '[]')
            ->pluck('colors')
            ->unique()
            ->toArray();

        foreach ($colors_collection as $color_json) {
            $color_array = json_decode($color_json, true);
            $colors_in_shop_merge = array_merge($colors_in_shop_merge, $color_array);
        }
        $colors_in_shop = array_unique($colors_in_shop_merge);
        // Colors End
        $banner = \App\Model\BusinessSetting::where('type', 'banner_product_list_page')->whereJsonContains('value', ['status' => '1'])->first();

        if ($request->ajax()) {
            return response()->json([
                'total_product'=>$products->total(),
                'view' => view(VIEW_FILE_NAMES['products__ajax_partials'], compact('products','product_ids'))->render(),
            ], 200);
        }

        if ($request['data_from'] == 'brand') {
            $brand_data = Brand::active()->find((int)$request['id']);
            if(!$brand_data) {
                Toastr::warning(translate('not_found'));
                return redirect('/');
            }
        }

        return view(VIEW_FILE_NAMES['products_view_page'], compact('products','tag_category','tag_brand','product_ids','categories','colors_in_shop','banner'));
    }

    public function theme_all_purpose(Request $request)
    {
        $request['sort_by'] == null ? $request['sort_by'] == 'latest' : $request['sort_by'];

        $porduct_data = Product::active()->with(['reviews','rating']);

        $product_ids = [];
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

        if ($request->has('search_category_value') && $request['search_category_value'] != 'all') {
            $products = $porduct_data->get();
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $request['search_category_value']) {
                        array_push($product_ids, $product['id']);
                    }
                }
            }
            $query = $porduct_data->whereIn('id', $product_ids);
        }

        if ($request['data_from'] == 'brand') {
            $query = $porduct_data->where('brand_id', $request['id']);
        }

        if (!$request->has('data_from') || $request['data_from'] == 'latest') {
            $query = $porduct_data;
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

        if ($request['data_from'] == 'featured_deal') {
            $featured_deal_id = FlashDeal::where(['status'=>1])->where(['deal_type'=>'feature_deal'])->pluck('id')->first();
            $featured_deal_product_ids = FlashDealProduct::where('flash_deal_id',$featured_deal_id)->pluck('product_id')->toArray();
            $query = Product::with(['reviews'])->active()->whereIn('id', $featured_deal_product_ids);
        }

        if ($request['data_from'] == 'search') {
            $key = explode(' ', $request['name']);
            $product_ids = Product::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                        ->orWhereHas('tags',function($query)use($value){
                            $query->where('tag', 'like', "%{$value}%");
                        });
                }
            })->pluck('id');

            if($product_ids->count()==0)
            {
                $product_ids = Translation::where('translationable_type', 'App\Model\Product')
                    ->where('key', 'name')
                    ->where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('value', 'like', "%{$value}%");
                        }
                    })
                    ->pluck('translationable_id');
            }

            $query = $porduct_data->WhereIn('id', $product_ids);

        }

        if ($request['data_from'] == 'discounted') {
            $query = Product::with(['reviews'])->active()->where('discount', '!=', 0);
        }

        if ($request['sort_by'] == 'latest') {
            $fetched = $query->latest();
        } elseif ($request['sort_by'] == 'low-high') {
            $fetched = $query->orderBy('unit_price', 'ASC');
        } elseif ($request['sort_by'] == 'high-low') {
            $fetched = $query->orderBy('unit_price', 'DESC');
        } elseif ($request['sort_by'] == 'a-z') {
            $fetched = $query->orderBy('name', 'ASC');
        } elseif ($request['sort_by'] == 'z-a') {
            $fetched = $query->orderBy('name', 'DESC');
        } else {
            $fetched = $query->latest();
        }

        if ($request['min_price'] != null || $request['max_price'] != null) {
            $fetched = $fetched->whereBetween('unit_price', [Helpers::convert_currency_to_usd($request['min_price']), Helpers::convert_currency_to_usd($request['max_price'])]);
        }
        $common_query = $fetched;

        $rating_1 = 0;
        $rating_2 = 0;
        $rating_3 = 0;
        $rating_4 = 0;
        $rating_5 = 0;

        foreach($common_query->get() as $rating){
            if(isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] >0 && $rating->rating[0]['average'] <2)){
                $rating_1 += 1;
            }elseif(isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] >=2 && $rating->rating[0]['average'] <3)){
                $rating_2 += 1;
            }elseif(isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] >=3 && $rating->rating[0]['average'] <4)){
                $rating_3 += 1;
            }elseif(isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] >=4 && $rating->rating[0]['average'] <5)){
                $rating_4 += 1;
            }elseif(isset($rating->rating[0]['average']) && ($rating->rating[0]['average'] == 5)){
                $rating_5 += 1;
            }
        }
        $ratings = [
            'rating_1'=>$rating_1,
            'rating_2'=>$rating_2,
            'rating_3'=>$rating_3,
            'rating_4'=>$rating_4,
            'rating_5'=>$rating_5,
        ];
        $data = [
            'id' => $request['id'],
            'name' => $request['name'],
            'data_from' => $request['data_from'],
        ];
        $products_count = $common_query->count();
        $products = $common_query->paginate(4)->appends($data);
        $categories = Category::withCount(['product'=>function($query){
                        $query->where(['status'=>'1']);
                    }])->with(['childes' => function ($sub_query) {
                        $sub_query->with(['childes' => function ($sub_sub_query) {
                            $sub_sub_query->withCount(['sub_sub_category_product'])->where('position', 2);
                        }])->withCount(['sub_category_product'])->where('position', 1);
                    }, 'childes.childes'])
                    ->where('position', 0)->get();
        // Categories End
        // Colors Start
        $colors_in_shop_merge = [];
        $colors_collection = Product::active()
            ->where('colors', '!=', '[]')
            ->pluck('colors')
            ->unique()
            ->toArray();

        foreach ($colors_collection as $color_json) {
            $color_array = json_decode($color_json, true);
            $colors_in_shop_merge = array_merge($colors_in_shop_merge, $color_array);
        }
        $colors_in_shop = array_unique($colors_in_shop_merge);
        // Colors End
        $banner = \App\Model\BusinessSetting::where('type', 'banner_product_list_page')->whereJsonContains('value', ['status' => '1'])->first();

        if ($request->ajax()) {
            return response()->json([
                'total_product'=>$products->total(),
                'view' => view(VIEW_FILE_NAMES['products__ajax_partials'], compact('products','product_ids'))->render(),
            ], 200);
        }

        if ($request['data_from'] == 'brand') {
            $brand_data = Brand::active()->find((int)$request['id']);
            if(!$brand_data) {
                Toastr::warning(translate('not_found'));
                return redirect('/');
            }
        }
        return view(VIEW_FILE_NAMES['products_view_page'], compact('products','product_ids','products_count','categories','colors_in_shop','banner','ratings'));
    }
}
