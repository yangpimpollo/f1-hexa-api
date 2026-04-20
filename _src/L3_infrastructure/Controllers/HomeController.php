<?php

namespace yangpimpollo\L3_infrastructure\Controllers;

use Illuminate\Http\JsonResponse;

class HomeController
{
    public function __construct() {}

    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'success✅',
            'message' => 'Welcome ComePizza!🍕 API',
            'by' => 'yangpimpollo',
            'url-1' => 'login',
            'url-2' => 'logout',
            'url-3' => 'dashboard',
        ]);
    }

}