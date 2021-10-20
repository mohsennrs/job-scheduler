<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@site.com',
            'password' => Hash::make('123456')
        ]);

        $admin->assignRole('admin');

        $worker = User::factory()->create([
            'name' => 'worker',
            'email' => 'worker@site.com',
            'password' => Hash::make('123456')
        ]);

        $worker->assignRole('worker');
    }
}
