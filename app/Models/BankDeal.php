<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDeal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deal_number', 'exchange_rate', 'deal_amount',
    ];
}
