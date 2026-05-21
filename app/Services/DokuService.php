<?php

namespace App\Services;

use App\Models\PaymentConfig;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DokuService
{
    protected ?PaymentConfig $config = null;

    public function __construct()
    {
        $this->config = PaymentConfig::where('provider_name', 'doku')->orderBy('id', 'desc')->first();
    }

    public function getConfig(): ?PaymentConfig
    {
        return $this->config;
    }

    /**
     * Generate signature according to Doku V2 docs
     *
     * @param string $requestId
     * @param string $targetPath e.g. "/v1/payment"
     * @param string $requestBody raw JSON string
     * @param string $timestamp
     * @return string
     */
    public function generateSignature(string $requestId, string $targetPath, string $requestBody, string $timestamp): string
    {
        $config = $this->config;
        $clientId = $config->client_id ?? '';
        $sharedKey = $config->shared_key ?? '';

        $digest = base64_encode(hash('sha256', $requestBody ?? '', true));

        $components = [];
        $components[] = 'Client-Id:' . $clientId;
        $components[] = 'Request-Id:' . $requestId;
        $components[] = 'Request-Timestamp:' . $timestamp;
        $components[] = 'Request-Target:' . $targetPath;
        $components[] = 'Digest:' . $digest;

        // $rawSignatureComponent = 
        //     "Client-Id:" . $clientId . "\n" .
        //     "Request-Id:" . $requestId . "\n" .
        //     "Request-Timestamp:" . $timestamp . "\n" .
        //     "Request-Target:" . $targetPath . "\n" .
        //     "Bytes:" . $digest;

        $signingString = implode("\n", $components);

        // dd($signingString);

        $signature = base64_encode(hash_hmac('sha256', $signingString, $sharedKey, true));

        return $signature;
    }

    /**
     * Create invoice/session in Doku
     */
    public function createInvoice(float $amount, string $invoiceNumber, array $customerDetails = []): array
    {
        $config = $this->config;
        if (!$config) {
            throw new \RuntimeException('Doku configuration not found');
        }

        // Example endpoint - replace with actual Doku endpoint for environment
        $base = $config->is_production ? 'https://api.doku.com' : 'https://api-sandbox.doku.com';
        $path = '/checkout/v1/payment';
        $url = rtrim($base, '/') . $path;

        $requestId = (string) Str::uuid();
        $timestamp = now()->toIso8601ZuluString();

        $body = [
            'order' => [
                'amount' => $amount,
                'invoice_number' => $invoiceNumber,
                'customer' => $customerDetails,
            ],
            'payment' => [
                'payment_due_date' => 120, // in minutes
            ],
        ];

        $bodyJson = json_encode($body, JSON_UNESCAPED_SLASHES);

        
        $signature = $this->generateSignature($requestId, $path, $bodyJson, $timestamp);
        // dd($bodyJson, "HMACSHA256=" . $signature);

        $headers = [
            'Content-Type' => 'application/json',
            'Client-Id' => $config->client_id,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $timestamp,
            'Signature' => "HMACSHA256=" . $signature,
        ];

        // dd($headers);

        try {
            $response = Http::withHeaders($headers)
                ->timeout(15)
                ->post($url, $body);

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            }

            Log::warning('Doku createInvoice failed', ['status' => $response->status(), 'body' => $response->body()]);
            return ['success' => false, 'status' => $response->status(), 'body' => $response->body()];
        } catch (\Throwable $e) {
            Log::error('Doku createInvoice error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Verify incoming webhook signature. Returns true if valid.
     */
    public function verifySignature(string $clientId, string $requestId, string $requestTarget, string $timestamp, string $signature, string $body): bool
    {
        // find config by client id
        $configs = PaymentConfig::where('provider_name', 'doku')->get();
        foreach ($configs as $cfg) {
            if ($cfg->client_id && hash_equals($cfg->client_id, $clientId)) {
                $sharedKey = $cfg->shared_key;
                $digest = base64_encode(hash('sha256', $body ?? '', true));
                $components = [];
                $components[] = 'Client-Id:' . $clientId;
                $components[] = 'Request-Id:' . $requestId;
                $components[] = 'Request-Timestamp:' . $timestamp;
                $components[] = 'Request-Target:' . $requestTarget;
                $components[] = 'Digest:' . $digest;

                $signingString = implode("\n", $components);
                $expected = base64_encode(hash_hmac('sha256', $signingString, $sharedKey, true));
                return hash_equals($expected, $signature);
            }
        }

        return false;
    }
}
