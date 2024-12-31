<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class CompanyController extends Controller
{
    public function CreateDynamicDatabase($databaseName)
    {
        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($databaseName));
        $slug = trim($slug, '-');

        return $slug;
    }

    public function CreateCompany(Request $request)
    {
        $databaseName = $request->cmpname ? $request->cmpname : 'Sample testing database';
        $userName = $request->name ? $request->name : 'venky';
        $userNo = $request->contactno ? $request->contactno : '8667444193';
        $userEmail = $request->email ? $request->email : 'venky@gmail.com';
        $userPassword = $request->password ? $request->password : 'VenKeyPassword';

        $db_name = $this->CreateDynamicDatabase($databaseName);

        $existingCompany = Company::where('cmpname', $databaseName)->first();

        if(!$existingCompany){
            // $user = new User();
            // $user->name = $userName;
            // $user->email = $userEmail;
            // $user->contactno = $userNo;
            // $user->password = Hash::make($userPassword);
            // $user->save();

            $user = new User();
            $user->emp_code = 'EMP' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT); 
            $user->vemp_name = $userName; 
            $user->contactno = $userNo; 
            $user->emp_desg = 'Employee'; 
            $user->alt_ph_no = null; 
            $user->emp_mail = $userEmail; 
            $user->b_grp = 'N/A'; 
            $user->salary = 0;
            $user->experience = 0; 
            $user->doj = now(); 
            $user->password = Hash::make($userPassword); 
            // $user->company_id = $company->id; 
            $user->status = 1; 
            $user->created_by = Auth::id() ?? 1; 
            $user->save();

            $company = new Company();
            $company->cmpname = $databaseName;
            $company->name = $userName;
            $company->email = $userEmail;
            $company->contactno = $userNo;
            $company->database_name = $db_name;
            $company->user_id = $user->id;
            $company->save();

            $user = User::find($user->id);
            $user->company_id = $company->id;
            $user->save();

            Config::set('database.connections.dynamic_db.database',$db_name);
            DB::setDefaultConnection('dynamic_db');
            Artisan::call('migrate', [
                '--database' => 'dynamic_db',
                '--path' => 'database/migrations',
                '--force' => true,
            ]);

            // // Optionally, seed the database
            // Artisan::call('db:seed', [
            //     '--database' => 'dynamic_db',
            //     '--class' => 'Database\\Seeders\\DatabaseSeeder',
            //     '--force' => true,
            // ]);

            // $user = new User();
            // $user->name = $userName;
            // $user->email = $userEmail;
            // $user->contactno = $userNo;
            // $user->password = Hash::make($userPassword);
            // $user->company_id = $company->id;
            // $user->message = 'Im dynamic database';
            // $user->save();

            $user = new User();
            $user->emp_code = 'EMP' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT); 
            $user->vemp_name = $userName; 
            $user->contactno = $userNo; 
            $user->emp_desg = 'Employee'; 
            $user->alt_ph_no = null; 
            $user->emp_mail = $userEmail; 
            $user->b_grp = 'N/A'; 
            $user->salary = 0;
            $user->experience = 0; 
            $user->doj = now(); 
            $user->password = Hash::make($userPassword); 
            $user->company_id = $company->id; 
            $user->status = 1; 
            $user->created_by = Auth::id() ?? 1; 
            $user->save();


             return redirect()->route('login')->with(['status' => 'success', 'message' => 'Company created successfully']);
        }else{
             return redirect()->route('login')->with(['status' => 'error', 'message' => 'Company already exist, go back and login']);
        }
    }

    public function Login(Request $request)
    {
        $userNo = $request->contactno;
        $userPassword = $request->password;

        $credentials = [
            'contactno' => $userNo,
            'password' => $userPassword,
        ];

        $user = User::where('contactno', $userNo)->first();
        $company_detail = Company::find($user->company_id);
        
        if($user)
        {
            if(Auth::attempt($credentials))
            {
                $dbName = $company_detail->database_name;

                Config::set('database.connections.dynamic_db.database', $dbName);

                DB::setDefaultConnection('dynamic_db');

                $user = User::where('contactno', $userNo)->first();
                
                return redirect()->route('dashboard')->with(['status' => 'success', 'message' => "Welcome " . Auth::user()->vemp_name]);
            }else{
                return redirect()->route('login')->with(['status' => 'error', 'message' => 'Invalid password.']);
            }
        }else{
            return redirect()->route('login')->with(['status' => 'error', 'message' => 'user  not found']);
        }
    }
}
