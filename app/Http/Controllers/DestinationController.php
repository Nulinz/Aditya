<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;



class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $des=DB::table('destinations')->where('status',1)->get();

        return view('desgination.list',['des'=>$des]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('desgination.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'designation' => 'required',
        ]);
    
        $user_id = auth()->user()->id;
    
        $designation = new Destination();
        $designation->designation = $request->designation;
        $designation->created_by = $user_id;
        $designation->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Designation saved successfully!'
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
        $designation = Destination::findOrFail($id);
        $designation->designation = $request->designation;
        $designation->des = $request->des;
        $designation->save();
    

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
        $designation = Destination::find($id);
    
        if ($designation) {
            $designation->delete();
            return redirect()->route('desgination.index')->with([
                'status' => 'success',
                'message' => 'Desgination deleted successfully!'
            ]);
        } else {
            return redirect()->route('desgination.index')->with([
                'status' => 'error',
                'message' => 'Desgination not found!'
            ]);
        }
    }
}
