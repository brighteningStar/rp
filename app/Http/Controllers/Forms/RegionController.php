<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Services\RegionService;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    protected $service;

    public function __construct(RegionService $regionService)
    {
        $this->service = $regionService;

    }

    public function index()
    {
        return view('forms.regions.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:regions,name',
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
            'name' => 'required|unique:regions,name,'.$id,
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
