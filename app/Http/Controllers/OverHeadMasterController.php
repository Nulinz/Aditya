<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Overhead;
use App\Models\Project;
use App\Imports\OverheadImport;
use App\Exports\OverheadExport;
use Maatwebsite\Excel\Facades\Excel;

class OverHeadMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project=DB::table('projects')->select('id','pro_title')->where('status',1)->get();

        $overhead = DB::table('overheads as a')
        ->leftJoin('projects as b', 'a.pro_id', '=', 'b.id')
        ->where('a.status', 1)
        ->select('a.*', 'b.pro_title')
        ->get();


        return view('overhead.list',['project'=>$project,'overhead'=>$overhead]);
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
            'mat_des' => 'required',
        ]);

        $user_id = auth()->user()->id;

        $overhead = new Overhead();
        $overhead->pro_id = $request->pro_id;
        $overhead->item_code =$request->item_code;
        $overhead->mat_des =$request->mat_des;
        $overhead->hm_date = now()->format('Y-m-d');
        $overhead->created_by =$user_id;

        $overhead->save();

        return response()->json([
            'success' => true,
            'message' => 'overhead saved successfully!'
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
        $overhead = DB::table('overheads')->where('id', $id)->first();

        $project=DB::table('projects')->select('id','pro_title')->where('status',1)->get();

        return view('overhead.edit',['overhead'=>$overhead,'project'=>$project]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $overhead = Overhead::findOrFail($id);
        $overhead->pro_id = $request->pro_id;
        $overhead->item_code =$request->item_code;
        $overhead->mat_des =$request->mat_des;
        $overhead->save();

        return redirect()->route('overhead.index')->with(['status' => 'success', 'message' => 'Overhead Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $overhead =Overhead::find($id);

        if ($overhead) {
            $overhead->delete();
            return redirect()->route('overhead.index')->with([
                'status' => 'success',
                'message' => 'Overhead deleted successfully!'
            ]);
        } else {
            return redirect()->route('overhead.index')->with([
                'status' => 'error',
                'message' => 'Overhead not found!'
            ]);
        }
    }

    public function import(Request $request)
    {

        $request->validate([
            'overhead_file' => 'required|mimes:xlsx,csv'
        ]);

        $overhead_file = $request->file('overhead_file');

        Excel::import(new OverheadImport(), $overhead_file);

        return back()->with(['status' => 'success', 'message' => 'Overhead Imported  successfully']);
    }

    public function export()
    {
        return Excel::download(new OverheadExport(), 'Overhead.xlsx');
    }
}
