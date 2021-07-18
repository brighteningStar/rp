<?php

namespace App\Http\Controllers;

use App\Resources\RolesResource;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    const EXCLUDE_ROLES = ['super_admin'];

    public function get()
    {
        $allRoles = Role::whereNotIn('guard_name', self::EXCLUDE_ROLES)->get();

        return RolesResource::collection($allRoles);
    }
}
