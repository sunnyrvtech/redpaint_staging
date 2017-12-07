<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Country;
use App\Payment;
use Auth;
use Redirect;
use View;
use Hash;

class AccountController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {

        if (Auth::check()) {
            $users = User::where('id', Auth::id())->first();
            $countries = Country::get();
            return View::make('accounts.profile', compact('users', 'countries'));
        }
        return redirect('/login');
    }

    /**
     * Update profile function.
     *
     * @return Response
     */
    public function updateProfile(Request $request) {
        $data = $request->all();

        $this->validate($request, [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'address' => 'required|max:200',
            'city' => 'required|max:50',
            'state' => 'required|max:50',
            'zip' => 'required|max:6',
            'country_id' => 'required',
        ]);



        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $type = $image->getClientMimeType();
            if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = base_path('public/user_images/');
                @unlink($path . Auth::user()->user_image);
                $image->move($path, $filename);
                $data['user_image'] = $filename;
            }
        }

        $users = User::findOrFail(Auth::id());
        $users->fill($data)->save();
        return Redirect::back()
                        ->with('success-message', 'Profile updated successfully!');
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
                return Redirect::to('/')->with('success-message', 'Your account has been activated and successfully logged in!');
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

    /**
     * Change password function.
     *
     * @return Response
     */
    public function changePassword(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, array(
                    'current_password' => 'required',
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|same:password'
                        )
        );

        $errors = $validator->errors();
        if (!empty($errors->messages())) {
            return response()->json($errors, 401);
        }


        //grab user with find method
        $user = User::find(Auth::id());

        $old_password = $data['current_password'];
        $password = $data['password'];

        //check if old password supplied matches their current password
        if (Hash::check($old_password, $user->getAuthPassword())) {
            //get users password field in db = new password
            $user->password = bcrypt($password);

            if ($user->save()) {
                return response()->json(['success' => true, 'messages' => "Your password has been changed."]);
            }
        } else {
            return response()->json(array('error' => 'The current password is invalid. Please enter correct current password!'), 401);
        }
        return response()->json(array('error' => 'Your password could not be changed.Please try again later!'), 401);
    }
    
    /**
     * get order history function.
     *
     * @return Response
     */
    
    public function getPaymentHistory(Request $request){
        $history = Payment::Where('user_id',Auth::id())->paginate(15);
        return View::make('payments.index',compact('history'));
    }

    /**
     * function to render profile html.
     *
     * @return Response
     */
    public function renderProfile(Request $request) {
        return View::make('profile.profile');
    }

}
