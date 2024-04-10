<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ClientsService;

class ClientsController extends Controller
{
    private ClientsService $clientService;

    public function __construct(ClientsService $clientsService)
    {
        $this->clientService = $clientsService;
    }

    public function getClients(): JsonResponse
    {
        return $this->clientService->getClients();
    }

    public function findClient(Request $request): JsonResponse
    {
        $constraints = [
            "name" => 'prohibits:card_number',
            "card_number" => 'prohibits:name|regex:/^[a-zA-Z0-9]*$/|exists:clients,card_number'
        ];

        $this->validateRequestParameters($request->all(), $constraints);

        return new JsonResponse();
    }
}
