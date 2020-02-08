<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RmaHead extends Model
{
    protected $table = 'rma_heads';

    protected $fillable = [
        'rma_date', 'rma_number', 'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
