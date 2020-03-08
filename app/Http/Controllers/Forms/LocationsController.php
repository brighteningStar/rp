<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Services\LocationService;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    protected $service;

    public function __construct(LocationService $locationService)
    {
        $this->service = $locationService;

    }

    public function index()
    {
        return view('forms.locations.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:locations,name',
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
            'name' => 'required|unique:locations,name,'.$id,
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
