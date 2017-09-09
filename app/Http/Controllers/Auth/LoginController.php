<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Auth;
use Session;
use View;
use URL;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
        Session::put('backUrl', route('account-profile'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $view = View::make('auth.login');
        //if ($request->wantsJson()) {
        //  $sections = $view->renderSections();
        // return $sections['content'];
        //}
        return $view;
    }

    /**
     * Authenticate user function.
     *
     * @return Response
     */
    protected function authenticated($request, $user) {

        if ($request->wantsJson()) {
            if (Auth::check() && Auth::user()->status == 0 && !empty(Auth::user()->verify_token)) {
                Auth::logout();
                return response()->json(['error' => "Your account is not activated yet! Please check activation email in your inbox and activate your account."], 401);
            } else if (Auth::check() && Auth::user()->status == 0) {
                Auth::logout();
                return response()->json(['error' => "Your account is deactivated by admin! Please contact with administrator."], 401);
            }
            return response()->json(['intended' => Session::get('backUrl')]);
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request) {
        if ($request->wantsJson()) {
            return response()->json([
                        'error' => Lang::get('auth.failed')
                            ], 401);
        }

        return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors([
                            $this->username() => Lang::get('auth.failed'),
        ]);
    }

    protected function sendLockoutResponse(Request $request) {
        $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
        );
        if ($request->wantsJson()) {
            return response()->json([
                        'error' => $message
                            ], 401);
        }

        return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors([$this->username() => $message]);
    }

}
