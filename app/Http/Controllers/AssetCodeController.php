<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\AssetCode;
use App\Models\Project;
use App\Imports\AssetImport;
use App\Exports\AssetExport;
use Maatwebsite\Excel\Facades\Excel;

class AssetCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project=DB::table('projects')->select('id','pro_title')->where('status',1)->get();

        $asset_code = DB::table('asset_codes as a')
        ->leftJoin('projects as b', 'a.pro_id', '=', 'b.id')
        ->where('a.status', 1)
        ->select('a.*', 'b.pro_title')
        ->get();

        return view('asset_code.list',['project'=>$project,'asset_code'=>$asset_code]);
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
            'asset_code' => 'required',
            'des' => 'required',
            'asset_date' => 'required',

        ]);

        $user_id = auth()->user()->id;

        $asset_code = new AssetCode();
        $asset_code->pro_id = $request->pro_id;
        $asset_code->asset_code =$request->asset_code;
        $asset_code->des =$request->des;
        $asset_code->asset_date = $request->asset_date;
        $asset_code->created_by =$user_id;

        $asset_code->save();

        return response()->json([
            'success' => true,
            'message' => 'AssetCode saved successfully!'
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

        $asset_code = DB::table('asset_codes')->where('id', $id)->first();

        $project=DB::table('projects')->select('id','pro_title')->where('status',1)->get();

        return view('asset_code.edit',['asset_code'=>$asset_code,'project'=>$project]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $asset_code = AssetCode::findOrFail($id);
        $asset_code->pro_id = $request->pro_id;
        $asset_code->asset_code =$request->asset_code;
        $asset_code->des =$request->des;
        $asset_code->asset_date = $request->asset_date;
        $asset_code->save();

        return redirect()->route('asset_code.index')->with(['status' => 'success', 'message' => 'AssetCode Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $asset_code =AssetCode::find($id);

        if ($asset_code) {
            $asset_code->delete();
            return redirect()->route('asset_code.index')->with([
                'status' => 'success',
                'message' => 'asset_code deleted successfully!'
            ]);
        } else {
            return redirect()->route('asset_code.index')->with([
                'status' => 'error',
                'message' => 'asset_code not found!'
            ]);
        }
    }

    public function import(Request $request)
    {

        $request->validate([
            'asset_file' => 'required|mimes:xlsx,csv'
        ]);

        $asset_file = $request->file('asset_file');

        Excel::import(new AssetImport(), $asset_file);

        return back()->with(['status' => 'success', 'message' => 'Asset Code Imported  successfully']);
    }

    public function export()
    {
        return Excel::download(new AssetExport(), 'AssetCode.xlsx');
    }
}
