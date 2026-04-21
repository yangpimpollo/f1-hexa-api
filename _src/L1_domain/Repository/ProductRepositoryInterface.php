<?php

namespace yangpimpollo\L1_domain\Repository;

interface ProductRepositoryInterface
{
    /**
     * @param string $query Término de búsqueda
     * @param string $storeId ID de la tienda del usuario
     */
    public function index(string $query, string $storeId);
}
