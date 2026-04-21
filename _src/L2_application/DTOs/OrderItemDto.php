<?php

namespace yangpimpollo\L2_application\DTOs;

class OrderItemDto
{
    public function __construct(
        public readonly string $productId,
        public readonly int $quantity,
        public readonly float $discount = 0
    ) {}
}
