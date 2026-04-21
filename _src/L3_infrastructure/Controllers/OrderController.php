<?php

namespace yangpimpollo\L3_infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use yangpimpollo\L2_application\UseCases\StoreOrderUseCase;
use yangpimpollo\L2_application\DTOs\OrderDto;
use yangpimpollo\L2_application\DTOs\OrderItemDto;

class OrderController
{
    public function __construct(
        private StoreOrderUseCase $storeOrderUseCase
    ) {}

    public function store(Request $request): JsonResponse
    {
        // 1. Validación de Infraestructura (Eliminado list_price)
        $request->validate([
            'customer_dni' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.discount' => 'nullable|numeric|min:0',
        ]);

        // 2. Mapeo de Items a DTOs (Eliminado list_price)
        $itemsDto = array_map(function ($item) {
            return new OrderItemDto(
                $item['product_id'],
                $item['quantity'],
                (float) ($item['discount'] ?? 0)
            );
        }, $request->input('items'));

        // 3. Crear el DTO Principal
        $dto = new OrderDto(
            $request->input('customer_dni'),
            $request->user()->store_id,
            $request->user()->id,
            $itemsDto
        );

        // 4. Ejecutar Caso de Uso
        try {
            $this->storeOrderUseCase->execute($dto);
            
            return new JsonResponse([
                'status' => 'success✅',
                'message' => '¡Venta realizada con éxito! 🍕🔥',
            ], 201);

        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Error al procesar la venta: ' . $e->getMessage()
            ], 400);
        }
    }
}
