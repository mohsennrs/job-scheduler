<?php

namespace Tests\Feature;

use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    const GET_SCHEDULES_URL = '/schedules';
    const CREATE_SCHEDULE_URL = '/schedules/create';
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_schedules()
    {
        $response = $this->get(self::GET_SCHEDULES_URL.'?start_date='.Carbon::today().'&end_date='.Carbon::today()->addDays(6));
        
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    "job","date","shift","description","status","user"
                ],
            ],
            'message'
        ]);;
    }

    public function test_create_schedule() {
        $user = User::factory()->create();
        $user->assignRole('worker');
        $data = [
            'date' => Carbon::now()->toString(),
            'job' => 'waiter',
            'shift' => 'morning',
            'description' => 'test'
        ];
        $response = $this->actingAs($user)->post(self::CREATE_SCHEDULE_URL, $data);
        $response->assertStatus(201);
    }

    public function test_admin_edit_schedule() {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $schedule = Schedule::factory()->create();

        $response = $this->actingAs($user)->post('/schedules/edit/'.$schedule->id, [
            'status' => 'accepted',
            'description' => 'test'
        ]);

        $response->assertStatus(200);
    }
}
