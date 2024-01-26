<?php

namespace App\Http\Controllers\Api\V1\Customer\CMS;

use Carbon\Carbon;
use App\Model\Shop;
use App\Model\Brand;
use App\Model\Banner;
use App\Model\Category;
use App\Models\Article;
use App\Model\FlashDeal;
use App\Models\CustomPage;
use Illuminate\Http\Request;
use App\Models\familyRelation;
use App\Model\FlashDealProduct;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function index()
    {
        $layouts = DB::table('home_layouts')->where('mobile_status', 1)->orderBy('mobile_order', 'asc')->get();
        return response()->json($layouts, 200);
    }

    public function SwitchUser($id){
        if($id == 0){
            return redirect()->route('home');
        }else{
            $child = DB::table('family_relation')->where('id', $id)->first();
            if($child){
                // Male
                if($child->gender == 1){
                    return response()->json(['errors' => 'Child is Boy.'], 200);
                }elseif($child->gender == 0){
                    return response()->json(['errors' => 'Child is Girl.'], 200);
                }
            }else{
                return response()->json(['errors' => 'Child not found.'], 200);
            }

        }
    }

    public function NewArrtival(Request $request){
        if($request->id != null){
            $child = familyRelation::where('id',$request->id)->first();
            if($child != null){
                $child->tag = ($child->gender == 1)?'Boy':'Girl';
                $toparrivalcategorys = DB::table('categories')
                ->where('parent_id', 0)
                ->where('priority', '!=', 0)
                ->orderBy('priority', 'asc')
                ->take(10)
                ->with(['customPage' => function ($query) {
                    $query->where('resource_type', 'category');
                }])
                ->get();
                $imageUrls = [];
                $name = [];
                foreach($toparrivalcategorys as $categoryavatar){
                    $url = asset('storage/app/public/category/' . $categoryavatar->icon);
                    $categoryavatar->image = $url;
                    $imageUrls[] = $url;
                    $name[] = $categoryavatar->name;
                }
                $imageUrls = array_values($imageUrls);
                $nameArray = array_values($name);
            }else{
                return response()->json(['message'=>'Child not found.'], 200);
            }
        }else{
            $toparrivalcategorys = DB::table('categories')
            ->where('parent_id', 0)
            ->where('priority', '!=', 0)
            ->orderBy('priority', 'asc')
            ->take(10)
            ->with(['customPage' => function ($query) {
                $query->where('resource_type', 'category');
            }])
            ->get();
            $imageUrls = [];
            $name = [];
            foreach($toparrivalcategorys as $categoryavatar){
                $url = asset('storage/app/public/category/' . $categoryavatar->icon);
                $categoryavatar->image = $url;
                $imageUrls[] = $url;
                $name[] = $categoryavatar->name;
            }
            $imageUrls = array_values($imageUrls);
            $nameArray = array_values($name);
        }
        // $latestCategory = DB::table('categories')->orderBy('id', 'desc')->first();
        // $url = asset('storage/app/public/category/' . $latestCategory->icon);
        // $latestCategory->image = $url;

        return response()->json(['image'=>$imageUrls,'name'=> $nameArray], 200);
    }

    public function categoriesPromo(Request $request){
        if($request->id != null){
            $child = familyRelation::where('id',$request->id)->first();
            if($child != null){
                $child->tag = ($child->gender == 1)?'Boy':'Girl';
                $toparrivalcategorys = DB::table('categories')
                ->where('parent_id', 0)
                ->where('priority', '!=', 0)
                ->where('id', function($query) {
                    $query->select('resource_id')
                        ->from('custom_page')
                        ->where('resource_type', 'category');
                })
                ->orderBy('priority', 'asc')
                ->take(10)
                ->get();
                $imageUrls = [];
                $name = [];
                foreach($toparrivalcategorys as $categoryavatar){
                    $url = asset('storage/app/public/category/' . $categoryavatar->icon);
                    $categoryavatar->image = $url;
                    $imageUrls[] = $url;
                    $name[] = $categoryavatar->name;
                }
                $imageUrls = array_values($imageUrls);
                $nameArray = array_values($name);
            }else{
                return response()->json(['message'=>'Child not found.'], 200);
            }
        }else{
            $toparrivalcategorys = DB::table('categories')
            ->where('parent_id', 0)
            ->where('priority', '!=', 0)
            ->where('id', function($query) {
                $query->select('resource_id')
                      ->from('custom_page')
                      ->where('resource_type', 'category');
            })
            ->orderBy('priority', 'asc')
            ->take(10)
            ->get();
            $imageUrls = [];
            $name = [];
            foreach($toparrivalcategorys as $categoryavatar){
                $url = asset('storage/app/public/category/' . $categoryavatar->icon);
                $categoryavatar->image = $url;
                $imageUrls[] = $url;
                $name[] = $categoryavatar->name;
            }
            $imageUrls = array_values($imageUrls);
            $nameArray = array_values($name);
        }
        // $latestCategory = DB::table('categories')->orderBy('id', 'desc')->first();
        // $url = asset('storage/app/public/category/' . $latestCategory->icon);
        // $latestCategory->image = $url;

        return response()->json(['image'=>$imageUrls,'name'=> $nameArray], 200);
    }


    public function AllCategorys(Request $request){
        if($request->id != null){
            $child = familyRelation::where('id',$request->id)->first();
            if($child != null){
                $child->tag = ($child->gender == 1)?'Boy':'Girl';
                $toparrivalcategorys = DB::table('categories')
                ->where('parent_id', '=', 0)
                ->where('priority', '!=', 0)
                ->orderBy('priority', 'asc')
                ->whereJsonContains('tags', $child->tag)
                ->get();
                $imageUrls = [];
                $name = [];
                foreach($toparrivalcategorys as $categoryavatar){
                    $url = asset('storage/app/public/category/' . $categoryavatar->icon);
                    $categoryavatar->image = $url;
                    $imageUrls[] = $url;
                    $name[] = $categoryavatar->name;
                }
                $imageUrls = array_values($imageUrls);
                $nameArray = array_values($name);
            }else{
                return response()->json(['message'=>'Child not found.'], 200);
            }
        }else{

            $toparrivalcategorys = DB::table('categories')
            ->where('parent_id', '=', 0)
            ->where('priority', '!=', 0)
            ->orderBy('priority', 'asc')
            ->get();
            $imageUrls = [];
            $name = [];
            foreach($toparrivalcategorys as $categoryavatar){
                $url = asset('storage/app/public/category/' . $categoryavatar->icon);
                $categoryavatar->image = $url;
                $imageUrls[] = $url;
                $name[] = $categoryavatar->name;
            }
            $imageUrls = array_values($imageUrls);
            $nameArray = array_values($name);
        }
        // $latestCategory = DB::table('categories')->orderBy('id', 'desc')->first();
        // $url = asset('storage/app/public/category/' . $latestCategory->icon);
        // $latestCategory->image = $url;

        return response()->json(['image'=>$imageUrls,'name'=> $nameArray], 200);
    }

    public function FlashDeals(Request $request){
        if($request->id != null){
            $child = familyRelation::where('id',$request->id)->first();
            if($child != null){
                $child->tag = ($child->gender == 1)?'Boy':'Girl';
                $currentDate = Carbon::now();
                $flashdeals = FlashDeal::with('products')
                ->whereJsonContains('tags', $child->tag)
                ->where(['status' => 1, 'deal_type' => 'flash_deal'])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->get();

                $formattedFlashDeals = [];

                foreach($flashdeals as $flashdeal){
                    $url = asset('storage/app/public/product/thumbnail/' . $flashdeal->banner);
                    $flashdeal->banner = asset('storage/app/public/deal/' . $flashdeal->banner);
            }
            }else{
                return response()->json(['message'=>'Child not found.'], 200);
            }
        }else{
            $currentDate = Carbon::now();
            $flashdeals = FlashDeal::with('products')->where(['status' => 1, 'deal_type' => 'flash_deal'])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->get();

            $formattedFlashDeals = [];

            foreach($flashdeals as $flashdeal){
                $url = asset('storage/app/public/product/thumbnail/' . $flashdeal->banner);
                $flashdeal->banner = asset('storage/app/public/deal/' . $flashdeal->banner);
        }
        }

        return response()->json($flashdeals, 200);
    }

    public function FlashDealProduct(Request $request)
{
    $currentDate = Carbon::now();
    $flashdeals = FlashDeal::with('products.product')->where(['status' => 1, 'id'=>$request->id])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->get();

    foreach($flashdeals as $flashdeal){
        $banners =  Banner::where([
            'resource_type' => 'deals',
            'resource_id' => $flashdeal->id
        ])->get();

        $organizedBanners = [];
        foreach ($banners as $banner) {
            $banner->photo = asset('storage/app/public/banner/' . $banner->photo);
            $banner->mobile_photo = asset('storage/app/public/banner/mobile/' . $banner->mobile_photo);
            $bannerType = $banner->banner_type;
            if (!isset($organizedBanners[$bannerType])) {
                $organizedBanners[$bannerType] = [];
            }
            $organizedBanners[$bannerType][] = $banner;
        }
        $flashdeal['banners'] = $organizedBanners;

        // Apply the custom page logic for deals
        $custom_page = CustomPage::where([
            'resource_type' => 'deals',
            'resource_id' => $flashdeal->id,
            'is_mobile' => 1
        ])->with('page_data')->first();

        $inline_array = [];
        $currentArray = [];
        $sumWidth = 0;

        if ($custom_page != null) {
            if ($custom_page->page_data != null) {
                foreach ($custom_page->page_data as $page) {
                    $imgUrl = asset("storage/app/public/deal/{$flashdeal->name}" . $page->image);
                    $page->image = $imgUrl;
                    $sumWidth += $page->width;

                    if ($sumWidth <= 100) {
                        $currentArray[] = $page;
                    } else {
                        $inline_array[] = $currentArray;
                        $currentArray = [$page];
                        $sumWidth = $page->width;
                    }
                }

                if (!empty($currentArray)) {
                    $inline_array[] = $currentArray;
                }
            }

            $data = $custom_page;
            $data['in_line'] = $inline_array;
        } else {
            $data = $flashdeal;
        }

        return response()->json($data, 200);
    }
}

