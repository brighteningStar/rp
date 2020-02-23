<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Services\ShippingBillingService;
use Illuminate\Http\Request;

class ShippingBillingsController extends Controller
{
    protected $service;

    public function __construct(ShippingBillingService $shippingBillingService)
    {
        $this->service = $shippingBillingService;

    }

    public function index()
    {
        return view('forms.shipping-billings.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'address_type' => 'required|in:ship_to,bill_to',
        ]);
        $this->service->create($request->all());
    }


    public function show($id)
    {
        return $this->service->find($id);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'address_type' => 'required|in:ship_to,bill_to',
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
        return $this->service->getAll(['name','address','address type']);
    }
}
