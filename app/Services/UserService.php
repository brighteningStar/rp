<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService extends ServiceAbstract
{

    public function model()
    {
        return User::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        $query = $this->model->select('users.id as id', 'users.name as name', 'users.email as email', 'roles.id as role_id', 'roles.name as role')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id');

        if ( $keyword != '' ) {
            $query = $query->whereRaw( "users.name like ?", "%$keyword%" )
                ->orWhereRaw("users.email like ?", "%$keyword%")
                ->orWhereRaw("roles.name like ?", "%$keyword%");
        }

        return [
            'columns' => $columns,
            'items'   => $query->paginate(10)
        ];
    }

    public function create(Array $data){
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('12345678'),
        ]);
        $role = Role::find($data['role_id']);
        $user->assignRole($role->name);
    }


    public function find($id, $columns = array('*'))
    {
        $user = $this->model->select('users.id as id', 'users.name as name', 'users.email as email', 'roles.id as role_id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id',$id)
            ->first();
        return $user;
    }

    public function update(Request $request, array $where)
    {
        $user = $this->model->where($where)->first();
        $user->update($request->all());
        $role = Role::find($request->get('role_id'));
        $oldRole = $user->getRoleNames()->first();
        $user->removeRole($oldRole);
        $user->assignRole($role->name);
    }

    public function updateProfile(Request $request, array $where){
        $user = $this->model->where($where)->first();
        $user->update($request->all());
        return $user;
    }


}