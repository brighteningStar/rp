<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\Make;

class MakeService extends ServiceAbstract
{

    public function model()
    {
        return Make::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        if ( $keyword != '' ) {
            $make = $this->model->whereRaw( "make.name like ?", "%$keyword%" );
        }
        else {
            $make = $this->model;
        }

        return [
            'columns' => $columns,
            'items'   => $make->paginate(10)
        ];
    }


}