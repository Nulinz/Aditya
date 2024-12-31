<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Division;
use App\Models\Project;
use App\Exports\SubDivisionExport;
use Maatwebsite\Excel\Facades\Excel;

class SubDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project=DB::table('projects')->select('id','pro_title')->where('status',1)->get();

        $boq=DB::table('boqs')->select('id','code')->where('status',1)->get();

        $division=DB::table('divisions as a')
        ->leftJoin('projects as b', 'a.pro_id', '=', 'b.id')
        ->leftJoin('boqs as c', 'a.boq', '=', 'c.id')
        ->where('a.status', 1)
        ->select('a.*', 'b.pro_title','c.code')
        ->get();

        return view('division.list',['project'=>$project,'boq'=>$boq,'division'=>$division]);
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
            'boq' => 'required',
            'sub_code' => 'required',
            'des' => 'required',

        ]);

        $user_id = auth()->user()->id;

        $division = new Division();
        $division->pro_id = $request->pro_id;
        $division->boq =$request->boq;
        $division->sub_code =$request->sub_code;
        $division->des =$request->des;
        $division->created_by =$user_id;

        $division->save();

        return response()->json([
            'success' => true,
            'message' => 'SubDivision saved successfully!'
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
        $sub_division = DB::table('divisions')->where('id', $id)->first();

        $boq=DB::table('boqs')->select('id','code')->where('status',1)->get();

        $project=DB::table('projects')->select('id','pro_title')->where('status',1)->get();


        return view('division.edit',['sub_division'=>$sub_division,'boq'=>$boq,'project'=>$project]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $division = Division::findOrFail($id);
        $division->pro_id = $request->pro_id;
        $division->boq =$request->boq;
        $division->sub_code =$request->sub_code;
        $division->des =$request->des;
        $division->save();

        return redirect()->route('division.index')->with(['status' => 'success', 'message' => 'Sub Division Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $division = Division::find($id);

        if ($division) {
            $division->delete();
            return redirect()->route('division.index')->with([
                'status' => 'success',
                'message' => 'Division deleted successfully!'
            ]);
        } else {
            return redirect()->route('division.index')->with([
                'status' => 'error',
                'message' => 'Division not found!'
            ]);
        }
    }

    public function export()
    {
        return Excel::download(new SubDivisionExport(), 'Sub Division.xlsx');
    }

}
