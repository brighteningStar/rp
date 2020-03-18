<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesFilter extends Model
{
    protected $table = 'sales_filters';

    protected $fillable = [
        'sales_head_id', 'search_model_id', 'search_color_id', 'search_capacity_id', 'search_grade_id', 'quantity'
    ];
}
