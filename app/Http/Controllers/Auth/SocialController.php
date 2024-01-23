<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
        public function redirectToProvider($provider)
        {
            return Socialite::driver($provider)->redirect();
        }

        public function handleProviderCallback($provider)
        {
            $user = Socialite::driver($provider)->user();

            // Implement your logic to handle the authenticated user

            return redirect()->route('home'); // Redirect to home or another page after authentication
        }

}
