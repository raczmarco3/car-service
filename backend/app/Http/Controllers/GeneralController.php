<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class GeneralController extends Controller
{
    public function checkDatabase()
    {
        Artisan::call('app:check-database');
    }
}
