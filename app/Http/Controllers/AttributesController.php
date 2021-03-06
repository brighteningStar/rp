<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributesController extends Controller
{
    public function search( Request $request )
    {
        $table = $request->get( 'table' );

        if ( $table === 'bill_to' || $table === 'ship_to' ) {
            $table = 'shipping_billings';
        }

        $keyword = $request->get( 'q', null );

        if ( $table === 'bank_deals' ) {
            return $this->bankDeal( $table, $keyword );
        }

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


    private function bankDeal( $table, $keyword )
    {
        $attributes = DB::table( $table )->select( 'deal_number', 'id' )->whereRaw( "deal_number like ?", "%$keyword%" )->get();

        $array = [];
        foreach ( $attributes as $attribute ) {
            $array[] = [
                'id'    => $attribute->id,
                'label' => $attribute->deal_number,
            ];
        }
        return [ 'items' => $array ];
    }

}
