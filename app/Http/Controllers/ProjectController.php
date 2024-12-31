<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Value;
use App\Models\Boq;
use App\Models\Address;
use App\Models\ProjectTeam;
use App\Models\ProjectSale;
use App\Models\Hire;
use App\Models\PettyCash;
use App\Models\Petty;
use App\Models\Purchase;
use App\Models\Lab;
use App\Models\HeadExpense;
use App\Models\ScBill;
use App\Models\ApproveReq;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Imports\BoqImport;
use App\Exports\BoqExport;
use App\Imports\ProcessZeroImport;
use App\Exports\ProcessZeroExport;
use App\Imports\HireImport;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->emp_desg == 'Admin') {

            $project = Project::where('status',1)
                               ->orderBy('id', 'asc')
                               ->get();

        } else {

            $proIds = ProjectTeam::where('mb_id', $user->id)
                             ->where('status',1)
                             ->pluck('pro_id');

            $project = Project::whereIn('id', $proIds)
                               ->where('status', 1)
                               ->orderBy('id', 'asc')
                               ->get();
        }


        return view('projects.list',['project'=>$project]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $validatedData = $request->validate([
            'pro_code' => 'required|string',
            'pro_title' => 'required|string',
            'bul_type' => 'required|string',
            'tlt_area' => 'required|numeric',
            'pro_cost' => 'required|numeric',
            'remarks' => 'nullable|string',
            'ad1' => 'required|string',
            'ad2' => 'nullable|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'state' => 'required|string',
            'pin' => 'required|numeric|digits:6',
        ]);

        $project = new Project();
        $project->pro_code = $request->pro_code;
        $project->pro_title = $request->pro_title;
        $project->bul_type = $request->bul_type;
        $project->tlt_area = $request->tlt_area;
        $project->pro_cost = $request->pro_cost;
        $project->remarks = $request->remarks;
        $project->created_by = $user_id;

        $project->save();

        $lastProjectId = $project->id;

        $address = new Address();
        $address->fid = $lastProjectId;
        $address->cat = 'Project';
        $address->ad1 = $request->ad1;
        $address->ad2 = $request->ad2;
        $address->city = $request->city;
        $address->district = $request->district;
        $address->state = $request->state;
        $address->pin = $request->pin;
        $address->created_by = $user_id;

        $address->save();

        return redirect()->route('projects.index')->with(['status' => 'success', 'message' => 'Project Added successfully']);


    }

    public function showProfile($id)
    {
        $project = Project::findOrFail($id);

        return view('projects.project_profile',['project'=>$project]);
    }

    public function edit($id)
    {
        $project = DB::table('projects')
        ->leftJoin('addresses', 'projects.id', '=', 'addresses.fid')
        ->where('addresses.cat', 'Project')
        ->where('projects.id', $id)
        ->select('projects.*', 'addresses.*')
        ->first();


        return view('projects.edit', ['project' => $project]);
    }



    // public function loadTabContent(Request $request)
    // {
    //     $tab = $request->input('tab');
    //     $projectId = $request->input('project_id');

    //     if (!$tab || !$projectId) {
    //         return response()->json(['error' => 'Invalid request'], 400);
    //     }

    //     $viewMap = [
    //         'overview' => 'projects.overview',
    //         'boq' => 'projects.boq',
    //         'pro_sale' => 'projects.pro_sale',
    //         'hire' => 'projects.hire',
    //         'petty' => 'projects.petty',
    //         'addpetty' => 'projects.add_petty',
    //         'boq_pur' => 'projects.boq_pur',
    //         'boq_lab' => 'projects.boq_lab',
    //         'headexpense' => 'projects.head_expense',
    //         'ateam' => 'projects.assign_team',
    //         'scbill' => 'projects.sc_bill',
    //         'rateapproval' => 'projects.rate_approval',
    //         'report' => 'projects.report',
    //     ];


    //     if (!array_key_exists($tab, $viewMap)) {
    //         return response()->json(['error' => 'Tab content not found'], 404);
    //     }

    //     $html = view($viewMap[$tab], ['projectId' => $projectId])->render();

    //     return response()->json(['html' => $html]);
    // }

    public function loadTabContent(Request $request)
    {
        $tab = $request->input('tab');
        $projectId = $request->input('project_id');

        if (!$tab || !$projectId) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $user = Auth::user();

        $allTabs = [
            'overview' => 'projects.overview',
            'boq' => 'projects.boq',
            'pro_sale' => 'projects.pro_sale',
            'hire' => 'projects.hire',
            'petty' => 'projects.petty',
            'addpetty' => 'projects.add_petty',
            'boq_pur' => 'projects.boq_pur',
            'boq_lab' => 'projects.boq_lab',
            'headexpense' => 'projects.head_expense',
            'ateam' => 'projects.assign_team',
            'scbill' => 'projects.sc_bill',
            'rateapproval' => 'projects.rate_approval',
            'report' => 'projects.report',
        ];

        $limitedTabs = [
            'petty' => 'projects.petty',
            'addpetty' => 'projects.add_petty',
            'scbill' => 'projects.sc_bill',
        ];

        if ($user->emp_desg === 'Admin') {
            $viewMap = $allTabs;
        } else {
            $viewMap = $limitedTabs;
        }

        if (!array_key_exists($tab, $viewMap)) {
            return response()->json(['error' => 'Tab content not found or access denied'], 404);
        }

        $html = view($viewMap[$tab], ['projectId' => $projectId])->render();

        return response()->json(['html' => $html]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**

     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{


    $project = Project::findOrFail($id);
    $project->pro_code = $request->pro_code;
    $project->pro_title = $request->pro_title;
    $project->bul_type = $request->bul_type;
    $project->tlt_area = $request->tlt_area;
    $project->pro_cost = $request->pro_cost;
    $project->remarks = $request->remarks;
    $project->save();

    $address = Address::where('fid', $id)->where('cat', 'Project')->first();
    $address->ad1 = $request->ad1;
    $address->ad2 = $request->ad2;
    $address->city = $request->city;
    $address->district = $request->district;
    $address->state = $request->state;
    $address->pin = $request->pin;
    $address->save();

    return redirect()->back()->with(['status' => 'success', 'message' => 'Project updated successfully']);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function updateAssetValue(Request $request)
    {
        $request->validate([
            'pro_id' => 'required|integer',
            'value' => 'required|numeric|min:0',
        ]);

        $asset = Value::where('pro_id', $request->pro_id)->first();

        if ($asset) {
            $asset->value = $request->value;
        } else {
            $asset = new Value();
            $asset->pro_id = $request->pro_id;
            $asset->value = $request->value;
        }

        $asset->save();

        return back()->with(['status' => 'success', 'message' => 'Value updated successfully.']);
    }


    public function boq_store(Request $request)
    {

        $request->validate([
            'pro_id' => 'required',
            'code' => 'required',
            'des' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'qty' => 'required',
            'boq_rate' => 'required',
            'zero_rate' => 'required',
            'boq_amount' => 'required',
            'zero_amount' => 'required',
            'remarks' => 'required',
        ]);

        $user_id = auth()->user()->id;

        $data = new Boq();
        $data->pro_id = $request->pro_id;
        $data->code = $request->code;
        $data->des = $request->des;
        $data->description = $request->description;
        $data->unit = $request->unit;
        $data->qty = $request->qty;
        $data->boq_rate = $request->boq_rate;
        $data->zero_rate = $request->zero_rate;
        $data->boq_amount = $request->boq_amount;
        $data->zero_amount = $request->zero_amount;
        $data->remarks = $request->remarks;
        $data->created_by = $user_id;

        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'BOQ saved successfully!'
        ]);
    }

    public function boqedit($id)
    {
        $boq=DB::table('boqs')->where('id', $id)->first();

        $unit=DB::table('units')->select('id','unit')->where('status',1)->get();

        return view('projects.boqedit',['boq'=>$boq,'unit'=>$unit]);

    }

    public function boqupdate(Request $request, string $id)
    {
        $data = Boq::findOrFail($id);
        $data->code = $request->code;
        $data->des = $request->des;
        $data->description = $request->description;
        $data->unit = $request->unit;
        $data->qty = $request->qty;
        $data->boq_rate = $request->boq_rate;
        $data->zero_rate = $request->zero_rate;
        $data->boq_amount = $request->boq_amount;
        $data->zero_amount = $request->zero_amount;
        $data->remarks = $request->remarks;

        $data->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'BOQ Updated successfully']);

    }

    public function boqdelete(string $id)
    {
        $boq = Boq::find($id);

        if ($boq) {
            $boq->delete();
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'BOQ deleted successfully!'
            ]);
        } else {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'BOQ not found!'
            ]);
        }
    }

    public function process_sales_store(Request $request)
    {
        $request->validate([
            'pro_date'=>'required',
            'pro_id' => 'required',
            'code' => 'required',
            'des' => 'required',
            'work' => 'required',
            'unit' => 'required',
            'qty' => 'required',
            'pro_sale_rate' => 'required',
            'pro_sale_amt' => 'required',
            'pro_zero_rate' => 'required',
            'pro_zero_amt' => 'required',
            'remarks' => 'required',
        ]);

        $user_id = auth()->user()->id;

        $data = new ProjectSale();
        $data->pro_date = $request->pro_date;
        $data->pro_id = $request->pro_id;
        $data->code = $request->code;
        $data->des = $request->des;
        $data->work = $request->work;
        $data->unit = $request->unit;
        $data->qty = $request->qty;
        $data->pro_sale_rate = $request->pro_sale_rate;
        $data->pro_sale_amt = $request->pro_sale_amt;
        $data->pro_zero_rate = $request->pro_zero_rate;
        $data->pro_zero_amt = $request->pro_zero_amt;
        $data->remarks = $request->remarks;
        $data->created_by = $user_id;

        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'BOQ saved successfully!'
        ]);
    }

    public function process_sales_store_edit($id)
    {
        $project_sales=DB::table('project_sales')->where('id', $id)->first();

        $unit=DB::table('units')->select('id','unit')->where('status',1)->get();

        $boq=DB::table('boqs')->select('id','code','description','des')->where('status',1)->get();


        return view('projects.pro_sales_edit',['project_sales'=>$project_sales,'unit'=>$unit,'boq'=>$boq]);

    }

    public function process_sales_store_update(Request $request, string $id)
    {
        $data = ProjectSale::findOrFail($id);
        $data->pro_date = $request->pro_date;
        $data->code = $request->code;
        $data->des = $request->des;
        $data->work = $request->work;
        $data->unit = $request->unit;
        $data->qty = $request->qty;
        $data->pro_sale_rate = $request->pro_sale_rate;
        $data->pro_sale_amt = $request->pro_sale_amt;
        $data->pro_zero_rate = $request->pro_zero_rate;
        $data->pro_zero_amt = $request->pro_zero_amt;
        $data->remarks = $request->remarks;

        $data->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Project Sales Updated successfully']);

    }
    public function process_sales_store_delete(string $id)
    {
        $data = ProjectSale::find($id);

        if ($data) {
            $data->delete();
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Project Sales deleted successfully!'
            ]);
        } else {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Project Sales not found!'
            ]);
        }
    }

    public function hire_store(Request $request)
    {
        $request->validate([
            'hire_date'=>'required',
            'pro_id' => 'required',
            'code' => 'required',
            'bill' => 'required',
            'con_name' => 'required',
            'des' => 'required',
            'a_code' => 'required',
            'type' => 'required',
            'unit' => 'required',
            'qty' => 'required',
            'u_rate' => 'required',
            'amount' => 'required',
            'gst' => 'required',
            'gross' => 'required',
            'remark' => 'required',
        ]);

        $user_id = auth()->user()->id;

        $data = new Hire();
        $data->pro_id = $request->pro_id;
        $data->code = $request->code;
        $data->bill = $request->bill;
        $data->con_name = $request->con_name;
        $data->des = $request->des;
        $data->a_code = $request->a_code;
        $data->type = $request->type;
        $data->unit = $request->unit;
        $data->qty = $request->qty;
        $data->u_rate = $request->u_rate;
        $data->amount = $request->amount;
        $data->gst = $request->gst;
        $data->gross = $request->gross;
        $data->remark = $request->remark;
        $data->hire_date = $request->hire_date;
        $data->created_by = $user_id;

        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Hire saved successfully!'
        ]);
    }

    public function hire_edit($id)
    {
        $hires=DB::table('hires')->where('id', $id)->first();

        $unit=DB::table('units')->select('id','unit')->where('status',1)->get();

        $boq=DB::table('boqs')->select('id','code','des')->where('status',1)->get();

        $vendors=DB::table('vendors')->select('id','v_name','type')->where('type', 'contractor')->where('status',1)->get();

        $assets=DB::table('asset_codes')->select('id','des','asset_code')->where('status',1)->get();


        return view('projects.hires_edit',['hires'=>$hires,'unit'=>$unit,'boq'=>$boq,'vendors'=>$vendors,'assets'=>$assets]);

    }

    public function hire_update(Request $request, string $id)
    {
        $data = Hire::findOrFail($id);
        $data->code = $request->code;
        $data->bill = $request->bill;
        $data->con_name = $request->con_name;
        $data->des = $request->des;
        $data->a_code = $request->a_code;
        $data->type = $request->type;
        $data->unit = $request->unit;
        $data->qty = $request->qty;
        $data->u_rate = $request->u_rate;
        $data->amount = $request->amount;
        $data->gst = $request->gst;
        $data->gross = $request->gross;
        $data->remark = $request->remark;
        $data->hire_date = $request->hire_date;

        $data->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Hires Updated successfully']);

    }
    public function hire_delete(string $id)
    {
        $data = Hire::find($id);

        if ($data) {
            $data->delete();
            return redirect()->back()->with([
                'status' => 'success',
                'message' => 'Hire deleted successfully!'
            ]);
        } else {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Hire not found!'
            ]);
        }
    }

    public function prettystore(Request $request)
    {
        $request->validate([
            'pro_id' => 'required',
            'date' => 'required',
            'v_no' => 'required',
            'code' => 'required',
            'des' => 'required',
            'v_name'=>'required',
            'unit' => 'required',
            'qty' => 'required',
            'rate' => 'required',
            'amount' => 'required',
            'remark' => 'required',
            'in_img1' => 'required|file|mimes:jpg,jpeg,png|max:2048',

        ]);

        $user_id = auth()->user()->id;

        $pettyCash = new Petty();
        $pettyCash->pro_id = $request->pro_id;
        $pettyCash->date = $request->date;
        $pettyCash->v_no = $request->v_no;
        $pettyCash->code = $request->code;
        $pettyCash->v_name = $request->v_name;
        $pettyCash->des = $request->des;
        $pettyCash->unit = $request->unit;
        $pettyCash->qty = $request->qty;
        $pettyCash->rate = $request->rate;
        $pettyCash->amount = $request->amount;
        $pettyCash->open_blnc = $request->open_blnc;
        $pettyCash->remark = $request->remark;
        $pettyCash->created_by = $user_id;


        if ($request->hasFile('in_img1')) {
            $file = $request->file('in_img1');
            $name = date('y') . '-' . Str::upper(Str::random(8)) . '.' . $file->getClientOriginalExtension();
            $path = 'assets/images/Petty Cash/';
            $file->move($path, $name);
            $pettyCash->in_img1 = $path . $name;
        }

        $pettyCash->save();

        return response()->json([
            'success' => true,
            'message' => 'Petty Cash saved successfully.'
        ]);
    }



    public function prettyedit($id)
    {
        $petty = Petty::findOrFail($id);

        $boqs = DB::table('boqs')->where('status', 1)->get();

        $vendors = DB::table('vendors')->where('status', 1)->get();

        $units = DB::table('units')->where('status', 1)->get();

        return view('projects.petty_edit',['petty'=>$petty,'boqs'=>$boqs,'vendors'=>$vendors,'units'=>$units]);
    }

    public function prettyupdate(Request $request, $id)
    {
        $pettyCash = Petty::findOrFail($id);
        $pettyCash->date = $request->date;
        $pettyCash->v_no = $request->v_no;
        $pettyCash->code = $request->code;
        $pettyCash->v_name = $request->v_name;
        $pettyCash->des = $request->des;
        $pettyCash->unit = $request->unit;
        $pettyCash->qty = $request->qty;
        $pettyCash->rate = $request->rate;
        $pettyCash->amount = $request->amount;
        $pettyCash->open_blnc = $request->open_blnc;
        $pettyCash->remark = $request->remark;

        if ($request->hasFile('in_img1')) {
            $file = $request->file('in_img1');
            $name = date('y') . '-' . Str::upper(Str::random(8)) . '.' . $file->getClientOriginalExtension();
            $path = 'assets/images/Petty Cash/';
            $file->move($path, $name);
            $pettyCash->in_img1 = $path . $name;
        }

        $pettyCash->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Petty Updated successfully']);
    }

    public function prettydestroy($id)
    {
        $pettyCash = Petty::findOrFail($id);
        $pettyCash->delete();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Petty Deleted successfully']);
    }

    public function addprettycashstore(Request $request)
    {
        $request->validate([
            'pro_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'emp_id' => 'required',
        ]);

        $user_id = auth()->user()->id;

        $pettyCash = new PettyCash();
        $pettyCash->pro_id = $request->pro_id;
        $pettyCash->date = $request->date;
        $pettyCash->amount = $request->amount;
        $pettyCash->emp_id = $request->emp_id;
        $pettyCash->created_by = $user_id;


        $pettyCash->save();

        return response()->json([
            'success' => true,
            'message' => 'Petty Cash saved successfully.'
        ]);
    }

    public function petty_edit($id)
    {
        $petty = PettyCash::findOrFail($id);

        $employee = DB::table('users')->where('status', 1)->get();


        return view('projects.petty_cash_edit',['petty'=>$petty,'employee'=>$employee]);
    }

    public function petty_update(Request $request, $id)
    {
        $pettyCash = PettyCash::findOrFail($id);
        $pettyCash->date = $request->date;
        $pettyCash->amount = $request->amount;
        $pettyCash->emp_id = $request->emp_id;

        $pettyCash->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'PettyCash Updated successfully']);
    }

    public function petty_delete($id)
    {
        $pettyCash = PettyCash::findOrFail($id);
        $pettyCash->delete();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Petty Deleted successfully']);
    }

    public function boq_purchase(Request $request)
    {
        $request->validate([
            'pro_id' => 'required',
            'pur_date' => 'required',
            'pur_bill' => 'required',
            'code' => 'required',
            'item_code' => 'required',
            'ven_name'=>'required',
            'material' => 'required',
            'uom' => 'required',
            'qty' => 'required',
            'b_rate' => 'required',
            'amount' => 'required',
            'gst'=>'required',
            'gross' => 'required',
            'remarks' => 'required'
        ]);

        $user_id = auth()->user()->id;

        $purchase = new Purchase();
        $purchase->pro_id = $request->pro_id;
        $purchase->pur_date = $request->pur_date;
        $purchase->pur_bill = $request->pur_bill;
        $purchase->code = $request->code;
        $purchase->item_code = $request->item_code;
        $purchase->ven_name = $request->ven_name;
        $purchase->material = $request->material;
        $purchase->uom = $request->uom;
        $purchase->qty = $request->qty;
        $purchase->b_rate = $request->b_rate;
        $purchase->amount = $request->amount;
        $purchase->gst = $request->gst;
        $purchase->gross = $request->gross;
        $purchase->remarks = $request->remarks;
        $purchase->created_by = $user_id;

        $purchase->save();

        return response()->json([
            'success' => true,
            'message' => 'BOQ Purchase  saved successfully.'
        ]);
    }

    public function boq_pur_edit($id)
    {
        $purchase = Purchase::findOrFail($id);

        $boqs = DB::table('boqs')->where('status', 1)->get();

        $vendor = DB::table('vendors')->where('type','contractor')->where('status', 1)->get();

        $materials = DB::table('materials')->where('status', 1)->get();

        $units = DB::table('units')->where('status', 1)->get();


        return view('projects.boq_purchase_edit',['purchase'=>$purchase,'boqs'=>$boqs,'vendor'=>$vendor,'materials'=>$materials,'units'=>$units]);
    }

    public function boq_pur_update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->pur_date = $request->pur_date;
        $purchase->pur_bill = $request->pur_bill;
        $purchase->code = $request->code;
        $purchase->item_code = $request->item_code;
        $purchase->ven_name = $request->ven_name;
        $purchase->material = $request->material;
        $purchase->uom = $request->uom;
        $purchase->qty = $request->qty;
        $purchase->b_rate = $request->b_rate;
        $purchase->amount = $request->amount;
        $purchase->gst = $request->gst;
        $purchase->gross = $request->gross;
        $purchase->remarks = $request->remarks;

        $purchase->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Purchase Updated successfully']);
    }

    public function boq_pur_delete($id)
    {
        $pettyCash = Purchase::findOrFail($id);

        $pettyCash->delete();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Petty Deleted successfully']);
    }


    public function boq_labour(Request $request)
    {
        $request->validate([
            'pro_id' => 'required',
            'lab_date' => 'required',
            'code' => 'required',
            'des' => 'required',
            'v_name'=>'required',
            'uom' => 'required',
            'qty' => 'required',
            'b_rate' => 'required',
            'amount' => 'required',
            'gst'=>'required',
            'gross' => 'required',
            'remark' => 'required'
        ]);

        $user_id = auth()->user()->id;

        $labour = new Lab();
        $labour->pro_id = $request->pro_id;
        $labour->lab_date = $request->lab_date;
        $labour->code = $request->code;
        $labour->des = $request->des;
        $labour->v_name = $request->v_name;
        $labour->uom = $request->uom;
        $labour->qty = $request->qty;
        $labour->b_rate = $request->b_rate;
        $labour->amount = $request->amount;
        $labour->gst = $request->gst;
        $labour->gross = $request->gross;
        $labour->remark = $request->remark;
        $labour->created_by = $user_id;

        $labour->save();

        return response()->json([
            'success' => true,
            'message' => 'BOQ Labour  saved successfully.'
        ]);
    }

    public function boq_lab_edit($id)
    {
        $labour = Lab::findOrFail($id);

        $boqs = DB::table('boqs')->where('status', 1)->get();

        $vendor = DB::table('vendors')->where('type','contractor')->where('status', 1)->get();

        $units = DB::table('units')->where('status', 1)->get();


        return view('projects.boq_lab_edit',['labour'=>$labour,'boqs'=>$boqs,'vendor'=>$vendor,'units'=>$units]);
    }

    public function boq_lab_update(Request $request, $id)
    {
        $labour = Lab::findOrFail($id);
        $labour->lab_date = $request->lab_date;
        $labour->code = $request->code;
        $labour->des = $request->des;
        $labour->v_name = $request->v_name;
        $labour->uom = $request->uom;
        $labour->qty = $request->qty;
        $labour->b_rate = $request->b_rate;
        $labour->amount = $request->amount;
        $labour->gst = $request->gst;
        $labour->gross = $request->gross;
        $labour->remark = $request->remark;

        $labour->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'BOQ Labour Updated successfully']);
    }

    public function boq_lab_delete($id)
    {
        $labour = Lab::findOrFail($id);

        $labour->delete();

        return redirect()->back()->with(['status' => 'success', 'message' => 'BOQ Labour Deleted successfully']);
    }

    public function head_expense(Request $request)
    {
        $request->validate([
            'pro_id' => 'required',
            'boq_code' => 'required',
            'des' => 'required',
            'v_name' => 'required',
            'uom' => 'required',
            'qty'=>'required',
            'rate' => 'required',
            'amt' => 'required',
            'gst' => 'required',
            'gross' => 'required',
            'remark'=>'required',
            'head_date' => 'required',
        ]);

        $user_id = auth()->user()->id;

        $head_expenses = new HeadExpense();
        $head_expenses->pro_id = $request->pro_id;
        $head_expenses->head_date = $request->head_date;
        $head_expenses->boq_code = $request->boq_code;
        $head_expenses->des = $request->des;
        $head_expenses->v_name = $request->v_name;
        $head_expenses->uom = $request->uom;
        $head_expenses->qty = $request->qty;
        $head_expenses->rate = $request->rate;
        $head_expenses->amt = $request->amt;
        $head_expenses->gst = $request->gst;
        $head_expenses->gross = $request->gross;
        $head_expenses->remark = $request->remark;
        $head_expenses->created_by = $user_id;

        $head_expenses->save();

        return response()->json([
            'success' => true,
            'message' => 'Over Head  saved successfully.'
        ]);
    }

    public function head_expense_edit($id)
    {
        $expenses = HeadExpense::findOrFail($id);

        $headcode=DB::table('overheads')->where('status',1)->get();

        $vendor = DB::table('vendors')->where('status', 1)->get();

        $units = DB::table('units')->where('status', 1)->get();

        return view('projects.head_expense_edit',['expenses'=>$expenses,'headcode'=>$headcode,'vendor'=>$vendor,'units'=>$units]);
    }

    public function head_expense_update(Request $request, $id)
    {
        $head_expenses = HeadExpense::findOrFail($id);
        $head_expenses->head_date = $request->head_date;
        $head_expenses->boq_code = $request->boq_code;
        $head_expenses->des = $request->des;
        $head_expenses->v_name = $request->v_name;
        $head_expenses->uom = $request->uom;
        $head_expenses->qty = $request->qty;
        $head_expenses->rate = $request->rate;
        $head_expenses->amt = $request->amt;
        $head_expenses->gst = $request->gst;
        $head_expenses->gross = $request->gross;
        $head_expenses->remark = $request->remark;

        $head_expenses->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Head Expenses Updated successfully']);
    }

    public function head_expense_delete($id)
    {
        $head_expenses = HeadExpense::findOrFail($id);

        $head_expenses->delete();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Head Expenses Deleted successfully']);
    }

    public function assgin_team(Request $request)
    {
        $request->validate([
            'pro_id' => 'required',
            'mb_id' => 'required',
            'desg' => 'required',
            'emp_access' => 'required',
            'assign_date' => 'required',

        ]);

        $user_id = auth()->user()->id;

        $assign_team = new ProjectTeam();
        $assign_team->pro_id = $request->pro_id;
        $assign_team->mb_id = $request->mb_id;
        $assign_team->desg = $request->desg;
        $assign_team->emp_access = $request->emp_access;
        $assign_team->assign_date = $request->assign_date;
        $assign_team->created_by = $user_id;

        $assign_team->save();

        return response()->json([
            'success' => true,
            'message' => 'Assgin Team  saved successfully.'
        ]);
    }

    public function assgin_team_edit($id)
    {
        $assign_team = ProjectTeam::findOrFail($id);

        $employee = DB::table('users')->where('status', 1)->get();

        $desgination=DB::table('destinations')->where('status',1)->get();


        return view('projects.assgin_team_edit',['assign_team'=>$assign_team,'employee'=>$employee,'desgination'=>$desgination]);
    }

    public function assgin_team_update(Request $request, $id)
    {
        $assign_team = ProjectTeam::findOrFail($id);
        $assign_team->mb_id = $request->mb_id;
        $assign_team->desg = $request->desg;
        $assign_team->emp_access = $request->emp_access;
        $assign_team->assign_date = $request->assign_date;

        $assign_team->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Assgin Team Updated successfully']);
    }

    public function assgin_team_delete($id)
    {
        $assign_team = ProjectTeam::findOrFail($id);

        $assign_team->delete();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Assgin Team Deleted successfully']);
    }

    public function sc_bill(Request $request)
    {

        // $check_user_permissions = DB::table('project_teams')
        // ->leftJoin('users', 'project_teams.mb_id', '=', 'users.id')
        // ->where('project_teams.pro_id', $request->pro_id)
        // ->where('project_teams.status', 1)
        // ->select('project_teams.*', 'users.emp_desg')
        // ->get();

        $user_id = auth()->user()->id;

        $sc_bill = new ScBill();
        $sc_bill->pro_id = $request->pro_id;
        $sc_bill->sc_date = $request->sc_date;
        $sc_bill->boq_code = $request->boq_code;
        $sc_bill->sub_code = $request->sub_code;
        $sc_bill->des = $request->des;
        $sc_bill->v_name = $request->v_name;
        $sc_bill->unit = $request->unit;
        $sc_bill->qty = $request->qty;
        $sc_bill->rate = $request->rate;
        $sc_bill->amount = $request->amount;
        $sc_bill->remarks = $request->remarks;
        $sc_bill->remarks = $request->remarks;
        $sc_bill->created_by = $user_id;

        if ($request->hasFile('sc_file')) {
            $file = $request->file('sc_file');
            $name = date('y') . '-' . Str::upper(Str::random(8)) . '.' . $file->getClientOriginalExtension();
            $path = 'assets/images/Sc Bill/';
            $file->move($path, $name);
            $sc_bill->sc_file = $path . $name;
        }

        $sc_bill->save();

        return response()->json([
            'success' => true,
            'message' => 'SC saved successfully.'
        ]);
    }

    public function sc_bill_edit($id)
    {
        $sc_bill = ScBill::findOrFail($id);

        $units = DB::table('units')->where('status', 1)->get();

        $vendor = DB::table('vendors')->where('status', 1)->get();

        $division = DB::table('divisions')
                    ->leftJoin('boqs', 'divisions.boq', '=', 'boqs.id')
                    ->where('divisions.status', 1)
                    ->select(
                        'divisions.*',
                        'boqs.code as boq_code')
                    ->get();


        return view('projects.scbill_edit',['sc_bill'=>$sc_bill,'units'=>$units,'vendor'=>$vendor,'division'=>$division]);
    }

    public function sc_bill_update(Request $request, $id)
    {
        $sc_bill = ScBill::findOrFail($id);
        $sc_bill->sc_date = $request->sc_date;
        $sc_bill->boq_code = $request->boq_code;
        $sc_bill->sub_code = $request->sub_code;
        $sc_bill->des = $request->des;
        $sc_bill->v_name = $request->v_name;
        $sc_bill->unit = $request->unit;
        $sc_bill->qty = $request->qty;
        $sc_bill->rate = $request->rate;
        $sc_bill->amount = $request->amount;
        $sc_bill->remarks = $request->remarks;
        $sc_bill->remarks = $request->remarks;

        if ($request->hasFile('sc_file')) {
            $file = $request->file('sc_file');
            $name = date('y') . '-' . Str::upper(Str::random(8)) . '.' . $file->getClientOriginalExtension();
            $path = 'assets/images/Sc Bill/';
            $file->move($path, $name);
            $sc_bill->sc_file = $path . $name;
        }

        $sc_bill->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'SC Bill Updated successfully']);
    }

    public function sc_bill_delete($id)
    {
        $sc_bill = ScBill::findOrFail($id);

        $sc_bill->delete();

        return redirect()->back()->with(['status' => 'success', 'message' => 'SC Bill Deleted successfully']);
    }

    public function getBoqDetails(Request $request)
    {
        $boqId = $request->boq_id;

        $result = DB::table('divisions')
            ->join('boqs', 'divisions.boq', '=', 'boqs.id')
            ->where('divisions.boq', $boqId)
            ->select('boqs.des', 'divisions.id','divisions.sub_code')
            ->first();

        if ($result) {
            return response()->json([
                'des' => $result->des,
                'sub_code' => $result->sub_code,
                'id'=>$result->id
            ]);
        } else {
            return response()->json([
                'des' => 'No description found',
                'sub_code' => 'No sub_code found'
            ]);
        }
    }

    public function rate_approval_store(Request $request)
    {
        $request->validate([
            'pro_id' => 'required',
            'boq_code' => 'required',
            'rate_date' => 'required',
            'sub_code' => 'required',
            'unit' => 'required',
            'mh_rate' => 'required',
            'unit_rate'=>'required',
            'tlt_rate' => 'required',
            'rcm_rate' => 'required',
            'cont_profit' => 'required',
            'remarks'=>'required',
        ]);
        $user_id = auth()->user()->id;

        $sc_bill = new ApproveReq();
        $sc_bill->pro_id = $request->pro_id;
        $sc_bill->rate_date = $request->rate_date;
        $sc_bill->boq_code = $request->boq_code;
        $sc_bill->sub_code = $request->sub_code;
        $sc_bill->unit = $request->unit;
        $sc_bill->mh_rate = $request->mh_rate;
        $sc_bill->unit_rate = $request->unit_rate;
        $sc_bill->tlt_rate = $request->tlt_rate;
        $sc_bill->rcm_rate = $request->rcm_rate;
        $sc_bill->cont_profit = $request->cont_profit;
        $sc_bill->remarks = $request->remarks;
        $sc_bill->created_by = $user_id;

        $sc_bill->save();

        return response()->json([
            'success' => true,
            'message' => 'Rate Approval saved successfully.'
        ]);
    }

    public function rate_approval_edit($id)
    {

        $rate_approval = ApproveReq::findOrFail($id);

        $boqs = DB::table('boqs')->where('status', 1)->get();


        $sub_code = DB::table('divisions')->where('status', 1)->get();


        $units = DB::table('units')->where('status', 1)->get();


        return view('projects.approval_edit',['boqs'=>$boqs,'sub_code'=>$sub_code,'units'=>$units,'rate_approval'=>$rate_approval]);
    }

    public function rate_approval_update(Request $request, $id)
    {
        $sc_bill = ApproveReq::findOrFail($id);
        $sc_bill->rate_date = $request->rate_date;
        $sc_bill->boq_code = $request->boq_code;
        $sc_bill->sub_code = $request->sub_code;
        $sc_bill->unit = $request->unit;
        $sc_bill->mh_rate = $request->mh_rate;
        $sc_bill->unit_rate = $request->unit_rate;
        $sc_bill->tlt_rate = $request->tlt_rate;
        $sc_bill->rcm_rate = $request->rcm_rate;
        $sc_bill->cont_profit = $request->cont_profit;
        $sc_bill->remarks = $request->remarks;

        $sc_bill->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Rate Approval Updated successfully']);
    }

    public function rate_approval_delete($id)
    {
        $sc_bill = ApproveReq::findOrFail($id);

        $sc_bill->delete();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Rate Approval Deleted successfully']);
    }


    public function boqimport(Request $request)
    {

        $request->validate([
            'boq_file' => 'required|mimes:xlsx,csv'
        ]);

        $boq_file = $request->file('boq_file');
        $proId = $request->input('pro_id');

        Excel::import(new BoqImport($proId), $boq_file);

        return back()->with(['status' => 'success', 'message' => 'Boq Imported  successfully']);
    }

    public function export($projectId)
    {
        return Excel::download(new BoqExport($projectId), 'boq_data.xlsx');
    }

    public function processimport(Request $request)
    {

        $request->validate([
            'process_file' => 'required|mimes:xlsx,csv'
        ]);

        $process_file = $request->file('process_file');
        $proId = $request->input('pro_id');

        Excel::import(new ProcessZeroImport($proId), $process_file);

        return back()->with(['status' => 'success', 'message' => 'Process Sales Imported  successfully']);
    }

    public function processexport($projectId)
    {
        return Excel::download(new ProcessZeroExport($projectId), 'Processsales_data.xlsx');
    }



    public function hireimport(Request $request)
    {
        try {

            $request->validate([
                'hire_file' => 'required|mimes:xlsx,xls,csv|max:2048',
            ]);

            $proId = $request->input('pro_id');

            $import = new HireImport($proId);

            Excel::import($import, $request->file('hire_file'));

            $errors = $import->getErrors();

            if (count($errors) > 0) {
                return back()->with(['status' => 'error', 'message' => 'Need to Insert a Vendors or Asset Code Masters', 'errors' => $errors]);
            }

            // If everything is successful
            return back()->with(['status' => 'success', 'message' => 'Hire data imported successfully.']);

        } catch (\Exception $e) {
            return back()->with(['status' => 'error', 'message' => 'There was an error processing the import. Please check the logs.']);
        }
    }


    public function hireexport($projectId)
    {
        return Excel::download(new ProcessZeroExport($projectId), 'Processsales_data.xlsx');
    }

}
