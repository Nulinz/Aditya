<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



class EmpolyeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee=DB::table('users')->where('status',1)->get();

        return view('employee.list',['employee'=>$employee]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'emp_code' => 'required',
            'vemp_name' => 'required',
            'contactno' => 'required|unique:users,contactno',
            'emp_desg' => 'required',
            'alt_ph_no' => 'nullable',
            'emp_mail' => 'required',
            'b_grp' => 'nullable',
            'salary' => 'required',
            'experience' => 'required',
            'doj' => 'required',
            'password' => 'required',
            'ad1' => 'required',
            'ad2' => 'nullable',
            'city' => 'required',
            'district' => 'required',
            'state' => 'required',
            'pin' => 'required',
        ]);

        $user_id = auth()->user()->id;

        $user = new User();
        $user->emp_code = $request->emp_code;
        $user->vemp_name = $request->vemp_name;
        $user->contactno = $request->contactno;
        $user->emp_desg = $request->emp_desg;
        $user->alt_ph_no = $request->alt_ph_no;
        $user->emp_mail = $request->emp_mail;
        $user->b_grp = $request->b_grp;
        $user->salary = $request->salary;
        $user->experience = $request->experience;
        $user->doj = $request->doj;
        $user->password = Hash::make($request->password);
        $user->created_by = $user_id;

        $user->save();

        $lastUserId = $user->id;

        $address = new Address();
        $address->fid = $lastUserId;
        $address->cat = 'Emp';
        $address->ad1 = $request->ad1;
        $address->ad2 = $request->ad2;
        $address->city = $request->city;
        $address->district = $request->district;
        $address->state = $request->state;
        $address->pin = $request->pin;
        $address->created_by = $user_id;

        $address->save();

        return redirect()->route('employee.index')->with(['status' => 'success', 'message' => 'Employee Added successfully']);

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
        $employee = DB::table('users as a')
        ->leftJoin('addresses as b', 'a.id', '=', 'b.fid')
        ->select('a.*', 'b.cat','b.ad1','b.ad2','b.city','b.district','b.state','b.pin')
        ->first();



        return view('employee.edit',['employee'=>$employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{

    $user = User::find($id);

    if (!$user) {
        return redirect()->route('employee.index')->with([
            'status' => 'error',
            'message' => 'Employee not found!'
        ]);
    }

    $user->emp_code = $request->emp_code;
    $user->vemp_name = $request->vemp_name;
    $user->contactno = $request->contactno;
    $user->emp_desg = $request->emp_desg;
    $user->alt_ph_no = $request->alt_ph_no;
    $user->emp_mail = $request->emp_mail;
    $user->b_grp = $request->b_grp;
    $user->salary = $request->salary;
    $user->experience = $request->experience;
    $user->doj = $request->doj;


    $user->save();

    $address = Address::where('fid', $user->id)->first();

    if ($address) {
        $address->ad1 = $request->ad1;
        $address->ad2 = $request->ad2;
        $address->city = $request->city;
        $address->district = $request->district;
        $address->state = $request->state;
        $address->pin = $request->pin;

        $address->save();
    }

    return redirect()->route('employee.index')->with([
        'status' => 'success',
        'message' => 'Employee updated successfully'
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = User::find($id);

        if ($employee) {
            $address = Address::where('fid', $employee->id)->first();
            if ($address) {
                $address->delete();
            }

            $employee->delete();

            return redirect()->route('employee.index')->with([
                'status' => 'success',
                'message' => 'Employee and their address deleted successfully!'
            ]);
        } else {
            return redirect()->route('employee.index')->with([
                'status' => 'error',
                'message' => 'Employee not found!'
            ]);
        }
    }

}
