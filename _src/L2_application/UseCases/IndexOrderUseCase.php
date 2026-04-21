<?php

namespace yangpimpollo\L2_application\UseCases;

use yangpimpollo\L1_domain\Repository\OrderRepositoryInterface;

class IndexOrderUseCase
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository
    ) {}

    public function execute(string $storeId): array
    {
        return $this->repository->index($storeId);
    }
}
