@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-8 text-center">
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand">Pusat Bantuan</h1>
                <p class="text-slate-500 mt-1">Panduan penggunaan IndoApart</p>
            </div>

            <!-- Table of Contents -->
            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Daftar Isi</h2>
                <ul class="space-y-2">
                    <li><a href="#booking" class="text-brand hover:underline">1. Cara Memesan Apartemen</a></li>
                    <li><a href="#pembayaran" class="text-brand hover:underline">2. Cara Pembayaran</a></li>
                    <li><a href="#cek-booking" class="text-brand hover:underline">3. Cara Melacak Booking</a></li>
                    <li><a href="#pembatalan" class="text-brand hover:underline">4. Cara Membatalkan Booking</a></li>
                    <li><a href="#kontak" class="text-brand hover:underline">5. Hubungi Kami</a></li>
                    <li><a href="#faq" class="text-brand hover:underline">6. Pertanyaan Umum</a></li>
                </ul>
            </div>

            <!-- Section 1: How to Book -->
            <div id="booking" class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand">1</span>
                    Cara Memesan Apartemen
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>Ikuti langkah-langkah berikut untuk melakukan pemesanan apartemen:</p>

                    <h3 class="font-medium text-slate-800">Langkah 1: Pilih Apartemen</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Buka halaman <strong>"Apartemen"</strong> dari menu utama</li>
                        <li>Anda dapat melihat daftar apartemen yang tersedia</li>
                        <li>Klik pada apartemen yang ingin dipesan untuk melihat detail</li>
                    </ol>

                    <h3 class="font-medium text-slate-800">Langkah 2: Isi Form Pemesanan</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Klik tombol <strong>"Pesan Sekarang"</strong></li>
                        <li>Isi data diri Anda:
                            <ul class="list-disc list-inside ml-4 mt-1 space-y-1">
                                <li><strong>Nama Tamu</strong> - Nama lengkap sesuai KTP</li>
                                <li><strong>Email</strong> - Email aktif untuk konfirmasi</li>
                                <li><strong>Nomor WhatsApp</strong> - Nomor yang aktif</li>
                            </ul>
                        </li>
                        <li>Pilih tanggal <strong>Check-in</strong> (tanggal mulai menginap)</li>
                        <li>Pilih tanggal <strong>Check-out</strong> (tanggal selesai menginap)</li>
                        <li>Masukkan jumlah tamu yang akan menginap</li>
                        <li>Tambahkan catatan khusus (opsional)</li>
                    </ol>

                    <h3 class="font-medium text-slate-800">Langkah 3: Konfirmasi Pemesanan</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Klik tombol <strong>"Konfirmasi Booking"</strong></li>
                        <li>Anda akan menerima kode booking</li>
                        <li>Simpan kode booking untuk referensi</li>
                        <li>Lakukan pembayaran dalam 24 jam</li>
                    </ol>

                    <div class="p-3 bg-amber-50 rounded-lg text-sm text-amber-700">
                        <strong>Catatan:</strong> Pemesanan akan dibatalkan secara otomatis jika pembayaran tidak dilakukan
                        dalam 24 jam.
                    </div>
                </div>
            </div>

            <!-- Section 2: How to Pay -->
            <div id="pembayaran" class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand">2</span>
                    Cara Pembayaran
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>Setelah melakukan pemesanan, Anda perlu melakukan pembayaran. Tersedia dua metode pembayaran:</p>

                    <h3 class="font-medium text-slate-800">Metode 1: Transfer Bank</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Buka halaman pembayaran dari link di email atau success page</li>
                        <li>Pilih <strong>"Transfer Bank"</strong></li>
                        <li>Catat nomor rekening tujuan:
                            <ul class="list-disc list-inside ml-4 mt-1 space-y-1">
                                <li>Bank: [Nama Bank Owner]</li>
                                <li>No. Rekening: [Nomor Rekening]</li>
                                <li>Atas Nama: [Nama Pemilik Rekening]</li>
                            </ul>
                        </li>
                        <li>Transfer sesuai jumlah yang tertera</li>
                        <li>Upload bukti transfer pada formulir</li>
                        <li>Klik <strong>"Konfirmasi Pembayaran"</strong></li>
                    </ol>

                    <h3 class="font-medium text-slate-800">Metode 2: QRIS (QR Code)</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Pilih <strong>"QRIS"</strong> sebagai metode pembayaran</li>
                        <li>Scan QR code menggunakan aplikasi e-wallet atau mobile banking</li>
                        <li>Masukkan jumlah pembayaran sesuai total</li>
                        <li>Konfirmasi pembayaran</li>
                        <li>Screenshot bukti pembayaran (opsional)</li>
                    </ol>

                    <div class="p-3 bg-emerald-50 rounded-lg text-sm text-emerald-700">
                        <strong>Tips:</strong> Simpan bukti pembayaran sampai booking dikonfirmasi oleh owner.
                    </div>
                </div>
            </div>

            <!-- Section 3: How to Check Booking -->
            <div id="cek-booking" class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand">3</span>
                    Cara Melacak Booking
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>Ada dua cara untuk melihat status booking Anda:</p>

                    <h3 class="font-medium text-slate-800">Cara 1: Melalui Email Konfirmasi</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li>Cek kotak masuk email Anda</li>
                        <li>Cari email dari IndoApart dengan subject booking confirmation</li>
                        <li>Klik link untuk melihat detail booking</li>
                    </ul>

                    <h3 class="font-medium text-slate-800">Cara 2: Melalui Menu Lacak Booking</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Buka menu <strong>"Lacak Booking"</strong> di footer website</li>
                        <li>Masukkan kode booking Anda (format: XXXXXX)</li>
                        <li>Masukkan email yang digunakan saat booking</li>
                        <li>Klik <strong>"Cari"</strong></li>
                        <li>Status booking akan ditampilkan</li>
                    </ol>

                    <h3 class="font-medium text-slate-800">Status Booking</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li><strong>Menunggu Konfirmasi</strong> - Booking baru, menunggu konfirmasi dari owner</li>
                        <li><strong>Dikonfirmasi</strong> - Booking sudah dikonfirmasi, siap check-in</li>
                        <li><strong>Selesai</strong> - Tamu sudah check-out</li>
                        <li><strong>Dibatalkan</strong> - Booking dibatalkan</li>
                    </ul>
                </div>
            </div>

            <!-- Section 4: Cancel Booking -->
            <div id="cancel-booking" class="bg-white rounded-xl border border-slate-100 p-6 mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand">4</span>
                    Cara Membatalkan Booking
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>Jika Anda perlu membatalkan pemesanan, berikut langkah-langkahnya:</p>

                    <h3 class="font-medium text-slate-800">Langkah 1: Lacak Booking Anda</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li>Buka menu <strong>"Lacak Booking"</strong> di footer website</li>
                        <li>Masukkan kode booking Anda (format: XXXXXX)</li>
                        <li>Masukkan email yang digunakan saat booking</li>
                        <li>Klik <strong>"Cari"</strong></li>
                    </ul>

                    <h3 class="font-medium text-slate-800">Langkah 2: Klik Batalkan Booking</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li>Setelah halaman detail booking muncul</li>
                        <li>Klik tombol <strong>"Batalkan Booking"</strong> di bagian bawah</li>
                        <li>Anda akan diarahkan ke halaman pembatalan</li>
                    </ul>

                    <h3 class="font-medium text-slate-800">Langkah 3: Isi Alasan Pembatalan</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Isi alasan mengapa Anda membatalkan</li>
                        <li>Contoh alasan: "Rencana berubah", "Butuh tanggal lain", dll</li>
                        <li>Klik <strong>"Ya, Batalkan Booking"</strong></li>
                    </ol>

                    <div class="p-3 bg-amber-50 rounded-lg text-sm text-amber-700">
                        <strong>Catatan Penting:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Jika <strong>belum membayar</strong>, booking akan dibatalkan tanpa pengembalian dana</li>
                            <li>Jika <strong>sudah membayar</strong>, silakan hubungi owner via WhatsApp untuk proses refund
                            </li>
                            <li>Setelah dibatalkan, apartemen akan kembali tersedia untuk pemesanan lain</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Section 5: Contact Us -->
            <div id="kontak" class="bg-white rounded-xl border border-slate-100 p-6 mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand">5</span>
                    Hubungi Kami
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>Anda memiliki pertanyaan atau butuh bantuan? Jangan ragu untuk menghubungi kami.</p>

                    <h3 class="font-medium text-slate-800">Cara Menghubungi:</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li><strong>Via Formulir</strong> - Klik tombol di bawah untuk mengisi formulir pertanyaan</li>
                        <li><strong>Via WhatsApp</strong> - Hubungi langsung: 0812 3456 7890</li>
                        <li><strong>Via Email</strong> - Kirim email ke: info@indoapart.com</li>
                    </ul>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('inquiry.create') }}"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-brand text-white rounded-lg hover:bg-brand-light transition-colors">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            Kirim Pesan via Formulir
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            Chat WhatsApp
                        </a>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-lg text-sm text-slate-600">
                        <strong>Jam Operasional:</strong> Senin - Minggu, 08:00 - 21:00 WIB
                    </div>
                </div>
            </div>

            <!-- Section 6: FAQ -->
            <div id="faq" class="bg-white rounded-xl border border-slate-100 p-6 mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4">Pertanyaan Umum</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-slate-800">Apakah saya bisa membatalkan booking?</h3>
                        <p class="text-sm text-slate-600 mt-1">Ya, Anda dapat membatalkan booking dengan menghubungi owner
                            atau melalui admin. Namun, kebijakan pengembalian dana tergantung pada kebijakan masing-masing
                            owner.</p>
                    </div>

                    <div>
                        <h3 class="font-medium text-slate-800">Berapa lama konfirmasi booking?</h3>
                        <p class="text-sm text-slate-600 mt-1">Konfirmasi biasanya dilakukan dalam 1x24 jam. Jika lebih dari
                            24 jam, hubungi owner melalui WhatsApp.</p>
                    </div>

                    <div>
                        <h3 class="font-medium text-slate-800">Apa yang harus dibawa saat check-in?</h3>
                        <p class="text-sm text-slate-600 mt-1">Bawa KTP/Paspor asli untuk verifikasi. Owner akan memberikan
                            instruksi lebih lanjut.</p>
                    </div>

                    <div>
                        <h3 class="font-medium text-slate-800">Apakah check-out bisa diperpanjang?</h3>
                        <p class="text-sm text-slate-600 mt-1">Hubungi owner minimal 1 hari sebelum check-out untuk
                            permintaan perpanjangan.</p>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="bg-brand/5 border border-brand/10 rounded-xl p-6 text-center">
                <h2 class="text-lg font-semibold text-brand mb-4">Masih Memerlukan Bantuan?</h2>
                <p class="text-slate-600 mb-4">Hubungi kami melalui:</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        WhatsApp
                    </a>
                    <a href="mailto:info@indoapart.com"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition-colors">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                        Email
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
