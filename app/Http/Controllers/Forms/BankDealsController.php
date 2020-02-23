<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Services\BankDealService;
use Illuminate\Http\Request;

class BankDealsController extends Controller
{
    protected $service;

    public function __construct(BankDealService $bankDealService)
    {
        $this->service = $bankDealService;

    }

    public function index()
    {
        return view('forms.bank-deals.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'deal_number' => 'required|unique:bank_deals,deal_number',
            'exchange_rate' => 'required|numeric',
            'deal_amount' => 'required|numeric',
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
            'deal_number' => 'required|unique:bank_deals,deal_number,'.$id,
            'exchange_rate' => 'required|numeric',
            'deal_amount' => 'required|numeric',
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
        return $this->service->getAll(['deal number','exchange rate','deal amount']);
    }
}
