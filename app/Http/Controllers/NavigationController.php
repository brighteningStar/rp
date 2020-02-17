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
                'route' => '#',
                'permission' => 'view_all_users',
                'title' => 'Users',
                'icon' => 'fas fa-users',
                'children' => null,
            ),
            'forms' => array(
                'route' => null,
                'permission' => null,
                'title' => 'Forms',
                'icon' => 'far fa-file',
                'children' => array(
                    'view_colors' => array(
                        'route' => route('colors.index'),
                        'permission' => 'view_all_colors',
                        'title' => 'Colors',
                        'icon' => 'far fa-circle',
                        'children' => null,
                    ),
                    'view_capacity' => array(
                        'route' => route('capacities.index'),
                        'permission' => 'view_all_capacity',
                        'title' => 'Capacity',
                        'icon' => 'far fa-circle',
                        'children' => null,
                    ),
                    'view_make' => array(
                        'route' => route('makes.index'),
                        'permission' => 'view_all_make',
                        'title' => 'Make',
                        'icon' => 'far fa-circle',
                        'children' => null,
                    ),
                    'view_models' => array(
                        'route' => route('make-models.index'),
                        'permission' => 'view_all_models',
                        'title' => 'Models',
                        'icon' => 'far fa-circle',
                        'children' => null,
                    ),
                    'view_grade' => array(
                        'route' => route('grades.index'),
                        'permission' => 'view_all_grades',
                        'title' => 'Grades',
                        'icon' => 'far fa-circle',
                        'children' => null,
                    ),
                    'view_fault_type' => array(
                        'route' => route('fault-types.index'),
                        'permission' => 'view_all_fault_types',
                        'title' => 'Fault Types',
                        'icon' => 'far fa-circle',
                        'children' => null,
                    ),
                    'view_customers' => array(
                        'route' => route('customers.index'),
                        'permission' => 'view_all_customers',
                        'title' => 'Customers',
                        'icon' => 'far fa-circle',
                        'children' => null,
                    ),
                    'view_suppliers' => array(
                        'route' => route('suppliers.index'),
                        'permission' => 'view_all_suppliers',
                        'title' => 'Suppliers',
                        'icon' => 'far fa-circle',
                        'children' => null,
                    ),
                    'view_regions' => array(
                        'route' => route('regions.index'),
                        'permission' => 'view_all_regions',
                        'title' => 'Regions',
                        'icon' => 'far fa-circle',
                        'children' => null,
                    ),
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
