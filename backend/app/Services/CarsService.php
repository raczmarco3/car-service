<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CarsService
{
    public function getClientCars($clientId): JsonResponse
    {
        $cars = DB::table('cars')
            ->select('cars.car_id', 'cars.type', 'cars.registered', 'cars.ownbrand', 'cars.accident', DB::raw('MAX(log_number) as log_number'), DB::raw('MAX(event_time) as event_time'))
            ->join('services', 'cars.client_id', '=', 'services.client_id')
            ->where('cars.client_id', '=', $clientId)
            ->groupBy('cars.car_id', 'cars.type', 'cars.client_id', 'cars.registered', 'cars.ownbrand', 'cars.accident')
            ->get();

        if (count($cars) == 0) {
            return new JsonResponse(["error" => "This client doesn't have any cars!"], 404);
        }

        return new JsonResponse($cars, 200);
    }
}
