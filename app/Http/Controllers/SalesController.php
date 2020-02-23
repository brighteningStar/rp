<?php

namespace App\Http\Controllers;

use App\Services\SalesService;
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
