<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;

use App\Models\MakeModel;

class MakeModelService extends ServiceAbstract
{

    public function model()
    {
        return MakeModel::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        if ( $keyword != '' ) {
            $makeModels = $this->model->whereRaw( "make_models.name like ?", "%$keyword%" );
        }
        else {
            $makeModels = $this->model;
        }

        return [
            'columns' => $columns,
            'items'   => $makeModels->paginate(10)
        ];
    }


}