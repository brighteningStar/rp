<?php

namespace App\Http\Controllers;


use App\Exceptions\AttributeNotFound;
use App\Models\Color;
use App\Models\Grade;
use App\Models\Make;
use App\Models\MakeModel;
use App\Models\Region;
use App\Models\ShippingBilling;
use App\Models\StockHead;
use App\Models\StockHeadDetail;
use App\Models\Supplier;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Excel;

class StockController extends Controller
{
    protected $service;

    public function __construct( StockService $service )
    {
        $this->service = $service;
    }

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
                $quantity = 0;
                foreach ( $results as $result ) {

                    $maker        = $this->service->maker( trim( $result['make'] ) );
                    $makeModel    = $this->service->makeModel( trim( $result['model'] ) );
                    $color        = $this->service->color( trim( $result['color'] ) );
                    $grade        = $this->service->grade( trim( $result['grade'] ) );
                    $capacity     = $this->service->capacity( trim( $result['capacity'] ) );
                    $exchangeRate = $this->service->bankDealExchangeRate( trim( $result['bank_deal_no'] ) );

                    $serialNo                           = preg_replace( '/^\p{Z}+|\p{Z}+$/u', '', $result['serial_no'] );
                    $processedData['heading']           = $this->service->builtHeadSection( $result, $quantity );
                    $processedData['detail'][$serialNo] = [
                        'sys_id'       => '',
                        'imei'         => '',
                        'serial_no'    => $serialNo,
                        'make'         => $maker,
                        'model'        => $makeModel,
                        'capacity'     => $capacity,
                        'color'        => $color,
                        'grade'        => $grade,
                        'stock_id'     => trim( $result['stock_id'] ),
                        'part_no'      => trim( $result['part_no'] ),
                        'price_usd'    => number_format( ( $result['price_aed'] * $exchangeRate ), 2 ),
                        'price_aed'    => trim( $result['price_aed'] ),
                        'custom_duty'  => trim( $result['custom_duty'] ),
                        'freight'      => trim( $result['freight'] ),
                        'total_cost'   => trim( $result['total_cost'] ),
                        'bank_deal_no' => trim( $result['bank_deal_no'] ),
                    ];
                }
            } );
        } );

        Storage::disk( 'local' )->delete( $fileName );
        return $processedData;
    }


    public function store( Request $request )
    {
        $headPart  = $request->get( 'heading' );
        $details   = $request->get( 'detail' );
        $stockHead = [
            'quantity_invoice'   => $headPart['quantity_per_inv'],
            'invoice_number'     => $headPart['invoice_no'],
            'declaration_number' => $headPart['declaration_no'],
            'tracking_number'    => $headPart['tracking_no'],
            'invoice_date'       => $headPart['invoice_date'],
            'so_number'          => $headPart['so_number'],
            'so_date'            => $headPart['so_date'],
            'bill_to'            => $headPart['bill_to']['id'],
            'ship_to'            => $headPart['ship_to']['id'],
            'supplier_id'        => $headPart['supplier']['id'],
            'region_id'          => $headPart['region']['id'],
        ];

        $stockHeadID = StockHead::create( $stockHead );
        $detailPart  = [];
        foreach ( $details as $serialNo => $detail ) {
            StockHeadDetail::create( [
                'stock_head_id'    => $stockHeadID->id,
                'sys_id'           => $detail['sys_id'],
                'imei_no'          => $detail['imei'],
                'serial_no'        => $detail['serial_no'],
                'make_id'          => $detail['make']['id'],
                'model_id'         => $detail['model']['id'],
                'capacity_id'      => $detail['capacity']['id'],
                'color_id'         => $detail['color']['id'],
                'grade_id'         => $detail['grade']['id'],
                'bank_deal_id'     => 1,
                'stock_number'     => $detail['stock_id'],
                'part_description' => $detail['part_no'],
                'price_usd'        => $detail['price_usd'],
                'price_aed'        => $detail['price_aed'],
                'custom_duty'      => $detail['custom_duty'],
                'freight'          => $detail['freight'],
                'total_cost'       => $detail['total_cost'],
                'stock_status'     => 'in_stock',
                'local_imported'   => 'local',
            ] );
        }

        return $stockHeadID;
    }
}
