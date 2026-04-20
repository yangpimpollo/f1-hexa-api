<?php

namespace yangpimpollo\L3_infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use yangpimpollo\L2_application\UseCases\HelloWorld;

class HelloWorldController
{
    public function __construct(private readonly HelloWorld $useCase) {}

    public function __invoke(): JsonResponse
    {
        $message = $this->useCase->execute();

        return new JsonResponse([
            'status' => 'success✅',
            'data' => [ 'message' => $message ]
        ]);
    }
}