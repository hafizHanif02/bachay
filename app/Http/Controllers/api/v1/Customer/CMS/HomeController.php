<?php

namespace App\Http\Controllers\Api\V1\Customer\CMS;

use Illuminate\Http\Request;
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
        $toparrivalcategorys = DB::table('categories')->orderBy('id', 'desc')->take(10)->get();
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
