<?php

namespace App\Rules;

use App\Models\StockHeadDetail;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class IMEIValid implements Rule
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
        $filters = $this->myrequest->get('filters');
        $exists = StockHeadDetail::where('imei_no',$value)
            ->where('model_id',$filters['model'])
            ->where('color_id',$filters['color'])
            ->where('capacity_id',$filters['capacity'])
            ->where('grade_id',$filters['grade'])
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
        return 'The IMEI does not match with the filters';
    }
}
