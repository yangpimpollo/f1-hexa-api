<?php

namespace yangpimpollo\L3_infrastructure\Persistence;

use Illuminate\Support\Facades\DB;
use yangpimpollo\L1_domain\Entity\Order;
use yangpimpollo\L1_domain\Repository\OrderRepositoryInterface;
use Exception;

class EloquentOrder implements OrderRepositoryInterface
{
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
                // Usamos una sentencia que falla si el stock queda negativo para mayor seguridad
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
}
