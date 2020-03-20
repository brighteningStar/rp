<?php

namespace App\Services;

use App\Models\StockHead;

class SearchService
{

    protected const STOCK_ATTRIBUTES_QUERY = 'stock_details.price_usd, stock_details.price_aed, stock_heads.tracking_number';
    protected const STOCK_COLUMNS          = [
        'price_usd'       => 'Price (USD)',
        'price_aed'       => 'Price (AED)',
        'tracking_number' => 'Tracking Number'
    ];

    protected const SALES_ATTRIBUTES_QUERY = 'unit_price, discount, DATE_FORMAT(sale_date, "%Y-%m-%d") as sale_date, invoice_no, customers.name AS `customer_name`';
    protected const SALES_COLUMNS          = [
        'unit_price'    => 'Unit Price',
        'discount'      => 'Discount',
        'sale_date'     => 'Sale Date',
        'customer_name' => 'Customer Name'
    ];

    public function searchByIMEI($imei)
    {
        $stockSelectors = Self::STOCK_ATTRIBUTES_QUERY;
        $salesSelectors = Self::SALES_ATTRIBUTES_QUERY;

        $data = StockHead::selectRaw("{$stockSelectors}, {$salesSelectors}")
            ->join('stock_details', 'stock_details.stock_head_id', '=', 'stock_heads.id')
            ->leftJoin('sales_details', 'sales_details.stock_details_id', '=', 'stock_details.id')
            ->join('sales_heads', 'sales_heads.id', '=', 'sales_details.sales_head_id')
            ->join('customers', 'customers.id', '=', 'sales_heads.customer_id')
            ->where('stock_details.imei_no', $imei)
            ->first();

        $stockTable = [];
        $salesTable = [];

        foreach( self::STOCK_COLUMNS as $dbKey => $columnName) {
            
            $stockTable['column'][]          = $columnName;
            $stockTable['item'][$columnName] = $data->$dbKey;

        } 

        foreach( self::SALES_COLUMNS as $dbKey => $columnName) {
            
            $salesTable['column'][]          = $columnName;
            $salesTable['item'][$columnName] = $data->$dbKey;

        } 

        return [
            'stock_table' => $stockTable,
            'sale_table'  => $salesTable
        ];
    }
}
