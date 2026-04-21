<?php

namespace yangpimpollo\L1_domain\Entity;

class Product
{
    public function __construct(
        private readonly string $product_id,
        private string $product_category_id,
        private string $product_name,
        private string $description,
        private float $product_price
    ) {}

    public function getProductId(): string { return $this->product_id; }
    public function getProductName(): string { return $this->product_name; }
    public function getProductPrice(): float { return $this->product_price; }
}