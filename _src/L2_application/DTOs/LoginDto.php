<?php

namespace yangpimpollo\L2_application\DTOs;

class LoginDto
{
    public function __construct(
        public readonly string $username,
        public readonly string $password
    ) {}
}