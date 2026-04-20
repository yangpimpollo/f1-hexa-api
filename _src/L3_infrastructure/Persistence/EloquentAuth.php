<?php

namespace yangpimpollo\L3_infrastructure\Persistence;

use yangpimpollo\L1_domain\Repository\AuthRepositoryInterface;
use yangpimpollo\L3_infrastructure\Model\my_user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class EloquentAuth implements AuthRepositoryInterface
{
    public function login(string $username, string $password)
    {
        $user = my_user::where('username', $username)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Credenciales incorrectas.'],
            ]);
        }

        // Eliminar tokens anteriores si lo deseas (opcional)
        $user->tokens()->delete();

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logout()
    {
        $user = auth()->user();
        
        if ($user) {
            $user->currentAccessToken()->delete();
            return "❌❌❌ Sesión cerrada correctamente.";
        }

        return "No hay una sesión activa.";
    }
}
