<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierCreditHead extends Model
{
    protected $table = 'supplier_credit_heads';

    protected $fillable = [
        'supplier_credit_date', 'supplier_credit_invoice_no', 'supplier_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function details(){
        return $this->hasMany(SupplierCreditHeadDetail::class, 'supplier_credit_head_id');
    }


    public function stockDetails(){
        return $this->belongsToMany(StockHeadDetail::class, 'supplier_credit_details', 'supplier_credit_head_id', 'stock_details_id')->withPivot('usd_price');
    }
}
