<?php

namespace yangpimpollo\L2_application\UseCases;

use yangpimpollo\L1_domain\Repository\AuthRepositoryInterface;
use yangpimpollo\L2_application\DTOs\LoginDto;


class LoginUseCase {

    public function __construct(
        private AuthRepositoryInterface $repository
    ) {}

    public function execute(LoginDto $dto)
    {
        return $this->repository->login($dto->username, $dto->password);
    }
}