<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\SalesHead;

class SalesService extends ServiceAbstract
{

    public function model()
    {
        return SalesHead::class;
    }

    public function getAll($columns = null)
    {
//        $columns = is_null($columns)?$this->model->getFillable():$columns;
//        $keyword = request()->get( 'q', null );
//
//        if ( $keyword != '' ) {
//            $regions = $this->model->whereRaw( "regions.name like ?", "%$keyword%" );
//        }
//        else {
//            $regions = $this->model;
//        }
//
//        return [
//            'columns' => $columns,
//            'items'   => $regions->paginate(10)
//        ];
    }


}