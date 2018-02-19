<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;
use Auth;
use DB;
use Carbon\Carbon;
use Redirect;
use Session;

class SocialAuthController extends Controller {

    public function redirect($provider) {

        $previous_url = explode("/", parse_url(url()->previous(), PHP_URL_PATH));

        if (isset($previous_url[4]) && $previous_url[4] == 'business') {
            Session::put('login_type', 2);
        } else {
            Session::put('login_type', 3);
        }
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider) {
        $role_type = Session::get('login_type');
        Session::forget('login_type');
        // when facebook call us a with token
        $providerUser = Socialite::driver($provider)->user();
        if (strpos($providerUser->name, ' ') > 0) {
            $user_name = explode(' ', $providerUser->name);
        } else {
            $user_name[0] = $providerUser->name;   // twitter not contain whitespace in the name
            $user_name[1] = '';
        }
        $users = User::where('social_id', '=', $providerUser->id)->orWhere('email', '=', $providerUser->email)->first();

        if (empty($users)) {
            $code = str_random(10) . time();
            $users = new User;
            $users->social_id = $providerUser->id;
            $users->first_name = $user_name[0];
            $users->last_name = $user_name[1];
            $users->email = $providerUser->email;
            $users->role_id = $role_type;
            $users->status = 1;
            //$users->remember_token = $providerUser->token;
            $users->save();

            $users->user_image = $this->saveSocialImage(file_get_contents($providerUser->avatar_original), $users->id);
            $users->save();
            // insert user record in social log table

            DB::table('social_logs')->insert([
                'user_id' => $users->id,
                'social_id' => $providerUser->id,
                'social_type' => $provider,
            ]);
            Auth::login($users);
            return Redirect::to('/')->with('success-message', 'login successfully !');
        } else {
            // check user social type
            $user_social_log = DB::table('social_logs')->where('user_id', '=', $users->id)->where('social_type', '=', $provider)->first();
            if (empty($user_social_log)) {
                // insert user record in social log table

                DB::table('social_logs')->insert([
                    'user_id' => $users->id,
                    'social_id' => $providerUser->id,
                    'social_type' => $provider,
                ]);
            }
            $users->role_id = $role_type;
            //$users->remember_token = $providerUser->token;
            $users->user_image = $this->saveSocialImage(file_get_contents($providerUser->avatar_original), $users->id);
            $users->save();
            Auth::login($users);
            return Redirect::to('/');
        }
    }

    public function saveSocialImage($image_url, $id) {
        $image_name = $id . ".png";
        $path = base_path('public/user_images/');
        $image_check = base_path() . "/public/user_images/" . $image_name;
        if (file_exists($image_check)) {
            unlink($image_check);
        }
        if (file_put_contents($path . $image_name, $image_url)) {
            return $image_name;
        } else {
            return null;
        }
    }

}
