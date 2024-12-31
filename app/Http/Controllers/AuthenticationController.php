<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthenticationController extends Controller
{
    public function login (Request $request)
    {
        $request->validate([
            'contactno' => 'required',
            'password' => 'required',

        ]);

        $contactno = $request->contactno;
        $password = $request->password;

        $user = User::where('contactno', $contactno)->first();

        if ($user) {
                if (Auth::attempt(['contactno' => $contactno, 'password' => $password])) {

                    // session(['user_id' => Auth::id(), 'user_name' => Auth::user()->vemp_name]);


                    return redirect()->route('dashboard')->with(['status' => 'success', 'message' => 'welcome' . Auth::user()->vemp_name]);
                }

            return redirect()->route('login')->with(['status' => 'error', 'message' => 'Invalid Password']);

            return redirect()->route('login')->with(['status' => 'error', 'message' => 'Your Account has Suspended']);

        }

        return redirect()->route('login')->with(['status' => 'error', 'message' => 'Invalid Contact No']);
    }

    public function logout()
    {
        $user = Auth::logout();

        session()->flush();

        return redirect()->route('login')->with(['status' => 'success', 'message' => 'Successfully Logout']);
    }

    public function developer_login(Request $request)
    {
        $user_id = $request->user_id;

        $user = User::where('id', $user_id)->first();

        if ($user) {
            if ($user->status !== '0') {
                Auth::login($user);

                session(['user_id' => Auth::id(), 'user_name' => Auth::user()->vemp_name]);

                return redirect()->route('dashboard')->with([
                    'status' => 'success',
                    'message' => 'Welcome ' . Auth::user()->vemp_name,
                ]);
            }

            return redirect()->route('login')->with([
                'status' => 'error',
                'message' => 'Your account has been suspended',
            ]);
        }

        return redirect()->route('login')->with([
            'status' => 'error',
            'message' => 'Invalid User ID',
        ]);
    }



}
