<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Services\ColorService;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    protected $service;

    public function __construct(ColorService $colorService)
    {
        $this->service = $colorService;

    }

    public function index()
    {
        return view('forms.colors.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:colors,name',
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
            'name' => 'required|unique:users,name,'.$id,
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
