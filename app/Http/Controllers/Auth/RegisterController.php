<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Mail;
use View;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $view = View::make('auth.register');
//        if ($request->wantsJson()) {
//            $sections = $view->renderSections();
//            return $sections['content'];
//        }
        return $view;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
        ]);

        $errors = $validator->errors();
        if (!empty($errors->messages())) {
            return response()->json($errors, 401);
        }
        $code = str_random(10) . time();

        if ($data['type'] == 'business') {
            $role_id = 2;
        } else {
            $role_id = 3;
        }

        User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'role_id' => $role_id,
            'password' => bcrypt($data['password']),
            'verify_token' => $code,
        ]);

        Mail::send('auth.emails.activated', array('link' => route('account.activate', $code), 'username' => $data['first_name'] . ' ' . $data['last_name']), function($message) use ($data) {
            $message->to($data['email'], $data['first_name'])->subject('Welcome to Redpaint!');
        });
        Mail::send('auth.emails.admin_notify.account', array('first_name' => $data['first_name'], 'last_name' => $data['last_name'], 'email' => $data['email']), function($message) {
            $message->to('sunny_kumar@rvtechnologies.com')->subject('New account has been created');
        });
        return response()->json(['success' => true, 'messages' => "Your account has been created! We have sent you an email to activate your account."]);
    }

}
