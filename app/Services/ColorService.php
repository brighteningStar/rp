<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;

use App\Models\Color;

class ColorService extends ServiceAbstract
{

    public function model()
    {
        return Color::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        if ( $keyword != '' ) {
            $colors = $this->model->whereRaw( "colors.name like ?", "%$keyword%" );
        }
        else {
            $colors = $this->model;
        }

        return [
            'columns' => $columns,
            'items'   => $colors->paginate(10)
        ];
    }


}