<?php

namespace App\Services;

use App\Models\Clients;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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

    public function findClient($filter, $type): JsonResponse
    {
        $results = DB::table('clients')
            ->select('clients.id', 'clients.name', 'clients.card_number', DB::raw('COUNT(DISTINCT cars.car_id) as car_count'), DB::raw('COUNT(DISTINCT services.id) as services_count'))
            ->leftJoin('cars', 'clients.id', '=', 'cars.client_id')
            ->leftJoin('services', 'clients.id', '=', 'services.client_id')
            ->groupBy('clients.id', 'clients.name', 'clients.card_number')
            ->where($type, 'like', '%'.$filter.'%')
            ->get();

        if(count($results) > 1) {
            return new JsonResponse(["error" => "There are more than one result!"], 409);
        } else if(count($results) == 0) {
            return new JsonResponse(["error" => "Client not found!"], 404);
        }

        return new JsonResponse($results, 200);
    }
}
