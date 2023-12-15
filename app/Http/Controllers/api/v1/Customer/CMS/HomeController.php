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

    public function NewArrtival(){
        $toparrivalcategorys = DB::table('categories')->orderBy('id', 'desc')->take(10)->get();
        foreach($toparrivalcategorys as $categoryavatar){
            $url = asset('storage/app/public/banner/' . $categoryavatar->icon);
            $categoryavatar->image = $url;
        }
        $latestCategory = DB::table('categories')->orderBy('id', 'desc')->first();
        $url = asset('storage/app/public/banner/' . $latestCategory->icon);
        $latestCategory->image = $url;
        return response()->json(['new-arrival' => $toparrivalcategorys,'latest' => $latestCategory], 200);
    }

    public function MainBanner(){
        $banner = DB::table('banners')->where('status', 1)->orderBy('id', 'desc')->get();
        return response()->json($banners, 200);
    }
}
