<?php

namespace yangpimpollo\L3_infrastructure\Controllers;

use Illuminate\Http\JsonResponse;

class DashBoardController
{
    public function __construct() {}

    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'success✅',
            'message' => 'Welcome to the dashboard!🎰',
            'url-1' => 'all_orders',
            'url-2' => 'new_order',
            'url-3' => 'logout',
        ]);
    }

}