<?php

namespace App\Services;

use App\Models\Services;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ServicesService
{
    public function getServiceLogs($carId, $clientId)
    {
        $serviceLogs = DB::table('services')
            ->where('car_id', '=', $carId)
            ->where('client_id', '=', $clientId)
            ->select('log_number', 'event', 'event_time', 'document_id')
            ->get();

        if (count($serviceLogs) == 0) {
            return new JsonResponse(["error" => "This car doesn't have any service logs!"], 404);
        }

        $returnArray = [];

        foreach ($serviceLogs as $serviceLog) {
            $eventTime = $serviceLog->event_time;

            if (is_null($eventTime)) {
                $eventTime = $this->getRegistrationDate($carId, $clientId);
            }

            $returnArray[] = [
                "log_number" => $serviceLog->log_number,
                "event" => $serviceLog->event,
                "event_time" => $eventTime,
                "document_id" => $serviceLog->document_id
            ];
        }

        return new JsonResponse($returnArray);
    }

    private function getRegistrationDate($carId, $clientId)
    {
        $carData = DB::table('cars')->select('registered')
            ->where('car_id', '=', $carId)
            ->where('client_id', '=', $clientId)
            ->first();

        if (!$carData) {
            return '0000-00-00 00:00:00';
        }

        return $carData->registered;
    }
}
