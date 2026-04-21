<?php

namespace yangpimpollo\L3_infrastructure\Persistence;

use Illuminate\Support\Facades\DB;
use yangpimpollo\L1_domain\Entity\Order;
use yangpimpollo\L1_domain\Entity\OrderItem;
use yangpimpollo\L1_domain\Repository\OrderRepositoryInterface;
use yangpimpollo\L1_domain\ValueObjects\dni;
use Exception;
use DateTimeImmutable;

class EloquentOrder implements OrderRepositoryInterface
{
    /**
     * Lista las órdenes de una tienda con paginación nativa de SQL.
     */
    public function index(string $storeId): array 
    {
        $limit = 15;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $limit;

        return DB::select(
            "SELECT * FROM orders WHERE store_id = ? ORDER BY order_date DESC LIMIT ? OFFSET ?",
            [$storeId, $limit, $offset]
        );
    }

    public function store(Order $order): void
    {
        DB::transaction(function () use ($order) {
            
            // 1. Insertar Cabecera de la Orden
            DB::insert(
                "INSERT INTO orders (order_id, customer_dni, store_id, staff_id, total_amount, order_date) 
                 VALUES (?, ?, ?, ?, ?, ?)",
                [
                    $order->getOrderId(),
                    $order->getCustomerDni(),
                    $order->getStoreId(),
                    $order->getStaffId(),
                    $order->getTotalAmount(),
                    $order->getOrderDate()->format('Y-m-d H:i:s')
                ]
            );

            // 2. Procesar cada Item de la Orden
            foreach ($order->getItems() as $item) {
                
                // A. Insertar Detalle
                DB::insert(
                    "INSERT INTO order_items (order_id, product_id, quantity, list_price, discount) 
                     VALUES (?, ?, ?, ?, ?)",
                    [
                        $order->getOrderId(),
                        $item->getProductId(),
                        $item->getQuantity(),
                        $item->getListPrice(),
                        $item->getDiscount()
                    ]
                );

                // B. Restar Stock en Inventario
                $affected = DB::update(
                    "UPDATE inventories 
                     SET quantity = quantity - ? 
                     WHERE store_id = ? AND product_id = ? AND quantity >= ?",
                    [
                        $item->getQuantity(),
                        $order->getStoreId(),
                        $item->getProductId(),
                        $item->getQuantity()
                    ]
                );

                if ($affected === 0) {
                    throw new Exception("Stock insuficiente para el producto: " . $item->getProductId());
                }
            }
        });
    }

    /**
     * Recupera una orden completa con sus items (Reconstrucción del Agregado)
     */
    public function show(string $orderId): ?Order 
    {
        $row = DB::selectOne("SELECT * FROM orders WHERE order_id = ?", [$orderId]);
        if (!$row) return null;

        $order = new Order(
            $row->order_id,
            new dni($row->customer_dni),
            $row->store_id,
            (int)$row->staff_id,
            new DateTimeImmutable($row->order_date)
        );

        $items = DB::select("SELECT * FROM order_items WHERE order_id = ?", [$orderId]);
        foreach ($items as $item) {
            $order->addItem(new OrderItem(
                $item->product_id,
                (int)$item->quantity,
                (float)$item->list_price,
                (float)$item->discount
            ));
        }

        return $order;
    }

    /**
     * Elimina una orden y DEVUELVE el stock a inventories
     */
    public function delete(string $orderId): void 
    {
        DB::transaction(function () use ($orderId) {
            // 1. Buscamos la orden para saber qué productos devolver
            $order = $this->show($orderId);
            if (!$order) throw new Exception("Orden no encontrada.");

            // 2. Devolvemos el stock a inventories
            foreach ($order->getItems() as $item) {
                DB::update(
                    "UPDATE inventories SET quantity = quantity + ? 
                     WHERE store_id = ? AND product_id = ?",
                    [$item->getQuantity(), $order->getStoreId(), $item->getProductId()]
                );
            }

            // 3. Borramos la orden (Items se borran por CASCADE)
            DB::delete("DELETE FROM orders WHERE order_id = ?", [$orderId]);
        });
    }
}
