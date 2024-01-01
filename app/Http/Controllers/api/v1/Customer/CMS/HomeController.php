<?php

namespace App\Http\Controllers\Api\V1\Customer\CMS;

use App\Model\Category;
use App\Models\Article;
use Illuminate\Http\Request;
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

    public function NewArrtival(){
        $toparrivalcategorys = DB::table('categories')
        ->where('parent_id', '=', 0)
        ->where('priority', '!=', 0)
        ->orderBy('priority', 'dsc')
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
        // $latestCategory = DB::table('categories')->orderBy('id', 'desc')->first();
        // $url = asset('storage/app/public/category/' . $latestCategory->icon);
        // $latestCategory->image = $url;

        return response()->json(['image'=>$imageUrls,'name'=> $nameArray], 200);
    }

    public function FlashDeals(){
        $flashdeals = FlashDealProduct::with('product')->get();
        $formattedFlashDeals = [];
    
        foreach($flashdeals as $flashdeal){
            $url = asset('storage/app/public/product/thumbnail/' . $flashdeal->product->thumbnail);
    
            $formattedFlashDeal = [
                'id' => $flashdeal->product->id,
                'name' => $flashdeal->product->name,
                'image' => $url,
                'discount' => $flashdeal->discount,
            ];
    
            $formattedFlashDeals[] = $formattedFlashDeal;
        }
    
        return response()->json($formattedFlashDeals, 200);
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

   

    public function MainBanner(){
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
        return response()->json($imageUrls, 200);
    }

    public function MainBannerSection(){
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
        return response()->json($imageUrls, 200);
    }
    public function FooterBanner(){
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
    
        return response()->json($imageUrls, 200);
    }
    
}
