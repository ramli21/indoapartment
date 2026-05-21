@extends('admin.layout')
@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold">Payment Configurations</h1>
                    <p class="text-sm text-slate-500">Manage payment gateway credentials (Doku)</p>
                </div>
                <div>
                    <a href="{{ route('admin.payment-configs.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-brand text-white rounded-xl">Tambah</a>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left table-auto">
                        <thead>
                            <tr class="bg-slate-50 border-b">
                                <th class="px-5 py-3 text-sm text-slate-500">Provider</th>
                                <th class="px-5 py-3 text-sm text-slate-500">Merchant ID</th>
                                <th class="px-5 py-3 text-sm text-slate-500">Client ID</th>
                                <th class="px-5 py-3 text-sm text-slate-500">Production</th>
                                <th class="px-5 py-3 text-sm text-slate-500 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($configs as $conf)
                                <tr>
                                    <td class="px-5 py-4 text-sm">{{ $conf->provider_name }}</td>
                                    <td class="px-5 py-4 text-sm">{{ $conf->merchant_id }}</td>
                                    <td class="px-5 py-4 text-sm">{{ Str::limit($conf->client_id, 30) }}</td>
                                    <td class="px-5 py-4 text-sm">{{ $conf->is_production ? 'Yes' : 'No' }}</td>
                                    <td class="px-5 py-4 text-sm text-right">
                                        <a href="{{ route('admin.payment-configs.edit', $conf) }}"
                                            class="inline-flex items-center gap-2 px-3 py-1 bg-slate-100 rounded">Edit</a>
                                        <form action="{{ route('admin.payment-configs.destroy', $conf) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Hapus config ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="inline-flex items-center gap-2 px-3 py-1 bg-red-50 text-red-600 rounded">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center text-slate-500">Belum ada konfigurasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
