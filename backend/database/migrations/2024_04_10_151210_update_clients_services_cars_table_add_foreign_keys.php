<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->index('client_id');
            $table->index('car_id');
            $table->index('log_number');
            $table->index('document_id');
            $table->foreign('car_id')->references('id')->on('cars');
            $table->foreign('client_id')->references('id')->on('clients');
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->index('client_id');
            $table->index('car_id');
            $table->foreign('car_id')->references('id')->on('cars');
            $table->foreign('client_id')->references('id')->on('clients');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign('services_car_id_foreign');
            $table->dropForeign('services_client_id_foreign');
            $table->dropIndex('client_id');
            $table->dropIndex('car_id');
            $table->dropIndex('log_number');
            $table->dropIndex('document_id');
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->dropForeign('cars_car_id_foreign');
            $table->dropForeign('cars_client_id_foreign');
            $table->dropIndex('client_id');
            $table->dropIndex('car_id');
        });
    }
};
