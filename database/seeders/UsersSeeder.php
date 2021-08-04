<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "full_name"=>"Geoffrey Mwangi",
            "email"=>"a@b.com",
            "password"=>Hash::make("1234")
        ]);
    }
}
