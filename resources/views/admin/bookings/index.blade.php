@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Manajemen Booking</h1>
                    <p class="text-slate-500 mt-1">Kelola semua pemesanan apartemen</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.help') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-600 text-sm font-medium rounded-xl hover:bg-slate-200 transition-colors">
                        <i data-lucide="help-circle" class="w-4 h-4"></i>
                        Panduan
                    </a>
                    <a href="{{ route('admin.bookings.calendar') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors">
                        <i data-lucide="calendar-days" class="w-4 h-4"></i>
                        Kalender
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-slate-800">{{ $stats['total'] }}</div>
                    <div class="text-xs text-slate-500">Total</div>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-amber-500">{{ $stats['pending'] }}</div>
                    <div class="text-xs text-slate-500">Pending</div>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-emerald-500">{{ $stats['confirmed'] }}</div>
                    <div class="text-xs text-slate-500">Confirmed</div>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-brand">{{ $stats['completed'] }}</div>
                    <div class="text-xs text-slate-500">Completed</div>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="text-2xl font-semibold text-red-500">{{ $stats['cancelled'] }}</div>
                    <div class="text-xs text-slate-500">Cancelled</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm mb-6">
                <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nama oder email..."
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                        <select name="status"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Apartemen</label>
                        <select name="apartment_id"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                            <option value="">Semua Apartemen</option>
                            @foreach ($apartments as $apt)
                                <option value="{{ $apt->id }}"
                                    {{ request('apartment_id') == $apt->id ? 'selected' : '' }}>{{ $apt->judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-brand-light transition-colors text-sm">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bookings Table -->
            <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
                @if ($bookings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">ID</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Apartemen
                                    </th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Tamu</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">
                                        Check-in/out</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Total</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Status</th>
                                    <th class="text-left px-4 py-3 text-xs font-medium text-slate-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($bookings as $booking)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-4 py-3">
                                            <span
                                                class="font-mono text-sm">#{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm font-medium text-slate-800">
                                                {{ $booking->apartment->judul }}</div>
                                            <div class="text-xs text-slate-400">{{ $booking->apartment->nama_tower }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-slate-800">{{ $booking->nama_tamu }}</div>
                                            <div class="text-xs text-slate-400">{{ $booking->email_tamu }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm text-slate-600">
                                                {{ \Carbon\Carbon::parse($booking->check_in)->format('d M') }}</div>
                                            <div class="text-xs text-slate-400">s/d
                                                {{ \Carbon\Carbon::parse($booking->check_out)->format('d M') }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-sm font-medium text-brand">Rp
                                                {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-amber-100 text-amber-700',
                                                    'confirmed' => 'bg-emerald-100 text-emerald-700',
                                                    'completed' => 'bg-brand text-white',
                                                    'cancelled' => 'bg-slate-100 text-slate-600',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full capitalize {{ $statusClasses[$booking->status] ?? 'bg-slate-100 text-slate-600' }}">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                                class="inline-flex items-center gap-1 px-2 py-1 text-xs text-brand hover:bg-brand/10 rounded-lg transition-colors">
                                                <i data-lucide="eye" class="w-3 h-3"></i>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($bookings->hasPages())
                        <div class="px-4 py-3 border-t border-slate-100">
                            {{ $bookings->links('pagination::tailwind') }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="calendar-x" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-700 mb-1">Tidak ada booking</h3>
                        <p class="text-sm text-slate-500">Belum ada pemesanan untuk ditampilkan</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
