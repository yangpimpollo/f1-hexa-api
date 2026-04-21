<?php

namespace yangpimpollo\L1_domain\Repository;

use yangpimpollo\L1_domain\Entity\Customer;
use yangpimpollo\L1_domain\ValueObjects\dni;

interface CustomerRepositoryInterface
{
    public function show(dni $dni): ?Customer;
    public function store(Customer $customer): void;
}
