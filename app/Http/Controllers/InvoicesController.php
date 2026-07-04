<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoicesRequest;
use App\Services\AsaasService;
use Exception;

class InvoicesController extends Controller
{
    protected $asaas_service;

    public function __construct()
    {
        $this->asaas_service = new AsaasService();
    }

    public function storeInvoice(InvoicesRequest $request)
    {
        try {
            $data = $request->validated();

            $invoice = $this->asaas_service->storeInvoice($data);

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
