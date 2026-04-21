<?php

namespace yangpimpollo\L3_infrastructure\Persistence;

use Illuminate\Support\Facades\DB;
use yangpimpollo\L1_domain\Entity\Customer;
use yangpimpollo\L1_domain\Repository\CustomerRepositoryInterface;
use yangpimpollo\L1_domain\ValueObjects\dni;
use yangpimpollo\L1_domain\ValueObjects\phone;
use DateTimeImmutable;

class EloquentCustomer implements CustomerRepositoryInterface
{
    private const TABLE = 'customers';

    public function show(dni $dni): ?Customer
    {
        $row = DB::selectOne(
            "SELECT dni, firstname, lastname, phone, created_at FROM " . self::TABLE . " WHERE dni = ?",
            [$dni->value()]
        );

        if (!$row) return null;

        return new Customer(
            new dni($row->dni),
            $row->firstname,
            $row->lastname,
            new phone($row->phone),
            new DateTimeImmutable($row->created_at)
        );
    }

    public function store(Customer $customer): void
    {
        // Usamos ON CONFLICT para PostgreSQL por si el cliente ya existe (Upsert)
        DB::insert(
            "INSERT INTO " . self::TABLE . " (dni, firstname, lastname, phone, created_at) 
             VALUES (:dni, :firstname, :lastname, :phone, :created_at)
             ON CONFLICT (dni) DO UPDATE SET 
                firstname = EXCLUDED.firstname,
                lastname = EXCLUDED.lastname,
                phone = EXCLUDED.phone",
            [
                'dni' => $customer->getDni(),
                'firstname' => $customer->getFirstname(),
                'lastname' => $customer->getLastname(),
                'phone' => $customer->getPhone(),
                'created_at' => $customer->getCreatedAt()->format('Y-m-d H:i:s'),
            ]
        );
    }
}
