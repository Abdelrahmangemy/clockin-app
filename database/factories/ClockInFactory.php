<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ClockIn;
use App\Models\Worker;

class ClockInFactory extends Factory
{
    protected $model = ClockIn::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'worker_id' => Worker::factory(), // Creates a new Worker if not already existing
            'clock_in_time' => $this->faker->dateTimeThisYear,
            'latitude' => $this->faker->latitude(37.75, 37.80), // latitude within a range
            'longitude' => $this->faker->longitude(-122.45, -122.40), // longitude within a range
        ];
    }
}
