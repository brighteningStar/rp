<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingBilling extends Model
{
    protected $table = 'shipping_billings';

    protected $fillable = [
        'name', 'address', 'address_type'
    ];
}