public function AllBrands(){
    $all_brands = Brand::with('brandProducts')->get();
    foreach($all_brands as $brand){
        $url = asset('storage/app/public/brand/' . $brand->image);
        $brand->image = $url;
        foreach($brand->brandProducts as $product){
            $product->thumbnail = asset('storage/app/public/product/thumbnail/' . $product->thumbnail);
        }
    }
    return response()->json($all_brands, 200);
}

public function BrandDetails($id)
{
    $brand = Brand::where('id', $id)->with('brandProducts')->first();

    if ($brand != null) {
        foreach ($brand->brandProducts as $product) {
            $product->thumbnail = asset('storage/app/public/product/thumbnail/' . $product->thumbnail);
        }
        $url = asset('storage/app/public/brand/' . $brand->image);
        $brand->image = $url;

        $banners = Banner::where([
            'resource_type' => 'brand',
            'resource_id' => $brand->id,
        ])->get();

        $organizedBanners = [];
        foreach ($banners as $banner) {
            $banner->photo = asset('storage/app/public/banner/' . $banner->photo);
            $banner->mobile_photo = asset('storage/app/public/banner/mobile/' . $banner->mobile_photo);
            $bannerType = $banner->banner_type;
            if (!isset($organizedBanners[$bannerType])) {
                $organizedBanners[$bannerType] = [];
            }
            $organizedBanners[$bannerType][] = $banner;
        }
        $brand['banners'] = $organizedBanners;

        $custom_page = CustomPage::where([
            'resource_type' => 'brand',
            'resource_id' => $brand->id,
            'is_mobile' => 1
        ])->with('page_data')->first();

        $inline_array = [];
        $currentArray = [];
        $sumWidth = 0;

        if ($custom_page != null) {
            if ($custom_page->page_data != null) {
                foreach ($custom_page->page_data as $page) {
                    $imgUrl = asset("/public/assets/images/brand/{$brand->name}/" . $page->image);
                    $page->image = $imgUrl;
                    $sumWidth += $page->width;

                    if ($sumWidth <= 100) {
                        $currentArray[] = $page;
                    } else {
                        $inline_array[] = $currentArray;
                        $currentArray = [$page];
                        $sumWidth = $page->width;
                    }
                }

                if (!empty($currentArray)) {
                    $inline_array[] = $currentArray;
                }
            }

            $data = $custom_page;
            $data['in_line'] = $inline_array;
        } else {
            $data = $brand;
        }

        return response()->json($data, 200);
    } else {
        return response()->json(['message' => 'Brand not found.'], 200);
    }
}

