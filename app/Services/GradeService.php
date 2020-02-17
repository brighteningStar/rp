<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\Grade;

class GradeService extends ServiceAbstract
{

    public function model()
    {
        return Grade::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        if ( $keyword != '' ) {
            $grades = $this->model->whereRaw( "grades.name like ?", "%$keyword%" );
        }
        else {
            $grades = $this->model;
        }

        return [
            'columns' => $columns,
            'items'   => $grades->paginate(10)
        ];
    }


}