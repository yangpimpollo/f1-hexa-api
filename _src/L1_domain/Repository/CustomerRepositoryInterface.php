<?php

namespace yangpimpollo\L1_domain\Repository;

use yangpimpollo\L1_domain\Entity\Customer;

interface CustomerRepositoryInterface
{
    public function show(string $dni);
    public function store(Customer $customer);
}
