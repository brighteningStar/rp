<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavigationController extends Controller
{
    protected $routes;

    public function __construct()
    {
        $this->routes = array(
            'dashboard' => array(
                'route' => route('home'),
                'permission' => 'view_dashboard',
                'title' => 'Dashboard',
                'icon' => 'fas fa-th',
                'children' => null,
            ),
            'users' => array(
                'route' => null,
                'permission' => null,
                'title' => 'Users',
                'icon' => 'fas fa-users',
                'children' => array(
                    'view_users' => array(
                        'route' => route('users.index'),
                        'permission' => 'view_all_users',
                        'title' => 'View Users',
                        'icon' => 'far fa-circle',
                        'children' => null,
                    ),
                    'create_user' => array(
                        'route' => route('users.create'),
                        'permission' => 'create_new_user',
                        'title' => 'Create New User',
                        'icon' => 'far fa-circle',
                        'children' => null,
                    )
                ),

            )
        );
    }

    public function index(){
        $children = $this->checkForChildren($this->routes);
        return json_encode($children);
    }

    private function checkForChildren($children){
        foreach ($children as $key=>$myRoute){
            if(is_null($myRoute['children'])){
                $res = $this->hasPermission($myRoute);
                if(!$res){
                    unset($children[$key]);
                }
            } else {
                $myRoute['children'] = $this->checkForChildren($myRoute['children']);
                $children[$key]['children'] = empty($myRoute['children'])?null:array_values($myRoute['children']);
            }
        }
        return $children;
    }

    private function hasPermission($myRoute){
        $user = auth()->user();
        if($user->can($myRoute['permission'])){
            return true;
        }
        return false;
    }
}
