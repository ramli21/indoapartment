@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-brand/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="check-circle" class="w-8 h-8 text-brand"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Booking Ditemukan!</h1>
                <p class="text-slate-500 mt-1">Berikut adalah detail pemesanan Anda</p>
            </div>

            <!-- Back Link -->
            <div class="mb-4">
                <a href="{{ route('booking.track') }}"
                    class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-brand">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Lacak booking lain
                </a>
            </div>

            <!-- Booking Details Card -->
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                <!-- Booking ID Header -->
                <div class="bg-brand px-6 py-4">
                    <div class="flex items-center justify-between">
                        <span class="text-white/80 text-sm">Kode Booking</span>
                        <span class="text-white font-mono text-xl font-semibold">
                            #{{ $booking->booking_code }}
                        </span>
                    </div>
                </div>

                <!-- Booking Info -->
                <div class="p-6 space-y-6">
                    <!-- Apartment Info -->
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i data-lucide="building" class="w-6 h-6 text-slate-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-slate-500">Apartemen</p>
                            <p class="font-semibold text-slate-800">{{ $booking->room->judul }}</p>
                            <p class="text-sm text-slate-600">{{ $booking->room->nama_tower }} - Lantai
                                {{ $booking->room->lantai }}</p>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div>
                        <p class="text-sm text-slate-500 mb-2">Status Booking</p>
                        @php
                            $statusLabels = [
                                'pending' => ['text' => 'Pending', 'class' => 'bg-amber-100 text-amber-700'],
                                'confirmed' => ['text' => 'Confirmed', 'class' => 'bg-green-100 text-green-700'],
                                'completed' => ['text' => 'Completed', 'class' => 'bg-brand text-white'],
                                'cancelled' => ['text' => 'Cancelled', 'class' => 'bg-slate-100 text-slate-600'],
                            ];
                            $status = $statusLabels[$booking->status] ?? $statusLabels['pending'];
                        @endphp
                        <span
                            class="inline-flex px-3 py-1 text-sm font-medium rounded-full capitalize {{ $status['class'] }}">
                            {{ $status['text'] }}
                        </span>
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-slate-500">Check-in</p>
                            <p class="font-medium text-slate-800">
                                {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}
                            </p>
                            <p class="text-sm text-slate-600">Pukul 14:00 WIB</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Check-out</p>
                            <p class="font-medium text-slate-800">
                                {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                            </p>
                            <p class="text-sm text-slate-600">Pukul 12:00 WIB</p>
                        </div>
                    </div>

                    <!-- Guest Info -->
                    <div class="border-t border-slate-100 pt-6">
                        <p class="text-sm text-slate-500 mb-3">Informasi Tamu</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-400">Nama Tamu</p>
                                <p class="text-slate-800">{{ $booking->nama_tamu }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Email</p>
                                <p class="text-slate-800">{{ $booking->email_tamu }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">No. WhatsApp</p>
                                <p class="text-slate-800">{{ $booking->no_hp }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400">Jumlah Tamu</p>
                                <p class="text-slate-800">{{ $booking->jumlah_tamu }} orang</p>
                            </div>
                        </div>
                    </div>

                    <!-- Price Summary -->
                    <div class="border-t border-slate-100 pt-6">
                        <p class="text-sm text-slate-500 mb-3">Rincian Pembayaran</p>
                        <div class="bg-slate-50 rounded-lg p-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Harga per malam</span>
                                <span class="text-slate-800">Rp
                                    {{ number_format($booking->harga_per_malam, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Lama menginap</span>
                                <span class="text-slate-800">{{ $booking->jumlah_malam }} malam</span>
                            </div>
                            <div class="flex justify-between text-sm border-t border-slate-200 pt-2 mt-2">
                                <span class="text-slate-800 font-medium">Total Pembayaran</span>
                                <span class="text-brand font-semibold">Rp
                                    {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if ($booking->catatan)
                        <div class="border-t border-slate-100 pt-6">
                            <p class="text-sm text-slate-500 mb-2">Catatan</p>
                            <p class="text-slate-700 text-sm">{{ $booking->catatan }}</p>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="px-6 pb-6 flex flex-col sm:flex-row gap-3">
                    @if (in_array($booking->status, ['pending', 'confirmed']))
                        @if (!empty($booking->paid_at))
                            <a href="https://wa.me/{{ $booking->room->owner_wa }}?text=Halo,%20saya%20ingin%20konfirmasi%20booking%20{{ $booking->booking_code }}"
                                target="_blank"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                                Hubungi via WhatsApp
                            </a>
                        @else
                            <a href="{{ route('booking.payment', $booking->booking_code) }}"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-brand text-white rounded-lg hover:bg-brand-light transition-colors text-sm">
                                <i data-lucide="credit-card" class="w-4 h-4"></i>
                                Bayar Sekarang
                            </a>
                        @endif
                    @endif
                    @if ($booking->status === 'pending')
                        <button onclick="window.print()"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors text-sm">
                            <i data-lucide="printer" class="w-4 h-4"></i>
                            Cetak Details
                        </button>
                    @else
                        <a href="{{ route('booking.track') }}"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors text-sm">
                            <i data-lucide="search" class="w-4 h-4"></i>
                            Lacak Booking Lain
                        </a>
                    @endif
                </div>

                <!-- Cancel Booking Button -->
                @if (in_array($booking->status, ['pending', 'confirmed']))
                    <div class="px-6 pb-2">
                        <a href="{{ route('booking.cancel', $booking->booking_code) }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors text-sm">
                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                            Batalkan Booking
                        </a>
                    </div>
                @endif
            </div>

            <!-- Help Text -->
            <div class="mt-6 p-4 bg-amber-50 rounded-xl border border-amber-100">
                <div class="flex gap-3">
                    <i data-lucide="info" class="w-5 h-5 text-amber-500 flex-shrink-0"></i>
                    <div class="text-sm text-amber-800">
                        <p class="font-medium mb-1">Catatan:</p>
                        <ul class="list-disc list-inside space-y-1 text-amber-700">
                            <li>Silakan datang tepat waktu sesuai tanggal check-in</li>
                            <li>Hubungi admin apartemen jika ada perubahan jadwal</li>
                            <li>Simpan kode booking ini untuk referensi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
@endsection
