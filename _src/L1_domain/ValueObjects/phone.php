<?php

namespace yangpimpollo\L1_domain\ValueObjects;

use yangpimpollo\L1_domain\Exceptions\my_invalid_phone_Exception;

final class phone
{
    private string $value;

    public function __construct(string $phone)
    {
        $this->validate($phone);
        $this->value = $phone;
    }

    private function validate(string $phone): void
    {
        if (!ctype_digit($phone)) throw my_invalid_phone_Exception::notNumeric($phone);
        if (strlen($phone) !== 9) throw my_invalid_phone_Exception::invalidLength($phone);
        if ($phone[0] !== '9') throw my_invalid_phone_Exception::invalidStart($phone);
    }

    public function value(): string { return $this->value; }
    public function equals(phone $other): bool { return $this->value === $other->value; }
    public function __toString(): string { return $this->value; }
}