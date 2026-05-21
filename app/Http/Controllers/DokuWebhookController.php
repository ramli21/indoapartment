<?php

namespace App\Http\Controllers;

use App\Services\DokuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DokuWebhookController extends Controller
{
    protected DokuService $doku;

    public function __construct(DokuService $doku)
    {
        $this->doku = $doku;
    }

    public function handleNotification(Request $request)
    {
        try {
            $clientId = $request->header('Client-Id') ?? $request->header('client-id');
            $requestId = $request->header('Request-Id') ?? $request->header('request-id');
            $signature = $request->header('Signature') ?? $request->header('signature');
            $timestamp = $request->header('Request-Timestamp') ?? $request->header('request-timestamp');
            $target = $request->getPathInfo();
            $body = $request->getContent();

            if (!$clientId || !$requestId || !$signature || !$timestamp) {
                return response()->json(['message' => 'Missing headers'], 400);
            }

            $valid = $this->doku->verifySignature($clientId, $requestId, $target, $timestamp, $signature, $body);

            if (!$valid) {
                Log::warning('Doku webhook signature invalid', ['clientId' => $clientId, 'requestId' => $requestId]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Simulate updating transaction status
            $payload = json_decode($body, true);
            // Example: find transaction by invoice id and update status (simulation)
            Log::info('Doku webhook received and verified', ['payload' => $payload]);

            // Return 200 OK as Doku expects; structure may vary by provider
            return response()->json(['code' => '00', 'message' => 'OK']);
        } catch (\Throwable $e) {
            Log::error('Doku webhook handle error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }
}
