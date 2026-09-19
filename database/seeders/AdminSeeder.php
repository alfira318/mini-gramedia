<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Administrator',
            'email'=> 'admin@gmail.com',
            'role' => 'admin', //WAJIB untuk jenis hak akses
            'password' => Hash::make('admin123')
        ]);
    }
}
