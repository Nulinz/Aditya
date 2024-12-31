<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Material;
use App\Models\Project;
use App\Imports\MaterialImport;
use App\Exports\MaterialExport;
use Maatwebsite\Excel\Facades\Excel;


class MaterialMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $project=DB::table('projects')->select('id','pro_title')->where('status',1)->get();

        $material = DB::table('materials as a')
        ->leftJoin('projects as b', 'a.pro_id', '=', 'b.id')
        ->where('a.status', 1)
        ->select('a.*', 'b.pro_title')
        ->get();

        return view('material.list',['project'=>$project,'material'=>$material]);
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
            'pro_id' => 'required',
            'item_code' => 'required',
            'des' => 'required',
        ]);

        $user_id = auth()->user()->id;

        $material = new Material();
        $material->pro_id = $request->pro_id;
        $material->item_code =$request->item_code;
        $material->des =$request->des;
        $material->mat_date = now()->format('Y-m-d');
        $material->created_by =$user_id;

        $material->save();

        return response()->json([
            'success' => true,
            'message' => 'Material saved successfully!'
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
        $material = DB::table('materials')->where('id', $id)->first();

        $project=DB::table('projects')->select('id','pro_title')->where('status',1)->get();

        return view('material.edit',['material'=>$material,'project'=>$project]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $material = Material::findOrFail($id);
        $material->pro_id = $request->pro_id;
        $material->item_code =$request->item_code;
        $material->des =$request->des;
        $material->save();

        return redirect()->route('material.index')->with(['status' => 'success', 'message' => 'Material Updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::find($id);

        if ($material) {
            $material->delete();
            return redirect()->route('material.index')->with([
                'status' => 'success',
                'message' => 'Material deleted successfully!'
            ]);
        } else {
            return redirect()->route('material.index')->with([
                'status' => 'error',
                'message' => 'Material not found!'
            ]);
        }
    }

    public function import(Request $request)
    {

        $request->validate([
            'material_file' => 'required|mimes:xlsx,csv'
        ]);

        $material_file = $request->file('material_file');

        Excel::import(new MaterialImport(), $material_file);

        return back()->with(['status' => 'success', 'message' => 'Material Imported  successfully']);
    }

    public function export()
    {
        return Excel::download(new MaterialExport(), 'Materials.xlsx');
    }

}
