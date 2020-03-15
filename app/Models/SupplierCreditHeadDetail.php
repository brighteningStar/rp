<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierCreditHeadDetail extends Model
{
    protected $table = 'supplier_credit_details';

    protected $fillable = [
        'supplier_credit_head_id', 'stock_details_id','usd_price',
    ];
}
