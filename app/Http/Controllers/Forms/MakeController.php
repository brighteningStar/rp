<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Services\MakeService;
use Illuminate\Http\Request;

class MakeController extends Controller
{
    protected $service;

    public function __construct(MakeService $makeService)
    {
        $this->service = $makeService;

    }

    public function index()
    {
        return view('forms.make.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:make,name',
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
            'name' => 'required|unique:make,name,'.$id,
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
        return $this->service->getAll();
    }
}