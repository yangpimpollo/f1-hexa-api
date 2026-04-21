<?php

namespace yangpimpollo\L1_domain\Exceptions;

use Exception;

class my_invalid_phone_Exception extends Exception
{
    public static function invalidLength(string $dni): self
    {
        return new self("🙄❌❌ El telefono '$dni' debe tener exactamente 9 dígitos.");
    }

    public static function notNumeric(string $dni): self
    {
        return new self("🤔❌ El telefono '$dni' solo debe contener números.");
    }

    public static function invalidStart(string $phone): self
    {
        return new self("🙄🙄🙄 El teléfono '$phone' debe comenzar con 9.");
    }
}