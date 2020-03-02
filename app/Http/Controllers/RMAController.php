<?php

namespace App\Http\Controllers;

use App\Services\RMAService;
use Illuminate\Http\Request;

class RMAController extends Controller
{
    protected $service;

    public function __construct(RMAService $rmaService)
    {
        $this->service = $rmaService;

    }

    public function index()
    {
        return view('rma.index');
    }

    public function create(){
        return view('rma.create');
    }

    public function edit($id){
        $item = $this->service->find($id);
        if(isset($item)){
            return view('rma.edit')->with('id',$id);
        }
        else {
            return abort(404);
        }

    }


    public function store(Request $request)
    {
        $request->validate([
            'rma_no' => 'required|unique:rma_heads,rma_number',
            'rma_date' => 'required',
            'customer_id' => 'required|integer',
            'details.*.imei' => 'required',
            'details.*.price_aed' => 'required',
            'details.*.freight' => 'required',
        ],
            [
                'details.*.imei.required' => 'IMEI is required',
                'details.*.price_aed.required' => 'AED Price is required',
                'details.*.freight.required' => 'Freight is required',
            ]);
        $this->service->create($request->all());

    }


    public function show($id)
    {
        return $this->service->getDetails($id);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'rma_no' => 'required|unique:rma_heads,rma_number,'.$id,
            'rma_date' => 'required',
            'customer_id' => 'required|integer',
            'details.*.imei' => 'required',
            'details.*.price_aed' => 'required',
            'details.*.freight' => 'required',
        ],
            [
                'details.*.imei.required' => 'IMEI is required',
                'details.*.price_aed.required' => 'AED Price is required',
                'details.*.freight.required' => 'Freight is required',
            ]);

        $where = array('id'=>$id);
        $this->service->update($request, $where);


    }


    public function destroy($id)
    {
        //
    }


    public function get()
    {
        return $this->service->getAll(['customer', 'RMA date', 'RMA number']);
    }

//    public function searchImei(Request $request){
//        $imei = $request->get('imei');
//        return $this->service->fetchStockDetails($imei);
//    }
}