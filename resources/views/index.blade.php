@extends('layout')

@push('js-scripts')
    {{-- <script src="{{ asset('js/search.js') }}"></script> --}}
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[680px] h-[75vh] flex items-end overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://picsum.photos/seed/tropical-paradise/1920/1080" class="hero-bg w-full h-full object-cover"
                alt="Hero">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/20"></div>
        </div>
        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 pb-10 md:pb-16">
            <div class="text-center mb-8">
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-serif font-semibold text-white tracking-tight leading-tight mb-4">
                    {{-- Temukan Apartemen<br class="hidden sm:block"> Impianmu --}}
                    Staycation in Apartment

                </h1>
                <p class="text-white/70 text-base sm:text-lg max-w-xl mx-auto">Jelajahi pilihan apartemen dan
                    penginapan terbaik dengan harga terjangkau</p>
            </div>

            <!-- Search Bar -->
            <div class="max-w-5xl mx-auto">
                <!-- Tab -->
                <div class="flex gap-1 mb-3">
                    <button onclick="setSearchTab(this, 'apartment')"
                        class="search-tab px-5 py-2 rounded-full text-sm font-medium bg-white/15 text-white/80 hover:bg-white/25 transition-all">🏢
                        Apartemen</button>
                </div>

                <!-- Search Box -->
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl p-3 sm:p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-2 sm:gap-3">
                        <!-- Destination -->
                        <div class="lg:col-span-4 relative">
                            <label
                                class="block text-[11px] font-medium text-slate-400 uppercase tracking-wider mb-1 px-3">Destinasi</label>
                            <div
                                class="flex items-center gap-2 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 focus-within:border-brand focus-within:ring-2 focus-within:ring-brand/10 transition-all">
                                <i data-lucide="map-pin" class="w-4 h-4 text-brand shrink-0"></i>
                                <input type="text" id="searchDest" placeholder="Apartemen, kota..."
                                    class="w-full bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400">
                            </div>
                        </div>
                        <!-- Check-in -->

                        <div class="lg:col-span-2">
                            <label
                                class="block text-[11px] font-medium text-slate-400 uppercase tracking-wider mb-1 px-3">Check-in</label>
                            <div
                                class="flex items-center gap-2 ps-3 pe-8 py-2.5 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 focus-within:border-brand focus-within:ring-2 focus-within:ring-brand/10 transition-all">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                <input type="date" id="checkin"
                                    class="w-full bg-transparent text-sm text-slate-700 outline-none">
                            </div>
                        </div>
                        <!-- Check-out -->
                        <div class="lg:col-span-2">
                            <label
                                class="block text-[11px] font-medium text-slate-400 uppercase tracking-wider mb-1 px-3">Check-out</label>
                            <div
                                class="flex items-center gap-2 ps-3 pe-8 py-2.5 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 focus-within:border-brand focus-within:ring-2 focus-within:ring-brand/10 transition-all">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                <input type="date" id="checkout"
                                    class="w-full bg-transparent text-sm text-slate-700 outline-none">
                            </div>
                        </div>
                        <!-- Guests -->
                        <div class="lg:col-span-2">
                            <label
                                class="block text-[11px] font-medium text-slate-400 uppercase tracking-wider mb-1 px-3">Tamu</label>
                            {{-- <button onclick="openGuestModal()"
                                class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition-all text-left">
                                <i data-lucide="users" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                <span id="guestDisplay" class="text-sm text-slate-700 truncate">2 Dewasa, 1 Kamar</span>
                            </button> --}}

                            <select name="tamu" id="guestSelect"
                                class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition-all text-left">
                                <option value="" disabled>Pilih jumlah tamu</option>
                                <option value="1">1 Tamu</option>
                                <option value="2">2 Tamu</option>
                                <option value="3">3 Tamu</option>
                                <option value="4">4 Tamu</option>
                            </select>
                        </div>
                        <!-- Search Button -->
                        <div class="lg:col-span-2 flex items-end">
                            <button onclick="handleSearch()"
                                class="w-full bg-brand text-white py-3 rounded-xl font-medium hover:bg-brand-light transition-colors flex items-center justify-center gap-2 text-sm shadow-lg shadow-brand/20">
                                <i data-lucide="search" class="w-4 h-4"></i>
                                Cari
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats -->
    <section class="bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-semibold text-brand">15K+</div>
                    <div class="text-sm text-slate-500 mt-1">Apartemen & Penginapan</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-semibold text-brand">500+</div>
                    <div class="text-sm text-slate-500 mt-1">Kota di Indonesia</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-semibold text-brand">2M+</div>
                    <div class="text-sm text-slate-500 mt-1">Pengguna Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-semibold text-brand">4.8</div>
                    <div class="text-sm text-slate-500 mt-1 flex items-center justify-center gap-1">
                        <i data-lucide="star" class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400"></i> Rating
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- List Product (Rooms carousel) -->
    <section class="py-5 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            {{-- <div class="flex items-end justify-between mb-6">
                <div>
                    <span class="text-xs font-medium tracking-[0.2em] uppercase text-brand/60">Pilihan</span>
                    <h2 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800 mt-1">List Room</h2>
                </div>
            </div> --}}

            @if (isset($randomRooms) && $randomRooms->count())
                <div class="relative">
                    <div id="productCarousel" class="overflow-hidden">
                        <div class="carousel-track flex will-change-transform">
                            @foreach ($randomRooms as $room)
                                @php
                                    $thumb = null;
                                    if (is_array($room->gambar) && count($room->gambar)) {
                                        $thumb = asset('storage/' . $room->gambar[0]);
                                    } elseif (is_string($room->gambar) && $room->gambar) {
                                        $thumb = asset('storage/' . $room->gambar);
                                    } else {
                                        $thumb = 'https://picsum.photos/seed/room' . $loop->index . '/300/200';
                                    }
                                @endphp

                                <a href="{{ route('booking.create', ['room' => $room->slug ?? $room->id]) }}"
                                    class="carousel-item flex-none w-1/2 sm:w-1/3 lg:w-1/4 pr-3">
                                    <div
                                        class="bg-white rounded-2xl border border-slate-100 p-3 sm:flex gap-3 items-center">
                                        <div
                                            class="w-full h-20 sm:w-20 sm:h-20 flex-shrink-0 rounded-md overflow-hidden bg-slate-100 mb-1 sm:mb-0">
                                            <img src="{{ $thumb }}" class="w-full h-full object-cover"
                                                alt="{{ $room->judul }}">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-xs text-slate-400">{{ $room->apartment->nama ?? '—' }}</div>
                                            <h3
                                                class="font-semibold text-slate-800 sm:line-clamp-2 line-clamp-3 text-sm sm:text-base">
                                                {{ $room->judul }}
                                            </h3>
                                            <div class="text-sm text-brand font-medium mt-1">Rp
                                                {{ number_format((float) $room->harga_per_malam, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <button id="prevProduct" aria-label="Previous"
                        class="absolute left-2 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-white/90 shadow flex items-center justify-center">
                        <i data-lucide="chevron-left" class="w-4 h-4 text-slate-700"></i>
                    </button>
                    <button id="nextProduct" aria-label="Next"
                        class="absolute right-2 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-white/90 shadow flex items-center justify-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-700"></i>
                    </button>
                </div>
            @else
                <p class="text-sm text-slate-500">Belum ada room untuk ditampilkan.</p>
            @endif
        </div>
    </section>

    @push('js-scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carousel = document.getElementById('productCarousel');
                if (!carousel) return;
                const track = carousel.querySelector('.carousel-track');
                const originals = Array.from(track.children);
                if (!originals.length) return;

                // clone items for infinite effect
                originals.forEach(node => track.appendChild(node.cloneNode(true)));
                originals.slice().reverse().forEach(node => track.insertBefore(node.cloneNode(true), track.firstChild));

                const items = Array.from(track.children);
                let index = originals.length;

                function updateTrack(animate = true) {
                    const item = track.querySelector('.carousel-item');
                    const itemWidth = item.getBoundingClientRect().width;
                    if (!animate) track.style.transition = 'none';
                    else track.style.transition = 'transform 500ms ease';
                    track.style.transform = `translateX(${-index * itemWidth}px)`;
                    if (!animate) requestAnimationFrame(() => {
                        track.style.transition = 'transform 500ms ease';
                    });
                }

                // initial position
                updateTrack(false);

                // autoplay
                let autoplay = setInterval(() => {
                    index++;
                    updateTrack(true);
                }, 3000);

                function resetAutoplay() {
                    if (autoplay) clearInterval(autoplay);
                    autoplay = setInterval(() => {
                        index++;
                        updateTrack(true);
                    }, 3000);
                }

                // handle bounds and reset without animation
                const totalOriginal = originals.length;
                track.addEventListener('transitionend', () => {
                    if (index >= items.length - totalOriginal) {
                        index = totalOriginal;
                        updateTrack(false);
                    } else if (index < totalOriginal) {
                        index = items.length - (2 * totalOriginal);
                        updateTrack(false);
                    }
                });

                // navigation buttons
                const prevBtn = document.getElementById('prevProduct');
                const nextBtn = document.getElementById('nextProduct');
                if (prevBtn) prevBtn.addEventListener('click', () => {
                    index--;
                    updateTrack(true);
                    resetAutoplay();
                });
                if (nextBtn) nextBtn.addEventListener('click', () => {
                    index++;
                    updateTrack(true);
                    resetAutoplay();
                });

                // responsive: recalc on resize
                let resizeTimeout;
                window.addEventListener('resize', () => {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(() => updateTrack(false), 150);
                });

                // touch swipe
                let startX = 0;
                let currentX = 0;
                carousel.addEventListener('touchstart', e => startX = e.touches[0].clientX);
                carousel.addEventListener('touchmove', e => currentX = e.touches[0].clientX);
                carousel.addEventListener('touchend', () => {
                    const diff = startX - currentX;
                    if (Math.abs(diff) > 50) {
                        if (diff > 0) index++;
                        else index--;
                        updateTrack(true);
                        resetAutoplay();
                    }
                });
            });
        </script>
    @endpush

    <!-- Newest Apartments -->
    <section class="py-16 md:pt-20 md:pb-10 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-xs font-medium tracking-[0.2em] uppercase text-brand/60">Terbaru</span>
                    <h2 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800 mt-1">Apartemen Terbaru</h2>
                </div>
                <a href="{{ route('rooms.list') }}"
                    class="hidden sm:flex items-center gap-1 text-sm font-medium text-brand hover:underline">
                    Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @if (isset($apartments) && $apartments->count())
                    @foreach ($apartments as $apartment)
                        @php
                            $img = $apartment->gambar
                                ? asset('storage/' . $apartment->gambar)
                                : 'https://picsum.photos/seed/apartment' . $loop->index . '/600/450';
                        @endphp
                        <a href="{{ route('rooms.list', ['apartment' => $apartment->nama]) }}"
                            class="group block bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                            <div class="relative overflow-hidden aspect-[4/3]">
                                <img src="{{ $img }}" loading="lazy"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                    alt="{{ $apartment->nama }}">
                            </div>
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-1">
                                    <span
                                        class="text-xs text-slate-400">{{ $apartment->nama ?? ($apartment->alamat ?? '—') }}</span>
                                    {{-- <span class="text-xs text-slate-500">Rp
                                        {{ number_format((float) $room->harga_per_malam, 0, ',', '.') }}</span> --}}
                                </div>
                                <h3 class="font-semibold text-slate-800 line-clamp-1 group-hover:text-brand">
                                    {{ $apartment->nama }}</h3>
                                {{-- <p class="text-[12px] text-slate-500 mt-2 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit($apartment->deskripsi, 80) }}</p> --}}
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="text-sm text-slate-500">Belum ada apartemen terbaru untuk ditampilkan.</p>
                @endif
            </div>
        </div>
    </section>

    <section class="py-6 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <img src="{{ asset('images/indoapart-img.jpeg') }}" alt="Customer Service"
                class="w-full rounded-2xl object-cover">
        </div>
    </section>

    <!-- Popular Destinations -->
    {{-- <section class="py-16 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-xs font-medium tracking-[0.2em] uppercase text-brand/60">Jelajahi</span>
                    <h2 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800 mt-1">Destinasi Populer
                    </h2>
                </div>
                <a href="#" class="hidden sm:flex items-center gap-1 text-sm font-medium text-brand hover:underline">
                    Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                <a href="#"
                    class="group relative rounded-2xl overflow-hidden aspect-[3/4] shadow-md hover:shadow-xl transition-all duration-300">
                    <img src="https://picsum.photos/seed/bali-temple/400/530"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        alt="Bali">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3">
                        <h3 class="text-white font-semibold text-sm">Bali</h3>
                        <p class="text-white/60 text-xs">3,245 hotel</p>
                    </div>
                </a>
                <a href="#"
                    class="group relative rounded-2xl overflow-hidden aspect-[3/4] shadow-md hover:shadow-xl transition-all duration-300">
                    <img src="https://picsum.photos/seed/jakarta-city/400/530"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        alt="Jakarta">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3">
                        <h3 class="text-white font-semibold text-sm">Jakarta</h3>
                        <p class="text-white/60 text-xs">2,180 hotel</p>
                    </div>
                </a>
                <a href="#"
                    class="group relative rounded-2xl overflow-hidden aspect-[3/4] shadow-md hover:shadow-xl transition-all duration-300">
                    <img src="https://picsum.photos/seed/yogyakarta-palace/400/530"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        alt="Yogyakarta">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3">
                        <h3 class="text-white font-semibold text-sm">Yogyakarta</h3>
                        <p class="text-white/60 text-xs">1,420 hotel</p>
                    </div>
                </a>
                <a href="#"
                    class="group relative rounded-2xl overflow-hidden aspect-[3/4] shadow-md hover:shadow-xl transition-all duration-300">
                    <img src="https://picsum.photos/seed/bandung-garden/400/530"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        alt="Bandung">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3">
                        <h3 class="text-white font-semibold text-sm">Bandung</h3>
                        <p class="text-white/60 text-xs">1,890 hotel</p>
                    </div>
                </a>
                <a href="#"
                    class="group relative rounded-2xl overflow-hidden aspect-[3/4] shadow-md hover:shadow-xl transition-all duration-300">
                    <img src="https://picsum.photos/seed/surabaya-tower/400/530"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        alt="Surabaya">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3">
                        <h3 class="text-white font-semibold text-sm">Surabaya</h3>
                        <p class="text-white/60 text-xs">1,120 hotel</p>
                    </div>
                </a>
                <a href="#"
                    class="group relative rounded-2xl overflow-hidden aspect-[3/4] shadow-md hover:shadow-xl transition-all duration-300">
                    <img src="https://picsum.photos/seed/lombok-beach/400/530"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        alt="Lombok">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 right-3">
                        <h3 class="text-white font-semibold text-sm">Lombok</h3>
                        <p class="text-white/60 text-xs">870 hotel</p>
                    </div>
                </a>
            </div>
        </div>
    </section> --}}

    <!-- Promo Banner -->
    <section class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="relative rounded-2xl overflow-hidden h-48 sm:h-56 group cursor-pointer">
                    <img src="https://picsum.photos/seed/flash-sale-hotel/800/400"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        alt="">
                    <div class="absolute inset-0 bg-gradient-to-r from-brand/90 to-brand/30"></div>
                    <div class="absolute inset-0 p-6 sm:p-8 flex flex-col justify-center">
                        <span
                            class="inline-flex items-center gap-1 bg-accent text-brand text-[10px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full w-fit mb-3">🔥
                            Flash Sale</span>
                        <h3 class="text-white text-xl sm:text-2xl font-semibold leading-tight">Diskon
                            hingga<br><span class="text-accent">70% OFF</span></h3>
                        <p class="text-white/60 text-sm mt-2">Berlaku hingga 31 Des 2025</p>
                    </div>
                </div>
                <div class="relative rounded-2xl overflow-hidden h-48 sm:h-56 group cursor-pointer">
                    <img src="https://picsum.photos/seed/last-minute-deal/800/400"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        alt="">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 to-slate-900/30"></div>
                    <div class="absolute inset-0 p-6 sm:p-8 flex flex-col justify-center">
                        <span
                            class="inline-flex items-center gap-1 bg-white/20 text-white text-[10px] font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full w-fit mb-3 backdrop-blur-sm">⚡
                            Last Minute</span>
                        <h3 class="text-white text-xl sm:text-2xl font-semibold leading-tight">Booking Hari
                            Ini<br><span class="text-accent">Hemat 40%</span></h3>
                        <p class="text-white/60 text-sm mt-2">Check-in malam ini</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 md:py-20 bg-brand">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="text-xs font-medium tracking-[0.2em] uppercase text-accent/70">Mengapa
                    IndoApart</span>
                <h2 class="text-2xl sm:text-3xl font-serif font-semibold text-white mt-2">Kenapa Jutaan Orang<br
                        class="hidden sm:block"> Memilih Kami?</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="text-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <div class="w-14 h-14 bg-accent/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="shield-check" class="w-7 h-7 text-accent"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Jaminan Harga</h3>
                    <p class="text-white/50 text-sm leading-relaxed">Temukan harga lebih murah?</p>
                </div>
                <div
                    class="text-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <div class="w-14 h-14 bg-accent/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="credit-card" class="w-7 h-7 text-accent"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Pembayaran Mudah</h3>
                    <p class="text-white/50 text-sm leading-relaxed">Bayar di tempat, transfer, kartu kredit, atau
                        cicilan 0%</p>
                </div>
                <div
                    class="text-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <div class="w-14 h-14 bg-accent/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="headphones" class="w-7 h-7 text-accent"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Support 24/7</h3>
                    <p class="text-white/50 text-sm leading-relaxed">Tim kami siap membantu kapanpun melalui chat,
                        telepon, atau email</p>
                </div>
                <div
                    class="text-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <div class="w-14 h-14 bg-accent/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="rotate-ccw" class="w-7 h-7 text-accent"></i>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Gratis Pembatalan</h3>
                    <p class="text-white/50 text-sm leading-relaxed">Banyak pilihan apartemen dengan gratis
                        pembatalan
                        hingga 24 jam</p>
                </div>
            </div>
        </div>
    </section>



    <!-- Testimonials -->
    <section class="py-16 md:py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="text-xs font-medium tracking-[0.2em] uppercase text-brand/60">Testimoni</span>
                <h2 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800 mt-1">Apa Kata Mereka?</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-1 mb-3">
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">"Pertama kali pakai IndoApart, langsung
                        ketemu
                        hotel impian di Bali. Harganya jauh lebih murah dari platform lain. Proses bookingnya super
                        gampang!"</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-brand/10 flex items-center justify-center text-brand font-semibold text-sm">
                            AS</div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Andi Susanto</p>
                            <p class="text-xs text-slate-400">Jakarta</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-1 mb-3">
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">"Suka banget fitur bayar di tempatnya!
                        Jadi
                        lebih aman dan nggak perlu khawatir. Customer servicenya juga responsif banget."</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-brand/10 flex items-center justify-center text-brand font-semibold text-sm">
                            RN</div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Rina Nurhayati</p>
                            <p class="text-xs text-slate-400">Bandung</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-1 mb-3">
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 fill-yellow-400 text-yellow-400"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400"></i>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">"Liburan keluarga ke Lombok jadi
                        terencana
                        berkat StayGo. Bisa filter hotel yang ramah anak dan ada kolam renang. Recommended!"</p>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-brand/10 flex items-center justify-center text-brand font-semibold text-sm">
                            BP</div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Budi Pratama</p>
                            <p class="text-xs text-slate-400">Surabaya</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section class="py-16 md:py-20 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
                <div>
                    <span class="text-xs font-medium tracking-[0.2em] uppercase text-brand/60">Hubungi Kami</span>
                    <h2 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800 mt-2 mb-4">Ada
                        Pertanyaan?</h2>
                    <p class="text-slate-500 mb-8">Tim kami siap membantu Anda 24/7. Hubungi kami untuk informasi
                        apartemen, pemesanan, atau pertanyaan lainnya.</p>

                    <div class="space-y-4">
                        <a href="{{ route('inquiry.create') }}"
                            class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl hover:bg-brand/5 transition-colors group">
                            <div
                                class="w-12 h-12 bg-brand/10 rounded-xl flex items-center justify-center group-hover:bg-brand/20 transition-colors">
                                <i data-lucide="message-circle" class="w-6 h-6 text-brand"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-slate-800">Chat Kami</h3>
                                <p class="text-sm text-slate-500">Respons cepat untuk Anda</p>
                            </div>
                            <i data-lucide="arrow-right"
                                class="w-5 h-5 text-slate-300 ml-auto group-hover:text-brand transition-colors"></i>
                        </a>

                        <a href="tel:+{{ $adminInfo->whatsapp }}"
                            class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl hover:bg-brand/5 transition-colors group">
                            <div
                                class="w-12 h-12 bg-brand/10 rounded-xl flex items-center justify-center group-hover:bg-brand/20 transition-colors">
                                <i data-lucide="phone" class="w-6 h-6 text-brand"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-slate-800">Telepon</h3>
                                <p class="text-sm text-slate-500">+{{ $adminInfo->whatsapp }}</p>
                            </div>
                            <i data-lucide="arrow-right"
                                class="w-5 h-5 text-slate-300 ml-auto group-hover:text-brand transition-colors"></i>
                        </a>

                        <a href="mailto:{{ $adminInfo->email }}"
                            class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl hover:bg-brand/5 transition-colors group">
                            <div
                                class="w-12 h-12 bg-brand/10 rounded-xl flex items-center justify-center group-hover:bg-brand/20 transition-colors">
                                <i data-lucide="mail" class="w-6 h-6 text-brand"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-slate-800">Email</h3>
                                <p class="text-sm text-slate-500">{{ $adminInfo->email }}</p>
                            </div>
                            <i data-lucide="arrow-right"
                                class="w-5 h-5 text-slate-300 ml-auto group-hover:text-brand transition-colors"></i>
                        </a>

                        <a href="{{ route('inquiry.create') }}"
                            class="flex items-center gap-4 p-4 bg-brand rounded-xl hover:bg-brand-light transition-colors group">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <i data-lucide="send" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-white">Kirim Pesan</h3>
                                <p class="text-sm text-white/70">Isi formulir kontak</p>
                            </div>
                            <i data-lucide="arrow-right" class="w-5 h-5 text-white/70 ml-auto"></i>
                        </a>
                    </div>
                </div>

                <div class="hidden md:block relative">
                    <img src="{{ asset('images/bg-contact.jpeg') }}" alt="Customer Service"
                        class="w-full rounded-2xl object-cover">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent rounded-2xl">
                    </div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="bg-white/90 backdrop-blur-sm rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium text-slate-700">Online 24/7</span>
                            </div>
                            <p class="text-sm text-slate-600">Tim customer service kami siap membantu Anda kapan
                                saja.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Owner Recruitment Banner -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="rounded-2xl bg-brand p-8 sm:p-12 flex flex-col md:flex-row items-center gap-6">
                <div class="flex-1 text-white">
                    <h3 class="text-2xl font-semibold">Daftarkan Apartemen Anda di IndoApart.com
                    </h3>
                    <p class="text-white/90 mt-2">Gabung bersama ribuan owner lain untuk tingkatkan
                        okupansi dan pendapatan. Mudah diatur, dukungan penuh dari tim kami.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('rooms.owner.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-3 bg-white text-brand rounded-xl font-medium hover:opacity-95 transition">Pasang
                        Iklan Gratis</a>
                    <a href="https://wa.me/{{ $adminInfo->whatsapp }}?text=Halo%20Admin,%20saya%20ingin%20mendaftar%20sebagai%20owner%20apartemen"
                        class="inline-flex items-center gap-2 px-5 py-3 bg-white/20 text-white rounded-xl font-medium hover:opacity-90 transition">Hubungi
                        Admin</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    {{-- <section class="py-16 bg-slate-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 text-center">
            <i data-lucide="mail" class="w-10 h-10 text-brand/30 mx-auto mb-4"></i>
            <h2 class="text-2xl font-serif font-semibold text-slate-800 mb-2">Dapatkan Penawaran Eksklusif</h2>
            <p class="text-slate-500 text-sm mb-6">Berlangganan newsletter kami dan dapatkan diskon 15% untuk booking
                pertama</p>
            <form onsubmit="handleNewsletter(event)" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="email" id="newsletterEmail" placeholder="Alamat email kamu" required
                    class="flex-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                <button type="submit"
                    class="px-6 py-3 bg-brand text-white rounded-xl font-medium text-sm hover:bg-brand-light transition-colors whitespace-nowrap">Berlangganan</button>
            </form>
        </div>
    </section> --}}
@endsection
