<?php

namespace yangpimpollo\L1_domain\Entity;


class Customer
{
    public function __construct(
        private readonly TaskId $id,
        private string $title,
        private string $description,
        private string $status,
        private readonly DateTimeImmutable $createdAt
    ) {}
}