<?php

namespace App\Services;

use App\Models\Clients;
use App\Models\Invoices;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class AsaasService
{
    protected $api_url;
    protected $api_token;

    public function __construct()
    {
        $this->api_url = config('asaas.api.url');
        $this->api_token = config('asaas.api.token');
    }

    public function getClient()
    {
        $user_id = auth('api')->user()->id;

        $client = Clients::where('id', $user_id)->first();

        return $client;
    }

    public function storeInvoiceDB($request, $dueDate)
    {
        Invoices::create([
            'payment_id' => $request['payment_id'],
            'billing_type' => $request['billingType'],
            'value' => $request['value'],
            'due_date' => $dueDate,
            'description' => $request['description'],
            'external_reference' => $request['external_reference']
        ]);
    }

    public function storeCustomer()
    {
        $client = $this->getClient();

        $request['cpfCnpj'] = $client->cpfCnpj ?? null;
        $request['name'] = $client->name ?? null;
        $request['email'] = $client->email ?? null;
        $request['phoneNumber'] = $client->phone_number ?? null;
        $request['mobilePhone'] = $client->mobile_phone ?? null;
        $request['address'] = $client->address ?? null;
        $request['addressNumber'] = $client->address_number ?? null;
        $request['complement'] = $client->complement ?? null;

        $response = Http::baseUrl($this->api_url)
            ->withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'access_token' => $this->api_token,
            ])
            ->post('/customers', $request);

        if ($client) {
            $client->update(["customer_id" => $response['id']]);
        }

        return $response->json();
    }

    public function storeInvoice($request)
    {
        $client = $this->getClient();

        if ($client) {
            if (empty($client->customer_id)) {
                $this->storeCustomer();
            }

            $dueDate = Carbon::now()->addMonth()->format('Y-m-d');

            $request['external_reference'] = "BOLETO SISTEMA";
            $request['dueDate'] = $dueDate;
            $request['billingType'] = "BOLETO";
            $request['customer'] = $client->customer_id;

            $response = Http::baseUrl($this->api_url)
                ->withHeaders([
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'access_token' => $this->api_token,
                ])
                ->post('/payments', $request);

            $request['payment_id'] = $response['id'];

            $this->storeInvoiceDB($request, $dueDate);

            return $response;
        }
        return false;
    }

    public function clientInvoices()
    {
        $client = $this->getClient();

        if ($client) {
            if (empty($client->customer_id)) {
                $this->storeCustomer();
            }

            $request['customer'] = $client->customer_id;

            $response = Http::baseUrl($this->api_url)
                ->withHeaders([
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'access_token' => $this->api_token,
                ])
                ->get('/payments', $request);

            return $response->json();
        }
        return false;
    }
}
