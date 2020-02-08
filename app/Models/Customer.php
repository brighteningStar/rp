<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 'address', 'phone', 'email'
    ];

    public function rmaHeads()
    {
        return $this->hasMany(RmaHead::class, 'customer_id');
    }

    public function salesHeads()
    {
        return $this->hasMany(SalesHead::class, 'customer_id');
    }
}
