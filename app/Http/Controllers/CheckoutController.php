<?php

namespace App\Http\Controllers;

use App\Services\DokuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected DokuService $doku;

    public function __construct(DokuService $doku)
    {
        $this->doku = $doku;
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'invoice_number' => 'required|string',
            'customer' => 'nullable|array',
        ]);

        try {
            $amount = (float) $request->input('amount');
            $invoice = $request->input('invoice_number');
            $customer = $request->input('customer', []);

            $result = $this->doku->createInvoice($amount, $invoice, $customer);

            dd($result);

            if (!empty($result['success'])) {
                // open new tab with payment URL
                return redirect()->away($result['data']['payment_url']);
                // return response()->json(['success' => true, 'data' => $result['data']]);

            }

            return response()->json(['success' => false, 'error' => $result], 500);
        } catch (\Throwable $e) {
            Log::error('Checkout processPayment error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Internal error'], 500);
        }
    }
}
