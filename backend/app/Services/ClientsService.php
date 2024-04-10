<?php

namespace App\Services;

use App\Models\Clients;
use Illuminate\Http\JsonResponse;

class ClientsService
{
    public function getClients(): JsonResponse
    {
        $clients = Clients::all();

        if (count($clients) == 0) {
            return new JsonResponse(["error" => "Clients table is empty!"], 404);
        }

        return new JsonResponse($clients, 200);
    }

    public function findClient()
    {
        //
    }
}
