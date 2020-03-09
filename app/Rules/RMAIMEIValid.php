<?php

namespace App\Rules;

use App\Models\StockHeadDetail;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class RMAIMEIValid implements Rule
{
    protected $myrequest;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->myrequest = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $customer_id = $this->myrequest->get('customer_id');
        $exists = StockHeadDetail::select(\DB::raw('stock_details.id as id, stock_details.imei_no as imei_no'))
            ->join('sales_details', 'stock_details.id', '=', 'sales_details.stock_details_id')
            ->join('sales_heads', 'sales_details.sales_head_id', '=', 'sales_heads.id')
            ->where('customer_id',$customer_id)
            ->where('stock_details.imei_no',$value)
            ->exists();
        return $exists;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The IMEI does not match with the customer';
    }
}
