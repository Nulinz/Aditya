<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();


        $user = User::find($auth->id);

        return view('settings',['user'=>$user]);
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
        //
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
    public function update(Request $request)
    {
        $vemp_name = $request->vemp_name;
        $emp_mail = $request->emp_mail;
        $password = $request->password;
        $contactno=$request->contactno;

        $user = User::where('contactno', $contactno)->first();
        if ($user) {
            if ($password) {
                if (Hash::check($password, $user->password)){
                    return redirect()->route('dashboard')->with
                    (['status' => 'error', 'message' => 'You Entered old password']);
                }
            }
            $user->vemp_name = $vemp_name;
            $user->emp_mail = $emp_mail;
            $user->contactno = $contactno;
            if($password) {
                $user->password = Hash::make($password);
            }
            $user->save();

            return redirect()->route('dashboard')-> with
            (['status' => 'success', 'message' => 'Profile Updated Successfully']);

        }

        return redirect()->route('dashboard')->with(['status' => 'error', 'message' => 'Unauthroized profile']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
