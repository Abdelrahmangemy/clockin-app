<?php

namespace Tests\Feature;

use App\Models\ClockIn;
use App\Models\Worker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 
     * @test
     */
    public function clockInValidation()
    {
        $response = $this->postJson('/worker/clock-in', []);
        $response->assertStatus(400);
    }

    /**
     * 
     * @test
     */
    public function clockInSuccess()
    {
        $worker = Worker::factory()->create();

        $data = [
            'worker_id' => $worker->id,
            'timestamp' => time(),
            'latitude' => 37.7749,
            'longitude' => -122.4194,
        ];

        $response = $this->postJson('/worker/clock-in', $data);
        $response->assertStatus(200);
    }

    /**
     * 
     * @test
     */
    public function getClockInsValidation()
    {
        $response = $this->getJson('/worker/clock-ins?worker_id=999');
        $response->assertStatus(400);
    }

    /**
     * 
     * @test
     */
    public function getClockInsSuccess()
    {
        $worker = Worker::factory()->create();
        ClockIn::factory()->create(['worker_id' => $worker->id]);

        $response = $this->getJson("/worker/clock-ins?worker_id={$worker->id}");
        $response->assertStatus(200);
    }

}
