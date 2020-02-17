<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\FaultType;

class FaultTypeService extends ServiceAbstract
{

    public function model()
    {
        return FaultType::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        if ( $keyword != '' ) {
            $faults = $this->model->whereRaw( "fault_types.name like ?", "%$keyword%" );
        }
        else {
            $faults = $this->model;
        }

        return [
            'columns' => $columns,
            'items'   => $faults->paginate(10)
        ];
    }


}