<?php

namespace yangpimpollo\L1_domain\Repository;

use yangpimpollo\L1_domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function index(string $storeId): array;
    public function store(Order $order): void;
    public function show(string $orderId): ?Order;
    public function delete(string $orderId): void;
}
