<?php

namespace yangpimpollo\L2_application\UseCases;

use yangpimpollo\L1_domain\Entity\Order;
use yangpimpollo\L1_domain\Entity\OrderItem;
use yangpimpollo\L1_domain\Repository\OrderRepositoryInterface;
use yangpimpollo\L1_domain\Repository\ProductRepositoryInterface;
use yangpimpollo\L1_domain\ValueObjects\dni;
use yangpimpollo\L2_application\DTOs\OrderDto;
use Illuminate\Support\Str;
use Exception;

class StoreOrderUseCase
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
        private readonly ProductRepositoryInterface $productRepository
    ) {}

    public function execute(OrderDto $dto): void
    {
        // 1. Generamos un ID único para la orden (String)
        $orderId = 'ORD-' . strtoupper(Str::random(8));

        // 2. Creamos el Agregado Raíz (Order)
        $order = new Order(
            $orderId,
            new dni($dto->customerDni),
            $dto->storeId,
            $dto->staffId
        );

        // 3. Añadimos los items a la orden buscando su precio oficial
        foreach ($dto->items as $itemDto) {
            
            $product = $this->productRepository->show($itemDto->productId);

            if (!$product) {
                throw new Exception("El producto con ID {$itemDto->productId} no existe.");
            }

            $order->addItem(new OrderItem(
                $itemDto->productId,
                $itemDto->quantity,
                (float) $product->product_price, // Precio oficial de la DB
                $itemDto->discount
            ));
        }

        // 4. Guardamos la orden completa
        $this->repository->store($order);
    }
}
