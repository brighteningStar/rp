<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    protected $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;

    }

    public function index()
    {
        if(Auth::user()->can('view_all_users')){
            return view('users.index');
        }
        else {
            return redirect(route('home'));
        }

    }


    public function store(Request $request)
    {
        if(Auth::user()->can('create_new_user') && $request->ajax()){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'role_id' => 'required'
            ]);
            $this->service->create($request->all());
        }
        else {
            abort(403, 'Unauthorized action.');
        }

    }


    public function show($id)
    {
        if(Auth::user()->hasRole('super_admin') || Auth::id()==$id){
            return $this->service->find($id);
        }
        else {
            abort(403, 'Unauthorized action.');
        }

    }


    public function update(Request $request, $id)
    {

        if(Auth::user()->can('edit_user') && $request->ajax()){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'role_id' => 'required'
            ]);
            $where = array('id'=>$id);
            $this->service->update($request, $where);
        }
        else {
            abort(403, 'Unauthorized action.');
        }

    }


    public function destroy($id)
    {
        $this->service->destroy($id);
    }


    public function get()
    {
        if(Auth::user()->can('view_all_users') && request()->ajax()){
            return $this->service->getAll(['id', 'name', 'email', 'role']);
        }
        else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function profile(){
        return view('auth.profile');
    }

    public function updateProfile(Request $request, $id){
        if(Auth::user()->hasRole('super_admin') || Auth::id()==$id){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
            ]);
            $where = array('id'=>$id);
            return $this->service->updateProfile($request, $where);
        }
        else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function updatePassword(Request $request, $id){

        if(Auth::id()==$id){
            $request->validate([
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
                'curr_password' => ['required'],
            ]);
            $user = Auth::user();
            if (Hash::check($request->get('curr_password'), $user->password)) {
                $user->password = Hash::make($request->get('new_password'));
                $user->save();
            } else {
                $errors =  [
                  'errors' => [
                      'curr_password' => array(
                          'Current Password is not correct'
                      )
                  ]
                ];
                return response()->json($errors, 422);

            }
        }
        else {
            abort(403, 'Unauthorized action.');
        }
    }

}
