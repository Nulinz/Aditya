<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use App\Imports\VendorImport;
use App\Exports\VendorsExport;
use Maatwebsite\Excel\Facades\Excel;


class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project=DB::table('projects')->select('id','pro_title')->where('status',1)->get();

        $vendor = DB::table('vendors as a')
        ->leftJoin('projects as b', 'a.pro_id', '=', 'b.id')
        ->where('a.status', 1)
        ->select('a.*', 'b.pro_title')
        ->get();

        return view('vendors.list',['project'=>$project,'vendor'=>$vendor]);
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
            'type' => 'required',
            'v_code' => 'required',
            'v_name' => 'required',
            'pan' => 'required',
            'address' => 'required',
            'gst' => 'required',
            'aadhar' => 'required',
            'bank' => 'required',
            'ac_name' => 'required',
            'ac_no' => 'required',
            'ifsc' => 'required',
            'branch' => 'required',
            'mob' => 'required',
            'mail' => 'required',
            'trade' => 'required',
            'ven_date' => 'required',

        ]);

        $user_id = auth()->user()->id;

        $vendor = new Vendor();
        $vendor->pro_id = $request->pro_id;
        $vendor->type =$request->type;
        $vendor->v_code =$request->v_code;
        $vendor->pan = $request->pan;
        $vendor->address = $request->address;
        $vendor->gst =$request->gst;
        $vendor->aadhar =$request->aadhar;
        $vendor->bank = $request->bank;
        $vendor->ac_name = $request->ac_name;
        $vendor->ac_no =$request->ac_no;
        $vendor->v_name =$request->v_name;
        $vendor->ifsc = $request->ifsc;
        $vendor->branch = $request->branch;
        $vendor->mob =$request->mob;
        $vendor->mail =$request->mail;
        $vendor->trade = $request->trade;
        $vendor->ven_date = $request->ven_date;
        $vendor->created_by =$user_id;

        $vendor->save();

        return response()->json([
            'success' => true,
            'message' => 'Vendor saved successfully!'
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
        $vendor = DB::table('vendors')->where('id', $id)->first();

        $project=DB::table('projects')->select('id','pro_title')->where('status',1)->get();

        return view('vendors.edit',['vendor'=>$vendor,'project'=>$project]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pro_id' => 'required',
            'type' => 'required',
            'v_code' => 'required',
            'v_name' => 'required',
            'pan' => 'required',
            'address' => 'required',
            'gst' => 'required',
            'aadhar' => 'required',
            'bank' => 'required',
            'ac_name' => 'required',
            'ac_no' => 'required',
            'ifsc' => 'required',
            'branch' => 'required',
            'mob' => 'required',
            'mail' => 'required',
            'trade' => 'required',
            'ven_date' => 'required',
        ]);

        $vendor = Vendor::findOrFail($id);

        $vendor->pro_id = $request->pro_id;
        $vendor->type = $request->type;
        $vendor->v_code = $request->v_code;
        $vendor->v_name = $request->v_name;
        $vendor->pan = $request->pan;
        $vendor->address = $request->address;
        $vendor->gst = $request->gst;
        $vendor->aadhar = $request->aadhar;
        $vendor->bank = $request->bank;
        $vendor->ac_name = $request->ac_name;
        $vendor->ac_no = $request->ac_no;
        $vendor->ifsc = $request->ifsc;
        $vendor->branch = $request->branch;
        $vendor->mob = $request->mob;
        $vendor->mail = $request->mail;
        $vendor->trade = $request->trade;
        $vendor->ven_date = $request->ven_date;

        $vendor->save();

        return redirect()->route('vendors.index')->with([
            'status' => 'success',
            'message' => 'Vendor updated successfully',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Vendor = Vendor::find($id);

        if ($Vendor) {
            $Vendor->delete();
            return redirect()->route('vendors.index')->with([
                'status' => 'success',
                'message' => 'vendors deleted successfully!'
            ]);
        } else {
            return redirect()->route('vendors.index')->with([
                'status' => 'error',
                'message' => 'vendors not found!'
            ]);
        }
    }

    public function vendorimport(Request $request)
    {

        $request->validate([
            'vendor_file' => 'required|mimes:xlsx,csv'
        ]);

        $vendor_file = $request->file('vendor_file');

        Excel::import(new VendorImport(), $vendor_file);

        return back()->with(['status' => 'success', 'message' => 'Vendor Imported  successfully']);
    }

    public function vendorexport()
    {
        return Excel::download(new VendorsExport(), 'vendors.xlsx');
    }
}
