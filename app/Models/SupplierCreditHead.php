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
}
