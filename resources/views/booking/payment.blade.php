@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-[450px]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Pembayaran</h1>
                <p class="text-slate-500 mt-1">Selesaikan pembayaran untuk booking Anda</p>
            </div>

            @if (session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Booking Summary -->
            <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm mb-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-medium text-slate-500">Kode Booking</span>
                    <span class="text-lg font-bold text-brand">#{{ $booking->booking_code }}</span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Apartemen</span>
                        <span class="text-slate-800 font-medium">{{ $booking->room->judul }}</span>
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
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Harga per Malam</span>
                        <span class="text-slate-800">Rp
                            {{ number_format($booking->harga_per_malam, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        @php
                            $checkIn = \Carbon\Carbon::parse($booking->check_in);
                            $checkOut = \Carbon\Carbon::parse($booking->check_out);
                            $jumlahMalam = $checkIn->diffInDays($checkOut);
                        @endphp
                        <span class="text-slate-600">Sub Total</span>
                        <span class="text-slate-800">Rp
                            {{ number_format($booking->harga_per_malam * $jumlahMalam, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">PPN</span>
                        <span class="text-slate-800">{{ $booking->ppn }}%</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Admin Fee</span>
                        <span class="text-slate-800">{{ $booking->admin_fee }}%</span>
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
            @if ($booking->paid_at === null)
                @if (isset($dokuAvailable) && $dokuAvailable)
                    <div class="mb-6">
                        <a href="{{ route('direct.pay.doku', $booking) }}" id="payDokuBtn" type="submit"
                            class="w-full bg-emerald-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-emerald-700 transition-colors flex items-center justify-center gap-2">
                            <svg id="payDokuSpinner" class="hidden animate-spin w-5 h-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                </path>
                            </svg>
                            <i data-lucide="credit-card" class="w-5 h-5"></i>
                            <span id="payDokuLabel">Bayar Sekarang Rp
                                {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </a>
                    </div>
                @endif

                @if (session('error') || !$dokuAvailable)
                    <!-- Payment Form -->
                    <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm">
                        <form method="POST" action="{{ route('booking.processPayment', $booking->booking_code) }}"
                            enctype="multipart/form-data" id="paymentForm">
                            @csrf

                            <!-- Payment Method Selection -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-slate-700 mb-3">Pilih Metode Pembayaran</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Bank Transfer Option -->
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="payment_method" value="bank_transfer"
                                            class="peer sr-only" {{ 'checked' }}>
                                        <div
                                            class="p-4 rounded-xl border-2 border-slate-200 peer-checked:border-brand peer-checked:bg-brand/5 transition-all">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center">
                                                    <i data-lucide="building-2" class="w-5 h-5 text-slate-600"></i>
                                                </div>
                                                <span class="font-medium text-slate-800">Transfer Bank</span>
                                            </div>
                                            <p class="text-xs text-slate-500">Transfer ke rekening owner dan upload bukti
                                            </p>
                                        </div>
                                    </label>

                                    <!-- QRIS Option -->
                                    {{-- <label class="relative cursor-pointer">
                                        <input type="radio" name="payment_method" value="qris" class="peer sr-only"
                                            disabled>
                                        <div
                                            class="p-4 rounded-xl border-2 border-slate-200 peer-checked:border-brand peer-checked:bg-brand/5 transition-all">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center">
                                                    <i data-lucide="scan-line" class="w-5 h-5 text-slate-600"></i>
                                                </div>
                                                <span class="font-medium text-slate-800">QRIS</span>
                                            </div>
                                            <p class="text-xs text-slate-500">Scan kode QR dengan aplikasi pembayaran</p>
                                        </div>
                                    </label> --}}
                                </div>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bank Transfer Details -->
                            <div id="bankDetails" class="mb-6 p-4 bg-slate-50 rounded-xl">
                                <h4 class="font-medium text-slate-800 mb-3 flex items-center gap-2">
                                    <i data-lucide="building-2" class="w-4 h-4"></i>
                                    Rekening Tujuan
                                </h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Bank</span>
                                        <span class="text-slate-800 font-medium">{{ $paymentInfo->bank_name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">No. Rekening</span>
                                        <span
                                            class="text-slate-800 font-mono font-medium">{{ $paymentInfo->account_number }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Atas Nama</span>
                                        <span class="text-slate-800 font-medium">{{ $paymentInfo->account_holder }}</span>
                                    </div>
                                </div>

                                <!-- Payment Proof Upload -->
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Upload Bukti
                                        Transfer</label>
                                    <input id="payment_proof" name="payment_proof" type="file" accept="image/*">
                                    {{-- <div class="mt-1 flex justify-center px-4 pt-4 pb-4 border-2 border-dashed border-slate-300 rounded-xl hover:border-brand transition-colors cursor-pointer"
                                id="dropZone"> --}}
                                    {{-- <div class="space-y-1 text-center">
                                    <div id="previewContainer" class="hidden mb-2">
                                        <img id="proofPreview" class="mx-auto h-32 object-contain rounded-lg">
                                    </div>
                                    <div id="uploadIcon">
                                        <i data-lucide="upload" class="mx-auto h-8 w-8 text-slate-300"></i>
                                    </div>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <label for="payment_proof"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-brand hover:text-brand-light">
                                            <span>Pilih file</span>
                                            
                                        </label>
                                        <p class="pl-1">atau drag & drop</p>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG max 2MB</p>
                                </div> --}}
                                    {{-- </div> --}}
                                    @error('payment_proof')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- QRIS Section -->
                            <div id="qrisDetails" class="hidden mb-6 p-6 bg-slate-50 rounded-xl text-center">
                                <h4 class="font-medium text-slate-800 mb-3">Scan QRIS untuk Pembayaran</h4>
                                <div class="bg-white p-4 rounded-xl inline-block mb-3">
                                    <!-- QR Code placeholder - replace with actual QRIS QR code -->
                                    <div class="w-48 h-48 bg-slate-200 rounded-lg flex items-center justify-center">
                                        <span class="text-slate-400 text-sm">QRIS Code</span>
                                    </div>
                                </div>
                                <p class="text-sm text-slate-500">Total: <span class="font-bold text-brand">Rp
                                        {{ number_format($booking->total_harga, 0, ',', '.') }}</span></p>
                                <p class="text-xs text-slate-400 mt-1">Scan dengan aplikasi e-wallet atau mobile banking
                                </p>
                            </div>

                            <!-- Doku Section -->
                            <div id="dokuDetails" class="hidden mb-6 p-4 bg-slate-50 rounded-xl">
                                <h4 class="font-medium text-slate-800 mb-2 flex items-center gap-2">
                                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                                    Pembayaran via Doku
                                </h4>
                                <p class="text-sm text-slate-600">Anda akan diarahkan ke halaman pembayaran Doku untuk
                                    menyelesaikan transaksi.</p>
                            </div>

                            <!-- Payment Notes -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Pembayaran
                                    (Opsional)</label>
                                <textarea name="payment_notes" rows="2"
                                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm resize-none"
                                    placeholder="Tambahkan catatan..."></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full bg-brand text-white px-6 py-3 rounded-xl font-medium hover:bg-brand-light transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="check-circle" class="w-5 h-5"></i>
                                Konfirmasi Pembayaran
                            </button>

                            <!-- Back Link -->
                            <div class="text-center mt-4">
                                <a href="{{ route('booking.success', $booking->id) }}"
                                    class="text-sm text-slate-500 hover:text-brand">
                                    &larr; Kembali ke detail booking
                                </a>
                            </div>
                        </form>
                    </div>
                @endif
            @else
                <div
                    class="bg-green-50 rounded-xl p-3 mb-6 text-lg text-green-900 border border-green-100 text-center shadow-sm">
                    <i data-lucide="check-circle" class="w-10 h-10 text-green-500 mb-2 m-auto"></i>
                    Pembayaran sudah diterima. Terima kasih!

                    <a href="{{ route('booking.success', $booking) }}"
                        class="mt-4 block px-4 py-2 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition-colors">
                        Lihat Detail Booking
                    </a>
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
        <script>
            // Toggle payment method sections
            const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
            const bankDetails = document.getElementById('bankDetails');
            const qrisDetails = document.getElementById('qrisDetails');
            const dokuDetails = document.getElementById('dokuDetails');

            paymentMethodRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'bank_transfer') {
                        bankDetails.classList.remove('hidden');
                        qrisDetails.classList.add('hidden');
                        if (dokuDetails) dokuDetails.classList.add('hidden');
                    } else if (this.value === 'qris') {
                        bankDetails.classList.add('hidden');
                        qrisDetails.classList.remove('hidden');
                        if (dokuDetails) dokuDetails.classList.add('hidden');
                    } else if (this.value === 'doku') {
                        bankDetails.classList.add('hidden');
                        qrisDetails.classList.add('hidden');
                        if (dokuDetails) dokuDetails.classList.remove('hidden');
                    }
                });
            });

            // On page load, show correct section based on selected radio
            document.addEventListener('DOMContentLoaded', function() {
                const checked = document.querySelector('input[name="payment_method"]:checked');
                if (checked) {
                    checked.dispatchEvent(new Event('change'));
                }
            });

            // Image preview for payment proof
            document.getElementById('payment_proof').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('proofPreview').src = e.target.result;
                        document.getElementById('previewContainer').classList.remove('hidden');
                        document.getElementById('uploadIcon').classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Pay button loading state
            const payForm = document.getElementById('paymentForm');
            const payButton = document.getElementById('payButton');
            const paySpinner = document.getElementById('paySpinner');
            const payLabel = document.getElementById('payLabel');
            if (payForm && payButton) {
                payForm.addEventListener('submit', function() {
                    if (payButton.disabled) return;
                    payButton.disabled = true;
                    if (paySpinner) paySpinner.classList.remove('hidden');
                    if (payLabel) payLabel.textContent = 'Memproses...';
                });
            }

            // Doku quick-pay handling (open in new tab)
            const dokuForm = document.getElementById('dokuForm');
            const payDokuBtn = document.getElementById('payDokuBtn');
            const payDokuSpinner = document.getElementById('payDokuSpinner');
            const payDokuLabel = document.getElementById('payDokuLabel');
            if (dokuForm && payDokuBtn) {
                dokuForm.addEventListener('submit', function() {
                    if (payDokuBtn.disabled) return;
                    payDokuBtn.disabled = true;
                    if (payDokuSpinner) payDokuSpinner.classList.remove('hidden');
                    if (payDokuLabel) payDokuLabel.textContent = 'Mengalihkan ke Doku...';
                });
                // Safety: if payDokuBtn clicked directly, submit the form
                payDokuBtn.addEventListener('click', function() {
                    if (!dokuForm) return;
                    // ensure a payment_method field exists
                    if (!dokuForm.querySelector('[name="payment_method"]')) {
                        const inp = document.createElement('input');
                        inp.type = 'hidden';
                        inp.name = 'payment_method';
                        inp.value = 'doku';
                        dokuForm.appendChild(inp);
                    }
                    dokuForm.submit();
                });
            }
        </script>
    @endpush
@endsection
