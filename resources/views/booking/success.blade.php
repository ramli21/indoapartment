@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <!-- Success Card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-8 shadow-sm text-center">
                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="check" class="w-8 h-8 text-emerald-500"></i>
                </div>

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <h1 class="text-2xl font-serif font-semibold text-slate-800 mb-2">Booking Berhasil!</h1>
                <p class="text-slate-500 mb-8">Nomor booking Anda:</p>

                <div class="inline-block bg-brand/5 border border-brand/10 px-6 py-3 rounded-xl mb-8">
                    <span class="text-2xl font-bold text-brand tracking-wider">#{{ $booking->booking_code }}</span>
                </div>

                <!-- Booking Details -->
                <div class="text-left bg-slate-50 rounded-xl p-5 mb-6">
                    <h3 class="text-sm font-medium text-slate-500 mb-3">Detail Booking</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Apartemen</span>
                            <span class="text-slate-800 font-medium">{{ $booking->room->judul }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Tower</span>
                            <span class="text-slate-800">{{ $booking->room->apartment->nama }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Kamar</span>
                            <span class="text-slate-800">{{ $booking->room->nomor_kamar }}</span>
                        </div>
                        <div class="border-t border-slate-200 my-3"></div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Check-in</span>
                            <span
                                class="text-slate-800">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Check-out</span>
                            <span
                                class="text-slate-800">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Jumlah Tamu</span>
                            <span class="text-slate-800">{{ $booking->jumlah_tamu }} Tamu</span>
                        </div>
                        <div class="border-t border-slate-200 my-3"></div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Nama Tamu</span>
                            <span class="text-slate-800">{{ $booking->nama_tamu }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">No. HP</span>
                            <span class="text-slate-800">{{ $booking->no_hp }}</span>
                        </div>
                        <div class="border-t border-slate-200 my-3"></div>
                        <div class="flex justify-between">
                            @php
                                $checkIn = \Carbon\Carbon::parse($booking->check_in);
                                $checkOut = \Carbon\Carbon::parse($booking->check_out);
                                $jumlahMalam = $checkIn->diffInDays($checkOut);
                                $total_ppn = $booking->harga_per_malam * $jumlahMalam * ($booking->ppn / 100);
                                $total_admin = $booking->harga_per_malam * $jumlahMalam * ($booking->admin_fee / 100);
                                $subtotal = $booking->harga_per_malam * $jumlahMalam;
                            @endphp
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Sub Total</span>
                            <span class="text-slate-800">Rp
                                {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if ($booking->discount_amount > 0)
                            <div class="flex justify-between">
                                <span class="text-emerald-600">Diskon
                                    @if ($booking->discount_type === 'Voucher')
                                        ({{ $booking->voucher_code }})
                                    @endif
                                </span>
                                <span class="text-emerald-600">-Rp
                                    {{ number_format($booking->discount_amount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-slate-600">PPN</span>
                            <span class="text-slate-800">Rp {{ number_format($total_ppn, 0, ',', '.') }}
                                ({{ $booking->ppn }}%)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Admin Fee</span>
                            <span class="text-slate-800">Rp {{ number_format($total_admin, 0, ',', '.') }}
                                ({{ $booking->admin_fee }}%)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Total Pembayaran</span>
                            <span class="text-lg font-bold text-brand">Rp
                                {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-slate-200 my-3"></div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Status</span>
                            <span
                                class="inline-flex px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-full capitalize">
                                {{ $booking->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Owner Contact -->
                {{-- <div class="text-left bg-brand/5 border border-brand/10 rounded-xl p-5 mb-6">
                    <h3 class="text-sm font-medium text-brand mb-3 flex items-center gap-2">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        Hubungi Owner
                    </h3>
                    <p class="text-sm text-slate-600 mb-3">Silakan hubungi owner untuk konfirmasi dan informasi pembayaran:
                    </p>

                    <div class="space-y-2">
                        <a href="https://wa.me/{{ $apartment->owner_wa }}?text=Halo, saya ingin booking apartemen {{ $apartment->judul }}"
                            target="_blank"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-500 text-white rounded-xl font-medium hover:bg-emerald-600 transition-colors">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            Chat WhatsApp
                        </a>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Atas Nama</span>
                            <span class="text-slate-700">{{ $apartment->owner_nama }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Bank</span>
                            <span class="text-slate-700">{{ $apartment->owner_bank_name }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">No. Rekening</span>
                            <span class="text-slate-700 font-mono">{{ $apartment->owner_rekening }}</span>
                        </div>
                    </div>
                </div> --}}

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    @if (!$booking->paid_at)
                        <a href="{{ route('booking.payment', $booking->booking_code) }}"
                            class="flex-1 px-4 py-3 bg-brand text-white rounded-xl font-medium hover:bg-brand-light transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="credit-card" class="w-4 h-4"></i>
                            Bayar Sekarang
                        </a>
                    @endif
                    <a href="{{ route('rooms.list') }}"
                        class="flex-1 px-4 py-3 bg-slate-100 text-slate-700 rounded-xl font-medium hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="home" class="w-4 h-4"></i>
                        Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
