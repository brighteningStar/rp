<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\Capacity;

class CapacityService extends ServiceAbstract
{

    public function model()
    {
        return Capacity::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        if ( $keyword != '' ) {
            $items = $this->model->whereRaw( "capacities.name like ?", "%$keyword%" );
        }
        else {
            $items = $this->model;
        }

        return [
            'columns' => $columns,
            'items'   => $items->paginate(10)
        ];
    }


}