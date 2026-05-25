@extends('layout')

@section('content')
    <section class="pt-40 pb-40 bg-slate-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md w-full text-center border border-gray-100">

                <div class="relative w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                    <div class="absolute animate-spin rounded-full h-16 w-16 border-4 border-gray-200 border-t-indigo-600">
                    </div>
                    <svg class="w-8 h-8 text-indigo-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>

                <h2 class="text-xl font-bold text-gray-800 mb-2">Menverifikasi Pembayaran</h2>
                <p class="text-sm text-gray-500 mb-6">Sistem sedang membaca mutasi dari DOKU Gateway. Mohon tunggu sebentar,
                    halaman
                    akan beralih otomatis.</p>

                <div class="bg-indigo-50/50 rounded-xl p-3 mb-6 text-sm text-indigo-900 border border-indigo-100">
                    No. Invoice: <span class="font-mono font-bold">{{ $invoiceNumber }}</span>
                </div>

                <button id="btnCheckManual" onclick="checkStatus(true)"
                    class="w-full bg-white hover:bg-gray-50 text-gray-700 font-medium py-3 px-4 rounded-xl border border-gray-300 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                    <i class="w-5 h-5 text-gray-400" data-lucide="refresh-cw" id="iconRefresh"></i>
                    <span id="textBtn">Cek Status Pembayaran</span>
                </button>
            </div>
        </div>
    </section>
@endsection

@push('js-scripts')
    <script>
        const invoiceNumber = "{{ $invoiceNumber }}";
        const checkUrl = "{{ route('payment.check.json') }}?invoice_number=" + invoiceNumber;
        const successUrl = "{{ route('payment.success') }}?code=" + invoiceNumber;

        // Fungsi AJAX untuk cek status ke database
        function checkStatus(isManual = false) {
            const btn = document.getElementById('btnCheckManual');
            const icon = document.getElementById('iconRefresh');
            const text = document.getElementById('textBtn');

            if (isManual) {
                // Beri efek animasi berputar saat tombol CTA diklik manual
                icon.classList.add('animate-spin');
                text.innerText = 'Memeriksa...';
                btn.disabled = true;
            }

            fetch(checkUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'PAID' || data.status === 'confirmed') {
                        // Jika sudah lunas, langsung lempar ke halaman Thanks!
                        window.location.href = successUrl;
                    } else if (data.status === 'EXPIRED' || data.status === 'CANCELLED') {
                        // Jika gagal, bisa dilempar ke halaman invoice awal / halaman gagal
                        window.location.href = "/?payment_failed=true";
                    } else {
                        // Jika masih PENDING dan dipicu manual, kembalikan tombol ke status normal
                        if (isManual) {
                            setTimeout(() => {
                                icon.classList.remove('animate-spin');
                                text.innerText = 'Cek Status Pembayaran';
                                btn.disabled = false;
                            }, 1000);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking status:', error);
                    if (isManual) {
                        icon.classList.remove('animate-spin');
                        text.innerText = 'Cek Status Pembayaran';
                        btn.disabled = false;
                    }
                });
        }

        // Jalankan Polling Otomatis setiap 3 detik (3000 ms) di background
        setInterval(() => {
            checkStatus(false);
        }, 3000);
    </script>
@endpush
