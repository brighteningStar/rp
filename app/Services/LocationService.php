<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;

use App\Models\Location;

class LocationService extends ServiceAbstract
{

    public function model()
    {
        return Location::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );
        $locations = $this->model;
        if ( $keyword != '' ) {
            $locations = $locations->whereRaw( "locations.name like ?", "%$keyword%" );
        }

        return [
            'columns' => $columns,
            'items'   => $locations->paginate(10)
        ];
    }


}