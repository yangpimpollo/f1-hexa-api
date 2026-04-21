<?php

namespace yangpimpollo\L1_domain\Exceptions;

use Exception;

class InvalidDniException extends Exception
{
    public static function invalidLength(string $dni): self
    {
        return new self("El DNI '$dni' debe tener exactamente 8 dígitos.");
    }

    public static function notNumeric(string $dni): self
    {
        return new self("El DNI '$dni' solo debe contener números.");
    }
}