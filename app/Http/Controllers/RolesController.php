<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function get()
    {
        $columns = ['id','name'];
        return [
            'columns' => $columns,
            'items'   => Role::all()
        ];
    }
}
