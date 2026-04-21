<?php

namespace yangpimpollo\L3_infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use yangpimpollo\L2_application\UseCases\ShowCustomerUseCase;
use yangpimpollo\L2_application\UseCases\StoreCustomerUseCase;
use yangpimpollo\L2_application\DTOs\CustomerDto;

class CustomerController
{
    public function __construct(
        private ShowCustomerUseCase $ShowCustomerUseCase,
        private StoreCustomerUseCase $StoreCustomerUseCase
    ) {}

    public function show(string $id): JsonResponse 
    {
        $customer = $this->ShowCustomerUseCase->execute($id);

        if (!$customer) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Cliente no encontrado 🙄'
            ], 404);
        }

        return new JsonResponse([
            'status' => 'success✅',
            'data' => [
                'dni' => $customer->getDni(),
                'firstname' => $customer->getFirstname(),
                'lastname' => $customer->getLastname(),
                'phone' => $customer->getPhone(),
                'created_at' => $customer->getCreatedAt()->format('Y-m-d H:i:s')
            ]
        ]);
    }
   
    public function store(Request $request): JsonResponse 
    {
        $request->validate([
            'dni' => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'phone' => 'required|string',
        ]);

        $dto = new CustomerDto(
            $request->input('dni'),
            $request->input('firstname'),
            $request->input('lastname'),
            $request->input('phone')
        );

        $this->StoreCustomerUseCase->execute($dto);

        return new JsonResponse([
            'status' => 'success✅',
            'message' => '¡Cliente guardado correctamente! 🏎️',
        ], 201);
    }
}
