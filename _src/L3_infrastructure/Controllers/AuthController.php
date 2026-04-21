<?php

namespace yangpimpollo\L3_infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use yangpimpollo\L2_application\DTOs\LoginDto;
use yangpimpollo\L2_application\UseCases\LoginUseCase;
use yangpimpollo\L2_application\UseCases\LogoutUseCase;

class AuthController
{
    public function __construct(
        private LoginUseCase $LoginUseCase,
        private LogoutUseCase $LogoutUseCase
    ) {}

    /**
     * pagina de Login
     */
    public function index(): JsonResponse {
        return new JsonResponse([ 'message' => 'quiero iniciar sección . . .🔒🗝️' ]);
    }

    /**
     * Login
     */
    public function login(Request $request): JsonResponse {

        $request->validate([ 'username' => 'required|string', 'password' => 'required|string', ]);
        $dto = new LoginDto( $request->input('username'), $request->input('password') );

        $token = $this->LoginUseCase->execute($dto);

        return new JsonResponse([
            'status' => 'success✅',
            'message' => 'Login exitoso!!! . . .',
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request): JsonResponse {
        $dat = $this->LogoutUseCase->execute();

        return new JsonResponse([
            'status' => 'success✅',
            'message' => 'Logout exitoso!!! . . .',
            'dat' => $dat
        ]);
    }

}