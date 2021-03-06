<?php

namespace App\Http\Controllers;

use App\Rules\SupplierCreditIMEIValid;
use App\Services\SupplierCreditService;
use Illuminate\Http\Request;

class SupplierCreditController extends Controller
{
    protected $service;

    public function __construct(SupplierCreditService $creditService)
    {
        $this->service = $creditService;

    }

    public function index()
    {
        return view('supplier-credit.index');
    }

    public function create(){
        return view('supplier-credit.create');
    }

    public function view($id){
        $item = $this->service->find($id);
        if(isset($item)){
            return view('supplier-credit.view')->with('id',$id);
        }
        else {
            return abort(404);
        }

    }


    public function store(Request $request)
    {
        $request->validate([
            'credit_invoice_no' => 'required|unique:supplier_credit_heads,supplier_credit_invoice_no',
            'credit_date' => 'required',
            'supplier_id' => 'required|integer',
            'details.*.imei' => ['required', new SupplierCreditIMEIValid($request)],
            'details.*.usd_price' => 'required',
        ],
            [
                'details.*.imei.required' => 'IMEI is required',
                'details.*.sale_price.required' => 'USD Price is required',
            ]);
        $this->service->create($request->all());

    }


    public function show($id)
    {
        return $this->service->getDetails($id);
    }


    public function destroy($id)
    {
        //
    }


    public function get()
    {
        return $this->service->getAll(['supplier', 'credit date', 'Invoice number']);
    }

    public function searchImei(Request $request){
        $imei = $request->get('imei');
        $supplier_id = $request->get('supplier_id');
        return $this->service->fetchStockDetails($imei, $supplier_id);
    }
}
