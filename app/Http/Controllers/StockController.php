<?php

namespace App\Http\Controllers;


use App\Models\StockHead;
use App\Models\StockHeadDetail;
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
        $request->validate( [
            'file' => 'required',
        ],
            [
                'file.required' => 'File is required',
            ] );
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

                    if ( empty( $result['make'] ) ) {
                        continue;
                    }

                    $maker     = $this->service->maker( trim( $result['make'] ) );
                    $makeModel = $this->service->makeModel( trim( $result['model'] ) );
                    $color     = $this->service->color( trim( $result['color'] ) );
                    $grade     = $this->service->grade( trim( $result['grade'] ) );
                    $capacity  = $this->service->capacity( trim( $result['capacity'] ) );
                    $bankDeal  = $this->service->bankDeal( trim( $result['bank_deal_no'] ) );

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
                        'price_usd'    => number_format( ( $result['price_aed'] * $bankDeal['exchange_rate'] ), 2 ),
                        'price_aed'    => trim( $result['price_aed'] ),
                        'custom_duty'  => trim( $result['custom_duty'] ),
                        'freight'      => trim( $result['freight'] ),
                        'total_cost'   => number_format( $result['price_aed'] + $result['freight'] + $result['custom_duty'], 2, '.', '' ),
                        'bank_deal_no' => $bankDeal['bank_deal'],
                    ];
                }
            } );
        } );

        Storage::disk( 'local' )->delete( $fileName );
        return $processedData;
    }


    public function store( Request $request )
    {
        $request->validate( [
            'detail.*.sys_id'         => 'required|integer|unique:stock_details',
            'detail.*.custom_duty'    => 'required',
            'detail.*.total_cost'     => 'required',
            'detail.*.bank_deal_no'   => 'required',
            'detail.*.imei'           => 'required|unique:stock_details,imei_no',
            'detail.*.price_aed'      => 'required',
            'detail.*.freight'        => 'required',
            'local_imported.selected' => 'required',
        ],
            [
                'detail.*.bank_deal_no.required' => 'Bank Deal Number is required',
                'detail.*.custom_duty.required'  => 'Custom Duty is required',
                'detail.*.imei.required'         => 'IMEI is required',
                'detail.*.imei.unique'           => 'IMEI should be unique',
                'detail.*.sys_id.integer'        => 'SYS id should be a number',
                'detail.*.sys_id.required'       => 'SYS id field is required',
                'detail.*.sys_id.unique'         => 'SYS id should be unique',
                'detail.*.price_aed.required'    => 'AED Price is required',
                'detail.*.freight.required'      => 'Freight is required',
                'local_imported.selected.required'        => 'Local Imported field is required',
            ] );

        $headPart      = $request->get( 'heading' );
        $details       = $request->get( 'detail' );
        $localImported = $request->get( 'local_imported' );
        $stockHead     = [
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


        DB::transaction( function () use ( $details, $localImported, $stockHead ) {

            $stockHeadID = StockHead::create( $stockHead );

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
                    'bank_deal_id'     => $detail['bank_deal_no']['id'],
                    'stock_number'     => $detail['stock_id'],
                    'part_description' => $detail['part_no'],
                    'price_usd'        => $detail['price_usd'],
                    'price_aed'        => $detail['price_aed'],
                    'custom_duty'      => $detail['custom_duty'],
                    'freight'          => $detail['freight'],
                    'total_cost'       => $detail['total_cost'],
                    'stock_status'     => 'in_stock',
                    'local_imported'   => $localImported['selected']['id'],
                    'fault_type'       => 1,
                ] );
            }
        } );

        return [ 'created' ];
    }


    public function getStock()
    {
        $dataQuery = StockHead::selectRaw( 'invoice_number as `Invoice Number`, tracking_number as `Tracking Number`, imei_no as `IMEI Number`, serial_no as `Serial Number`, price_aed as `Price AED`, price_usd as `Price USD`, round(total_cost, 2) as `Total Cost`' )
                              ->join( 'stock_details', 'stock_details.stock_head_id', '=', 'stock_heads.id' );

        return [
            'columns' => [ 'Invoice Number', 'Tracking Number', 'IMEI Number', 'Serial Number', 'Price AED', 'Price USD', 'Total Cost' ],
            'items'   => $dataQuery->paginate( 4 )
        ];

    }
}
