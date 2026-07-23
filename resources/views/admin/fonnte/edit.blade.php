@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Pengaturan Fonnte WhatsApp</h1>
                <p class="text-slate-500 mt-1">Atur kredensial dan konfigurasi API Fonnte untuk notifikasi WhatsApp.</p>
            </div>

            @if (session('success'))
                <div class="mb-4 p-3 bg-emerald-100 text-emerald-800 rounded-lg shadow-sm">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm">
                <form action="{{ route('admin.fonnte.update') }}" method="post">
                    @csrf

                    <div class="grid grid-cols-1 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Perangkat / Device Name</label>
                            <input type="text" name="name" value="{{ old('name', $setting->name ?? '') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="Contoh: Primary Device" required />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Fonnte API Base URL</label>
                            <input type="url" name="base_url" value="{{ old('base_url', $setting->base_url ?? 'https://api.fonnte.com') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="https://api.fonnte.com" required />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Fonnte API Token</label>
                            <input type="password" name="token"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="{{ isset($setting->token) ? '•••••••••••••••• (Kosongkan jika tidak ingin mengubah)' : 'Masukkan token Fonnte Anda' }}" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Country Code Default</label>
                            <input type="text" name="country_code" value="{{ old('country_code', $setting->country_code ?? '62') }}"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="62" required />
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                class="rounded border-slate-300 text-brand focus:ring-brand"
                                {{ old('is_active', $setting->is_active ?? true) ? 'checked' : '' }} />
                            <label for="is_active" class="text-sm font-medium text-slate-700 select-none">Aktifkan integrasi ini</label>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex justify-end">
                            <button type="submit" class="px-5 py-2.5 bg-brand hover:bg-brand-dark text-white rounded-lg font-medium text-sm transition-colors shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
