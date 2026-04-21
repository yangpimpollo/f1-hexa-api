<?php

namespace yangpimpollo\L1_domain\Entity;

use DateTimeImmutable;

use yangpimpollo\L1_domain\ValueObjects\dni;


class Order
{
    private array $items = [];

    public function __construct(
        private readonly string $orderId,
        private readonly dni $customerDni,
        private readonly string $storeId,
        private readonly int $staffId,
        private readonly DateTimeImmutable $orderDate = new DateTimeImmutable()
    ) {}

    public function addItem(OrderItem $item): void
    {
        $this->items[] = $item;
    }

    public function getTotalAmount(): float
    {
        $total = 0;
        foreach ($this->items as $item) $total += $item->getSubtotal();
        return (float) number_format($total, 2, '.', '');
    }

    public function getOrderId(): string { return $this->orderId; }
    public function getCustomerDni(): string { return $this->customerDni->value(); }
    public function getStoreId(): string { return $this->storeId; }
    public function getStaffId(): int { return $this->staffId; }
    public function getOrderDate(): DateTimeImmutable { return $this->orderDate; }
    
    public function getItems(): array { return $this->items; }
}
