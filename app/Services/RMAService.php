<?php
/**
 * Created by PhpStorm.
 * User: fakhar
 * Date: 13/12/2016
 * Time: 3:27 PM
 */

namespace App\Services;


use App\Models\RmaHead;
use App\Models\StockHeadDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RMAService extends ServiceAbstract
{

    public function model()
    {
        return RmaHead::class;
    }

    public function getAll($columns = null)
    {
        $columns = is_null($columns)?$this->model->getFillable():$columns;
        $keyword = request()->get( 'q', null );

        $query = $this->model->select(\DB::raw("rma_heads.id as id, customers.name as customer, date_format(rma_heads.rma_date, '%Y-%m-%d') as 'RMA date', rma_heads.rma_number as 'RMA number'"))
            ->join('customers', 'customers.id', '=', 'rma_heads.customer_id');

        if ( $keyword != '' ) {
            $query = $query->whereRaw( "customers.name like ?", "%$keyword%" )
                ->orWhereRaw("rma_heads.rma_number like ?", "%$keyword%")
                ->orWhereDate('rma_heads.rma_date',$keyword);
        }
        return [
            'columns' => $columns,
            'items'   => $query->paginate(10)
        ];
    }

    public function create(array $data)
    {
        $data['rma_date'] = Carbon::parse($data['rma_date']);
        $rma_head = array(
            'customer_id' => $data['customer_id'],
            'rma_date' => $data['rma_date'],
            'rma_number' => $data['rma_no'],
        );
        $head = $this->model->create($rma_head);
        $detailsArr = array();
        foreach ($data['details'] as $detail){
            $detailItem = array(
                'stock_details_id' => $detail['detail_id'],
                'fault_type_id' => $detail['fault_type_id'],
                'location_id' => $detail['location_id'],
                'fault' => $detail['fault'],
            );
            array_push($detailsArr, $detailItem);
            StockHeadDetail::find($detail['detail_id'])->update(['stock_status'=>'rma']);
        }
        $head->details()->createMany($detailsArr);
    }

    public function update(Request $request, array $where)
    {
        $item = $this->model->where($where)->first();
        $data = $request->all();
        $data['rma_date'] = Carbon::parse($data['rma_date']);
        $rma_head = array(
            'customer_id' => $data['customer_id'],
            'rma_date' => $data['rma_date'],
            'rma_number' => $data['rma_no'],
        );
        $item->update($rma_head);

        $stockDetails = $item->stockDetails;
        foreach ($stockDetails as $stockDetail){
            $stockDetail->update(['stock_status'=>'in_stock']);
        }
        $item->stockDetails()->detach();
        $detailsArr = array();
        foreach ($data['details'] as $detail){
            $detailItem = array(
                'stock_details_id' => $detail['detail_id'],
                'fault_type_id' => $detail['fault_type_id'],
                'location_id' => $detail['location_id'],
                'fault' => $detail['fault'],
            );
            array_push($detailsArr, $detailItem);
            StockHeadDetail::find($detail['detail_id'])->update(['stock_status'=>'rma']);
        }
        $item->details()->createMany($detailsArr);

    }

    public function fetchStockDetails($imei){
        $query = StockHeadDetail::select('id', 'imei_no', 'price_aed','freight')
            ->whereRaw( "imei_no like ?", "%$imei%" )
            ->where('stock_status','sold')
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
        $rmaItems = $this->model->with('stockDetails')->where('id',$id)->first();
        return $rmaItems;
    }


}