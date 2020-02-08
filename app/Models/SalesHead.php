<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesHead extends Model
{
    protected $table = 'sales_heads';

    protected $fillable = [
        'customer_id', 'sale_date', 'invoice_no'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
