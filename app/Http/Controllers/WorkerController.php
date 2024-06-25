<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\ClockIn;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;
use App\Http\Requests\WorkerRequest;


class WorkerController extends Controller
{
    /**
     * @OA\Post(
     *     path="/worker/clock-in",
     *     summary="Clock-in a worker",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="worker_id", type="integer"),
     *             @OA\Property(property="timestamp", type="integer"),
     *             @OA\Property(property="latitude", type="number", format="float"),
     *             @OA\Property(property="longitude", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function clockIn(WorkerRequest $request)
    {
        $lat1 = 37.7749; // Example latitude for the reference location
        $lon1 = -122.4194; // Example longitude for the reference location
        $lat2 = $request->latitude;
        $lon2 = $request->longitude;

        $distance = $this->haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2);

        if ($distance > 2) {
            return response()->json(['error' => 'Location is not within the allowed radius'], 400);
        }

        $clockIn = ClockIn::create([
            'worker_id' => $request->worker_id,
            'clock_in_time' => date('Y-m-d H:i:s', $request->timestamp),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['status' => 'success', 'data' => $clockIn], 200);
    }

    /**
     * Haversine formula to calculate the great-circle distance between two points
     */
    private function haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2, $earthRadius = 6371)
    {
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    /**
     * @OA\Get(
     *     path="/worker/clock-ins",
     *     summary="Get worker clock-ins",
     *     @OA\Parameter(
     *         name="worker_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function getClockIns(Request $request)
    {
        $workerId = $request->query('worker_id');

        $validator = Validator::make(['worker_id' => $workerId], [
            'worker_id' => 'required|integer|exists:workers,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $clockIns = ClockIn::where('worker_id', $workerId)->get();
        return response()->json(['status' => 'success', 'data' => $clockIns], 200);
    }
}
