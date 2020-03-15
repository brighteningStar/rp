<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Services\CapacityService;
use Illuminate\Http\Request;

class CapacityController extends Controller
{
    protected $service;

    public function __construct(CapacityService $capacityService)
    {
        $this->service = $capacityService;

    }

    public function index()
    {
        return view('forms.capacity.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:capacities,name',
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
            'name' => 'required|unique:capacities,name,'.$id,
        ]);
        $where = array('id'=>$id);
        $this->service->update($request, $where);
    }


    public function destroy($id)
    {
        $this->service->destroy($id);
    }


    public function get()
    {
        return $this->service->getAll();
    }
}
