<?php

namespace App\Http\Controllers;

use App\Models\StockHead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ReportController extends Controller
{

    private const DATA_KEY_ARRAY = [
        'tracking_number'    => 'tracking_number as `Tracking Number`',
        'so_number'          => 'so_number as `So Number`',
        'so_date'            => 'DATE_FORMAT(so_date, "%Y-%m-%d") as `So Date`',
        'supplier_id'        => 'suppliers.name as `Supplier`',
        'declaration_number' => 'declaration_number as `Declaration Number`',
        'bill_to'            => 'bill.name as `Bill To`',
        'ship_to'            => 'ship.name as `Ship To`',
        'make_id'            => 'make.name as `Maker`',
        'model_id'           => 'make_models.name as `Model`',
        'capacity_id'        => 'capacities.name as `Capacity`',
        'color_id'           => 'colors.name as `Color`',
        'grade_id'           => 'grades.name as `Grade`',
        'price_aed'          => 'price_aed as `Price (AED)`',
        'price_usd'          => 'price_usd as `Price (USD)`',
        'total_cost'         => 'total_cost as `Total Cost`',
        'local_imported'     => 'local_imported as `Local/Imported`',
        'stock_number'       => 'stock_number as `Stock Number`',
    ];

    public function index()
    {
        return view('report.index');
    }


    public function fetch(Request $request)
    {
        $checkList  = $request->get('check_list', null);
        $reportType = $request->get('report_type', 'in_stock');
        $startDate  = $request->get('start_date', null);
        $endDate    = $request->get('end_date', null);

        if( Carbon::parse($endDate)->lt(Carbon::parse($startDate)) ) {
            return response()->json(['message' => 'End date cannot be less then start date'], 422);
        }

        if (is_null($checkList)) {
            return response()->json(['message' => 'Please select any item from check list'], 422);
        }

        $selectQuery = '';

        $lastElement = end($checkList);

        foreach ($checkList as $list) {
            if (array_key_exists($list, Self::DATA_KEY_ARRAY)) {
                $selectQuery .= Self::DATA_KEY_ARRAY[$list];

                if ($list != $lastElement) {
                    $selectQuery .= ', ';
                }
            }
        }

        $data = StockHead::selectRaw($selectQuery)
            ->join('stock_details', 'stock_details.stock_head_id', '=', 'stock_heads.id')
            ->join('suppliers', 'suppliers.id', '=', 'stock_heads.supplier_id')
            ->join('shipping_billings as bill', 'bill.id', '=', 'stock_heads.bill_to')
            ->join('shipping_billings as ship', 'ship.id', '=', 'stock_heads.ship_to');


        if ($reportType == 'in_stock') {
            $data = $data->where('stock_details.stock_status', 'in_stock')
                ->whereRaw("(`stock_heads`.`invoice_date` between '$startDate' and '$endDate')");
        }

        if ($reportType == 'sold') {
            $data = $data->join('sales_details', 'stock_details.id', '=', 'sales_details.stock_details_id')
                ->join('sales_heads', 'sales_details.sales_head_id', '=', 'sales_heads.id')
                ->whereRaw("(sales_heads.sale_date between '$startDate' and '$endDate')")
                ->where('stock_details.stock_status', 'sold');
        }

        if ($reportType == 'rma') {
            $data = $data->join('rma_details', 'stock_details.id', '=', 'rma_details.stock_details_id')
                ->join('rma_heads', 'rma_details.rma_heads_id', '=', 'rma_heads.id')
                ->whereRaw("(rma_heads.rma_date between '$startDate' and '$endDate')")
                ->where('stock_details.stock_status', 'rma');
        }


        if ($reportType == 'supplier_credit') {
            $data = $data->join('supplier_credit_details', 'stock_details.id', '=', 'supplier_credit_details.stock_details_id')
                ->join('supplier_credit_heads', 'supplier_credit_details.supplier_credit_head_id', '=', 'supplier_credit_heads.id')
                ->whereRaw("(supplier_credit_heads.supplier_credit_date between '$startDate' and '$endDate')")
                ->where('stock_details.stock_status', 'suppler_credit');
        }


        if (in_array('make_id', $checkList)) {
            $data = $data->join('make', 'make.id', '=', 'stock_details.make_id');
        }

        if (in_array('model_id', $checkList)) {
            $data = $data->join('make_models', 'make_models.id', '=', 'stock_details.model_id');
        }

        if (in_array('color_id', $checkList)) {
            $data = $data->join('colors', 'colors.id', '=', 'stock_details.color_id');
        }

        if (in_array('grade_id', $checkList)) {
            $data = $data->join('grades', 'grades.id', '=', 'stock_details.grade_id');
        }

        if (in_array('capacity_id', $checkList)) {
            $data = $data->join('capacities', 'capacities.id', '=', 'stock_details.capacity_id');
        }

        $data = $data->get();

        if (count($data)) {
            $dataColumns = array_keys($data->toArray()[0]);

            return [
                'columns' => $dataColumns,
                'items'   => $data
            ];
        }

        return response()->json(['message' => 'No data found for current selection'], 404);
    }
}
