<?php

namespace yangpimpollo\L2_application\UseCases;

use yangpimpollo\L1_domain\Repository\OrderRepositoryInterface;

class DeleteOrderUseCase
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository
    ) {}

    public function execute(string $orderId): void
    {
        $this->repository->delete($orderId);
    }
}
