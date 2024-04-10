<?php

namespace App\Console\Commands;

use App\Models\Cars;
use App\Models\Clients;
use App\Models\Services;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class CheckDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if database is empty';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hadAnyMigration = false;
        echo "Checking database\n";

        //check if any table is missing
        if (!Schema::hasTable('clients')) {
            $this->call('migrate', ['--path' => 'database/migrations/2024_04_09_120704_create_clients_table.php']);
        }

        if (!Schema::hasTable('services')) {
            $this->call('migrate', ['--path' => 'database/migrations/2024_04_09_120711_create_services_table.php']);
            $hadAnyMigration = true;
        }

        if (!Schema::hasTable('cars')) {
            $this->call('migrate', ['--path' => 'database/migrations/2024_04_09_120724_create_cars_table.php']);
            $hadAnyMigration = true;
        }

        //if cars or services was missing we need the foreign keys migration
        if ($hadAnyMigration) {
            $this->call('migrate', ['--path' => 'database/migrations/2024_04_09_120810_update_clients_services_cars_table_add_foreign_keys.php']);
        }

        //check if tables are empty
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        if (DB::table('clients')->doesntExist()) {
            echo "Uploading client data to clients table\n";

            $json = File::get(database_path('clients.json'));
            $clients = json_decode($json, true);

            foreach ($clients as $client) {
                $clientData = [
                    "id" => $client["id"],
                    "name" => $client["name"],
                    "card_number" => $client["idcard"]
                ];

                Clients::create($clientData);
            }

            echo "Clients data upload finished!\n";
        }

        if (DB::table('services')->doesntExist()) {
            echo "Uploading service data to services table\n";

            $json = File::get(database_path('services.json'));
            $services = json_decode($json, true);

            foreach ($services as $service) {
                $serviceData = [
                    "id" => $service["id"],
                    "client_id" => $service["client_id"],
                    "car_id" => $service["car_id"],
                    "log_number" => $service["lognumber"],
                    "event" => $service["event"],
                    "event_time" => $service["eventtime"],
                    "document_id" => $service["document_id"]
                ];

                Services::create($serviceData);
            }

            echo "Services data upload finished!\n";
        }

        if (DB::table('cars')->doesntExist()) {
            echo "Uploading car data to cars table\n";
            $json = File::get(database_path('cars.json'));
            $cars = json_decode($json, true);

            foreach ($cars as $car) {
                Cars::create($car);
            }

            echo "Cars data upload finished!\n";
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        echo "Database Checking finished!\n";
    }
}
