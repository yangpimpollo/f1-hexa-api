<?php

namespace yangpimpollo\L1_domain\ValueObjects;

use yangpimpollo\L1_domain\Exceptions\my_invalid_dni_Exception;

final class dni
{
    private string $value;

    public function __construct(string $dni)
    {
        $this->validate($dni);
        $this->value = $dni;
    }

    private function validate(string $dni): void
    {
        if (!ctype_digit($dni)) throw my_invalid_dni_Exception::notNumeric($dni);
        if (strlen($dni) !== 8) throw my_invalid_dni_Exception::invalidLength($dni);
    }

    public function value(): string { return $this->value; }
    public function equals(dni $other): bool { return $this->value === $other->value; }
    public function __toString(): string { return $this->value; }
}