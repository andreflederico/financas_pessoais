<?php

namespace App\Controllers;

class TransactionController
{
    public function index()
    {
        // Só é executado se passar pelo AuthMiddleware
        echo "Listagem de transações (área logada)";
    }

    public function store()
    {
        // Só chega aqui se passar por AuthMiddleware E CsrfMiddleware
        echo "Transação criada com sucesso!";
    }
}
