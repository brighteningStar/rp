<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    public function index()
    {
        return view('forms.colors.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:colors,name',
        ]);
        Color::create(['name' => $request->get('name')]);
    }


    public function show($id)
    {
        return Color::find($id);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:users,name,'.$id,
        ]);
        Color::where('id', $id)
            ->update(['name' => $request->get('name')]);
    }


    public function destroy($id)
    {
        //
    }


    public function getColors()
    {
        $columns = [ 'name' ];
        $colors   = Color::all();

        return [
            'columns' => $columns,
            'items'   => $colors
        ];
    }
}
