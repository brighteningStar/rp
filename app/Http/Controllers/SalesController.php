<?php

namespace App\Http\Controllers;

use App\Services\SalesService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    protected $service;

    public function __construct(SalesService $salesService)
    {
        $this->service = $salesService;

    }

    public function index()
    {
        return view('sales.index');
    }

    public function create(){
        return view('sales.create');
    }

    public function edit($id){
        dd($id);
    }


    public function store(Request $request)
    {
        $request->validate([
            'invoice_no' => 'required|unique:sales_heads,invoice_no',
            'sale_date' => 'required',
            'customer_id' => 'required|integer',
            'details.*.imei' => 'required',
            'details.*.price_aed' => 'required',
            'details.*.freight' => 'required',
            'details.*.unit_price' => 'required',
            'details.*.discount' => 'required',
            'details.*.amount' => 'required',
        ],
            [
                'details.*.imei.required' => 'IMEI is required',
                'details.*.price_aed.required' => 'AED Price is required',
                'details.*.freight.required' => 'Freight is required',
                'details.*.unit_price.required' => 'Unit Price is required',
                'details.*.discount.required' => 'Discount is required',
                'details.*.amount.required' => 'Amount is required',
            ]);
        $this->service->create($request->all());

    }


    public function show($id)
    {
        //return $this->service->find($id);
    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {
        //
    }


    public function get()
    {
        return $this->service->getAll(['customer', 'sale date', 'invoice number']);
    }

    public function searchImei(Request $request){
        $imei = $request->get('imei');
        return $this->service->fetchStockDetails($imei);
    }
}
