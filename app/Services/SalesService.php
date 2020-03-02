<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\SalesHead;
use App\Models\StockHeadDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesService extends ServiceAbstract
{

    public function model()
    {
        return SalesHead::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        $query = $this->model->select(\DB::raw("sales_heads.id as id, customers.name as customer, date_format(sales_heads.sale_date, '%Y-%m-%d') as 'sale date', sales_heads.invoice_no as 'invoice number'"))
            ->join('customers', 'customers.id', '=', 'sales_heads.customer_id');

        if ( $keyword != '' ) {
            $query = $query->whereRaw( "customers.name like ?", "%$keyword%" )
                        ->orWhereRaw("sales_heads.invoice_no like ?", "%$keyword%")
                        ->orWhereDate('sales_heads.sale_date',$keyword);
        }
        return [
            'columns' => $columns,
            'items'   => $query->paginate(10)
        ];
    }

    public function create(array $data)
    {
        $data['sale_date'] = Carbon::parse($data['sale_date']);
        $sales_head = array(
            'customer_id' => $data['customer_id'],
            'sale_date' => $data['sale_date'],
            'invoice_no' => $data['invoice_no'],
        );
        $head = $this->model->create($sales_head);
        $detailsArr = array();
        foreach ($data['details'] as $detail){
            $detailItem = array(
                'stock_details_id' => $detail['detail_id'],
                'unit_price' => $detail['unit_price'],
                'discount' => $detail['discount'],
                'amount' => $detail['amount'],
            );
            array_push($detailsArr, $detailItem);
            StockHeadDetail::find($detail['detail_id'])->update(['stock_status'=>'sold']);
        }
        $head->details()->createMany($detailsArr);
    }

    public function update(Request $request, array $where)
    {
        $item = $this->model->where($where)->first();
        $data = $request->all();
        $data['sale_date'] = Carbon::parse($data['sale_date']);
        $sales_head = array(
            'customer_id' => $data['customer_id'],
            'sale_date' => $data['sale_date'],
            'invoice_no' => $data['invoice_no'],
        );
        $item->update($sales_head);

        $stockDetails = $item->stockDetails;
        foreach ($stockDetails as $stockDetail){
            $stockDetail->update(['stock_status'=>'in_stock']);
        }
        $item->stockDetails()->detach();

        $detailsArr = array();
        foreach ($data['details'] as $detail){
            $detailItem = array(
                'stock_details_id' => $detail['detail_id'],
                'unit_price' => $detail['unit_price'],
                'discount' => $detail['discount'],
                'amount' => $detail['amount'],
            );
            array_push($detailsArr, $detailItem);
            StockHeadDetail::find($detail['detail_id'])->update(['stock_status'=>'sold']);
        }
        $item->details()->createMany($detailsArr);

    }

    public function fetchStockDetails($imei){
        $query = StockHeadDetail::select('id', 'imei_no', 'price_aed','freight')
            ->whereRaw( "imei_no like ?", "%$imei%" )
            ->where('stock_status','in_stock')
            ->get();
        $result = array();
        foreach ($query as $item){
            $obj = new \stdClass();
            $obj->label = $item->imei_no;
            $obj->value = $item;
            array_push($result,$obj);
        }
        return $result;
    }

    public function getDetails($id, $columns = array('*')){
        $salesItem = $this->model->with('stockDetails')->where('id',$id)->first();
        return $salesItem;
    }


}