<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MakeModel extends Model
{
    protected $table = 'make_models';

    protected $fillable = [
        'name', 'make_id'
    ];

    public function make()
    {
         return $this->belongsTo(Make::class, 'make_id');
    }



}
