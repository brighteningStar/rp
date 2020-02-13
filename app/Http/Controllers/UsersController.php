<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    /**
     * Show the application dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        $columns = [ 'name', 'email' ];
        $users   = User::all();

        return [
            'columns' => $columns,
            'items'   => $users
        ];
    }


    public function edit( $id )
    {
        return User::find($id);
    }
}
