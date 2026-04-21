<?php

namespace yangpimpollo\L2_application\DTOs;

class OrderDto
{
    public function __construct(
        public readonly string $customerDni,
        public readonly string $storeId,
        public readonly int $staffId,
        public array $items
    ) {}
}
