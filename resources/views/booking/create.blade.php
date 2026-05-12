@extends('layout')

@php
    $seoTitle = 'Booking ' . ($apartment->judul ?? 'Apartemen') . ' — IndoApart';
    $seoDescription =
        'Booking apartemen ' .
        ($apartment->judul ?? '') .
        ' di Bandung/Sekitarnya. Pilih tanggal check-in & check-out, lalu konfirmasi pemesanan.';
    $seoKeywords = 'booking apartemen, sewa apartemen, ' . ($apartment->alamat ?? 'Bandung') . ', IndoApart';

    $seoImage =
        isset($apartment->gambar) && is_array($apartment->gambar) && count($apartment->gambar)
            ? asset('storage/' . $apartment->gambar[0])
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
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('rooms.list') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-brand transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Daftar
                </a>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Apartment Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                        <!-- Image Slider -->
                        <div class="relative">
                            @if ($apartment->gambar && is_array($apartment->gambar) && count($apartment->gambar) > 0)
                                <div id="imageSlider" class="relative h-64 sm:h-80 overflow-hidden rounded-t-2xl">
                                    @foreach ($apartment->gambar as $index => $image)
                                        <img src="{{ asset('storage/' . $image) }}" data-index="{{ $index }}"
                                            class="slider-img absolute inset-0 w-full h-full object-cover cursor-zoom-in transition-opacity duration-500 opacity-0"
                                            style="{{ $index === 0 ? 'opacity: 1;' : '' }}"
                                            alt="{{ $apartment->judul }} - Gambar {{ $index + 1 }}" loading="lazy">
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
                                        @foreach ($apartment->gambar as $index => $image)
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
                                    {{ $apartment->tipe }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 sm:p-8">
                            <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand mb-2">
                                {{ $apartment->judul }}</h1>
                            <div class="flex items-center gap-1.5 text-slate-500 mb-4">
                                <i data-lucide="map-pin" class="w-4 h-4 shrink-0"></i>
                                <span class="text-sm">{{ $apartment->alamat }}</span>
                            </div>

                            <!-- Price -->
                            @if ($apartment->harga_per_malam)
                                <div class="flex items-baseline gap-2 mb-6 p-4 bg-brand/5 rounded-xl">
                                    <span class="text-2xl font-bold text-brand">Rp
                                        {{ number_format($apartment->harga_per_malam, 0, ',', '.') }}</span>
                                    <span class="text-sm text-slate-500">/ malam</span>
                                </div>
                            @endif

                            <!-- Description -->
                            @if ($apartment->deskripsi)
                                <div class="mb-6">
                                    <h3 class="text-sm font-medium text-slate-700 mb-2">Deskripsi</h3>
                                    <p class="text-sm text-slate-600 leading-relaxed">{{ $apartment->deskripsi }}</p>
                                </div>
                            @endif

                            <!-- Info Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                                <div class="p-3 bg-slate-50 rounded-xl text-center">
                                    <i data-lucide="maximize" class="w-5 h-5 text-brand mx-auto mb-1"></i>
                                    <div class="text-xs text-slate-500">Luas</div>
                                    <div class="text-sm font-semibold text-slate-800">{{ $apartment->luas }} m²</div>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl text-center">
                                    <i data-lucide="building" class="w-5 h-5 text-brand mx-auto mb-1"></i>
                                    <div class="text-xs text-slate-500">Tower</div>
                                    <div class="text-sm font-semibold text-slate-800">{{ $apartment->nama_tower }}</div>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl text-center">
                                    <i data-lucide="door-open" class="w-5 h-5 text-brand mx-auto mb-1"></i>
                                    <div class="text-xs text-slate-500">Kamar</div>
                                    <div class="text-sm font-semibold text-slate-800">{{ $apartment->nomor_kamar }}</div>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl text-center">
                                    <i data-lucide="users" class="w-5 h-5 text-brand mx-auto mb-1"></i>
                                    <div class="text-xs text-slate-500">Kapasitas</div>
                                    <div class="text-sm font-semibold text-slate-800">
                                        {{ $apartment->tamu_dewasa + $apartment->tamu_anak }} Tamu</div>
                                </div>
                            </div>

                            <!-- Fasilitas -->
                            @if ($apartment->fasilitas && count($apartment->fasilitas) > 0)
                                <div class="mb-6">
                                    <h3 class="text-sm font-medium text-slate-700 mb-3">Fasilitas</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($apartment->fasilitas as $fasilitas)
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
                            @if ($apartment->tata_tertib)
                                <div class="p-5 bg-slate-50 rounded-xl border border-slate-100">
                                    <h3 class="text-sm font-medium text-slate-700 mb-3 flex items-center gap-2">
                                        <i data-lucide="scroll-text" class="w-4 h-4 text-brand"></i>
                                        Tata Tertib
                                    </h3>
                                    <div class="text-sm text-slate-600 whitespace-pre-line">{{ $apartment->tata_tertib }}
                                    </div>
                                </div>
                            @endif

                            {{-- Maps --}}
                            <div class="mt-5 rounded-xl border border-slate-100 map-container overflow-hidden">
                                {!! $apartment->alamat_google !!}
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Booking Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm sticky top-24">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                            <i data-lucide="calendar-check" class="w-5 h-5 text-brand"></i>
                            Formulir Booking
                        </h2>

                        <form action="{{ route('booking.store', $apartment->slug) }}" method="POST" id="bookingForm">
                            @csrf

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

                            <!-- Guests -->
                            <div class="mb-4">
                                <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                    Jumlah Tamu (Max: {{ $apartment->tamu_dewasa + $apartment->tamu_anak }})
                                </label>
                                <select name="jumlah_tamu" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                                    @for ($i = 1; $i <= $apartment->tamu_dewasa + $apartment->tamu_anak; $i++)
                                        <option value="{{ $i }}">{{ $i }} Tamu</option>
                                    @endfor
                                </select>
                                @error('jumlah_tamu')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
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
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-600">Harga per malam</span>
                                    <span class="text-slate-800">Rp
                                        {{ number_format($apartment->harga_per_malam, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-600">Jumlah malam</span>
                                    <span class="text-slate-800" id="jumlahMalam">0 malam</span>
                                </div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-slate-600">Total</span>
                                    <span class="text-slate-800" id="totalHarga">Rp 0</span>
                                </div>
                            </div>

                            <!-- Submit -->
                            <button type="submit"
                                class="w-full bg-brand text-white py-3 rounded-xl font-medium hover:bg-brand-light transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="calendar-check" class="w-4 h-4"></i>
                                Booking Sekarang
                            </button>

                            <p class="text-xs text-slate-400 text-center mt-3">
                                Dengan booking, Anda setuju dengan syarat & ketentuan
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image slider init - make images global (safe init)
            window.apartmentImages = @json($apartment->gambar ?? []);
            if (window.initSlider && window.apartmentImages.length > 0) {
                window.initSlider();
            }

            // Booking calculator
            const checkInInput = document.getElementById('checkIn');
            const checkOutInput = document.getElementById('checkOut');
            const jumlahMalamDisplay = document.getElementById('jumlahMalam');
            const totalHargaDisplay = document.getElementById('totalHarga');
            const hargaPerMalam = {{ (float) $apartment->harga_per_malam }};

            // Set min date to today
            const today = new Date().toISOString().split('T')[0];
            checkInInput.min = today;
            checkOutInput.min = today;

            // Disable dates that are already booked for this apartment
            // We only rely on client-side disabling here; server-side validation still exists in BookingController.
            @php
                $bookingsForDates = \App\Models\Booking::where('apartment_id', $apartment->id)
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
                        this.value = '';

                        alert('Tanggal ' + this.value +
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
                    const total = diffDays * hargaPerMalam;

                    jumlahMalamDisplay.textContent = diffDays + ' malam';
                    totalHargaDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                } else {
                    jumlahMalamDisplay.textContent = '0 malam';
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
