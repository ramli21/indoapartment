@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="mb-6 text-center">
                <h1 class="text-3xl md:text-4xl font-semibold text-slate-900">Syarat &amp; Ketentuan</h1>
                <p class="text-slate-600 mt-2 max-w-2xl mx-auto">Dokumen ini menjelaskan ketentuan penggunaan layanan
                    IndoApart. Mohon baca dengan saksama sebelum menggunakan platform.</p>
            </div>

            <div class="grid md:grid-cols-12 gap-8 items-start">
                <aside class="md:col-span-3 hidden md:block">
                    <div class="sticky top-28 p-4 bg-white border border-slate-100 rounded-lg shadow-sm">
                        <h4 class="text-sm font-semibold text-slate-800 mb-3">Daftar Isi</h4>
                        <nav class="text-sm space-y-2">
                            <a href="#definitions" class="block text-slate-600 hover:text-brand">1. Definisi &amp; Ketentuan
                                Umum</a>
                            <a href="#payments" class="block text-slate-600 hover:text-brand">2. Pemesanan &amp;
                                Pembayaran</a>
                            <a href="#cancellation" class="block text-slate-600 hover:text-brand">3. Pembatalan &amp;
                                Refund</a>
                            <a href="#rules" class="block text-slate-600 hover:text-brand">4. Penggunaan Unit &amp; Tata
                                Tertib</a>
                            <a href="#privacy" class="block text-slate-600 hover:text-brand">5. Privasi &amp; Keamanan
                                Data</a>
                            <a href="#liability" class="block text-slate-600 hover:text-brand">6. Batasan Tanggung Jawab</a>
                        </nav>
                    </div>
                </aside>

                <article class="md:col-span-9">
                    <div class="bg-white border border-slate-100 rounded-lg shadow-sm p-6 prose prose-slate max-w-none">
                        <h2 id="definitions" class="text-2xl font-semibold mb-2">Definisi &amp; Ketentuan Umum</h2>

                        <p class="mb-2"><strong>Definisi Istilah:</strong> Dalam dokumen ini "Platform" berarti IndoApart;
                            "Pengguna"
                            berarti individu yang menggunakan layanan untuk memesan atau menyewa unit; "Pengelola"
                            atau
                            "Pemilik" berarti pihak yang menyediakan unit apartemen.</p>

                        <p class="mb-2"><strong>Kelayakan Usia:</strong> Pengguna harus berusia minimal 18 (delapan belas)
                            tahun atau
                            memiliki identitas legal (KTP/Paspor) yang sah untuk melakukan reservasi dan sewa melalui
                            Platform.</p>

                        <h2 id="payments" class="text-2xl font-semibold mb-2 mt-10">Mekanisme Pemesanan &amp; Pembayaran
                        </h2>
                        <p class="mb-2"><strong>Metode Pembayaran:</strong> Semua pembayaran resmi dilakukan secara online
                            melalui
                            payment gateway yang terintegrasi pada Platform.</p>
                        <p class="mb-2"><strong>Masa Berlaku Tagihan:</strong> Pengguna wajib menyelesaikan pembayaran
                            dalam batas waktu
                            yang ditentukan sejak kode pembayaran/tagihan diterbitkan. Jika tidak dibayar dalam batas waktu
                            tersebut, pesanan dapat dibatalkan secara otomatis.</p>
                        <p class="mb-2"><strong>Biaya Tambahan (Jika Ada):</strong> Selain harga sewa dasar, Pengguna
                            mungkin dikenakan
                            biaya tambahan seperti deposit jaminan, biaya kebersihan, atau biaya utilitas apabila tidak
                            termasuk dalam harga sewa dasar. Biaya tersebut akan diinformasikan pada saat pemesanan jika
                            berlaku.</p>

                        <h2 id="cancellation" class="text-2xl font-semibold mb-2 mt-10">Kebijakan Pembatalan &amp;
                            Pengembalian
                            Dana (Refund)</h2>
                        <p class="mb-2"><strong>Pembatalan oleh Penyewa:</strong> Aturan pembatalan dapat berbeda
                            berdasarkan kebijakan
                            unit (misalnya: pembatalan kurang dari 3 hari sebelum check-in dapat dikenakan potongan 50% atau
                            tidak ada refund untuk kategori non-refundable). Ketentuan spesifik akan ditampilkan saat
                            pemesanan.</p>
                        <p class="mb-2"><strong>Kegagalan Sistem / Force Majeure:</strong> Jika terjadi kegagalan sistem
                            pembayaran atau
                            kejadian kahar (force majeure) yang mengakibatkan unit tidak dapat ditempati, IndoApart akan
                            berkoordinasi dengan Pengelola untuk memberikan solusi termasuk pengembalian dana apabila
                            diperlukan.</p>
                        <p class="mb-2"><strong>Prosedur Refund:</strong> Proses pengembalian dana akan diproses dalam
                            jangka waktu
                            tertentu (misalnya 7–14 hari kerja) ke rekening asal pengguna, tergantung pada metode pembayaran
                            dan kebijakan bank/payment gateway.</p>

                        <h2 id="rules" class="text-2xl font-semibold mb-2 mt-10">Aturan Penggunaan Unit Apartemen
                            (Check-in
                            &amp; Tata Tertib)</h2>
                        <p class="mb-2"><strong>Prosedur Check-in &amp; Check-out:</strong> Pengguna wajib mengikuti
                            jadwal check-in dan
                            check-out yang ditetapkan. Keterlambatan check-out dapat dikenakan biaya tambahan sesuai
                            kebijakan Pengelola.</p>
                        <p class="mb-2"><strong>Kewajiban Penyewa:</strong> Pengguna wajib menjaga kebersihan unit, tidak
                            merusak
                            fasilitas, dan mematuhi peraturan gedung apartemen yang berlaku selama masa sewa.</p>
                        <p class="mb-2"><strong>Larangan Keras:</strong> Dilarang menggunakan unit untuk kegiatan ilegal
                            seperti
                            perjudian, penggunaan narkotika, tindakan asusila, atau membawa barang berbahaya. Hewan
                            peliharaan hanya diperbolehkan jika diizinkan oleh Pengelola.</p>

                        <h2 id="privacy" class="text-2xl font-semibold mb-2 mt-10">Kebijakan Privasi &amp; Keamanan Data
                        </h2>
                        <p class="mb-2"><strong>Pengumpulan Data:</strong> IndoApart mengumpulkan data pribadi seperti
                            Nama, Nomor HP,
                            Email, dan KTP untuk keperluan validasi identitas, konfirmasi pemesanan, serta pelaporan
                            check-in apabila diperlukan.</p>
                        <p class="mb-2"><strong>Keamanan Transaksi:</strong> Data kartu kredit atau informasi perbankan
                            Pengguna diproses
                            melalui payment gateway mitra (mis. DOKU) dengan mekanisme enkripsi dan tidak disimpan secara
                            permanen di server IndoApart.</p>

                        <h2 id="liability" class="text-2xl font-semibold mb-2 mt-10">Batasan Tanggung Jawab &amp; Hukum yang
                            Berlaku</h2>
                        <p class="mb-2"><strong>Kehilangan &amp; Kerusakan:</strong> IndoApart tidak bertanggung jawab
                            atas kehilangan
                            barang pribadi Pengguna di dalam unit atau area gedung. Pengguna dianjurkan menjaga barang
                            berharga selama menginap.</p>
                        <p class="mb-2"><strong>Ganti Rugi:</strong> Jika Pengguna terbukti merusak properti atau
                            fasilitas, Pengguna
                            wajib mengganti kerugian sesuai dengan biaya perbaikan yang ditetapkan oleh Pengelola.</p>
                        <p class="mb-2"><strong>Yurisdiksi Hukum:</strong> Semua perselisihan yang timbul dari penggunaan
                            layanan ini
                            akan diselesaikan secara mufakat dan tunduk pada hukum yang berlaku di Republik Indonesia.</p>

                        <p class="text-sm text-slate-500 mt-6">Tanggal efektif: {{ date('d F Y') }}</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('navbar');
            const offset = navbar ? navbar.getBoundingClientRect().height : 64;

            function scrollToHash(hash, push = false) {
                if (!hash) return;
                const el = document.querySelector(hash);
                if (!el) return;
                const rect = el.getBoundingClientRect();
                const top = window.scrollY + rect.top - offset - 16; // small extra gap
                window.scrollTo({
                    top,
                    behavior: 'smooth'
                });
                if (push) history.replaceState(null, '', hash);
            }

            // intercept in-page toc clicks
            document.querySelectorAll('a[href^="#"]').forEach(a => {
                a.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href && href.startsWith('#')) {
                        e.preventDefault();
                        scrollToHash(href, true);
                    }
                });
            });

            // if page loaded with a hash, adjust scroll after short delay
            if (window.location.hash) {
                setTimeout(() => scrollToHash(window.location.hash), 50);
            }
        });
    </script>

    <style>
        /* Fixed TOC styles when activated */
        .fixed-toc {
            position: fixed !important;
            z-index: 60;
            background: white;
            border-radius: 0.5rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const aside = document.querySelector('aside');
            if (!aside) return;
            const toc = aside.querySelector('.sticky');
            if (!toc) return;

            const navbar = document.getElementById('navbar');
            const navHeight = navbar ? navbar.getBoundingClientRect().height : 64;

            // get initial top position relative to the document
            const tocOffsetTop = toc.getBoundingClientRect().top + window.scrollY;

            function updateFixedToc() {
                const scrollY = window.scrollY || window.pageYOffset;
                if (scrollY > tocOffsetTop - navHeight - 8) {
                    if (!toc.classList.contains('fixed-toc')) {
                        const rect = toc.getBoundingClientRect();
                        // set width and left to keep layout stable
                        toc.style.width = rect.width + 'px';
                        toc.style.left = rect.left + 'px';
                        toc.style.top = (navHeight + 12) + 'px';
                        toc.classList.add('fixed-toc');
                    }
                } else {
                    if (toc.classList.contains('fixed-toc')) {
                        toc.classList.remove('fixed-toc');
                        toc.style.left = '';
                        toc.style.width = '';
                        toc.style.top = '';
                    }
                }
            }

            window.addEventListener('scroll', updateFixedToc, {
                passive: true
            });
            window.addEventListener('resize', function() {
                // recompute positions on resize
                if (toc.classList.contains('fixed-toc')) {
                    toc.classList.remove('fixed-toc');
                    toc.style.left = '';
                    toc.style.width = '';
                    toc.style.top = '';
                }
                // recalc offset after a short delay
                setTimeout(() => {
                    const newOffset = toc.getBoundingClientRect().top + window.scrollY;
                    // cannot reassign const; use closure trick by recreating handler variables - simpler to reload
                    // We'll just call updateFixedToc once to re-evaluate
                    updateFixedToc();
                }, 120);
            }, {
                passive: true
            });

            // initial check
            updateFixedToc();
        });
    </script>
@endsection
