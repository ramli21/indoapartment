@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold">Edit Payment Config</h1>
            </div>

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <form action="{{ route('admin.payment-configs.update', $paymentConfig) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4">
                        <label class="block">
                            <div class="text-sm text-slate-600 mb-1">Provider Name</div>
                            <input type="text" name="provider_name"
                                value="{{ old('provider_name', $paymentConfig->provider_name) }}"
                                class="w-full px-3 py-2 border rounded" />
                        </label>

                        <label class="block">
                            <div class="text-sm text-slate-600 mb-1">Merchant ID</div>
                            <input type="text" name="merchant_id"
                                value="{{ old('merchant_id', $paymentConfig->merchant_id) }}"
                                class="w-full px-3 py-2 border rounded" required />
                        </label>

                        <label class="block">
                            <div class="text-sm text-slate-600 mb-1">Client ID</div>
                            <input type="text" name="client_id" value="{{ old('client_id', $paymentConfig->client_id) }}"
                                class="w-full px-3 py-2 border rounded" required />
                        </label>

                        <label class="block">
                            <div class="text-sm text-slate-600 mb-1">Shared Key</div>
                            <input type="text" name="shared_key"
                                value="{{ old('shared_key', $paymentConfig->shared_key) }}"
                                class="w-full px-3 py-2 border rounded" required />
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_production" value="1" class="w-4 h-4"
                                {{ $paymentConfig->is_production ? 'checked' : '' }} />
                            <span class="text-sm text-slate-600">Is Production</span>
                        </label>

                        <div class="pt-2">
                            <button class="px-4 py-2 bg-brand text-white rounded">Simpan</button>
                            <a href="{{ route('admin.payment-configs.index') }}"
                                class="ml-2 text-sm text-slate-600">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
