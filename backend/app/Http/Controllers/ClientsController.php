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

        $this->validateRequestParameters($request->query(), $constraints);

        if ($request->input('card_number') !== null) {
            $type = 'card_number';
            $filter = $request->input('card_number');
        } else if ($request->input('name') !== null) {
            $type = "name";
            $filter = $request->input('name');
        } else {
            return new JsonResponse(["error" => "Either name or card_number is required!"], 400);
        }

        return $this->clientService->findClient($filter, $type);
    }
}
