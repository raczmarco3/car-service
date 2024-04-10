<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CarsService;

class CarsController extends Controller
{
    private CarsService $carService;

    public function __construct(CarsService $carsService)
    {
        $this->carService = $carsService;
    }

    public function getClientCars($clientId)
    {
        $this->validateRequestParameters(["client_id" => $clientId], ['client_id' => 'required|exists:clients,id']);

        return $this->carService->getClientCars($clientId);
    }
}
