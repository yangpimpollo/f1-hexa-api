<?php

namespace yangpimpollo\L3_infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use yangpimpollo\L2_application\UseCases\StoreOrderUseCase;
use yangpimpollo\L2_application\UseCases\IndexOrderUseCase;
use yangpimpollo\L2_application\UseCases\ShowOrderUseCase;
use yangpimpollo\L2_application\UseCases\DeleteOrderUseCase;
use yangpimpollo\L2_application\DTOs\OrderDto;
use yangpimpollo\L2_application\DTOs\OrderItemDto;

class OrderController
{
    public function __construct(
        private StoreOrderUseCase $storeOrderUseCase,
        private IndexOrderUseCase $indexOrderUseCase,
        private ShowOrderUseCase $showOrderUseCase,
        private DeleteOrderUseCase $deleteOrderUseCase
    ) {}

    /**
     * Lista de Ordenes
     */
    public function index(Request $request): JsonResponse
    {
        $storeId = $request->user()->store_id;
        $orders = $this->indexOrderUseCase->execute($storeId);

        return new JsonResponse([
            'status' => 'success✅',
            'results' => $orders
        ]);
    }

    /**
     * Detalle de Orden
     */
    public function show(Request $request): JsonResponse
    {
        $orderId = $request->query('order_id');
        if (!$orderId) return new JsonResponse(['error' => 'ID de orden requerido'], 400);

        $order = $this->showOrderUseCase->execute($orderId);

        if (!$order) {
            return new JsonResponse(['message' => 'Orden no encontrada'], 404);
        }

        // Mapeamos el objeto de dominio a un JSON limpio
        return new JsonResponse([
            'status' => 'success✅',
            'data' => [
                'order_id' => $order->getOrderId(),
                'customer_dni' => $order->getCustomerDni(),
                'total' => $order->getTotalAmount(),
                'date' => $order->getOrderDate()->format('Y-m-d H:i:s'),
                'items' => array_map(fn($item) => [
                    'product_id' => $item->getProductId(),
                    'quantity' => $item->getQuantity(),
                    'price' => $item->getListPrice(),
                    'subtotal' => $item->getSubtotal()
                ], $order->getItems())
            ]
        ]);
    }

    /**
     * Crear Orden
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'customer_dni' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.discount' => 'nullable|numeric|min:0',
        ]);

        $itemsDto = array_map(fn($item) => new OrderItemDto(
            $item['product_id'],
            $item['quantity'],
            (float) ($item['discount'] ?? 0)
        ), $request->input('items'));

        $dto = new OrderDto(
            $request->input('customer_dni'),
            $request->user()->store_id,
            $request->user()->id,
            $itemsDto
        );

        try {
            $this->storeOrderUseCase->execute($dto);
            return new JsonResponse(['status' => 'success✅', 'message' => '¡Venta realizada con éxito!'], 201);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Cancelar una orden
     */
    public function delete(Request $request): JsonResponse
    {
        $orderId = $request->query('order_id');
        if (!$orderId) return new JsonResponse(['error' => 'ID de orden requerido'], 400);

        try {
            $this->deleteOrderUseCase->execute($orderId);
            return new JsonResponse(['status' => 'success✅', 'message' => 'Orden cancelada y stock devuelto.']);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}
