<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;


class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unit=DB::table('units')->where('status',1)->get();

        return view('unit.list',['unit'=>$unit]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit' => 'required',
            'des' => 'required',
        ]);
    
        $user_id = auth()->user()->id;
    
        $unit = new Unit();
        $unit->unit = $request->unit;
        $unit->des = $request->des;
        $unit->created_by = $user_id;
        $unit->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Unit saved successfully!'
        ]);
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {

        $unit = Unit::findOrFail($id);
        $unit->unit = $request->unit;
        $unit->des = $request->des;
        $unit->save();
    

        return response()->json([
            'success' => true,
            'message' => 'Unit saved successfully!'
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::find($id);
    
        if ($unit) {
            $unit->delete();
            return redirect()->route('unit.index')->with([
                'status' => 'success',
                'message' => 'Unit deleted successfully!'
            ]);
        } else {
            return redirect()->route('unit.index')->with([
                'status' => 'error',
                'message' => 'Unit not found!'
            ]);
        }
    }
    

    
}
