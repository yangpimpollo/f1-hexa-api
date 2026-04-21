<?php

namespace yangpimpollo\L2_application\DTOs;

class CustomerDto
{
    public function __construct(
        public readonly string $dni,
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $phone
    ) {}
}
