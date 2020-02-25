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


    public function store(Request $request)
    {
        $request->validate([
            'invoice_no' => 'required|unique:sales_heads,invoice_no',
            'sale_date' => 'required',
            'customer_id' => 'required|integer'
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
       // return $this->service->getAll();
    }
}
