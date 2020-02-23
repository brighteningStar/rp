<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;

use App\Models\ShippingBilling;

class ShippingBillingService extends ServiceAbstract
{

    public function model()
    {
        return ShippingBilling::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        if ( $keyword != '' ) {
            $shippingBillings = $this->model->select('shipping_billings.name as name', 'shipping_billings.address as address', 'shipping_billings.address_type as address type')
                ->whereRaw( "shipping_billings.name like ?", "%$keyword%" )
                ->orWhereRaw( "shipping_billings.address like ?", "%$keyword%" )
                ->orWhereRaw( "shipping_billings.address_type like ?", "%$keyword%" );
        }
        else {
            $shippingBillings = $this->model->select('shipping_billings.name as name', 'shipping_billings.address as address', 'shipping_billings.address_type as address type');
        }

        return [
            'columns' => $columns,
            'items'   => $shippingBillings->paginate(10)
        ];
    }


}