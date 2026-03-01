<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developerInfo = config('app.developer');
        $developer = new User();
        $developer->name = 'Developer';
        $developer->email = $developerInfo['email'];
        $developer->password = bcrypt('password#');
        $developer->email_verified_at = now();
        $developer->save();

        $developer->assignRole('super admin');
    }
}
