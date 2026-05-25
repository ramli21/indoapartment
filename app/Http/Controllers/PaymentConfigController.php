<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentConfigRequest;
use App\Http\Requests\UpdatePaymentConfigRequest;
use App\Models\PaymentConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentConfigController extends Controller
{
    public function index()
    {
        $configs = PaymentConfig::orderBy('id', 'desc')->get();
        return view('admin.payment_configs.index', compact('configs'));
    }

    public function create()
    {
        return view('admin.payment_configs.create');
    }

    public function edit(PaymentConfig $paymentConfig)
    {
        return view('admin.payment_configs.edit', ['paymentConfig' => $paymentConfig]);
    }

    public function store(StorePaymentConfigRequest $request)
    {
        try {
            $data = $request->only(['provider_name', 'merchant_id', 'client_id', 'shared_key']);
            $data['is_production'] = $request->has('is_production') ? 1 : 0;
            $config = PaymentConfig::create($data);
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Created', 'data' => $config], 201);
            }
            return redirect()->route('admin.payment-configs.index')->with('success', 'Payment config created');
        } catch (\Throwable $e) {
            Log::error('PaymentConfig store error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Failed to create payment config'], 500);
            }
            return redirect()->back()->with('error', 'Failed to create payment config');
        }
    }

    public function show(PaymentConfig $paymentConfig)
    {
        return response()->json(['data' => $paymentConfig]);
    }

    public function update(UpdatePaymentConfigRequest $request, PaymentConfig $paymentConfig)
    {
        try {
            $data = $request->only(['provider_name', 'merchant_id', 'client_id', 'shared_key']);
            $data['is_production'] = $request->has('is_production') ? 1 : 0;
            $paymentConfig->update($data);
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Updated', 'data' => $paymentConfig]);
            }
            return redirect()->route('admin.payment-configs.index')->with('success', 'Payment config updated');
        } catch (\Throwable $e) {
            Log::error('PaymentConfig update error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Failed to update payment config'], 500);
            }
            return redirect()->back()->with('error', 'Failed to update payment config');
        }
    }

    public function destroy(PaymentConfig $paymentConfig)
    {
        try {
            $paymentConfig->delete();
            return redirect()->back()->with('success', 'Payment config deleted');
        } catch (\Throwable $e) {
            Log::error('PaymentConfig delete error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete payment config');
        }
    }
}
