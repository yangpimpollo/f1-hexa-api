<?php

namespace yangpimpollo\L2_application\UseCases;

use yangpimpollo\L1_domain\Repository\ProductRepositoryInterface;

class SearchProductUseCase
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository
    ) {}

    public function execute(string $query, string $storeId)
    {
        return $this->repository->index($query, $storeId);
    }
}
