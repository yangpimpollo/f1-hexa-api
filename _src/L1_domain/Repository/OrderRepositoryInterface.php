<?php

namespace yangpimpollo\L1_domain\Repository;

use yangpimpollo\L1_domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function store(Order $order): void;
}
