<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $roles = [
          [
            'name'=>'admin',
            'guard_name' => 'web'
          ],
          [
            'name'=>'worker',
            'guard_name' => 'web'
          ]
      ];
    public function run()
    {

        Role::insert($this->roles);
    }
}
