<?php


namespace App\Services;


use App\Exceptions\AttributeNotFound;
use App\Models\BankDeal;
use App\Models\Capacity;
use App\Models\Color;
use App\Models\Grade;
use App\Models\Make;
use App\Models\MakeModel;
use App\Models\Region;
use App\Models\ShippingBilling;
use App\Models\Supplier;

class StockService
{

    public function region( $region )
    {
        $region = $this->getAttribute( Region::class, $region );

        if ( ! is_array( $region ) ) {
            throw new AttributeNotFound( 'Region with name ' . $region . ' not found', 404 );
        }

        return $region;
    }


    public function supplier( $supplier )
    {
        $supplier = $this->getAttribute( Supplier::class, $supplier );

        if ( ! is_array( $supplier ) ) {
            throw new AttributeNotFound( 'Supplier with name ' . $supplier . ' not found', 404 );
        }

        return $supplier;
    }

    public function shippingBilling( $shippingBilling )
    {
        $shippingBilling = $this->getAttribute( ShippingBilling::class, $shippingBilling );

        if ( ! is_array( $shippingBilling ) ) {
            throw new AttributeNotFound( 'Shipping & Billing with name ' . $shippingBilling . ' not found', 404 );
        }

        return $shippingBilling;
    }


    public function maker( $maker )
    {
        $maker = $this->getAttribute( Make::class, $maker );

        if ( ! is_array( $maker ) ) {
            throw new AttributeNotFound( 'Maker with name ' . $maker . ' not found', 404 );
        }

        return $maker;
    }


    public function makeModel( $makeModel )
    {
        $makeModel = $this->getAttribute( MakeModel::class, $makeModel );

        if ( ! is_array( $makeModel ) ) {
            throw new AttributeNotFound( 'Model with name ' . $makeModel . ' not found', 404 );
        }

        return $makeModel;
    }


    public function color( $color )
    {
        $color = $this->getAttribute( Color::class, $color );

        if ( ! is_array( $color ) ) {
            throw new AttributeNotFound( 'Color with name ' . $color . ' not found', 404 );
        }

        return $color;
    }

    public function grade( $grade )
    {
        $grade = $this->getAttribute( Grade::class, $grade );

        if ( ! is_array( $grade ) ) {
            throw new AttributeNotFound( 'Grade ' . $grade . ' not found', 404 );
        }

        return $grade;
    }


    public function capacity( $capacity )
    {
        $capacity = $this->getAttribute( Capacity::class, $capacity );

        if ( ! is_array( $capacity ) ) {
            throw new AttributeNotFound( 'Capacity with ' . $capacity . ' not found', 404 );
        }

        return $capacity;
    }



    public function bankDealExchangeRate( $bankDealNo )
    {
        $bankDeal = BankDeal::where( 'deal_number', $bankDealNo )->first();

        if ( ! $bankDeal  ) {
            throw new AttributeNotFound( 'Bank deal having number ' . $bankDealNo . ' not found', 404 );
        }

        return $bankDeal->exchange_rate;
    }


    private function getAttribute( $attributeObj, $name )
    {
        $attribute = ( new $attributeObj() )->where( 'name', $name )->first();

        if ( $attribute ) {
            return [ 'label' => $attribute->name, 'id' => $attribute->id ];
        }

        return $attribute;
    }


    public function builtHeadSection( $result, &$quantity )
    {
        return [
            'so_date'          => trim( $result['so_date']->format( 'Y-m-d' ) ),
            'so_number'        => trim( $result['so_number'] ),
            'invoice_date'     => trim( $result['inv_date']->format( 'Y-m-d' ) ),
            'invoice_no'       => trim( $result['inv_no'] ),
            'declaration_no'   => trim( $result['declaration_no'] ),
            'tracking_no'      => trim( $result['tracking_no'] ),
            'region'           => $this->region( trim( $result['region'] ) ),
            'bill_to'          => $this->shippingBilling( trim( $result['bill_to'] ) ),
            'ship_to'          => $this->shippingBilling( trim( $result['bill_to'] ) ),
            'supplier'         => $this->supplier( trim( $result['supplier'] ) ),
            'quantity_per_inv' => ++$quantity,
        ];
    }
}
