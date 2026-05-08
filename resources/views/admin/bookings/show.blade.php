@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <!-- Back -->
            <div class="mb-6">
                <a href="{{ route('admin.bookings.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-brand transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Daftar Booking
                </a>
            </div>

            <!-- Booking Card -->
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                <!-- Header -->
                <div class="p-6 border-b border-slate-100">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-mono text-lg text-slate-400">#{{ $booking->booking_code }}</span>
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
                            </div>
                            <h1 class="text-2xl font-serif font-semibold text-slate-800">{{ $booking->apartment->judul }}
                            </h1>
                            <p class="text-sm text-slate-500">{{ $booking->apartment->nama_tower }} - Kamar
                                {{ $booking->apartment->nomor_kamar }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-brand">Rp
                                {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                            <div class="text-xs text-slate-500">{{ $booking->jumlah_malam }} malam</div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Guest Info -->
                        <div>
                            <h3 class="text-sm font-medium text-slate-700 mb-4 flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4 text-brand"></i>
                                Informasi Tamu
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-xs text-slate-500">Nama Tamu</div>
                                    <div class="text-sm font-medium text-slate-800">{{ $booking->nama_tamu }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">Email</div>
                                    <div class="text-sm text-slate-800">{{ $booking->email_tamu }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">No. HP</div>
                                    <div class="text-sm text-slate-800">{{ $booking->no_hp }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div>
                            <h3 class="text-sm font-medium text-slate-700 mb-4 flex items-center gap-2">
                                <i data-lucide="calendar" class="w-4 h-4 text-brand"></i>
                                Detail Booking
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-xs text-slate-500">Check-in</div>
                                    <div class="text-sm font-medium text-slate-800">
                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('d F Y') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">Check-out</div>
                                    <div class="text-sm font-medium text-slate-800">
                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('d F Y') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">Jumlah Tamu</div>
                                    <div class="text-sm font-medium text-slate-800">{{ $booking->jumlah_tamu }} Tamu</div>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">Harga per Malam</div>
                                    <div class="text-sm font-medium text-slate-800">Rp
                                        {{ number_format($booking->harga_per_malam, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if ($booking->catatan)
                        <div class="mt-6 p-4 bg-slate-50 rounded-xl">
                            <h3 class="text-sm font-medium text-slate-700 mb-2">Catatan</h3>
                            <p class="text-sm text-slate-600">{{ $booking->catatan }}</p>
                        </div>
                    @endif

                    <!-- Payment Info -->
                    <div class="mt-6 p-4 bg-slate-50 rounded-xl">
                        <h3 class="text-sm font-medium text-slate-700 mb-4 flex items-center gap-2">
                            <i data-lucide="credit-card" class="w-4 h-4"></i>
                            Informasai Pembayaran
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <div class="text-xs text-slate-500">Metode Pembayaran</div>
                                <div class="text-sm font-medium text-slate-800">
                                    @if ($booking->payment_method === 'bank_transfer')
                                        Transfer Bank
                                    @elseif($booking->payment_method === 'qris')
                                        QRIS
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500">Status Pembayaran</div>
                                <div class="text-sm font-medium">
                                    @if ($booking->paid_at)
                                        <span
                                            class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">
                                            Lunas
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-amber-100 text-amber-700">
                                            Menunggu Pembayaran
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if ($booking->paid_at)
                                <div>
                                    <div class="text-xs text-slate-500">Tanggal Bayar</div>
                                    <div class="text-sm text-slate-800">
                                        {{ \Carbon\Carbon::parse($booking->paid_at)->format('d F Y, H:i') }}
                                    </div>
                                </div>
                            @endif
                            @if ($booking->payment_proof)
                                <div>
                                    <div class="text-xs text-slate-500">Bukti Transfer</div>
                                    <a href="{{ Storage::url($booking->payment_proof) }}" target="_blank"
                                        class="text-sm text-brand hover:underline flex items-center gap-1">
                                        <i data-lucide="image" class="w-3 h-3"></i>
                                        Lihat Bukti
                                    </a>
                                </div>
                            @endif
                            @if ($booking->payment_notes)
                                <div class="md:col-span-2">
                                    <div class="text-xs text-slate-500">Catatan Pembayaran</div>
                                    <div class="text-sm text-slate-800">{{ $booking->payment_notes }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Owner Contact -->
                    <div class="mt-6 p-4 bg-brand/5 rounded-xl border border-brand/10">
                        <h3 class="text-sm font-medium text-brand mb-3 flex items-center gap-2">
                            <i data-lucide="building" class="w-4 h-4"></i>
                            Informasi Owner
                        </h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <div class="text-xs text-slate-500">Nama</div>
                                <div class="text-slate-800">{{ $booking->apartment->owner_nama }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500">WhatsApp</div>
                                <div class="text-slate-800">{{ $booking->apartment->owner_wa }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500">Bank</div>
                                <div class="text-slate-800">{{ $booking->apartment->owner_bank_name }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-slate-500">No. Rekening</div>
                                <div class="text-slate-800 font-mono">{{ $booking->apartment->owner_rekening }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Update -->
                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <h3 class="text-sm font-medium text-slate-700 mb-4">Update Status</h3>
                        <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking->id) }}"
                            class="flex flex-wrap gap-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="status" value="pending"
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $booking->status === 'pending' ? 'bg-amber-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                Pending
                            </button>
                            <button type="submit" name="status" value="confirmed"
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $booking->status === 'confirmed' ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                Confirmed
                            </button>
                            <button type="submit" name="status" value="completed"
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $booking->status === 'completed' ? 'bg-brand text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                Completed
                            </button>
                            @if ($booking->status !== 'cancelled')
                                <button type="submit" name="status" value="cancelled"
                                    class="px-4 py-2 rounded-lg text-sm font-medium bg-red-50 text-red-600 hover:bg-red-100 transition-colors">
                                    Cancel
                                </button>
                            @endif
                        </form>
                    </div>

                    <!-- Delete -->
                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <form method="POST" action="{{ route('admin.bookings.destroy', $booking->id) }}"
                            onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 rounded-lg text-sm font-medium bg-red-500 text-white hover:bg-red-600 transition-colors flex items-center gap-2">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                Hapus Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
