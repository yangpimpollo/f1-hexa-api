<?php

namespace yangpimpollo\L2_application\UseCases;

use yangpimpollo\L1_domain\Repository\CustomerRepositoryInterface;
use yangpimpollo\L1_domain\Entity\Customer;
use yangpimpollo\L1_domain\ValueObjects\dni;
use yangpimpollo\L1_domain\ValueObjects\phone;
use yangpimpollo\L2_application\DTOs\CustomerDto;
use DateTimeImmutable;

class StoreCustomerUseCase
{
    public function __construct(
        private readonly CustomerRepositoryInterface $repository
    ) {}

    public function execute(CustomerDto $dto): void
    {
        $customer = new Customer(
            new dni($dto->dni),
            $dto->firstname,
            $dto->lastname,
            new phone($dto->phone)
        );

        $this->repository->store($customer);
    }
}
