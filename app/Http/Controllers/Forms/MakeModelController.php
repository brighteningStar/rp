<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Services\MakeModelService;
use Illuminate\Http\Request;

class MakeModelController extends Controller
{
    protected $service;

    public function __construct(MakeModelService $makemodelService)
    {
        $this->service = $makemodelService;

    }

    public function index()
    {
        return view('forms.makeModels.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'make_id' => 'required',
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
            'make_id' => 'required',
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
