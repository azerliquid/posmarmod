<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Unit;

class CatUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array('category' => $category = Category::where('deleted', false)->get(),
                        'unit' => $unit = Unit::where('deleted', false)->get(),
        );
        // var_dump($data['unit']);
        return view('admin.catunit.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['jenis'] == 'Kategori') {
            $category = new Category;
            $category->categorys = $request->name;
            $category->deleted = 0;
            $category->save();
            return redirect()->route('catunit.index');
        }if ($request['jenis'] == 'Unit') {
            $unit = new Unit;
            $unit->units = $request->name;
            $unit->deleted = 0;
            $unit->save();
            return redirect()->route('catunit.index');
        } else {
            return redirect()->route('catunit.index');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request['jenis'] == 'Kategori') {
            $category = Category::find($id);
            $category->categorys = $request->name;
            $category->save();
            return redirect()->route('catunit.index');
        }if ($request['jenis'] == 'Unit'){
            $unit = Unit::find($id);
            $unit->units = $request->name;
            $unit->save();
            return redirect()->route('catunit.index');
        } else {
            return redirect()->route('catunit.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request['jenis'] == 'Kategori') {
            $category = Category::find($id);
            $category->deleted = 1;
            $category->save();
            return redirect()->route('catunit.index');
        }if ($request['jenis'] == 'Unit') {
            $unit = Unit::find($id);
            $unit->deleted = 1;
            $unit->save();
            return redirect()->route('catunit.index');
        } else {
            return redirect()->route('catunit.index');
        }
    }
}
