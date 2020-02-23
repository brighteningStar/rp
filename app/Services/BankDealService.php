<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\BankDeal;

class BankDealService extends ServiceAbstract
{

    public function model()
    {
        return BankDeal::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );
        $items = $this->model->select('bank_deals.deal_number as deal number', 'bank_deals.exchange_rate as exchange rate', 'bank_deals.deal_amount as deal amount');
        if ( $keyword != '' ) {
            $items = $items->whereRaw( "bank_deals.deal_number like ?", "%$keyword%" )
                ->orWhereRaw( "bank_deals.exchange_rate like ?", "%$keyword%" )
                ->orWhereRaw( "bank_deals.deal_amount like ?", "%$keyword%" );
        }

        return [
            'columns' => $columns,
            'items'   => $items->paginate(10)
        ];
    }


}