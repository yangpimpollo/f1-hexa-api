<?php

namespace yangpimpollo\L1_domain\Entity;

use yangpimpollo\L1_domain\ValueObjects\dni;
use yangpimpollo\L1_domain\ValueObjects\phone;

class Customer
{
    public function __construct(
        private readonly dni $dni,
        private string $firstname,
        private string $lastname,
        private phone $phone,
        private readonly DateTimeImmutable $createdAt
    ) {}
}