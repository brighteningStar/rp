<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\StockHeadDetail;
use App\Models\SupplierCreditHead;
use Carbon\Carbon;

class SupplierCreditService extends ServiceAbstract
{

    public function model()
    {
        return SupplierCreditHead::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        $query = $this->model->select(\DB::raw("supplier_credit_heads.id as id, suppliers.name as supplier, date_format(supplier_credit_heads.supplier_credit_date, '%Y-%m-%d') as 'credit date', supplier_credit_heads.supplier_credit_invoice_no as 'Invoice number'"))
            ->join('suppliers', 'suppliers.id', '=', 'supplier_credit_heads.supplier_id');

        if ( $keyword != '' ) {
            $query = $query->whereRaw( "suppliers.name like ?", "%$keyword%" )
                ->orWhereRaw("supplier_credit_heads.supplier_credit_invoice_no like ?", "%$keyword%")
                ->orWhereDate('supplier_credit_heads.supplier_credit_date',$keyword);
        }
        return [
            'columns' => $columns,
            'items'   => $query->paginate(10)
        ];
    }

    public function create(array $data)
    {
        $data['credit_date'] = Carbon::parse($data['credit_date']);
        $rma_head = array(
            'supplier_id' => $data['supplier_id'],
            'supplier_credit_date' => $data['credit_date'],
            'supplier_credit_invoice_no' => $data['credit_invoice_no'],
        );
        $head = $this->model->create($rma_head);
        $detailsArr = array();
        foreach ($data['details'] as $detail){
            $detailItem = array(
                'stock_details_id' => $detail['detail_id'],
                'usd_price' => $detail['usd_price'],
            );
            array_push($detailsArr, $detailItem);
            StockHeadDetail::find($detail['detail_id'])->update(['stock_status'=>'suppler_credit']);
        }
        $head->details()->createMany($detailsArr);
    }

    public function fetchStockDetails($imei, $supplier_id){

        $result = array();
        if($imei==null){
            return $result;
        }
        $query = StockHeadDetail::select(\DB::raw('stock_details.id as id, stock_details.imei_no as imei_no, stock_details.price_usd as usd_price'))
            ->join('stock_heads', 'stock_heads.id', '=', 'stock_details.stock_head_id')
            ->where('supplier_id',$supplier_id)
            ->whereRaw( "imei_no like ?", "%$imei%" )
            ->where('stock_status','rma')
            ->get();

        foreach ($query as $item){
            $obj = new \stdClass();
            $obj->label = $item->imei_no;
            $obj->value = $item;
            array_push($result,$obj);
        }
        return $result;
    }

    public function getDetails($id, $columns = array('*')){
        $creditItems = $this->model->with('stockDetails')->where('id',$id)->first();
        return $creditItems;
    }


}