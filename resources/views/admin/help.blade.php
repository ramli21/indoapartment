@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Panduan Admin</h1>
                <p class="text-slate-500 mt-1">Panduan menggunakan sistem IndoApart</p>
            </div>

            <!-- Table of Contents -->
            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Daftar Isi</h2>
                <ul class="space-y-2">
                    <li><a href="#apartments" class="text-brand hover:underline">1. Mengelola Apartemen</a></li>
                    <li><a href="#bookings" class="text-brand hover:underline">2. Mengelola Booking</a></li>
                    <li><a href="#calendar" class="text-brand hover:underline">3. Kalender Booking</a></li>
                    <li><a href="#payments" class="text-brand hover:underline">4. Pembayaran</a></li>
                    <li><a href="#banners" class="text-brand hover:underline">5. Mengelola Banner</a></li>
                    <li><a href="#inquiries" class="text-brand hover:underline">6. Pesan Masuk</a></li>
                </ul>
            </div>

            <!-- Section 1: Apartments -->
            <div id="apartments" class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand">1</span>
                    Mengelola Apartemen
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>Halaman ini digunakan untuk menambah, mengubah, dan menghapus data apartemen.</p>

                    <h3 class="font-medium text-slate-800">Menambah Apartemen Baru</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Klik tombol <strong>"Tambah Apartemen"</strong> di halaman daftar apartemen</li>
                        <li>Isi formulir dengan data apartemen:
                            <ul class="list-disc list-inside ml-4 mt-1 space-y-1">
                                <li><strong>Judul</strong> - Nama apartemen yang akan ditampilkan</li>
                                <li><strong>Tipe</strong> - Tipe apartemen (Studio, 1 Bedroom, dll)</li>
                                <li><strong>Luas</strong> - Luas apartemen dalam m²</li>
                                <li><strong>Harga per Malam</strong> - Harga sewa per malam</li>
                                <li><strong>Tower & Lantai</strong> - Lokasi apartemen</li>
                                <li><strong>Kapasitas Tamu</strong> - Jumlah tamu maksimal</li>
                            </ul>
                        </li>
                        <li>Upload foto apartemen (bisa lebih dari satu)</li>
                        <li>Pilih fasilitas yang tersedia</li>
                        <li>Klik <strong>"Simpan Apartemen"</strong></li>
                    </ol>

                    <h3 class="font-medium text-slate-800">Mengubah Data Apartemen</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Klik tombol <strong>"Edit"</strong> pada baris apartemen yang ingin diubah</li>
                        <li>Ubah data yang diperlukan</li>
                        <li>Klik <strong>"Simpan Perubahan"</strong></li>
                    </ol>

                    <h3 class="font-medium text-slate-800">Menghapus Apartemen</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Klik tombol <strong>"Hapus"</strong> pada baris apartemen</li>
                        <li>Konfirmasi dengan klik <strong>"Ya, Hapus"</strong></li>
                    </ol>

                    <div class="p-3 bg-amber-50 rounded-lg text-sm text-amber-700">
                        <strong>Catatan:</strong> Jika apartemen memiliki booking aktif, status akan otomatis berubah
                        menjadi "Terisi".
                    </div>
                </div>
            </div>

            <!-- Section 2: Bookings -->
            <div id="bookings" class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand">2</span>
                    Mengelola Booking
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>Halaman ini digunakan untuk melihat dan mengelola semua pemesanan apartemen.</p>

                    <h3 class="font-medium text-slate-800">Melihat Daftar Booking</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li>Buka halaman <strong>"Manajemen Booking"</strong> dari sidebar</li>
                        <li>Semua booking akan ditampilkan dalam tabel</li>
                        <li>Gunakan filter untuk mencari booking tertentu</li>
                    </ul>

                    <h3 class="font-medium text-slate-800">Filter Booking</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li><strong>Cari</strong> - Cari berdasarkan nama tamu atau email</li>
                        <li><strong>Status</strong> - Filter berdasarkan status (Pending/Confirmed/Completed/Cancelled)</li>
                        <li><strong>Apartemen</strong> - Filter berdasarkan apartemen tertentu</li>
                        <li><strong>Tanggal</strong> - Filter berdasarkan range tanggal</li>
                    </ul>

                    <h3 class="font-medium text-slate-800">Mengubah Status Booking</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Klik <strong>"Detail"</strong> pada booking yang ingin diubah</li>
                        <li>Di halaman detail, klik tombol status baru:
                            <ul class="list-disc list-inside ml-4 mt-1 space-y-1">
                                <li><strong>Pending</strong> - Pemesanan baru, belum konfirmasi</li>
                                <li><strong>Confirmed</strong> - Pemesanan sudah dikonfirmasi</li>
                                <li><strong>Completed</strong> - Tamu sudah check-out</li>
                                <li><strong>Cancelled</strong> - Pemesanan dibatalkan</li>
                            </ul>
                        </li>
                    </ol>

                    <h3 class="font-medium text-slate-800">Membatalkan Booking</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Buka detail booking</li>
                        <li>Klik tombol <strong>"Cancel"</strong></li>
                        <li>Konfirmasi pembatalan</li>
                        <li>Status apartemen akan kembali menjadi "Tersedia"</li>
                    </ol>
                </div>
            </div>

            <!-- Section 3: Calendar -->
            <div id="calendar" class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand">3</span>
                    Kalender Booking
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>Halaman kalender menampilkan booking dalam bentuk kalender visual.</p>

                    <h3 class="font-medium text-slate-800">Menggunakan Kalender</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li>Buka halaman <strong>"Jadwal Booking"</strong></li>
                        <li>Warna berbeda untuk setiap status:
                            <ul class="list-disc list-inside ml-4 mt-1 space-y-1">
                                <li><span class="inline-block w-3 h-3 bg-amber-500 rounded-full"></span>
                                    <strong>Orange</strong> - Pending
                                </li>
                                <li><span class="inline-block w-3 h-3 bg-emerald-500 rounded-full"></span>
                                    <strong>Hijau</strong> - Confirmed
                                </li>
                            </ul>
                        </li>
                        <li>Klik pada tanggal untuk melihat booking</li>
                    </ul>

                    <h3 class="font-medium text-slate-800">Membuat Booking Baru</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Klik tombol <strong>"Booking Baru"</strong></li>
                        <li>Pilih apartemen dari dropdown</li>
                        <li>Isi data tamu (nama, email, WhatsApp)</li>
                        <li>Pilih tanggal check-in dan check-out</li>
                        <li>Klik <strong>"Cek Ketersediaan"</strong> untuk memverifikasi</li>
                        <li>Klik <strong>"Simpan Booking"</strong></li>
                    </ol>

                    <h3 class="font-medium text-slate-800">Filter Kalender</h3>
                    <p>Gunakan filter untuk menampilkan booking apartemen tertentu saja.</p>
                </div>
            </div>

            <!-- Section 4: Payments -->
            <div id="payments" class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand">4</span>
                    Pembayaran
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>Sistem mendukung dua metode pembayaran: Transfer Bank dan QRIS.</p>

                    <h3 class="font-medium text-slate-800">Melihat Status Pembayaran</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li>Buka detail booking</li>
                        <li>Scroll ke bagian <strong>"Informasi Pembayaran"</strong></li>
                        <li>Status menunjukkan:
                            <ul class="list-disc list-inside ml-4 mt-1 space-y-1">
                                <li><strong>Lunas</strong> - Pembayaran sudah diterima</li>
                                <li><strong>Menunggu Pembayaran</strong> - Belum dibayar</li>
                            </ul>
                        </li>
                    </ul>

                    <h3 class="font-medium text-slate-800">Metode Pembayaran</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li><strong>Transfer Bank</strong> - Tamu transfer ke rekening owner dan upload bukti</li>
                        <li><strong>QRIS</strong> - Tamu scan QR kode untuk pembayaran instan</li>
                    </ul>

                    <h3 class="font-medium text-slate-800">Verifikasi Pembayaran</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Buka detail booking</li>
                        <li>Periksa bukti transfer (jika ada)</li>
                        <li>Konfirmasi pembayaran ke tamu via WhatsApp</li>
                        <li>Ubah status ke <strong>"Confirmed"</strong></li>
                    </ol>
                </div>
            </div>

            <!-- Section 5: Banners -->
            <div id="banners" class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand">5</span>
                    Mengelola Banner
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>Banner digunakan untuk menampilkan gambar promo di halaman utama.</p>

                    <h3 class="font-medium text-slate-800">Menambah Banner Baru</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Klik <strong>"Tambah Banner"</strong></li>
                        <li>Upload gambar banner</li>
                        <li>Isi judul dan subjudul (opsional)</li>
                        <li>Pilih tipe banner:
                            <ul class="list-disc list-inside ml-4 mt-1 space-y-1">
                                <li><strong>Hero Banner</strong> - Banner besar di atas halaman</li>
                                <li><strong>Promo Banner</strong> - Banner promo utama</li>
                                <li><strong>Promo Small</strong> - Kotak kecil</li>
                            </ul>
                        </li>
                        <li>Atur urutan tampil</li>
                        <li>Klik <strong>"Simpan Banner"</strong></li>
                    </ol>

                    <h3 class="font-medium text-slate-800">Mengubah Banner</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Klik tombol <strong>"Edit"</strong> pada banner</li>
                        <li>Ubah gambar atau teks</li>
                        <li>Klik <strong>"Simpan Perubahan"</strong></li>
                    </ol>

                    <h3 class="font-medium text-slate-800">Menghapus Banner</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Klik tombol <strong>"Hapus"</strong></li>
                        <li>Konfirmasi penghapusan</li>
                    </ol>
                </div>
            </div>

            <!-- Section 6: Inquiries -->
            <div id="inquiries" class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand">6</span>
                    Pesan Masuk (Inquiries)
                </h2>
                <div class="space-y-4 text-slate-600">
                    <p>Halaman ini menampilkan pesan yang dikirim melalui form hubungi kami.</p>

                    <h3 class="font-medium text-slate-800">Melihat Pesan</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li>Buka halaman <strong>"Pesan Masuk"</strong></li>
                        <li>Semua pesan akan ditampilkan</li>
                        <li>Klik untuk melihat detail pesan</li>
                    </ul>

                    <h3 class="font-medium text-slate-800">Status Pesan</h3>
                    <ul class="list-disc list-inside space-y-2 ml-2">
                        <li><strong>Baru</strong> - Pesan belum dibaca</li>
                        <li><strong>Dibaca</strong> - Pesan sudah dilihat</li>
                        <li><strong>ditangani</strong> - Pesan sudah ditindaklanjuti</li>
                    </ul>

                    <h3 class="font-medium text-slate-800">Merespon Pesan</h3>
                    <ol class="list-decimal list-inside space-y-2 ml-2">
                        <li>Buka detail pesan</li>
                        <li>Baca isi pesan</li>
                        <li>Hubungi via WhatsApp atau email</li>
                        <li>Ubah status menjadi <strong>"Ditangani"</strong></li>
                    </ol>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-brand/5 border border-brand/10 rounded-xl p-6">
                <h2 class="text-lg font-semibold text-brand mb-4">Tips Penting</h2>
                <ul class="space-y-2 text-slate-600">
                    <li>• Selalu verifikasi pembayaran sebelum mengonfirmasi booking</li>
                    <li>• Update status booking secara berkala</li>
                    <li>• Jangan lupa upload banner promo secara rutin</li>
                    <li>• Respon pesan masuk dalam 24 jam</li>
                    <li>• Backup data apartemen secara berkala</li>
                </ul>
            </div>
        </div>
    </section>
@endsection
