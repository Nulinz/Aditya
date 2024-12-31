<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeveloperAuthController extends Controller
{
    public function developer_login(Request $request)
    {
        $user_id = $request->user_id;

        $user = User::where('id', $user_id)->first();

        if ($user) {
            if ($user->status !== '0') {
                Auth::login($user);

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
