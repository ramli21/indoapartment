@extends('admin.layout')

@section('content')
    <section class="pt-14 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Pengaturan Midtrans</h1>
                <p class="text-slate-500 mt-1">Input key dari Midtrans agar payment dapat diproses.</p>
            </div>

            @if (session('success'))
                <div class="mb-4 p-3 bg-emerald-100 text-emerald-800 rounded">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm">
                <form action="{{ route('admin.midtrans_settings.update') }}" method="post">
                    @csrf

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Server Key</label>
                            <input type="text" name="server_key"
                                value="{{ old('server_key', $setting->server_key ?? '') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="Masukkan server key Midtrans" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Client Key</label>
                            <input type="text" name="client_key"
                                value="{{ old('client_key', $setting->client_key ?? '') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="Masukkan client key Midtrans" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Webhook Secret (Opsional)</label>
                            <input type="text" name="webhook_secret"
                                value="{{ old('webhook_secret', $setting->webhook_secret ?? '') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="Masukkan webhook secret (jika ada)" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Mode</label>
                            <select name="is_production"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                                <option value="0"
                                    {{ old('is_production', $setting->is_production ?? false) == false ? 'selected' : '' }}>
                                    Sandbox (Development)
                                </option>
                                <option value="1"
                                    {{ old('is_production', $setting->is_production ?? false) == true ? 'selected' : '' }}>
                                    Production
                                </option>
                            </select>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="px-4 py-2 bg-brand text-white rounded-lg">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
