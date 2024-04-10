<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ServicesService;

class ServicesController extends Controller
{
    private ServicesService $servicesService;

    public function __construct(ServicesService $servicesService)
    {
        $this->servicesService = $servicesService;
    }

    public function getServiceLogs(Request $request): JsonResponse
    {
        $constraints = [
            'client_id' => 'required|exists:clients,id',
            'car_id' => 'required|exists:cars,id'
        ];

        $this->validateRequestParameters($request->all(), $constraints);

        return $this->servicesService->getServiceLogs($request->input('car_id'), $request->input('client_id'));
    }

}
