<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHead extends Model
{
    protected $table = 'stock_heads';

    protected $fillable = [
        'quantity_invoice', 'declaration_number', 'so_date', 'so_number', 'invoice_date', 'invoice_number', 'tracking_number','bill_to', 'ship_to', 'supplier_id', 'region_id'
    ];

    public function BillTo()
    {
        return $this->belongsTo(ShippingBilling::class, 'bill_to');
    }

    public function shipTo()
    {
        return $this->belongsTo(ShippingBilling::class, 'ship_to');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function details()
    {
        return $this->hasMany(StockHeadDetail::class, 'stock_head_id');
    }
}
