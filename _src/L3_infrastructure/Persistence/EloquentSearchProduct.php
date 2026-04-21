<?php

namespace yangpimpollo\L3_infrastructure\Persistence;

use yangpimpollo\L1_domain\Repository\ProductRepositoryInterface;

class EloquentSearchProduct implements ProductRepositoryInterface
{
    public function index(string $query, string $storeId)
    {
        // SQL Puro de alto rendimiento para PostgreSQL
        return \Illuminate\Support\Facades\DB::select("
            SELECT 
                p.product_id, 
                p.product_name, 
                p.product_price, 
                i.quantity as stock
            FROM products p
            INNER JOIN inventories i ON p.product_id = i.product_id
            WHERE i.store_id = ? 
              AND p.product_name ILIKE ?
            ORDER BY p.product_name ASC
            LIMIT 20
        ", [$storeId, "%{$query}%"]);
    }

    public function show(string $productId): ?object
    {
        return \Illuminate\Support\Facades\DB::selectOne(
            "SELECT product_id, product_price FROM products WHERE product_id = ?",
            [$productId]
        );
    }
}