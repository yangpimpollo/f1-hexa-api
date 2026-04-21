<?php

namespace yangpimpollo\L1_domain\Entity;

use yangpimpollo\L1_domain\ValueObjects\dni;
use yangpimpollo\L1_domain\ValueObjects\phone;
use DateTimeImmutable;

class Customer
{
    public function __construct(
        private readonly dni $dni,
        private string $firstname,
        private string $lastname,
        private phone $phone,
        private readonly DateTimeImmutable $createdAt = new DateTimeImmutable() 
    ) {}

    public function getDni(): string { return $this->dni->value(); }
    public function getFirstname(): string { return $this->firstname; }
    public function getLastname(): string { return $this->lastname; }
    public function getPhone(): string { return $this->phone->value(); }
    public function getCreatedAt(): DateTimeImmutable { return $this->createdAt; }
}