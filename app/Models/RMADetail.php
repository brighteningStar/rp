<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RMADetail extends Model
{
    protected $table = 'rma_details';

    protected $fillable = [
        'rma_heads_id', 'stock_details_id', 'fault_type_id', 'location_id', 'fault', 'sale_price'
    ];
}
