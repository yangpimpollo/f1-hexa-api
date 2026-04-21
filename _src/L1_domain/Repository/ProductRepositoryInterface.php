<?php

namespace yangpimpollo\L1_domain\Repository;

interface ProductRepositoryInterface
{
    public function index(string $query, string $storeId);
    public function show(string $productId): ?object;
}
