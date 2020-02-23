<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributesController extends Controller
{
    public function search( Request $request )
    {
        $table = $request->get( 'table' );

        $keyword    = $request->get( 'q', null );
        $attributes = DB::table( $table )->select( 'name', 'id' )->whereRaw( "name like ?", "%$keyword%" )->get();

        $array = [];
        foreach ( $attributes as $attribute ) {
            $array[] = [
                'id'    => $attribute->id,
                'label' => $attribute->name,
            ];
        }
        return [ 'items' => $array ];
    }

}
