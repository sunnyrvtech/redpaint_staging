<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\PasswordBroker;
use View;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /**
     * Render forgot password view.
     *
     * @return void
     */
    public function index(Request $request) {
        $view = View::make('auth.forgot');
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

    public function getEmail(Request $request, PasswordBroker $passwords) {
        if ($request->wantsJson()) {
            $this->validate($request, ['email' => 'required|email']);

            $response = $passwords->sendResetLink($request->only('email'));

            switch ($response) {
                case PasswordBroker::RESET_LINK_SENT:
                    return response()->json(['success' => true, 'messages' => "A password link has been sent to your email address!"]);
                case PasswordBroker::INVALID_USER:
                    return response()->json(array('error' => "We can't find a user with that email address!"), 401);
            }
        }
    }
}
