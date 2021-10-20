<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $jobs = [
        [
            'name' => 'barista',
        ],
        [
            'name' => 'security',
        ],
        [
            'name' => 'waiter',
        ]
    ];
    public function run()
    {
        Job::insert($this->jobs);
    }
}
