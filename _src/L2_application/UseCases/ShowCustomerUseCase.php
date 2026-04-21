<?php

namespace yangpimpollo\L2_application\UseCases;

use yangpimpollo\L1_domain\Repository\CustomerRepositoryInterface;
use yangpimpollo\L1_domain\ValueObjects\dni;
use yangpimpollo\L1_domain\Entity\Customer;

class ShowCustomerUseCase
{
    public function __construct(
        private readonly CustomerRepositoryInterface $repository
    ) {}

    public function execute(string $dniValue): ?Customer
    {
        return $this->repository->show(new dni($dniValue));
    }
}
