<?php

namespace yangpimpollo\L3_infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use yangpimpollo\L2_application\UseCases\ShowCustomerUseCase;
use yangpimpollo\L2_application\UseCases\StoreCustomerUseCase;

class CustomerController
{
    public function __construct(
        private ShowCustomerUseCase $ShowCustomerUseCase,
        private StoreCustomerUseCase $StoreCustomerUseCase
    ) {}

    public function show($id): JsonResponse {

        return new JsonResponse([
        ]);
    }
   
    public function store(Request $request): JsonResponse {


        return new JsonResponse([
        ]);
    }

}