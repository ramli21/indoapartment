@extends('admin.layout')

@section('content')
    <section class="pt-8 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand">Pesan Masuk (Inquiries)</h1>
                    <p class="text-slate-500 mt-1">Kelola pesan dari form Hubungi Kami</p>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-green-700 animate-fadeIn">
                    <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-slate-800">{{ $stats['total'] ?? 0 }}</div>
                    <div class="text-xs text-slate-500">Total</div>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-amber-500">{{ $stats['baru'] ?? 0 }}</div>
                    <div class="text-xs text-slate-500">Baru</div>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-slate-600">{{ $stats['dibaca'] ?? 0 }}</div>
                    <div class="text-xs text-slate-500">Dibaca</div>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-brand">{{ $stats['dijawab'] ?? 0 }}</div>
                    <div class="text-xs text-slate-500">Dijawab</div>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-emerald-600">{{ $stats['selesai'] ?? 0 }}</div>
                    <div class="text-xs text-slate-500">Selesai</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm mb-6">
                <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nama / Email / Subjek"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                        <select name="status"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                            <option value="">Semua Status</option>
                            <option value="baru" {{ request('status') === 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="dibaca" {{ request('status') === 'dibaca' ? 'selected' : '' }}>Dibaca</option>
                            <option value="dijawab" {{ request('status') === 'dijawab' ? 'selected' : '' }}>Dijawab</option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                        </select>
                    </div>
                    <div class="sm:col-span-3 lg:col-span-4"></div>
                    <div>
                        <button type="submit"
                            class="w-full bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-brand-light transition-colors text-sm">Filter</button>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
                @if ($inquiries->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Nama</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Email</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Subjek</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Apartemen
                                    </th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Status</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Tanggal
                                    </th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($inquiries as $inquiry)
                                    @php
                                        $statusClasses = [
                                            'baru' => 'bg-amber-100 text-amber-700',
                                            'dibaca' => 'bg-slate-100 text-slate-600',
                                            'dijawab' => 'bg-brand/10 text-brand',
                                            'selesai' => 'bg-emerald-100 text-emerald-700',
                                        ];
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-4 py-3">
                                            <div class="text-sm font-medium text-slate-800">{{ $inquiry->nama }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-slate-700">{{ $inquiry->email }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-slate-800">{{ $inquiry->subjek }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ $inquiry->apartment->judul ?? '-' }}
                    </div>
                    </td>
                    <td class="px-4 py-3">
                        <span
                            class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full {{ $statusClasses[$inquiry->status] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ $inquiry->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm text-slate-600">
                            {{ optional($inquiry->created_at)->format('d M Y') }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.inquiries.show', $inquiry->id) }}"
                                class="inline-flex items-center gap-1 px-2 py-1 text-xs text-brand hover:bg-brand/10 rounded-lg transition-colors">
                                <i data-lucide="eye" class="w-3 h-3"></i>
                                Detail
                            </a>
                        </div>
                    </td>
                    </tr>
                @endforeach
                </tbody>
                </table>
            </div>

            @if ($inquiries->hasPages())
                <div class="px-4 py-3 border-t border-slate-100">
                    {{ $inquiries->links('pagination::tailwind') }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="inbox" class="w-8 h-8 text-slate-300"></i>
                </div>
                <h3 class="text-lg font-medium text-slate-700 mb-1">Tidak ada inquiry</h3>
                <p class="text-sm text-slate-500">Belum ada pesan untuk ditampilkan</p>
            </div>
            @endif
        </div>
        </div>
    </section>
@endsection
