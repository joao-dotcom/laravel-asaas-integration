<?php

namespace App\Services;

class MessageService
{
    public function success()
    {
        return response()->json([
            'message' => 'Sucesso.',
            'success' => true
        ], 200);
    }

    public function unauthorized()
    {
        return response()->json([
            'message' => 'Não Autorizado.',
            'success' => true
        ], 401);
    }
    
    public function notFound()
    {
        return response()->json([
            'message' => 'Não encontrado.',
            'success' => true
        ], 404);
    }
}
