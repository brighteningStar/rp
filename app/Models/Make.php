<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    protected $table = 'make';
    protected $fillable = [
        'name'
    ];

    public function models()
    {
        return $this->hasMany(MakeModel::class, 'make_id');
    }
}
