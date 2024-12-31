<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = new User();
        $user->emp_code = 'EMP' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $user->vemp_name = 'Admin';
        $user->contactno ='8667444193';
        $user->emp_desg = 'Admin';
        $user->alt_ph_no = null;
        $user->emp_mail = 'admin@gmail.com';
        $user->b_grp = 'N/A';
        $user->salary = 0;
        $user->experience = 0;
        $user->doj = now();
        $user->password = Hash::make(123456);
        $user->status = 1;
        $user->created_by = Auth::id() ?? 1;
        $user->save();
    }
}
