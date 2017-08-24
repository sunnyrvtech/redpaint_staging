<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Redirect;
use View;

class AccountController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request, $id = null) {
        if (Auth::check()) {
            $users = User::where('id', Auth::id())->first();
            return View::make('accounts.account', compact('users'));
        }
        return redirect('/login');
    }

    // To activate user by the code provided in the link via email
    public function getActivate($code) {

        $user = User::where('verify_token', '=', $code)->where('status', '=', 0);

        if ($user->count()) {
            // To get user info
            $user = $user->first();
            //Update user to activate state
            //has to be 1 for user to log in
            $user->status = 1;
            $user->verify_token = null;
            if ($user->save()) {
                Auth::login($user);
                return Redirect::to('/my-account')->with('success-message', 'Your account has been activated and successfully logged in!');
            } else {
                return Redirect::to('/')
                                ->with('error-message', 'We could not activate your account, please try again later.');
            }
        }
        if (!Auth::check()) {
            return Redirect::to('/')
                            ->with('success-message', 'Your account is already activated! You may now sign in!');
        } else {
            return Redirect::to('/my-account')->with('success-message', 'Your account has been activated and successfully logged in!');
        }
    }

}
