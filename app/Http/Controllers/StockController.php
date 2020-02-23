<?php

namespace App\Http\Controllers;


use App\Exceptions\AttributeNotFound;
use App\Models\Region;
use App\Models\ShippingBilling;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Excel;

class StockController extends Controller
{

    public function index()
    {
        return view( 'stock.index' );
    }


    public function processExcel( Request $request )
    {
        $fileName    = $request->file( 'file' )->getClientOriginalName();
        $fileContent = file_get_contents( $request->file( 'file' )->getRealPath() );

        Storage::disk( 'local' )->put( $fileName, $fileContent );

        $storage_path = storage_path( "app" );

        $path = $storage_path . "/$fileName";

        $processedData = [];

        Excel::load( $path, function ( $reader ) use ( &$processedData ) {

            $results = $reader->all();

            DB::transaction( function () use ( $results, &$processedData ) {
                foreach ( $results as $result ) {

                    $region = $this->getAttribute( Region::class, trim( $result['region'] ) );
                    if ( ! is_array( $region ) ) {
                        throw new AttributeNotFound( 'Region with name ' . trim( $result['region'] ) . ' not found', 404 );
                    }

                    $supplier = $this->getAttribute( Supplier::class, trim( $result['supplier'] ) );
                    if ( ! is_array( $supplier ) ) {
                        throw new AttributeNotFound( 'Supplier with name ' . trim( $result['supplier'] ) . ' not found', 404 );
                    }

                    $shippingBilling = $this->getAttribute( ShippingBilling::class, trim( $result['bill_to'] ) );
                    if ( ! is_array( $shippingBilling ) ) {
                        throw new AttributeNotFound( 'Shipping and Billing with name ' . trim( $result['bill_to'] ) . ' not found', 404 );
                    }

                    $serialNo                           = preg_replace( '/^\p{Z}+|\p{Z}+$/u', '', $result['serial_no'] );
                    $processedData['heading']           = [
                        'so_date'        => trim( $result['so_date']->format( 'Y-m-d' ) ),
                        'so_number'      => trim( $result['so_number'] ),
                        'invoice_date'   => trim( $result['inv_date']->format( 'Y-m-d' ) ),
                        'invoice_no'     => trim( $result['inv_no'] ),
                        'declaration_no' => trim( $result['declaration_no'] ),
                        'tracking_no'    => trim( $result['tracking_no'] ),
                        'region'         => $region,
                        'bill_to'        => $shippingBilling,
                        'ship_to'        => $shippingBilling,
                        'supplier'       => $supplier,
                    ];
                    $processedData['detail'][$serialNo] = [
                        'sys_id'           => '',
                        'imei'             => '',
                        'serial_no'        => $serialNo,
                        'make'             => trim( $result['make'] ),
                        'model'            => trim( $result['model'] ),
                        'capacity'         => trim( $result['capacity'] ),
                        'color'            => trim( $result['color'] ),
                        'grade'            => trim( $result['grade'] ),
                        'stock_id'         => trim( $result['stock_id'] ),
                        'quantity_per_inv' => trim( $result['quantity_per_inv'] ),
                        'part_no'          => trim( $result['part_no'] ),
                        'price_usd'        => trim( $result['price_usd'] ),
                        'price_aed'        => trim( $result['price_aed'] ),
                        'custom_duty'      => trim( $result['custom_duty'] ),
                        'freight'          => trim( $result['freight'] ),
                        'total_cost'       => trim( $result['total_cost'] ),
                        'bank_deal_no'     => trim( $result['bank_deal_no'] ),
                    ];
                }
            } );
        } );

        Storage::disk( 'local' )->delete( $fileName );
        return $processedData;
    }


    public function store( Request $request )
    {
        return $request->all();
    }


    private function getAttribute( $attributeObj, $name )
    {
        $attribute = ( new $attributeObj() )->where( 'name', $name )->first();

        if ( $attribute ) {
            return [ 'label' => $attribute->name, 'id' => $attribute->id ];
        }

        return $attribute;
    }
}
