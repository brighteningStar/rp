<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;

class StockController extends Controller
{

    public function index()
    {
        return view('stock.index');
    }


    public function processExcel(Request $request)
    {
        $fileContent = file_get_contents( $request->file( 'file' )->getRealPath() );
        \Excel::class;
        return $request->file('file');
    }
}
