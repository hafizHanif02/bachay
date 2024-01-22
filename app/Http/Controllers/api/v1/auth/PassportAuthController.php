<?php

namespace App\Http\Controllers\api\v1\auth;

use Carbon\Carbon;
use App\CPU\Helpers;
use App\Models\User;
use App\CPU\CartManager;
use Carbon\CarbonInterval;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use function App\CPU\translate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Model\PhoneOrEmailVerification;
use Illuminate\Support\Facades\Validator;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName();
            $picture = $request->avatar->move(public_path('assets/images/customers'), $filename);
        }else{
            $filename = null;
        }

        $validator = Validator::make($request->all(), [
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:8',
        ], [
            'f_name.required' => 'The first name field is required.',
            'l_name.required' => 'The last name field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        if ($request->referral_code){
            $refer_user = User::where(['referral_code' => $request->referral_code])->first();
        }

        $temporary_token = Str::random(40);
        $user = User::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $filename,
            'is_active' => 1,
            'password' => bcrypt($request->password),
            'temporary_token' => $temporary_token,
            'referral_code' => Helpers::generate_referer_code(),
            'referred_by' => isset($refer_user->id) ?? null,
        ]);

        $phone_verification = Helpers::get_business_settings('phone_verification');
        $email_verification = Helpers::get_business_settings('email_verification');
        if ($phone_verification && !$user->is_phone_verified) {
            return response()->json(['temporary_token' => $temporary_token], 200);
        }
        if ($email_verification && !$user->is_email_verified) {
            return response()->json(['temporary_token' => $temporary_token], 200);
        }

        $token = $user->createToken('LaravelAuthApp')->accessToken;
        return response()->json(['token' => $token], 200);
    }

    public function code(Request $request){
        $token = rand(1000, 9999);
        DB::table('phone_or_email_verifications')->insert([
            'phone_or_email' => $request['email'],
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $phone = User::where('email', $request['email'])->orWhere('phone', $request['email'])->pluck('phone')->first();
        $token = PhoneOrEmailVerification::where('phone_or_email',$request['email'])->latest()->first();
        $response_flag = 0;
        $errormsg = "";
            $emailServices_smtp = Helpers::get_business_settings('mail_config');
            if ($emailServices_smtp['status'] == 0) {
                $emailServices_smtp = Helpers::get_business_settings('mail_config_sendgrid');
            }
            if ($emailServices_smtp['status'] == 1) {
                Mail::to($request->email)->send(new EmailVerification($token->token));
                $response_flag = 1;
            }


            $curl = curl_init();
            $url = 'https://graph.facebook.com/v18.0/235106213008560/messages';
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization:Bearer EAAFTwPfvu6IBOxon9H1g7FDwrP30To11IHXYTOPQFTRZCshZCDC5dyfwYCzXZB9UamL8meP8rzbMyOgFFvmPPBnbxMcLs8qf49pqipkXGonoMxxuEUAmxrGy91vO86JpsnZAZBELefAoDQJHjD0oZAkG6k8SuelUK6viLUQAIbOl694ZAJf0xd2vR8PHonnKs9PMCDZCPr82K4Kh5rU8', 'Content-Type: application/json'));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $data = array(
                    "messaging_product" => "whatsapp",
                    "recipient_type" => "individual",
                    "to" => $phone,
                    "type" => "template",
                    "template" => array(
                        "name" => "bachay_otp",
                        "language" => array(
                            "code" => "en"
                        ),
                        "components" => array(
                            array(
                                "type" => "body",
                                "parameters" => array(
                                    array(
                                        "type" => "text",
                                        "text" => $token->token
                                    )
                                )
                            ),
                            array(
                                "type" => "button",
                                "sub_type" => "url",
                                "index" => "0",
                                "parameters" => array(
                                    array(
                                        "type" => "text",
                                        "text" => $token->token
                                    )
                                )
                            )
                        )
                    )
                );

                $fields_string = json_encode($data);
                //echo $fields_string;
                //echo $fields_string;
                //echo "<br/>";
                curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
                $resp = curl_exec($curl);
                curl_close($curl);
                //return $resp;

        session()->put('keep_return_url', url()->previous());
        return response()->json(['message' => 'Check Your Mail or Whatsapp for OTP'], 200);

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $tokenDb = PhoneOrEmailVerification::where(['token'=> $request->code,'otp_hit_count'=>0])->latest()->first();
        if($tokenDb != null){
            $request['email'] = $tokenDb->phone_or_email;
            $user_id = $request['email'];
            if (filter_var($user_id, FILTER_VALIDATE_EMAIL)) {
                $medium = 'email';
            } else {
                $count = strlen(preg_replace("/[^\d]/", "", $user_id));
                if ($count >= 9 && $count <= 15) {
                    $medium = 'phone';
                } else {
                    $errors = [];
                    array_push($errors, ['code' => 'email', 'message' => 'Invalid email address or phone number']);
                    return response()->json([
                        'errors' => $errors
                    ], 403);
                }
            }

            $data = [
                $medium => $user_id,
                'password' => $request->password
            ];

            $user = User::where([$medium => $user_id])->first();

            $max_login_hit = Helpers::get_business_settings('maximum_login_hit') ?? 5;
            $temp_block_time = Helpers::get_business_settings('temporary_login_block_time') ?? 5; //minute
            if (isset($user)) {
                $user->temporary_token = Str::random(40);
                $user->save();

                $phone_verification = Helpers::get_business_settings('phone_verification');
                $email_verification = Helpers::get_business_settings('email_verification');
                if ($phone_verification && !$user->is_phone_verified) {
                    return response()->json(['temporary_token' => $user->temporary_token], 200);
                }
                if ($email_verification && !$user->is_email_verified) {
                    return response()->json(['temporary_token' => $user->temporary_token], 200);
                }

                if(isset($user->temp_block_time ) && Carbon::parse($user->temp_block_time)->diffInSeconds() <= $temp_block_time){
                    $time = $temp_block_time - Carbon::parse($user->temp_block_time)->diffInSeconds();

                    $errors = [];
                    array_push($errors, ['code' => 'auth-001', 'message' => translate('please_try_again_after_') . CarbonInterval::seconds($time)->cascade()->forHumans()]);
                    return response()->json([
                        'errors' => $errors
                    ], 401);
                }

                if($user->is_active && auth()->attempt($data)){
                    $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;

                    $user->login_hit_count = 0;
                    $user->is_temp_blocked = 0;
                    $user->temp_block_time = null;
                    $user->updated_at = now();
                    $user->save();

                    CartManager::cart_to_db($request);

                    return response()->json(['token' => $token], 200);
                }else{
                    // return 'Invalid6';
                    //login attempt check start
                    if(isset($user->temp_block_time ) && Carbon::parse($user->temp_block_time)->diffInSeconds() <= $temp_block_time){
                        // return 'Invalid7';
                        $time= $temp_block_time - Carbon::parse($user->temp_block_time)->diffInSeconds();

                        $errors = [];
                        array_push($errors, ['code' => 'auth-001', 'message' => translate('please_try_again_after_') . CarbonInterval::seconds($time)->cascade()->forHumans()]);
                        return response()->json([
                            'errors' => $errors
                        ], 401);

                    }elseif($user->is_temp_blocked == 1 && Carbon::parse($user->temp_block_time)->diffInSeconds() >= $temp_block_time){
                        // return 'Invalid8';
                        $user->login_hit_count = 0;
                        $user->is_temp_blocked = 0;
                        $user->temp_block_time = null;
                        $user->updated_at = now();
                        $user->save();

                        $errors = [];
                        array_push($errors, ['code' => 'auth-001', 'message' => translate('credentials_do_not_match_or_account_has_been_suspended')]);
                        return response()->json([
                            'errors' => $errors
                        ], 401);

                    }elseif($user->login_hit_count >= $max_login_hit &&  $user->is_temp_blocked == 0){
                        // return 'Invalid9';
                        $user->is_temp_blocked = 1;
                        $user->temp_block_time = now();
                        $user->updated_at = now();
                        $user->save();

                        $time= $temp_block_time - Carbon::parse($user->temp_block_time)->diffInSeconds();

                        $errors = [];
                        array_push($errors, ['code' => 'auth-001', 'message' => translate('too_many_attempts. please_try_again_after_'). CarbonInterval::seconds($time)->cascade()->forHumans()]);
                        return response()->json([
                            'errors' => $errors
                        ], 401);

                    }else{
                        // return 'Invalid10';
                        $user->login_hit_count += 1;
                        $user->save();

                        $errors = [];
                        array_push($errors, ['code' => 'auth-001', 'message' => translate('credentials_do_not_match_or_account_has_been_suspended')]);
                        return response()->json([
                            'errors' => $errors
                        ], 401);
                    }
                    //login attempt check end
                }
            } else {
                // return 'Invalid11';
                $errors = [];
                array_push($errors, ['code' => 'auth-001', 'message' => translate('Customer_not_found_or_Account_has_been_suspended')]);
                return response()->json([
                    'errors' => $errors
                ], 401);
            }
        }else{
            // return 'Invalid12';
            return response()->json([
                'errors' => ['message' => 'Please enter correct code']
            ], 401);
        }


    }

    public function logout(Request $request)
    {
        if(auth()->check()) {
            auth()->user()->token()->revoke();
            return response()->json(['message' => 'Logged out successfully'], 200);
        }
        return response()->json(['message'=>'Logged out fail'], 403);
    }

}
