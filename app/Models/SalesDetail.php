<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    protected $table = 'sales_details';

    protected $fillable = [
        'sales_head_id', 'stock_details_id', 'unit_price', 'discount', 'amount'
    ];
}
