<?php

namespace yangpimpollo\L3_infrastructure\Persistence;

use yangpimpollo\L1_domain\Repository\AuthRepositoryInterface;

class EloquentAuth implements AuthRepositoryInterface
{
    public function login(string $username, string $password){
        return "token 333";
    }

    public function logout(){
        return "token 333 9                 9 9 9 9 9 ";
    }
}
