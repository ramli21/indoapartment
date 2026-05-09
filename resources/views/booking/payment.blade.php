@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Pembayaran</h1>
                <p class="text-slate-500 mt-1">Selesaikan pembayaran untuk booking Anda</p>
            </div>

            <!-- Booking Summary -->
            <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm mb-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-medium text-slate-500">Kode Booking</span>
                    <span class="text-lg font-bold text-brand">#{{ $booking->booking_code }}</span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Apartemen</span>
                        <span class="text-slate-800 font-medium">{{ $booking->apartment->judul }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Check-in</span>
                        <span class="text-slate-800">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Check-out</span>
                        <span
                            class="text-slate-800">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Durasi</span>
                        <span class="text-slate-800">{{ $booking->jumlah_malam }} malam</span>
                    </div>
                    <div class="border-t border-slate-200 pt-2 mt-2">
                        <div class="flex justify-between">
                            <span class="text-slate-600 font-medium">Total Pembayaran</span>
                            <span class="text-xl font-bold text-brand">Rp
                                {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm">
                <form id="paymentForm" onsubmit="return false;">
                    @csrf

                    <!-- Payment Notes -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Pembayaran (Opsional)</label>
                        <textarea id="payment_notes" name="payment_notes" rows="2"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm resize-none"
                            placeholder="Tambahkan catatan..."></textarea>
                    </div>

                    <div class="mb-4 text-sm text-slate-500">
                        Pembayaran diproses oleh Midtrans. Status pembayaran akan otomatis terupdate via webhook.
                    </div>

                    <button id="payButton" type="button"
                        class="w-full bg-brand text-white px-6 py-3 rounded-xl font-medium hover:bg-brand-light transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                        Bayar dengan Midtrans
                    </button>

                    <div id="payStatus"
                        class="hidden mt-4 text-sm text-slate-600 bg-slate-50 border border-slate-100 rounded-lg p-3">
                        Menyiapkan pembayaran...
                    </div>

                    <!-- Back Link -->
                    <div class="text-center mt-4">
                        <a href="{{ route('booking.success', $booking->id) }}"
                            class="text-sm text-slate-500 hover:text-brand">
                            &larr; Kembali ke detail booking
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </section>

    @push('scripts')
        <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js"
            data-client-key="{{ \App\Models\MidtransSetting::getFirst()?->client_key }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const payButton = document.getElementById('payButton');
                const payStatus = document.getElementById('payStatus');

                payButton.addEventListener('click', async function() {
                    try {
                        payStatus.classList.remove('hidden');

                        const csrfToken = document.querySelector('input[name="_token"]').value;
                        const paymentNotes = document.getElementById('payment_notes').value || null;

                        const resp = await fetch(
                            '{{ route('booking.payment.midtrans', $booking->booking_code) }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                },
                                body: JSON.stringify({
                                    payment_notes: paymentNotes
                                }),
                            });

                        const data = await resp.json();
                        if (!data.success) {
                            alert(data.message || 'Gagal menyiapkan pembayaran.');
                            payStatus.classList.add('hidden');
                            return;
                        }

                        if (!data.snap_token) {
                            alert('Midtrans snap token tidak tersedia.');
                            payStatus.classList.add('hidden');
                            return;
                        }

                        // Midtrans Snap checkout
                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                // Real update comes from webhook.
                                payStatus.innerText =
                                    'Pembayaran berhasil (menunggu konfirmasi webhook)';
                            },
                            onPending: function(result) {
                                payStatus.innerText =
                                    'Pembayaran pending (menunggu settlement webhook)';
                            },
                            onError: function(result) {
                                console.error(result);
                                alert('Pembayaran gagal.');
                                payStatus.classList.add('hidden');
                            },
                            onClose: function() {
                                payStatus.classList.add('hidden');
                            }
                        });
                    } catch (e) {
                        console.error(e);
                        alert('Terjadi error saat memulai pembayaran.');
                        payStatus.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush
@endsection
