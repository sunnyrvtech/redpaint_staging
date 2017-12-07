<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\User;
use Redirect;
use Yajra\Datatables\Facades\Datatables;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $title = 'Users';
        if ($request->ajax()) {
            $users = User::get();
            foreach ($users as $key => $value) {
                $users[$key]['action'] = '<a href="' . route('users.show', $value->id) . '" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>';
                if ($value->status == 1) {
                    $users[$key]['status'] = '<div class="btn-group status-toggle" data-id="' . $value->id . '" data-url="' . route('users-status') . '"><button class="btn active btn-primary" data-value="1">Active</button><button class="btn btn-default" data-value="0">Deactive</button></div>';
                } else {
                    $users[$key]['status'] = '<div class="btn-group status-toggle" data-id="' . $value->id . '" data-url="' . route('users-status') . '"><button class="btn btn-default" data-value="1">Active</button><button class="btn active btn-primary" data-value="0">Deactive</button></div>';
                }
            }
            return Datatables::of($users)->make(true);
        }
        return View::make('admin.users.index', compact('title'));
    }

    /**
     * create a new file
     *
     * @return Response
     */
    public function create() {
        $title = 'Users | create';
        return View::make('admin.users.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'required',
        ]);
        $data['status'] = 1;
        $data['password'] = bcrypt($data['password']);

        User::create($data);
        return redirect()->route('users.index')
                        ->with('success-message', 'User created successfully!');
    }

    /**
     * show function.
     *
     * @return Response
     */
    public function show(Request $request, $id) {
        $title = 'Users | update';
        $users = User::where('id', $id)->first();
        return View::make('admin.users.edit', compact('title', 'users'));
    }

//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
    public function update(Request $request, $id) {
        $title = 'Customers | update';
        $data = $request->all();
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ]);
        $users = User::findOrFail($id);
        $users->fill($data)->save();

        return redirect()->route('users.index')
                        ->with('success-message', 'User updated successfully!');
    }

    /**
     * function to update category status
     *
     * @param  int  $id
     * @return Response
     */
    public function userStatus(Request $request) {
        $id = $request->get('id');
        $status = $request->get('status');

        $user = User::find($id);

        if (!$user) {
            return response()->json(array('error' => 'Something went wrong.Please try again later!'), 401);
        } else {
            $user->fill(array('status' => $status))->save();
            if ($status == 1) {
                return response()->json(['success' => true, 'messages' => "User activated successfully!"]);
            }
            return response()->json(['success' => true, 'messages' => "User deactivated successfully!"]);
        }
    }

//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function destroy($id) {
//        
//    }
}
