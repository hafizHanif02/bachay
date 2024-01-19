<?php

namespace App\Http\Controllers\Customer\Auth;

use App\User;
use Carbon\Carbon;
use App\CPU\Helpers;
use App\Model\Wishlist;
use App\CPU\CartManager;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\Model\ProductCompare;
use App\Model\BusinessSetting;
use App\Mail\EmailVerification;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\DB;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;
use App\Model\PhoneOrEmailVerification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public $company_name;

    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
    }

    public function captcha(Request $request, $tmp)
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

        if (Session::has($request->captcha_session_id)) {
            Session::forget($request->captcha_session_id);
        }
        Session::put($request->captcha_session_id, $phrase);
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    public function login()
    {
        session()->put('keep_return_url', url()->previous());

        if (theme_root_path() == 'default') {
            return view('customer-view.auth.login');
        } else {
            return redirect()->route('home');
        }
    }
    public function tokenView( Request $request )
    {

        $token = rand(1000, 9999);
        DB::table('phone_or_email_verifications')->insert([
            'phone_or_email' => $request['user_id'],
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $token = PhoneOrEmailVerification::where('phone_or_email',$request['user_id'])->latest()->first();

        $response_flag = 0;
        $errormsg = "";
            $emailServices_smtp = Helpers::get_business_settings('mail_config');
            if ($emailServices_smtp['status'] == 0) {
                $emailServices_smtp = Helpers::get_business_settings('mail_config_sendgrid');
            }
            if ($emailServices_smtp['status'] == 1) {
                Mail::to($request->user_id)->send(new EmailVerification($token->token));
                $response_flag = 1;
            }

        session()->put('keep_return_url', url()->previous());

        if (theme_root_path() == 'default') {
            return view('customer-view.auth.code', compact('request'));
        } else {
            return redirect()->route('home');
        }
    }

    public function submit(Request $request)
    {
        // dd($request->all());
        $tokenDb = PhoneOrEmailVerification::where(['token'=> $request->token,'otp_hit_count'=>0])->latest()->first();
        if($tokenDb != null){
            $user = User::where(['phone' => $tokenDb->phone_or_email])->orWhere(['email' => $tokenDb->phone_or_email])->first();
            $request->user_id = $user->email;    
            $user = User::where(['phone' => $request->user_id])->orWhere(['email' => $request->user_id])->first();
            $remember = ($request['remember']) ? true : false;
    
            //login attempt check start
            $max_login_hit = Helpers::get_business_settings('maximum_login_hit') ?? 5;
            $temp_block_time = Helpers::get_business_settings('temporary_login_block_time') ?? 5; //seconds
            if (isset($user) == false) {
                if ($request->ajax()) {
                    // dd('invalid1');
                    return response()->json([
                        'status' => 'error',
                        'message' => translate('credentials_do_not_match_or_account_has_been_suspended'),
                        'redirect_url' => ''
                    ]);
                } else {
                    // dd('invalid2');
                    Toastr::error(translate('credentials_do_not_match_or_account_has_been_suspended'));
                    return back()->withInput();
                }
            }
            //login attempt check end
    
            //phone or email verification check start
            $phone_verification = Helpers::get_business_settings('phone_verification');
            $email_verification = Helpers::get_business_settings('email_verification');
            if ($phone_verification && !$user->is_phone_verified) {
                if ($request->ajax()) {
                    // dd('invalid3');
                    return response()->json([
                        'status' => 'error',
                        'message' => translate('account_phone_not_verified'),
                        'redirect_url' => route('customer.auth.check', [$user->id]),
                    ]);
                } else {
                    // dd('invalid4');
                    return redirect(route('customer.auth.check', [$user->id]));
                }
            }
            if ($email_verification && !$user->is_email_verified) {
                if ($request->ajax()) {
                    // dd('invalid5');
                    return response()->json([
                        'status' => 'error',
                        'message' => translate('account_email_not_verified'),
                        'redirect_url' => route('customer.auth.check', [$user->id]),
                    ]);
                } else {
                    // dd('invalid6');
                    return redirect(route('customer.auth.check', [$user->id]));
                }
            }
            //phone or email verification check end
    
            if (isset($user->temp_block_time) && Carbon::parse($user->temp_block_time)->DiffInSeconds() <= $temp_block_time) {
                // dd('invalid7');
                $time = $temp_block_time - Carbon::parse($user->temp_block_time)->DiffInSeconds();
    
                if ($request->ajax()) {
                    // dd('invalid8');
                    return response()->json([
                        'status' => 'error',
                        'message' => translate('please_try_again_after_') . CarbonInterval::seconds($time)->cascade()->forHumans(),
                        'redirect_url' => ''
                    ]);
                } else {
                    // dd('invalid9');
                    Toastr::error(translate('please_try_again_after_') . CarbonInterval::seconds($time)->cascade()->forHumans());
                    return back()->withInput();
                }
            }
            if (isset($user) && $user->is_active && auth('customer')->attempt(['email' => $user->email, 'password' => $request->password], $remember)) {
                // dd('invalid10');
                $tokenDb->update([
                    'otp_hit_count' => 1
                ]);
                $wish_list = Wishlist::whereHas('wishlistProduct', function ($q) {
                    return $q;
                })->where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray();
    
                $compare_list = ProductCompare::where('user_id', auth('customer')->id())->pluck('product_id')->toArray();
    
                session()->put('wish_list', $wish_list);
                session()->put('compare_list', $compare_list);
                Toastr::info(translate('welcome_to') . ' ' . Helpers::get_business_settings('company_name') . '!');
                // CartManager::cart_to_db();
    
                $user->login_hit_count = 0;
                $user->is_temp_blocked = 0;
                $user->temp_block_time = null;
                $user->updated_at = now();
                $user->save();
    
                $redirect_url = "";
                $previous_url = url()->previous();
    
                if (
                    strpos($previous_url, 'checkout-complete') !== false ||
                    strpos($previous_url, 'offline-payment-checkout-complete') !== false ||
                    strpos($previous_url, 'track-order') !== false
                ) {
                    // dd('invalid11');
                    $redirect_url = route('home');
                }
    
                if ($request->ajax()) {
                    // dd('invalid12');
                    return response()->json([
                        'status' => 'success',
                        'message' => translate('login_successful'),
                        'redirect_url' => $redirect_url,
                    ]);
                } else {
                    // dd('invalid13');
                    return redirect(session('keep_return_url'));
                }
            } else {
                // dd('invalid14');
    
                //login attempt check start
                if (isset($user->temp_block_time) && Carbon::parse($user->temp_block_time)->diffInSeconds() <= $temp_block_time) {
                    // dd('invalid15');
                    $time = $temp_block_time - Carbon::parse($user->temp_block_time)->diffInSeconds();
    
                    $ajax_message = [
                        'status' => 'error',
                        'message' => translate('please_try_again_after_') . CarbonInterval::seconds($time)->cascade()->forHumans(),
                        'redirect_url' => ''
                    ];
                    Toastr::error(translate('please_try_again_after_') . CarbonInterval::seconds($time)->cascade()->forHumans());
                } elseif ($user->is_temp_blocked == 1 && Carbon::parse($user->temp_block_time)->diffInSeconds() >= $temp_block_time) {
                    // dd('invalid16');
                    $user->login_hit_count = 0;
                    $user->is_temp_blocked = 0;
                    $user->temp_block_time = null;
                    $user->updated_at = now();
                    $user->save();
    
                    $ajax_message = [
                        'status' => 'error',
                        'message' => translate('credentials_do_not_match_or_account_has_been_suspended'),
                        'redirect_url' => ''
                    ];
                    Toastr::error(translate('credentials_do_not_match_or_account_has_been_suspended'));
                } elseif ($user->login_hit_count >= $max_login_hit &&  $user->is_temp_blocked == 0) {
                    // dd('invalid17');
                    $user->is_temp_blocked = 1;
                    $user->temp_block_time = now();
                    $user->updated_at = now();
                    $user->save();
    
                    $time = $temp_block_time - Carbon::parse($user->temp_block_time)->diffInSeconds();
    
                    $ajax_message = [
                        'status' => 'error',
                        'message' => translate('too_many_attempts._please_try_again_after_') . CarbonInterval::seconds($time)->cascade()->forHumans(),
                        'redirect_url' => ''
                    ];
                    Toastr::error(translate('too_many_attempts._please_try_again_after_') . CarbonInterval::seconds($time)->cascade()->forHumans());
                } else {
                    // dd('invalid18');
                    $ajax_message = [
                        'status' => 'error',
                        'message' => translate('credentials_do_not_match_or_account_has_been_suspended'),
                        'redirect_url' => ''
                    ];
                    Toastr::error(translate('credentials_do_not_match_or_account_has_been_suspended'));
    
                    $user->login_hit_count += 1;
                    $user->save();
                }
                //login attempt check end
    
                if ($request->ajax()) {
                    // dd('invalid19');
                    return response()->json($ajax_message);
                } else {
                    // dd('invalid20');
                    return back()->withInput();
                }
            }
        }else{
            // dd('invalid21');
           Toastr::error(translate('please_enter_valid_token'));
            return redirect()->back();
        }
        
    }

    public function logout(Request $request)
    {
        auth()->guard('customer')->logout();
        session()->forget('wish_list');
        Toastr::info(translate('come_back_soon') . '!');
        return redirect()->route('home');
    }

    public function get_login_modal_data(Request $request)
    {
        return response()->json([
            'login_modal' => view(VIEW_FILE_NAMES['get_login_modal_data'])->render(),
            'register_modal' => view(VIEW_FILE_NAMES['get_register_modal_data'])->render(),
        ]);
    }
}
