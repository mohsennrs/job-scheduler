<?php

namespace Database\Factories;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "job_id" => $this->faker->randomElement([1, 2, 3]),
            "user_id" => 2,
            "date" => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+6 days'),
            "shift" => 'morning',
            "description" => 'some text',
            "status" => 'accepted'
        ];
    }
}
