<?php

namespace yangpimpollo\L1_domain\Entity;

class OrderItem
{
    public function __construct(
        private readonly string $productId,
        private readonly int $quantity,
        private readonly float $listPrice,
        private readonly float $discount = 0
    ) {}

    public function getProductId(): string { return $this->productId; }
    public function getQuantity(): int { return $this->quantity; }
    public function getListPrice(): float { return $this->listPrice; }
    public function getDiscount(): float { return $this->discount; }

    /**
     * Calcula el subtotal neto de este item.
     */
    public function getSubtotal(): float 
    {
        return ($this->listPrice * $this->quantity) * (1 - $this->discount);
    }
}
