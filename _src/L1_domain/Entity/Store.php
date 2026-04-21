<?php

namespace yangpimpollo\L1_domain\Entity;

class Store
{
    public function __construct(
        private readonly string $store_id,
        private string $store_name
    ) {}

    public function getStoreId(): string { return $this->store_id; }
    public function getStoreName(): string { return $this->store_name; }
}