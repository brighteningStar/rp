<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHeadDetail extends Model
{
    protected $table = 'stock_details';

    protected $fillable = [
        'invoice_number', 'stock_head_id', 'sys_id', 'imei_no', 'serial_no', 'make_id', 'model_id', 'capacity_id','color_id', 'grade_id', 'bank_deal_id', 'fault_type', 'stock_number', 'part_description', 'price_usd', 'price_aed', 'total_cost', 'stock_status', 'local_imported'
    ];

    public function stockHead()
    {
        return $this->belongsTo(StockHead::class, 'stock_head_id');
    }

    public function make()
    {
        return $this->belongsTo(Make::class, 'make_id');
    }

    public function model()
    {
        return $this->belongsTo(MakeModel::class, 'model_id');
    }

    public function capacity()
    {
        return $this->belongsTo(Capacity::class, 'capacity_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function bankDeal()
    {
        return $this->belongsTo(BankDeal::class, 'bank_deal_id');
    }

    public function faultType()
    {
        return $this->belongsTo(FaultType::class, 'fault_type');
    }
}
