<?php

namespace App\Http\Controllers;

use App\Services\DokuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\BookingPaymentLog;

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
                Log::channel('doku_webhook')->warning('Doku webhook missing headers', ['request' => $request->all(), 'headers' => [
                    'Client-Id' => $clientId,
                    'Request-Id' => $requestId,
                    'Signature' => $signature,
                    'Request-Timestamp' => $timestamp,
                ]]);
                return response()->json(['message' => 'Missing headers'], 400);
            }

            $valid = $this->doku->verifySignature($clientId, $requestId, $target, $timestamp, $signature, $body);

            if (!$valid) {
                Log::channel('doku_webhook')->warning('Doku webhook signature invalid', ['clientId' => $clientId, 'requestId' => $requestId, 'request-all' => $request->all(), 'headers' => [
                    'Client-Id' => $clientId,
                    'Request-Id' => $requestId,
                    'Signature' => $signature,
                    'Request-Timestamp' => $timestamp,
                ]]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Simulate updating transaction status
            $arrayData = json_decode($body, true);
            // Example: find transaction by invoice id and update status (simulation)

            $orderData = data_get($arrayData, 'order') ?? data_get($arrayData, 'request-all.order');
            $transactionData = data_get($arrayData, 'transaction') ?? data_get($arrayData, 'request-all.transaction');
            $channelData = data_get($arrayData, 'channel') ?? data_get($arrayData, 'request-all.channel');
            $invoiceNumber = $orderData['invoice_number'] ?? 'unknown';
            $amount = $orderData['amount'] ?? 0;
            $paymentChannel = $channelData['id'] ?? 'unknown';
            $status = $transactionData['status'] ?? 'unknown';

            $originalRequestId = $transactionData['original_request_id'] ?? null;
            $channelId = $channelData['id'] ?? 'UNKNOWN';

            if ($status === 'SUCCESS' && $invoiceNumber) {
                $booking = Booking::where('booking_code', $invoiceNumber)->first();
                
                if (!$booking) {
                    Log::channel('doku_webhook')->warning('Doku webhook received for non-existing booking', ['invoiceNumber' => $invoiceNumber, 'payload' => $arrayData]);
                    return response()->json(['code' => '01', 'message' => 'Booking not found'], 404);
                }
                
                $booking->status = 'confirmed';
                $booking->payment_method = 'doku';
                $booking->paid_at = now();
                $booking->payment_notes = "Payment successful via Doku channel $paymentChannel (ID: $channelId)";
                $booking->save();                

                // store log of payment notification
                self::StorePaymentLog(
                    $invoiceNumber,
                    $originalRequestId,
                    $amount,
                    $paymentChannel,
                    $status,
                    $arrayData
                );

                Log::channel('doku_webhook')->info('Booking marked as paid for invoice - ' . $invoiceNumber, ['invoiceNumber' => $invoiceNumber]);

                // Return 200 OK as Doku expects; structure may vary by provider
                return response()->json(['code' => '00', 'message' => 'OK']);
            } else {

                $booking = Booking::where('booking_code', 'ON9J3S')->first();
                // $booking = Booking::where('booking_code', $orderData['invoiceNumber'])->first();
                
                if (!$booking) {
                    Log::channel('doku_webhook')->error('Requested by doku : Booking not found', ['invoiceNumber' => $invoiceNumber, 'payload' => $arrayData]);
                    return response()->json(['code' => '01', 'message' => 'Booking not found'], 404);
                }
                
                $booking->status = 'cancel';
                $booking->payment_method = 'doku';
                $booking->payment_notes = "Payment failed via Doku channel $paymentChannel (ID: $channelId)";
                $booking->cancel_reason = "Payment failed with status $status";
                $booking->canceled_by = "system";
                $booking->cancel_at = now();
                $booking->save();
                
                self::StorePaymentLog(
                    // $orderData['invoiceNumber'],
                    'ON9J3S',
                    $originalRequestId,
                    $amount,
                    $paymentChannel,
                    $status,
                    $arrayData
                );

                Log::channel('doku_webhook')->info('Doku webhook received with non-success status', ['status' => $status, 'payload' => $arrayData]);
                return response()->json(['code' => '00', 'message' => 'OK'], 200);
            }

        } catch (\Throwable $e) {
            Log::channel('doku_webhook')->error('Doku webhook handle error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    private function StorePaymentLog($invoiceId, $originalRequestId, $amount, $paymentChannel, $status, $rawPayload)
    {
        BookingPaymentLog::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'original_request_id' => $originalRequestId,
            'invoice_number' => $invoiceId,
            'amount' => $amount,
            'payment_channel' => $paymentChannel,
            'status' => $status,
            'raw_payload' => json_encode($rawPayload),
        ]);

        return true;
    }
}
