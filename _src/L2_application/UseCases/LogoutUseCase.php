<?php

namespace yangpimpollo\L2_application\UseCases;

use yangpimpollo\L1_domain\Repository\AuthRepositoryInterface;

class LogoutUseCase {
    public function __construct(
        private AuthRepositoryInterface $repository
    ) {}

    public function execute()
    {
        return $this->repository->logout();
    }
}