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
    public function index( Request $request )
    {
        $columns = [ 'name', 'email' ];

        $keyword = $request->get( 'q', null );

        if ( $keyword != '' ) {
            $users = User::whereRaw( "users.name like ?", "%$keyword%" )
                         ->paginate(3);

            return [
                'columns' => $columns,
                'items'   => $users
            ];
        }

        $users = User::paginate(3);

        return [
            'columns' => $columns,
            'items'   => $users
        ];
    }


    public function edit( $id )
    {
        return User::find( $id );
    }
}
