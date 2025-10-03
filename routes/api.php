<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/encuentros', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Encuentro::with('materias')->get()
    ]);
});

Route::get('/search', function (Request $request) {
    $query = $request->get('q');
    // Implementar búsqueda con Laravel Scout
    return response()->json([
        'success' => true,
        'query' => $query,
        'results' => []
    ]);
});
