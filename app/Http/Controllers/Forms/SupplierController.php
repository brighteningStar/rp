<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $service;

    public function __construct( SupplierService $supplierService )
    {
        $this->service = $supplierService;

    }

    public function index()
    {
        return view( 'forms.suppliers.index' );
    }


    public function store( Request $request )
    {
        $request->validate( [
            'name'    => 'required',
            'address' => 'required',
            'phone'   => 'required',
            'email'   => 'required|email|unique:suppliers,email',
        ] );
        $this->service->create( $request->all() );
    }


    public function show( $id )
    {
        return $this->service->find( $id );
    }


    public function update( Request $request, $id )
    {
        $request->validate( [
            'name'    => 'required',
            'address' => 'required',
            'phone'   => 'required',
            'email'   => 'required|email|unique:suppliers,email,' . $id,
        ] );
        $where = [ 'id' => $id ];
        $this->service->update( $request, $where );
    }


    public function destroy( $id )
    {
        $this->service->destroy($id);
    }


    public function get()
    {
        return $this->service->getAll();
    }
}
