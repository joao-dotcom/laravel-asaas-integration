<?php

namespace App\Http\Controllers;

use App\Services\AsaasService;
use Exception;

class ClientController extends Controller
{

    protected $asaas_service;

    public function __construct()
    {
        $this->asaas_service = new AsaasService();
    }
    
    public function clientInvoices()
    {
        try {

            $invoice = $this->asaas_service->clientInvoices();

            if (!$invoice) {
                return response()->json([
                    'message' => "Cliente não encontrado!",
                    'success' => false,
                ], 404);
            }

            return response()->json([
                'data' => $invoice,
                'success' => true,
            ], 200);
        } catch (Exception $e) {
            return "Erro: " . $e->getMessage();
        }
    }
}
