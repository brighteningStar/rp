<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Resources\RolesResource;

class RolesController extends Controller
{

    const EXCLUDE_ROLES = ['super_admin'];

    public function get()
    {
        $allRoles = Role::whereNotIn('name', self::EXCLUDE_ROLES)->get();

        return RolesResource::collection($allRoles);
    }
}
