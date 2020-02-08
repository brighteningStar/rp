<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name', 'address', 'email','phone'
    ];

    public function supplierCreditHeads()
    {
        return $this->hasMany(SupplierCreditHead::class, 'supplier_id');
    }
}
