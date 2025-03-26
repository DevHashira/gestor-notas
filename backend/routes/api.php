<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotaController;

Route::apiResource('notas', NotaController::class);


