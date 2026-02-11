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
        $developer = new User();
        $developer->name = 'Developer';
        $developer->email = 'developer@mustamirun.agency';
        $developer->password = bcrypt('password#');
        $developer->save();
    }
}
