<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesHead extends Model
{
    protected $table = 'sales_heads';

    protected $fillable = [
        'customer_id', 'sale_date', 'invoice_no', 'search_model_id', 'search_color_id', 'search_capacity_id', 'search_grade_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function details(){
        return $this->hasMany(SalesDetail::class, 'sales_head_id');
    }

    public function stockDetails(){
        return $this->belongsToMany(StockHeadDetail::class, 'sales_details', 'sales_head_id', 'stock_details_id')->withPivot('unit_price', 'discount', 'amount')->with('stockHead');
    }

    public function filters(){
        return $this->hasMany(SalesFilter::class, 'sales_head_id');
    }
}
