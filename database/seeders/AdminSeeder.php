<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $admins=[
            [
                'name'=>'admin1',
                'email'=>'admin@sms.com',
                'password'=>Hash::make('12345678'),
            ],
            [
                'name'=>'admin2',
                'email'=>'admin2@sms.com',
                'password'=>Hash::make('12345678')
            ],

            ];
            foreach ($admins as $key => $value){
                Admin::create($value);
                }
    }
}
