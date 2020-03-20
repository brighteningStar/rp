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

    public function __construct(StockService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('stock.index');
    }


    public function processExcel(Request $request)
    {
        $request->validate(
            [
                'file' => 'required',
            ],
            [
                'file.required' => 'File is required',
            ]
        );
        $fileName    = $request->file('file')->getClientOriginalName();
        $fileContent = file_get_contents($request->file('file')->getRealPath());

        Storage::disk('local')->put($fileName, $fileContent);

        $storage_path = storage_path("app");

        $path = $storage_path . "/$fileName";

        $processedData = [];

        Excel::load($path, function ($reader) use (&$processedData) {

            $results = $reader->all();

            DB::transaction(function () use ($results, &$processedData) {
                $quantity = 0;
                foreach ($results as $result) {

                    if (empty($result['make'])) {
                        continue;
                    }

                    $maker     = $this->service->maker(trim($result['make']));
                    $makeModel = $this->service->makeModel(trim($result['model']));
                    $color     = $this->service->color(trim($result['color']));
                    $grade     = $this->service->grade(trim($result['grade']));
                    $capacity  = $this->service->capacity(trim($result['capacity']));
                    $bankDeal  = $this->service->bankDeal(trim($result['bank_deal_no']));

                    $serialNo                           = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $result['serial_no']);
                    $processedData['heading']           = $this->service->builtHeadSection($result, $quantity);
                    $processedData['detail'][$serialNo] = [
                        'sys_id'       => trim($result['sys_id']),
                        'imei'         => trim($result['imei_no']),
                        'serial_no'    => $serialNo,
                        'make'         => $maker,
                        'model'        => $makeModel,
                        'capacity'     => $capacity,
                        'color'        => $color,
                        'grade'        => $grade,
                        'invoice_no'   => trim($result['inv_no']),
                        'stock_id'     => trim($result['stock_id']),
                        'part_no'      => trim($result['part_no']),
                        'price_usd'    => number_format($result['price_usd'], 2),
                        'price_aed'    => trim($result['price_aed']),
                        'total_cost'   => trim($result['total_cost']),
                        'bank_deal_no' => $bankDeal['bank_deal'],
                    ];
                }
            });
        });

        Storage::disk('local')->delete($fileName);
        return $processedData;
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'detail.*.invoice_no'     => 'required',
                'detail.*.sys_id'         => 'required|integer|unique:stock_details',
                'detail.*.total_cost'     => 'required',
                'detail.*.bank_deal_no'   => 'required',
                'detail.*.imei'           => 'required|unique:stock_details,imei_no',
                'detail.*.price_aed'      => 'required',
                'heading.freight'         => 'required',
                'heading.custom_duty'     => 'required',
                'local_imported.selected' => 'required',
            ],
            [
                'detail.*.invoice_no.required'     => 'Invoice Number is required',
                'detail.*.bank_deal_no.required'   => 'Bank Deal Number is required',
                'detail.*.imei.required'           => 'IMEI is required',
                'detail.*.imei.unique'             => 'IMEI should be unique',
                'detail.*.sys_id.integer'          => 'SYS id should be a number',
                'detail.*.sys_id.required'         => 'SYS id field is required',
                'detail.*.sys_id.unique'           => 'SYS id should be unique',
                'detail.*.price_aed.required'      => 'AED Price is required',
                'heading.freight.required'         => 'Freight is required',
                'heading.custom_duty.required'     => 'custom Duty is required',
                'local_imported.selected.required' => 'Local Imported field is required',
            ]
        );

        $headPart      = $request->get('heading');
        $details       = $request->get('detail');
        $localImported = $request->get('local_imported');
        $stockHead     = [
            'quantity_invoice'   => $headPart['quantity_per_inv'],
            'declaration_number' => $headPart['declaration_no'],
            'tracking_number'    => $headPart['tracking_no'],
            'invoice_date'       => $headPart['invoice_date'],
            'so_number'          => $headPart['so_number'],
            'so_date'            => $headPart['so_date'],
            'bill_to'            => $headPart['bill_to']['id'],
            'ship_to'            => $headPart['ship_to']['id'],
            'supplier_id'        => $headPart['supplier']['id'],
            'region_id'          => $headPart['region']['id'],
            'custom_duty'        => $headPart['custom_duty'],
            'freight'            => $headPart['freight'],
        ];


        DB::transaction(function () use ($details, $localImported, $stockHead) {

            $stockHeadID = StockHead::create($stockHead);

            foreach ($details as $serialNo => $detail) {
                StockHeadDetail::create([
                    'invoice_number'   => $detail['invoice_no'],
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
                    'total_cost'       => $detail['total_cost'],
                    'stock_status'     => 'in_stock',
                    'local_imported'   => $localImported['selected']['id'],
                ]);
            }
        });

        return ['created'];
    }


    public function getStock()
    {
        $dataQuery = StockHead::selectRaw('id as `id`, tracking_number as `Tracking Number`, so_number as `SO Number`, DATE_FORMAT(so_Date, "%Y-%m-%d") as `SO Date`, declaration_number as `Declaration Number`, quantity_invoice as `Quantity`');


        return [
            'columns' => ['Tracking Number', 'SO Number', 'SO Date', 'Declaration Number', 'Quantity', 'id'],
            'items'   => $dataQuery->paginate(10)
        ];
    }


    public function edit($stockID)
    {
        return view('stock.edit')->with('id', $stockID);
    }


    public function fetchStock($stockID)
    {
        $dataQuery = StockHead::with(['details'])
            ->where('stock_heads.id', $stockID)
            ->first();
        $stock = [];

        $stock['heading'] = [
            'so_date'          => $dataQuery->so_date,
            'so_number'        => $dataQuery->so_number,
            'invoice_date'     => $dataQuery->invoice_date,
            'declaration_no'   => $dataQuery->declaration_number,
            'tracking_no'      => $dataQuery->tracking_number,
            'region'           => ['label' => $dataQuery->region->name, 'id' => $dataQuery->region->id],
            'bill_to'          => ['label' => $dataQuery->billTo->name, 'id' => $dataQuery->billTo->id],
            'ship_to'          => ['label' => $dataQuery->shipTo->name, 'id' => $dataQuery->shipTo->id],
            'supplier'         => ['label' => $dataQuery->supplier->name, 'id' => $dataQuery->supplier->id],
            'quantity_per_inv' => $dataQuery->quantity_invoice,
            'custom_duty'      => $dataQuery->custom_duty,
            'freight'          => $dataQuery->freight,
        ];
        
        foreach ($dataQuery->details as $detail) {
            $stock['local_imported']             = [ 'title' => ucfirst( $detail->local_imported), 'id' => $detail->local_imported];
            $stock['detail'][$detail->serial_no] = [
                'invoice_no'   => $detail->invoice_number,
                'sys_id'       => $detail->sys_id,
                'imei'         => $detail->imei_no,
                'serial_no'    => $detail->serial_no,
                'make'         => ['label' => $detail->make->name, 'id' => $detail->make->id],
                'model'        => ['label' => $detail->model->name, 'id' => $detail->model->id],
                'capacity'     => ['label' => $detail->capacity->name, 'id' => $detail->capacity->id],
                'color'        => ['label' => $detail->color->name, 'id' => $detail->color->id],
                'grade'        => ['label' => $detail->grade->name, 'id' => $detail->grade->id],
                'stock_id'     => $detail->stock_number,
                'part_no'      => $detail->part_description,
                'price_usd'    => $detail->price_usd,
                'price_aed'    => $detail->price_aed,
                'total_cost'   => $detail->total_cost,
                'bank_deal_no' => ['label' => $detail->bankDeal->deal_number, 'id' => $detail->bankDeal->id],
            ];
        }

        return $stock;
    }


    public function update( Request $request, $stockID )
    {
        $request->validate(
            [
                'detail.*.invoice_no'     => 'required',
                'detail.*.sys_id'         => 'required|integer|unique:stock_details,stock_head_id,'.$stockID,
                'detail.*.total_cost'     => 'required',
                'detail.*.bank_deal_no'   => 'required',
                'detail.*.imei'           => 'required|unique:stock_details,stock_head_id,'.$stockID,
                'detail.*.price_aed'      => 'required',
                'heading.freight'         => 'required',
                'heading.custom_duty'     => 'required',
                'local_imported.selected' => 'required',
            ],
            [
                'detail.*.invoice_no.required'     => 'Invoice Number is required',
                'detail.*.bank_deal_no.required'   => 'Bank Deal Number is required',
                'detail.*.imei.required'           => 'IMEI is required',
                'detail.*.imei.unique'             => 'IMEI should be unique',
                'detail.*.sys_id.integer'          => 'SYS id should be a number',
                'detail.*.sys_id.required'         => 'SYS id field is required',
                'detail.*.sys_id.unique'           => 'SYS id should be unique',
                'detail.*.price_aed.required'      => 'AED Price is required',
                'heading.freight.required'         => 'Freight is required',
                'heading.custom_duty.required'     => 'custom Duty is required',
                'local_imported.selected.required' => 'Local Imported field is required',
            ]
        );

        $headPart      = $request->get('heading');
        $details       = $request->get('detail');
        $localImported = $request->get('local_imported');
        $stockHead     = [
            'quantity_invoice'   => $headPart['quantity_per_inv'],
            'declaration_number' => $headPart['declaration_no'],
            'tracking_number'    => $headPart['tracking_no'],
            'invoice_date'       => $headPart['invoice_date'],
            'so_number'          => $headPart['so_number'],
            'so_date'            => $headPart['so_date'],
            'bill_to'            => $headPart['bill_to']['id'],
            'ship_to'            => $headPart['ship_to']['id'],
            'supplier_id'        => $headPart['supplier']['id'],
            'region_id'          => $headPart['region']['id'],
            'custom_duty'        => $headPart['custom_duty'],
            'freight'            => $headPart['freight'],
        ];


        DB::transaction(function () use ($details, $localImported, $stockHead, $stockID) {

            StockHead::where('id', $stockID)->update($stockHead);

            foreach ($details as $serialNo => $detail) {
                StockHeadDetail::where('stock_head_id', $stockID)->where('serial_no', $serialNo)->update([
                    'invoice_number'   => $detail['invoice_no'],
                    'sys_id'           => $detail['sys_id'],
                    'imei_no'          => $detail['imei'],
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
                    'total_cost'       => $detail['total_cost'],
                    'stock_status'     => 'in_stock',
                    'local_imported'   => $localImported['selected']['id'],
                ]);
            }
        });
    }
}
