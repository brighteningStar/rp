<?php

namespace App\Rules;

use App\Models\StockHeadDetail;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class SupplierCreditIMEIValid implements Rule
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
        $supplier_id = $this->myrequest->get('supplier_id');
        $exists = StockHeadDetail::join('stock_heads', 'stock_heads.id', '=', 'stock_details.stock_head_id')
            ->where('imei_no',$value)
            ->where('supplier_id',$supplier_id)
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
        return 'The IMEI does not match with the supplier';
    }
}
