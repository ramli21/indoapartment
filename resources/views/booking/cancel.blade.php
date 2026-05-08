@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-6">
                <a href="{{ route('booking.track') }}"
                    class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-brand mb-4">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali
                </a>
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Batalkan Booking</h1>
                <p class="text-slate-500 mt-1">Anda yakin ingin membatalkan booking ini?</p>
            </div>

            <!-- Booking Info -->
            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Detail Booking</h2>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Kode Booking</span>
                        <span class="font-medium text-slate-800">#{{ $booking->booking_code }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Apartemen</span>
                        <span class="font-medium text-slate-800 text-right">{{ $booking->apartment->judul }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Check-in</span>
                        <span class="font-medium text-slate-800">
                            {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Check-out</span>
                        <span class="font-medium text-slate-800">
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Total Harga</span>
                        <span class="font-medium text-brand">Rp
                            {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                    </div>
                    @if (!empty($booking->paid_at))
                        <div class="flex justify-between">
                            <span class="text-slate-500">Status Pembayaran</span>
                            <span
                                class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">
                                Sudah Dibayar
                            </span>
                        </div>
                    @else
                        <div class="flex justify-between">
                            <span class="text-slate-500">Status Pembayaran</span>
                            <span
                                class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-amber-100 text-amber-700">
                                Belum Dibayar
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Warning -->
            @if (!empty($booking->paid_at))
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                    <div class="flex gap-3">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <h3 class="font-medium text-amber-800">Pembatalan dengan Pengembalian Dana</h3>
                            <p class="text-sm text-amber-700 mt-1">
                                Anda telah melakukan pembayaran untuk booking ini. Setelah pembatalan, silakan hubungi admin
                                untuk proses pengembalian dana.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <h3 class="font-medium text-blue-800">Pembatalan Tanpa Pengembalian Dana</h3>
                            <p class="text-sm text-blue-700 mt-1">
                                Anda belum melakukan pembayaran. Booking akan dibatalkan tanpa pengembalian dana.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Cancel Form -->
            <form method="POST" action="{{ route('booking.cancel', $booking->id) }}"
                class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alasan Pembatalan <span
                            class="text-red-500">*</span></label>
                    <textarea name="cancel_reason" rows="4" required
                        class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                        placeholder="Contoh: Rencana berubah, ingin booking tanggal lain, dll."></textarea>
                    @error('cancel_reason')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('booking.track') }}"
                        class="flex-1 px-6 py-3 border border-slate-200 text-slate-600 text-center font-medium rounded-lg hover:bg-slate-50 transition-colors">
                        Kembali
                    </a>
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-red-500 text-white text-center font-medium rounded-lg hover:bg-red-600 transition-colors">
                        Ya, Batalkan Booking
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
