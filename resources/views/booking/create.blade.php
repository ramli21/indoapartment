@extends('layout')

@php
    $seoTitle = 'Booking ' . ($room->judul ?? 'Apartemen') . ' — IndoApart';
    $seoDescription =
        'Booking apartemen ' .
        ($room->judul ?? '') .
        ' di Bandung/Sekitarnya. Pilih tanggal check-in & check-out, lalu konfirmasi pemesanan.';
    $seoKeywords = 'booking apartemen, sewa apartemen, ' . ($room->alamat ?? 'Bandung') . ', IndoApart';

    $seoImage =
        isset($room->gambar) && is_array($room->gambar) && count($room->gambar)
            ? asset('storage/' . $room->gambar[0])
            : asset('images/og-default.jpg');
@endphp

@push('styles')
    <style>
        .map-container>iframe {
            width: 100% !important;
            height: 450px !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
@endpush

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('rooms.list') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-brand transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Daftar
                </a>
            </div>

            <div class="grid lg:grid-cols-5 gap-6">
                <!-- Apartment Details -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                        <!-- Image Slider -->
                        <div class="relative">
                            @if ($room->gambar && is_array($room->gambar) && count($room->gambar) > 0)
                                <div id="imageSlider" class="relative h-64 sm:h-80 overflow-hidden rounded-t-2xl">
                                    @foreach ($room->gambar as $index => $image)
                                        <img src="{{ asset('storage/' . $image) }}" data-index="{{ $index }}"
                                            class="slider-img absolute inset-0 w-full h-full object-cover cursor-zoom-in transition-opacity duration-500 opacity-0"
                                            style="{{ $index === 0 ? 'opacity: 1;' : '' }}"
                                            alt="{{ $room->judul }} - Gambar {{ $index + 1 }}" loading="lazy">
                                    @endforeach
                                    <!-- Navigation Arrows + Dots -->
                                    <!-- Left Arrow -->
                                    <button id="prevSlide"
                                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg z-20 transition-all duration-200 slider-nav">
                                        <i data-lucide="chevron-left" class="w-6 h-6 text-slate-700"></i>
                                    </button>
                                    <!-- Right Arrow -->
                                    <button id="nextSlide"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg z-20 transition-all duration-200 slider-nav">
                                        <i data-lucide="chevron-right" class="w-6 h-6 text-slate-700"></i>
                                    </button>
                                    <!-- Navigation Dots -->
                                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                                        @foreach ($room->gambar as $index => $image)
                                            <button
                                                class="slider-dot w-2.5 h-2.5 rounded-full bg-white/50 hover:bg-white transition-all duration-200 {{ $index === 0 ? 'bg-white' : '' }}"
                                                onclick="goToSlide({{ $index }})"></button>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div
                                    class="w-full h-64 sm:h-80 bg-slate-100 flex items-center justify-center rounded-t-2xl">
                                    <i data-lucide="image-off" class="w-16 h-16 text-slate-300"></i>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 z-10">
                                <span
                                    class="px-3 py-1.5 bg-white/90 backdrop-blur-sm text-sm font-medium text-brand rounded-lg shadow-sm">
                                    {{ $room->tipe }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 sm:p-8">
                            <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand mb-2">
                                {{ $room->judul }}</h1>
                            <div class="flex items-center gap-1.5 text-slate-500 mb-4">
                                <i data-lucide="map-pin" class="w-4 h-4 shrink-0"></i>
                                <span
                                    class="text-sm">{{ $room->apartment->nama . ' - ' . $room->apartment->alamat }}</span>
                            </div>

                            <!-- Price -->
                            @if ($room->harga_per_malam)
                                <div class="flex items-baseline gap-2 mb-6 p-4 bg-brand/5 rounded-xl">
                                    <span class="text-2xl font-bold text-brand">Rp
                                        {{ number_format($room->harga_per_malam, 0, ',', '.') }}</span>
                                    <span class="text-sm text-slate-500">/ malam</span>
                                </div>
                            @endif

                            <!-- Description -->
                            @if ($room->deskripsi)
                                <div class="mb-6">
                                    <h3 class="text-sm font-medium text-slate-700 mb-2">Deskripsi</h3>
                                    <p class="text-sm text-slate-600 leading-relaxed">{{ $room->deskripsi }}</p>
                                </div>
                            @endif

                            <!-- Info Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                                <div class="p-3 bg-slate-50 rounded-xl text-center">
                                    <i data-lucide="maximize" class="w-5 h-5 text-brand mx-auto mb-1"></i>
                                    <div class="text-xs text-slate-500">Luas</div>
                                    <div class="text-sm font-semibold text-slate-800">{{ $room->luas }} m²</div>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl text-center">
                                    <i data-lucide="building" class="w-5 h-5 text-brand mx-auto mb-1"></i>
                                    <div class="text-xs text-slate-500">Tower</div>
                                    <div class="text-sm font-semibold text-slate-800">{{ $room->nama_tower }}</div>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl text-center">
                                    <i data-lucide="door-open" class="w-5 h-5 text-brand mx-auto mb-1"></i>
                                    <div class="text-xs text-slate-500">Kamar</div>
                                    <div class="text-sm font-semibold text-slate-800">{{ $room->nomor_kamar }}</div>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl text-center">
                                    <i data-lucide="users" class="w-5 h-5 text-brand mx-auto mb-1"></i>
                                    <div class="text-xs text-slate-500">Kapasitas</div>
                                    <div class="text-sm font-semibold text-slate-800">
                                        {{ $room->tamu_dewasa + $room->tamu_anak }} Tamu</div>
                                </div>
                            </div>

                            <!-- Fasilitas -->
                            @if ($room->fasilitas && count($room->fasilitas) > 0)
                                <div class="mb-6">
                                    <h3 class="text-sm font-medium text-slate-700 mb-3">Fasilitas</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($room->fasilitas as $fasilitas)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-accent/20 text-brand text-sm font-medium rounded-full">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                                {{ $fasilitas }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Tata Tertib -->
                            @if ($room->tata_tertib)
                                <div class="p-5 bg-slate-50 rounded-xl border border-slate-100">
                                    <h3 class="text-sm font-medium text-slate-700 mb-3 flex items-center gap-2">
                                        <i data-lucide="scroll-text" class="w-4 h-4 text-brand"></i>
                                        Tata Tertib
                                    </h3>
                                    <div class="text-sm text-slate-600 whitespace-pre-line">{{ $room->tata_tertib }}
                                    </div>
                                </div>
                            @endif

                            {{-- Maps --}}
                            <div class="mt-5 rounded-xl border border-slate-100 map-container overflow-hidden">
                                {!! $room->apartment->google_maps_embed !!}
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Booking Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm sticky top-24">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                            <i data-lucide="calendar-check" class="w-5 h-5 text-brand"></i>
                            Formulir Booking
                        </h2>

                        <form action="{{ route('booking.store', $room->slug) }}" method="POST" id="bookingForm">
                            @csrf

                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <!-- Name -->
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                        Nama Tamu
                                    </label>
                                    <input type="text" name="nama_tamu" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm"
                                        placeholder="Nama lengkap">
                                    @error('nama_tamu')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                        Email
                                    </label>
                                    <input type="email" name="email_tamu" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm"
                                        placeholder="email@example.com">
                                    @error('email_tamu')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <!-- Phone -->
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                        No. WhatsApp
                                    </label>
                                    <input type="tel" name="no_hp" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm"
                                        placeholder="0812 3456 7890">
                                    @error('no_hp')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Guests -->
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                        Jumlah Tamu (Max: {{ $room->tamu_dewasa + $room->tamu_anak }})
                                    </label>
                                    <select name="jumlah_tamu" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                                        @for ($i = 1; $i <= $room->tamu_dewasa + $room->tamu_anak; $i++)
                                            <option value="{{ $i }}">{{ $i }} Tamu</option>
                                        @endfor
                                    </select>
                                    @error('jumlah_tamu')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Dates -->
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                        Check-in
                                    </label>
                                    <input type="date" name="check_in" id="checkIn" required
                                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                                    @error('check_in')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                        Check-out
                                    </label>
                                    <input type="date" name="check_out" id="checkOut" required
                                        class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                                    @error('check_out')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                            <!-- Notes -->
                            <div class="mb-5">
                                <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                    Catatan (Opsional)
                                </label>
                                <textarea name="catatan" rows="3"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm resize-none"
                                    placeholder="Permintaan khusus..."></textarea>
                                @error('catatan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price Summary -->
                            <div class="mb-5 p-4 bg-brand/5 rounded-xl border border-brand/10">
                                <div class="hidden">
                                    <input type="hidden" name="ppn" id="ppnPercent"
                                        value="{{ $adminInfo->ppn ?? 0 }}" />
                                    <input type="hidden" name="admin_fee" id="adminFeePercent"
                                        value="{{ $adminInfo->admin_fee ?? 0 }}" />
                                </div>

                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-600">Harga per malam</span>
                                    <span class="text-slate-800">Rp
                                        {{ number_format($room->harga_per_malam, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-600">Jumlah malam</span>
                                    <span class="text-slate-800" id="jumlahMalam">0 malam</span>
                                </div>

                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-600">Subtotal</span>
                                    <span class="text-slate-800" id="subtotalHarga">Rp 0</span>
                                </div>

                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-600">PPN ({{ $adminInfo->ppn ?? 0 }}%)</span>
                                    <span class="text-slate-800" id="ppnAmount">Rp 0</span>
                                </div>

                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-600">Admin Fee ({{ $adminInfo->admin_fee ?? 0 }}%)</span>
                                    <span class="text-slate-800" id="adminFeeAmount">Rp 0</span>
                                </div>

                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-600">Total</span>
                                    <span class="text-slate-800" id="totalHarga">Rp 0</span>
                                </div>
                            </div>


                            <!-- Terms acceptance -->
                            <div class="mb-4 text-sm text-slate-600">
                                <label class="inline-flex items-start gap-3">
                                    <input type="checkbox" id="termsCheckbox" name="is_terms_accepted" value="1"
                                        class="mt-1 w-4 h-4" />
                                    <span class="text-sm">Saya menyetujui <a href="{{ route('terms') }}" target="_blank"
                                            rel="noopener noreferrer" class="text-blue-600 hover:underline">Syarat &amp;
                                            Ketentuan</a> dan <a href="{{ route('terms') }}#privacy" target="_blank"
                                            rel="noopener noreferrer" class="text-blue-600 hover:underline">Kebijakan
                                            Privasi</a></span>
                                </label>
                                @error('is_terms_accepted')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <button type="submit" id="bookingSubmit"
                                class="w-full bg-brand text-white py-3 rounded-xl font-medium hover:bg-brand-light transition-colors flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
                                disabled>
                                <i data-lucide="calendar-check" class="w-4 h-4"></i>
                                Booking Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating Share Button -->
    <button id="floatingShareBtn" aria-label="Share this listing"
        class="fixed right-5 bottom-20 z-50 w-12 h-12 rounded-full bg-brand text-white flex items-center justify-center shadow-lg hover:bg-brand-light transition">
        <i data-lucide="share-2" class="w-5 h-5"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image slider init - make images global (safe init)
            window.apartmentImages = @json($room->gambar ?? []);
            if (window.initSlider && window.apartmentImages.length > 0) {
                window.initSlider();
            }

            // Booking calculator
            const checkInInput = document.getElementById('checkIn');
            const checkOutInput = document.getElementById('checkOut');
            const jumlahMalamDisplay = document.getElementById('jumlahMalam');
            const subtotalHargaDisplay = document.getElementById('subtotalHarga');
            const ppnAmountDisplay = document.getElementById('ppnAmount');
            const adminFeeAmountDisplay = document.getElementById('adminFeeAmount');
            const totalHargaDisplay = document.getElementById('totalHarga');

            const hargaPerMalam = {{ (float) $room->harga_per_malam }};
            const ppnPercentEl = document.getElementById('ppnPercent');
            const adminFeePercentEl = document.getElementById('adminFeePercent');
            const ppnPercent = Number(ppnPercentEl?.value ?? 0);
            const adminFeePercent = Number(adminFeePercentEl?.value ?? 0);

            // Set min date to today
            const today = new Date().toISOString().split('T')[0];
            checkInInput.min = today;
            checkOutInput.min = today;

            // Disable dates that are already booked for this apartment
            // We only rely on client-side disabling here; server-side validation still exists in BookingController.
            @php
                $bookingsForDates = \App\Models\Booking::where('room_id', $room->id)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->get(['check_in', 'check_out']);

                $bookedDatesArr = [];
                foreach ($bookingsForDates as $b) {
                    $start = \Carbon\Carbon::parse($b->check_in)->startOfDay();
                    $end = \Carbon\Carbon::parse($b->check_out)->startOfDay();
                    // collect each night between check_in (inclusive) and check_out (exclusive)
                    for ($d = $start->copy(); $d->lt($end); $d->addDay()) {
                        $bookedDatesArr[] = $d->toDateString();
                    }
                }

                $bookedDatesArr = array_values(array_unique($bookedDatesArr));
            @endphp

            const bookedDates = @json($bookedDatesArr);

            function disableDateInput(inputEl) {
                // HTML date input supports filtering via min/max only.
                // So we enforce disabling by clearing value if selected date is blocked.
                inputEl.addEventListener('change', function() {
                    if (this.value && bookedDates.includes(this.value)) {
                        const blocked = this.value;
                        this.value = '';

                        alert('Tanggal ' + blocked +
                            ' sudah dibooking. Silakan pilih tanggal lain (check-in 14:00, check-out 12:00).'
                        );
                    }
                });
            }

            disableDateInput(checkInInput);
            disableDateInput(checkOutInput);


            function calculatePrice() {
                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);

                if (checkInInput.value && checkOutInput.value && checkOut > checkIn) {
                    const diffTime = checkOut - checkIn;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    const subtotal = diffDays * hargaPerMalam;
                    const ppnAmount = subtotal * (ppnPercent / 100);
                    const adminFeeAmount = subtotal * (adminFeePercent / 100);
                    const total = subtotal + ppnAmount + adminFeeAmount;

                    jumlahMalamDisplay.textContent = diffDays + ' malam';
                    subtotalHargaDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
                    ppnAmountDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(ppnAmount);
                    adminFeeAmountDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(
                        adminFeeAmount);
                    totalHargaDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                } else {
                    jumlahMalamDisplay.textContent = '0 malam';
                    subtotalHargaDisplay.textContent = 'Rp 0';
                    ppnAmountDisplay.textContent = 'Rp 0';
                    adminFeeAmountDisplay.textContent = 'Rp 0';
                    totalHargaDisplay.textContent = 'Rp 0';
                }
            }

            checkInInput.addEventListener('change', function() {
                if (this.value != '') {
                    const checkInDate = new Date(this.value);
                    checkOutInput.min = checkInDate.toISOString().split('T')[0];
                    calculatePrice();
                }

                return;
            });

            checkOutInput.addEventListener('change', calculatePrice);

            // Terms checkbox handling: enable submit only when checked
            const termsCheckbox = document.getElementById('termsCheckbox');
            const bookingSubmit = document.getElementById('bookingSubmit');
            if (termsCheckbox && bookingSubmit) {
                termsCheckbox.addEventListener('change', function() {
                    bookingSubmit.disabled = !this.checked;
                });
                // ensure it's unchecked by default
                termsCheckbox.checked = false;
                bookingSubmit.disabled = true;
            }
        });
    </script>
    <script>
        // Floating share button behaviour (Web Share API with clipboard fallback)
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('floatingShareBtn');
            if (!btn) return;

            function showFloatingTip(text) {
                const tip = document.createElement('div');
                tip.className = 'absolute bg-slate-800 text-white text-xs px-2 py-1 rounded-md z-60';
                tip.style.right = '0px';
                tip.style.top = '-40px';
                tip.textContent = text;
                btn.style.position = 'fixed';
                btn.appendChild(tip);
                setTimeout(() => {
                    try {
                        tip.remove();
                    } catch (e) {}
                }, 1600);
            }

            btn.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();
                const link = '{{ url()->current() }}';
                if (navigator.share) {
                    try {
                        await navigator.share({
                            title: document.title,
                            url: link
                        });
                        showFloatingTip('Terkirim');
                        return;
                    } catch (err) {
                        // fall back to clipboard
                    }
                }

                try {
                    await navigator.clipboard.writeText(link);
                    showFloatingTip('Tautan disalin');
                } catch (err) {
                    showFloatingTip('Gagal disalin');
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        // initialize a single GLightbox instance and bind clicks to open at index
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof GLightbox === 'undefined') return;
            const imgs = Array.from(document.querySelectorAll('.slider-img'));
            if (!imgs.length) return;

            const elements = imgs.map(i => ({
                href: i.src,
                type: 'image'
            }));
            const light = GLightbox({
                elements: elements,
                touchNavigation: true,
                loop: false
            });

            imgs.forEach((img, idx) => {
                img.style.cursor = 'zoom-in';
                img.addEventListener('click', function(e) {
                    e.preventDefault();
                    try {
                        light.openAt(idx);
                    } catch (err) {
                        console.error('GLightbox openAt error', err);
                    }
                });
            });

            // Ensure scrolling is restored when lightbox closes
            try {
                light.on('close', function() {
                    try {
                        document.body.style.overflow = '';
                        document.documentElement.style.overflow = '';
                        document.body.classList.remove('glightbox-open');
                    } catch (e) {
                        // no-op
                    }
                });
            } catch (e) {
                // some GLightbox versions may not support on(); fallback: no-op
            }
        });
    </script>
    <script src="{{ asset('js/image-slider.js') }}"></script>
@endsection
