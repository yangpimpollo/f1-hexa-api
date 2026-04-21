<?php

namespace yangpimpollo\L1_domain\Entity;


class Customer
{
    public function __construct(
        private readonly string $dni,
        private string $firstname,
        private string $lastname,
        private string $phone,
        private readonly DateTimeImmutable $createdAt
    ) {}
}