<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;

    }

    public function index()
    {
        return view('users.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required'
        ]);
        $this->service->create($request->all());
    }


    public function show($id)
    {
        return $this->service->find($id);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role_id' => 'required'
        ]);
        $where = array('id'=>$id);
        $this->service->update($request, $where);
    }


    public function destroy($id)
    {
        //
    }


    public function get()
    {
        return $this->service->getAll(['id', 'name', 'email', 'role']);
    }

}
