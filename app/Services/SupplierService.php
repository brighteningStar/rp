<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\Supplier;

class SupplierService extends ServiceAbstract
{

    public function model()
    {
        return Supplier::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        if ( $keyword != '' ) {
            $suppliers = $this->model->whereRaw( "suppliers.name like ?", "%$keyword%" )
                ->orWhereRaw("suppliers.email like ?", "%$keyword%")
                ->orWhereRaw("suppliers.phone like ?", "%$keyword%")
                ->orWhereRaw("suppliers.address like ?", "%$keyword%");
        }
        else {
            $suppliers = $this->model;
        }

        return [
            'columns' => $columns,
            'items'   => $suppliers->paginate(10)
        ];
    }


}