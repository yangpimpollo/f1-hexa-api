<?php

namespace yangpimpollo\L3_infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use yangpimpollo\L2_application\UseCases\SearchProductUseCase;

class SearchController
{
    public function __construct(
        private SearchProductUseCase $search
    ) {}

    public function index(Request $request): JsonResponse
    {
        // Al definir esta validación, Scramble detecta 'q' automáticamente
        // http://localhost:8000/api/products/search?q=.......
        // buscador patito
        // 1. Validamos la entrada (parámetro 'patito')
        $validated = $request->validate([ 
            'patito' => ['required', 'string', 'min:1', 'max:50'] 
        ]);

        // 2. Obtenemos el store_id del usuario autenticado vía Sanctum
        $storeId = $request->user()->store_id;

        // 3. Ejecutamos búsqueda filtrada por tienda
        $results = $this->search->execute($validated['patito'], $storeId);

        return response()->json([
            'status' => 'success✅',
            'store_id' => $storeId,
            'query' => $validated['patito'],
            'results' => $results
        ]);
    }

}