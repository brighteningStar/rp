<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\Customer;

class CustomerService extends ServiceAbstract
{

    public function model()
    {
        return Customer::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        if ( $keyword != '' ) {
            $customers = $this->model->whereRaw( "customers.name like ?", "%$keyword%" )
                        ->orWhereRaw("customers.email like ?", "%$keyword%")
                        ->orWhereRaw("customers.phone like ?", "%$keyword%")
                        ->orWhereRaw("customers.address like ?", "%$keyword%");
        }
        else {
            $customers = $this->model;
        }

        return [
            'columns' => $columns,
            'items'   => $customers->paginate(10)
        ];
    }


}