public function AllShops(){
    $all_brands = Shop::with('product')->get();
    foreach($all_brands as $brand){
        $url = asset('storage/app/public/shop/' . $brand->image);
        $brand->image = $url;
        foreach($brand->product as $product){
            $url = asset('storage/app/public/product/' . $product->thumbnail_img);
            $product->thumbnail_img = $url;
        }
    }
    return response()->json($all_brands, 200);
}

public function ShopDetails($id)
{
    $shop = Shop::where('id', $id)->with('product')->first();

    if ($shop != null) {
        foreach($shop->product as $product){
            $url = asset('storage/app/public/product/' . $product->thumbnail_img);
            $product->thumbnail_img = $url;
        }
        $url = asset('storage/app/public/shop/' . $shop->image);
        $shop->image = $url;

        $banners = Banner::where([
            'resource_type' => 'shop',
            'resource_id' => $shop->id,
        ])->get();

        $organizedBanners = [];
        foreach ($banners as $banner) {
            $banner->photo = asset('storage/app/public/banner/' . $banner->photo);
            $banner->mobile_photo = asset('storage/app/public/banner/mobile/' . $banner->mobile_photo);
            $bannerType = $banner->banner_type;
            if (!isset($organizedBanners[$bannerType])) {
                $organizedBanners[$bannerType] = [];
            }
            $organizedBanners[$bannerType][] = $banner;
        }
        $shop['banners'] = $organizedBanners;

        $custom_page = CustomPage::where([
            'resource_type' => 'shop',
            'resource_id' => $shop->id,
            'is_mobile' => 1
        ])->with('page_data')->first();

        $inline_array = [];
        $currentArray = [];
        $sumWidth = 0;

        if ($custom_page != null) {
            if ($custom_page->page_data != null) {
                foreach ($custom_page->page_data as $page) {
                    $imgUrl = asset("/public/assets/images/shop/{$shop->name}/" . $page->image);
                    $page->image = $imgUrl;
                    $sumWidth += $page->width;

                    if ($sumWidth <= 100) {
                        $currentArray[] = $page;
                    } else {
                        $inline_array[] = $currentArray;
                        $currentArray = [$page];
                        $sumWidth = $page->width;
                    }
                }

                if (!empty($currentArray)) {
                    $inline_array[] = $currentArray;
                }
            }

            $data = $custom_page;
            $data['in_line'] = $inline_array;
        } else {
            $data = $shop;
        }

        return response()->json($data, 200);
    } else {
        return response()->json(['message' => 'Shop not found.'], 200);
    }
}



    public function AllCategory(){
        $toparrivalcategorys = DB::table('categories')->orderBy('id', 'desc')->get();
        $imageUrls = [];
        foreach($toparrivalcategorys as $categoryavatar){
            $url = asset('storage/app/public/category/' . $categoryavatar->icon);
            $categoryavatar->image = $url;
            $imageUrls[] = $url;
        }
        $imageUrls = array_values($imageUrls);
        return response()->json($imageUrls, 200);
    }

    public function CategoryDetail($id)
{
    $category = Category::where('id', $id)->with(['childes.product', 'product'])->first();

    if ($category != null) {
        $url = asset('storage/app/public/category/' . $category->icon);
        $category->image = $url;
        $banners = Banner::where([
            'resource_type' => 'category',
            'resource_id' => $category->id,
        ])->get();

        foreach ($category->product as $product) {
            $product->thumbnail = asset('storage/app/public/product/thumbnail/' . $product->thumbnail);
        }

        $organizedBanners = [];
        foreach ($banners as $banner) {
            $banner->photo = asset('storage/app/public/banner/' . $banner->photo);
            $banner->mobile_photo = asset('storage/app/public/banner/mobile/' . $banner->mobile_photo);
            $bannerType = $banner->banner_type;
            if (!isset($organizedBanners[$bannerType])) {
                $organizedBanners[$bannerType] = [];
            }
            $organizedBanners[$bannerType][] = $banner;
        }
        $category['banners'] = $organizedBanners;

        $custom_page = CustomPage::where([
            'resource_type' => 'category',
            'resource_id' => $category->id,
            'is_mobile' => 1
        ])->with('page_data')->first();

        $inline_array = [];
        $currentArray = [];
        $sumWidth = 0;

        if ($custom_page != null) {
            if ($custom_page->page_data != null) {
                foreach ($custom_page->page_data as $page) {
                    $imgUrl = asset("storage/app/public/category/{$category->name}" . $page->image);
                    $page->image = $imgUrl;
                    $sumWidth += $page->width;

                    if ($sumWidth <= 100) {
                        $currentArray[] = $page;
                    } else {
                        $inline_array[] = $currentArray;
                        $currentArray = [$page];
                        $sumWidth = $page->width;
                    }
                }

                if (!empty($currentArray)) {
                    $inline_array[] = $currentArray;
                }
            }

            $data = $custom_page;
            $data['in_line'] = $inline_array;
        } else {
            $data = $category;
        }

        return response()->json($data, 200);
    } else {
        return response()->json(['message' => 'Category not found.'], 200);
    }
}


    public function AllArticle(){
        $articles = Article::with('category')->get();
        $imageUrls = [];
        foreach($articles as $article){
            $url = asset('/public/assets/images/articles/thumbnail/' . $article->thumbnail);
            $article->image = $url;
            $imageUrls[] = $url;
        }
        return response()->json($articles, 200);
    }

    public function allCategoryArticle(){
        $allCategorys = ArticleCategory::with('articles')->get();
        if(!$allCategorys->isEmpty()){
            foreach($allCategorys as $category){
                $url = asset('/public/assets/images/articles/category/thumbnail/' . $category->image);
                $category->image = $url;
                foreach($category->articles as $article){
                    $url = asset('/public/assets/images/articles/thumbnail/' . $article->thumbnail);
                    $article->thumbnail = $url;
                }
            }
            return response()->json($allCategorys, 200);
        }
        else {
            return response()->json(['message' => 'No Article Found'], 200);
        }
    }

    public function ArticleByCategory($id){
        $categoryArticle = ArticleCategory::where('id',$id)->with('articles')->first();
        if($categoryArticle){
            $url = asset('/public/assets/images/articles/category/thumbnail/' . $categoryArticle->image);
            $categoryArticle->image = $url;
            foreach($categoryArticle->articles as $article){
                $url = asset('/public/assets/images/articles/thumbnail/' . $article->thumbnail);
                $article->thumbnail = $url;
            }
            return response()->json($categoryArticle, 200);
        }else{
            return response()->json(['message' => 'No Article Category Found'], 200);
        }
    }

    public function ArticleDetail($id){
        $article = Article::where('id',$id)->with('articlecategory')->first();
        if($article){
            $url = asset('/public/assets/images/articles/thumbnail/' . $article->thumbnail);
            $article->thumbnail = $url;
            return response()->json($article, 200);
        }else{
            return response()->json(['message' => 'No Article Found'], 200);
        }
    }



    public function MainBanner(Request $request){
        if($request->id != null){
            $child = familyRelation::where('id',$request->id)->first();
            if($child != null){
                $child->tag = ($child->gender == 1)?'Boy':'Girl';
                $banners = DB::table('banners')
                ->where([
                'published'=> 1,
                'banner_type'=> 'Main Banner'
                ])
                ->whereJsonContains('tags', $child->tag)
                ->get();
                $imageUrls = [];
            foreach($banners as $banner){
                    $url = asset('storage/app/public/banner/' . $banner->photo);
                    $banner->image = $url;
                    $imageUrls[] = $url;
            }
            $imageUrls = array_values($imageUrls);
            }else{
                return response()->json(['message'=>'Child not found.'], 200);
            }
        }else{
            $banners = DB::table('banners')
            ->where([
                'published'=> 1,
                'banner_type'=> 'Main Banner'
                ])->get();
                $imageUrls = [];
            foreach($banners as $banner){
                    $url = asset('storage/app/public/banner/' . $banner->photo);
                    $banner->image = $url;
                    $imageUrls[] = $url;
            }
            $imageUrls = array_values($imageUrls);
        }
        return response()->json($imageUrls, 200);
    }

    public function MainBannerSection(Request $request){
        if($request->id != null){
            $child = familyRelation::where('id',$request->id)->first();
            if($child != null){
                $child->tag = ($child->gender == 1)?'Boy':'Girl';
                $banners = DB::table('banners')
            ->where([
                'published'=> 1,
                'banner_type'=> 'Main Section Banner'
                ])
                ->whereJsonContains('tags', $child->tag)->get();
                $imageUrls = [];
            foreach($banners as $banner){
                    $url = asset('storage/app/public/banner/' . $banner->photo);
                    $banner->image = $url;
                    $imageUrls[] = $url;
            }
            $imageUrls = array_values($imageUrls);
            }else{
                return response()->json(['message'=>'Child not found.'], 200);
            }
        }else{
            $banners = DB::table('banners')
            ->where([
                'published'=> 1,
                'banner_type'=> 'Main Section Banner'
                ])->get();
                $imageUrls = [];
            foreach($banners as $banner){
                    $url = asset('storage/app/public/banner/' . $banner->photo);
                    $banner->image = $url;
                    $imageUrls[] = $url;
            }
            $imageUrls = array_values($imageUrls);
        }
        return response()->json($imageUrls, 200);
    }
    public function FooterBanner(Request $request){
        if($request->id != null){
            $child = familyRelation::where('id',$request->id)->first();
            if($child != null){
                $child->tag = ($child->gender == 1)?'Boy':'Girl';
                $banners = DB::table('banners')
                ->where([
                    'published'=> 1,
                    'banner_type'=> 'Footer Banner'
                ])->whereJsonContains('tags', $child->tag)
                ->get();

            $imageUrls = [];

            foreach($banners as $banner){
                $url = asset('storage/app/public/banner/' . $banner->photo);
                $imageUrls[] = $url;
            }

            $imageUrls = array_values($imageUrls);
            }else{
                return response()->json(['message'=>'Child not found.'], 200);
            }
        }else{
            $banners = DB::table('banners')
                ->where([
                    'published'=> 1,
                    'banner_type'=> 'Footer Banner'
                ])->get();

            $imageUrls = [];

            foreach($banners as $banner){
                $url = asset('storage/app/public/banner/' . $banner->photo);
                $imageUrls[] = $url;
            }

            $imageUrls = array_values($imageUrls);
        }

        return response()->json($imageUrls, 200);
    }

}
