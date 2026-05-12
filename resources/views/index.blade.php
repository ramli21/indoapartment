@extends('layout')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[600px] h-[75vh] flex items-end overflow-hidden">
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
                    penginapan terbaik di bandung dengan harga terjangkau</p>
            </div>

            <!-- Search Bar -->
            <div class="max-w-5xl mx-auto">
                <!-- Tab -->
                <div class="flex gap-1 mb-3">
                    {{-- <button onclick="setSearchTab(this, 'hotel')"
                        class="search-tab active-tab px-5 py-2 rounded-full text-sm font-medium bg-white text-brand transition-all">🏨
                        Hotel</button> --}}
                    <button onclick="setSearchTab(this, 'apartment')"
                        class="search-tab px-5 py-2 rounded-full text-sm font-medium bg-white/15 text-white/80 hover:bg-white/25 transition-all">🏢
                        Apartemen</button>
                    {{-- <button onclick="setSearchTab(this, 'villa')"
                        class="search-tab px-5 py-2 rounded-full text-sm font-medium bg-white/15 text-white/80 hover:bg-white/25 transition-all">🏡
                        Villa</button>
                    <button onclick="setSearchTab(this, 'flight')"
                        class="search-tab px-5 py-2 rounded-full text-sm font-medium bg-white/15 text-white/80 hover:bg-white/25 transition-all">✈️
                        Penerbangan</button> --}}
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
                                <input type="text" id="searchDest" placeholder="Kota, hotel, atau tempat"
                                    class="w-full bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400">
                            </div>
                        </div>
                        <!-- Check-in -->
                        <div class="lg:col-span-2">
                            <label
                                class="block text-[11px] font-medium text-slate-400 uppercase tracking-wider mb-1 px-3">Check-in</label>
                            <div
                                class="flex items-center gap-2 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 focus-within:border-brand focus-within:ring-2 focus-within:ring-brand/10 transition-all">
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
                                class="flex items-center gap-2 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 focus-within:border-brand focus-within:ring-2 focus-within:ring-brand/10 transition-all">
                                <i data-lucide="calendar" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                <input type="date" id="checkout"
                                    class="w-full bg-transparent text-sm text-slate-700 outline-none">
                            </div>
                        </div>
                        <!-- Guests -->
                        <div class="lg:col-span-2">
                            <label
                                class="block text-[11px] font-medium text-slate-400 uppercase tracking-wider mb-1 px-3">Tamu</label>
                            <button onclick="openGuestModal()"
                                class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition-all text-left">
                                <i data-lucide="users" class="w-4 h-4 text-slate-400 shrink-0"></i>
                                <span id="guestDisplay" class="text-sm text-slate-700 truncate">2 Dewasa, 1 Kamar</span>
                            </button>
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
                    <div class="text-sm text-slate-500 mt-1">Hotel & Penginapan</div>
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

    <!-- Newest Apartments -->
    <section class="py-16 md:py-20 bg-white">
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
                @if (isset($newestRooms) && $newestRooms->count())
                    @foreach ($newestRooms as $room)
                        @php
                            $img =
                                is_array($room->gambar) && count($room->gambar)
                                    ? asset('storage/' . $room->gambar[0])
                                    : 'https://picsum.photos/seed/room' . $loop->index . '/600/450';
                        @endphp
                        <a href="{{ route('booking.create', $room) }}"
                            class="group block bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                            <div class="relative overflow-hidden aspect-[4/3]">
                                <img src="{{ $img }}" loading="lazy"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                    alt="{{ $room->judul }}">
                            </div>
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-1">
                                    <span
                                        class="text-xs text-slate-400">{{ $room->nama_tower ?? ($room->alamat ?? '—') }}</span>
                                    <span class="text-xs text-slate-500">Rp
                                        {{ number_format((float) $room->harga_per_malam, 0, ',', '.') }}</span>
                                </div>
                                <h3 class="font-semibold text-slate-800 line-clamp-1 group-hover:text-brand">
                                    {{ $room->judul }}</h3>
                                <p class="text-[12px] text-slate-500 mt-2 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit($room->deskripsi, 80) }}</p>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="text-sm text-slate-500">Belum ada apartemen terbaru untuk ditampilkan.</p>
                @endif
            </div>
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
                        <h3 class="text-white text-xl sm:text-2xl font-semibold leading-tight">Diskon hingga<br><span
                                class="text-accent">70% OFF</span></h3>
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

    <!-- Hotel Deals -->
    {{-- <section class="py-16 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-xs font-medium tracking-[0.2em] uppercase text-brand/60">Penawaran Terbaik</span>
                    <h2 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800 mt-1">Hotel Pilihan Hari
                        Ini</h2>
                </div>
                <div class="hidden sm:flex items-center gap-2">
                    <button onclick="scrollHotels(-1)"
                        class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition-colors">
                        <i data-lucide="chevron-left" class="w-4 h-4 text-slate-500"></i>
                    </button>
                    <button onclick="scrollHotels(1)"
                        class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition-colors">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-500"></i>
                    </button>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex gap-2 mb-6 overflow-x-auto hide-scrollbar pb-1">
                <button onclick="filterHotels(this,'all')"
                    class="hotel-filter active shrink-0 px-4 py-2 rounded-full text-sm font-medium bg-brand text-white transition-all">Semua</button>
                <button onclick="filterHotels(this,'promo')"
                    class="hotel-filter shrink-0 px-4 py-2 rounded-full text-sm font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">🔥
                    Promo</button>
                <button onclick="filterHotels(this,'top')"
                    class="hotel-filter shrink-0 px-4 py-2 rounded-full text-sm font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">⭐
                    Top Rated</button>
                <button onclick="filterHotels(this,'budget')"
                    class="hotel-filter shrink-0 px-4 py-2 rounded-full text-sm font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">💰
                    Budget</button>
                <button onclick="filterHotels(this,'luxury')"
                    class="hotel-filter shrink-0 px-4 py-2 rounded-full text-sm font-medium bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">💎
                    Luxury</button>
            </div>

            <!-- Hotel Cards -->
            <div id="hotelScroll" class="flex gap-5 overflow-x-auto hide-scrollbar pb-4 snap-x snap-mandatory">
                <!-- Card 1 -->
                <div class="hotel-card min-w-[280px] sm:min-w-[300px] snap-start group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col"
                    data-category="promo luxury">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="https://picsum.photos/seed/luxury-pool-bali/600/450"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            alt="">
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span
                                class="px-2.5 py-1 bg-red-500 text-white text-[10px] font-semibold rounded-lg uppercase">-45%</span>
                            <button onclick="toggleWishlist(this)"
                                class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-colors shadow-sm">
                                <i data-lucide="heart" class="w-4 h-4 text-slate-400"></i>
                            </button>
                        </div>
                        <div class="absolute bottom-3 left-3 flex gap-1.5">
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">Sarapan</span>
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">Pool</span>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs text-slate-400">Bali, Indonesia</span>
                        </div>
                        <h3 class="font-semibold text-slate-800 line-clamp-1 group-hover:text-brand transition-colors">
                            The Mulia Resort & Villas</h3>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <span class="bg-brand text-white text-xs font-semibold px-2 py-0.5 rounded">9.2</span>
                            <span class="text-xs text-slate-500">Luar Biasa (2,847 ulasan)</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-slate-50">
                            <div class="flex items-baseline gap-2">
                                <span class="text-xs text-slate-400 line-through">Rp 4.500.000</span>
                                <span class="text-lg font-semibold text-brand">Rp 2.475.000</span>
                            </div>
                            <p class="text-[11px] text-slate-400">per malam, termasuk pajak</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="hotel-card min-w-[280px] sm:min-w-[300px] snap-start group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col"
                    data-category="top">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="https://picsum.photos/seed/boutique-hotel-jkt/600/450"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            alt="">
                        <div class="absolute top-3 left-3 flex gap-2">
                            <button onclick="toggleWishlist(this)"
                                class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-colors shadow-sm">
                                <i data-lucide="heart" class="w-4 h-4 text-slate-400"></i>
                            </button>
                        </div>
                        <div class="absolute bottom-3 left-3 flex gap-1.5">
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">Spa</span>
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">Gym</span>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs text-slate-400">Jakarta, Indonesia</span>
                        </div>
                        <h3 class="font-semibold text-slate-800 line-clamp-1 group-hover:text-brand transition-colors">
                            Hotel Indonesia Kempinski</h3>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <span class="bg-brand text-white text-xs font-semibold px-2 py-0.5 rounded">9.5</span>
                            <span class="text-xs text-slate-500">Sempurna (5,120 ulasan)</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-slate-50">
                            <div class="flex items-baseline gap-2">
                                <span class="text-lg font-semibold text-brand">Rp 3.200.000</span>
                            </div>
                            <p class="text-[11px] text-slate-400">per malam, termasuk pajak</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="hotel-card min-w-[280px] sm:min-w-[300px] snap-start group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col"
                    data-category="budget promo">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="https://picsum.photos/seed/budget-hotel-yogya/600/450"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            alt="">
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span
                                class="px-2.5 py-1 bg-orange-500 text-white text-[10px] font-semibold rounded-lg uppercase">-30%</span>
                            <button onclick="toggleWishlist(this)"
                                class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-colors shadow-sm">
                                <i data-lucide="heart" class="w-4 h-4 text-slate-400"></i>
                            </button>
                        </div>
                        <div class="absolute bottom-3 left-3 flex gap-1.5">
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">WiFi</span>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs text-slate-400">Yogyakarta, Indonesia</span>
                        </div>
                        <h3 class="font-semibold text-slate-800 line-clamp-1 group-hover:text-brand transition-colors">
                            Phoenix Hotel Yogyakarta</h3>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <span class="bg-brand text-white text-xs font-semibold px-2 py-0.5 rounded">8.6</span>
                            <span class="text-xs text-slate-500">Sangat Baik (1,930 ulasan)</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-slate-50">
                            <div class="flex items-baseline gap-2">
                                <span class="text-xs text-slate-400 line-through">Rp 850.000</span>
                                <span class="text-lg font-semibold text-brand">Rp 595.000</span>
                            </div>
                            <p class="text-[11px] text-slate-400">per malam, termasuk pajak</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="hotel-card min-w-[280px] sm:min-w-[300px] snap-start group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col"
                    data-category="luxury top">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="https://picsum.photos/seed/resort-lombok/600/450"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            alt="">
                        <div class="absolute top-3 left-3 flex gap-2">
                            <button onclick="toggleWishlist(this)"
                                class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-colors shadow-sm">
                                <i data-lucide="heart" class="w-4 h-4 text-slate-400"></i>
                            </button>
                        </div>
                        <div class="absolute bottom-3 left-3 flex gap-1.5">
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">Pantai</span>
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">Pool</span>
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">Spa</span>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs text-slate-400">Lombok, Indonesia</span>
                        </div>
                        <h3 class="font-semibold text-slate-800 line-clamp-1 group-hover:text-brand transition-colors">
                            The Oberoi Beach Resort</h3>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <span class="bg-brand text-white text-xs font-semibold px-2 py-0.5 rounded">9.4</span>
                            <span class="text-xs text-slate-500">Luar Biasa (980 ulasan)</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-slate-50">
                            <div class="flex items-baseline gap-2">
                                <span class="text-lg font-semibold text-brand">Rp 5.800.000</span>
                            </div>
                            <p class="text-[11px] text-slate-400">per malam, termasuk pajak</p>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="hotel-card min-w-[280px] sm:min-w-[300px] snap-start group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col"
                    data-category="budget">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="https://picsum.photos/seed/capsule-hotel-bdg/600/450"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            alt="">
                        <div class="absolute top-3 left-3 flex gap-2">
                            <button onclick="toggleWishlist(this)"
                                class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-colors shadow-sm">
                                <i data-lucide="heart" class="w-4 h-4 text-slate-400"></i>
                            </button>
                        </div>
                        <div class="absolute bottom-3 left-3 flex gap-1.5">
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">WiFi</span>
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">Parkir</span>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs text-slate-400">Bandung, Indonesia</span>
                        </div>
                        <h3 class="font-semibold text-slate-800 line-clamp-1 group-hover:text-brand transition-colors">
                            Green Forest Resort Bandung</h3>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <span class="bg-brand text-white text-xs font-semibold px-2 py-0.5 rounded">8.2</span>
                            <span class="text-xs text-slate-500">Sangat Baik (3,210 ulasan)</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-slate-50">
                            <div class="flex items-baseline gap-2">
                                <span class="text-lg font-semibold text-brand">Rp 420.000</span>
                            </div>
                            <p class="text-[11px] text-slate-400">per malam, termasuk pajak</p>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="hotel-card min-w-[280px] sm:min-w-[300px] snap-start group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col"
                    data-category="promo">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="https://picsum.photos/seed/villa-seminyak/600/450"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            alt="">
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span
                                class="px-2.5 py-1 bg-red-500 text-white text-[10px] font-semibold rounded-lg uppercase">-55%</span>
                            <button onclick="toggleWishlist(this)"
                                class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-colors shadow-sm">
                                <i data-lucide="heart" class="w-4 h-4 text-slate-400"></i>
                            </button>
                        </div>
                        <div class="absolute bottom-3 left-3 flex gap-1.5">
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">Villa</span>
                            <span
                                class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-[10px] font-medium text-slate-700 rounded-md">Pool</span>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs text-slate-400">Seminyak, Bali</span>
                        </div>
                        <h3 class="font-semibold text-slate-800 line-clamp-1 group-hover:text-brand transition-colors">
                            Villa Seminyak Paradise</h3>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <span class="bg-brand text-white text-xs font-semibold px-2 py-0.5 rounded">8.9</span>
                            <span class="text-xs text-slate-500">Luar Biasa (1,456 ulasan)</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-slate-50">
                            <div class="flex items-baseline gap-2">
                                <span class="text-xs text-slate-400 line-through">Rp 3.000.000</span>
                                <span class="text-lg font-semibold text-brand">Rp 1.350.000</span>
                            </div>
                            <p class="text-[11px] text-slate-400">per malam, termasuk pajak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Why Choose Us -->
    <section class="py-16 md:py-20 bg-brand">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="text-xs font-medium tracking-[0.2em] uppercase text-accent/70">Mengapa IndoApart</span>
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
                    <p class="text-white/50 text-sm leading-relaxed">Banyak pilihan apartemen dengan gratis pembatalan
                        hingga 24 jam</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Explore by Type -->
    {{-- <section class="py-16 md:py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="text-xs font-medium tracking-[0.2em] uppercase text-brand/60">Kategori</span>
                <h2 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800 mt-1">Jelajahi Berdasarkan Tipe
                </h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="#"
                    class="group flex flex-col items-center gap-3 p-5 bg-white rounded-2xl border border-slate-100 hover:shadow-lg hover:border-brand/20 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-brand/5 rounded-2xl flex items-center justify-center group-hover:bg-brand/10 transition-colors text-2xl">
                        🏨</div>
                    <div class="text-center">
                        <p class="text-sm font-medium text-slate-700 group-hover:text-brand transition-colors">Hotel
                        </p>
                        <p class="text-[11px] text-slate-400 mt-0.5">12,450+</p>
                    </div>
                </a>
                <a href="#"
                    class="group flex flex-col items-center gap-3 p-5 bg-white rounded-2xl border border-slate-100 hover:shadow-lg hover:border-brand/20 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-brand/5 rounded-2xl flex items-center justify-center group-hover:bg-brand/10 transition-colors text-2xl">
                        🏡</div>
                    <div class="text-center">
                        <p class="text-sm font-medium text-slate-700 group-hover:text-brand transition-colors">Villa
                        </p>
                        <p class="text-[11px] text-slate-400 mt-0.5">3,280+</p>
                    </div>
                </a>
                <a href="#"
                    class="group flex flex-col items-center gap-3 p-5 bg-white rounded-2xl border border-slate-100 hover:shadow-lg hover:border-brand/20 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-brand/5 rounded-2xl flex items-center justify-center group-hover:bg-brand/10 transition-colors text-2xl">
                        🏢</div>
                    <div class="text-center">
                        <p class="text-sm font-medium text-slate-700 group-hover:text-brand transition-colors">
                            Apartemen</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">5,120+</p>
                    </div>
                </a>
                <a href="#"
                    class="group flex flex-col items-center gap-3 p-5 bg-white rounded-2xl border border-slate-100 hover:shadow-lg hover:border-brand/20 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-brand/5 rounded-2xl flex items-center justify-center group-hover:bg-brand/10 transition-colors text-2xl">
                        🏕️</div>
                    <div class="text-center">
                        <p class="text-sm font-medium text-slate-700 group-hover:text-brand transition-colors">Glamping
                        </p>
                        <p class="text-[11px] text-slate-400 mt-0.5">890+</p>
                    </div>
                </a>
                <a href="#"
                    class="group flex flex-col items-center gap-3 p-5 bg-white rounded-2xl border border-slate-100 hover:shadow-lg hover:border-brand/20 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-brand/5 rounded-2xl flex items-center justify-center group-hover:bg-brand/10 transition-colors text-2xl">
                        🏖️</div>
                    <div class="text-center">
                        <p class="text-sm font-medium text-slate-700 group-hover:text-brand transition-colors">Resort
                        </p>
                        <p class="text-[11px] text-slate-400 mt-0.5">2,340+</p>
                    </div>
                </a>
                <a href="#"
                    class="group flex flex-col items-center gap-3 p-5 bg-white rounded-2xl border border-slate-100 hover:shadow-lg hover:border-brand/20 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-brand/5 rounded-2xl flex items-center justify-center group-hover:bg-brand/10 transition-colors text-2xl">
                        🏔️</div>
                    <div class="text-center">
                        <p class="text-sm font-medium text-slate-700 group-hover:text-brand transition-colors">Homestay
                        </p>
                        <p class="text-[11px] text-slate-400 mt-0.5">8,760+</p>
                    </div>
                </a>
            </div>
        </div>
    </section> --}}

    <!-- Testimonials -->
    <section class="py-16 md:py-20 bg-white">
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
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">"Pertama kali pakai IndoApart, langsung ketemu
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
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">"Suka banget fitur bayar di tempatnya! Jadi
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
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">"Liburan keluarga ke Lombok jadi terencana
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

    <!-- App Download CTA -->
    {{-- <section class="py-16 md:py-20 bg-slate-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="relative rounded-3xl bg-brand overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-10 right-10 w-64 h-64 bg-accent rounded-full blur-3xl"></div>
                    <div class="absolute bottom-10 left-10 w-48 h-48 bg-accent rounded-full blur-3xl"></div>
                </div>
                <div class="relative grid md:grid-cols-2 gap-8 items-center p-8 sm:p-12 md:p-16">
                    <div>
                        <span
                            class="inline-flex items-center gap-1.5 bg-white/10 text-accent text-xs font-medium tracking-wider uppercase px-3 py-1.5 rounded-full mb-4 backdrop-blur-sm">
                            <i data-lucide="smartphone" class="w-3.5 h-3.5"></i> Aplikasi Mobile
                        </span>
                        <h2 class="text-3xl sm:text-4xl font-serif font-semibold text-white leading-tight mb-4">
                            Download Aplikasi<br>StayGo Sekarang</h2>
                        <p class="text-white/60 mb-8 max-w-md leading-relaxed">Dapatkan akses eksklusif ke harga
                            member-only, notifikasi flash sale, dan booking lebih cepat langsung dari smartphone kamu.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <button onclick="showToast('Link download App Store akan tersedia segera', 'info')"
                                class="flex items-center gap-3 bg-white text-slate-800 px-5 py-3 rounded-xl hover:bg-slate-100 transition-colors">
                                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z" />
                                </svg>
                                <div class="text-left">
                                    <div class="text-[10px] text-slate-500 leading-none">Download di</div>
                                    <div class="text-sm font-semibold leading-tight">App Store</div>
                                </div>
                            </button>
                            <button onclick="showToast('Link download Google Play akan tersedia segera', 'info')"
                                class="flex items-center gap-3 bg-white text-slate-800 px-5 py-3 rounded-xl hover:bg-slate-100 transition-colors">
                                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M3.609 1.814L13.792 12 3.61 22.186a.996.996 0 01-.61-.92V2.734a1 1 0 01.609-.92zm10.89 10.893l2.302 2.302-10.937 6.333 8.635-8.635zm3.199-3.198l2.807 1.626a1 1 0 010 1.73l-2.808 1.626L15.206 12l2.492-2.491zM5.864 2.658L16.8 8.99l-2.302 2.302-8.634-8.634z" />
                                </svg>
                                <div class="text-left">
                                    <div class="text-[10px] text-slate-500 leading-none">Get it on</div>
                                    <div class="text-sm font-semibold leading-tight">Google Play</div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="hidden md:flex justify-center">
                        <div class="relative">
                            <div
                                class="w-56 h-[420px] bg-slate-800 rounded-[2.5rem] border-4 border-slate-700 shadow-2xl overflow-hidden">
                                <div
                                    class="w-full h-full bg-gradient-to-b from-brand to-brand-dark flex flex-col items-center justify-center p-6 text-center">
                                    <div class="w-16 h-16 bg-accent rounded-2xl flex items-center justify-center mb-4">
                                        <i data-lucide="map-pin" class="w-8 h-8 text-brand"></i>
                                    </div>
                                    <span class="text-white text-lg font-semibold">StayGo</span>
                                    <p class="text-white/50 text-xs mt-2">Temukan hotel impianmu</p>
                                    <div class="mt-8 w-full space-y-3">
                                        <div class="bg-white/10 rounded-xl p-3">
                                            <div class="w-full h-2 bg-white/20 rounded mb-2"></div>
                                            <div class="w-2/3 h-2 bg-white/10 rounded"></div>
                                        </div>
                                        <div class="bg-white/10 rounded-xl p-3">
                                            <div class="w-full h-2 bg-white/20 rounded mb-2"></div>
                                            <div class="w-1/2 h-2 bg-white/10 rounded"></div>
                                        </div>
                                        <div class="bg-accent rounded-xl p-3 text-brand text-xs font-semibold text-center">
                                            Cari Hotel</div>
                                    </div>
                                    <div class="mt-6 flex gap-3">
                                        <div class="w-12 h-12 bg-white/10 rounded-xl"></div>
                                        <div class="w-12 h-12 bg-white/10 rounded-xl"></div>
                                        <div class="w-12 h-12 bg-white/10 rounded-xl"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute -top-3 -right-3 w-20 h-20 bg-accent rounded-full blur-2xl opacity-40">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Contact Us Section -->
    <section class="py-16 md:py-20 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid md:grid-cols-2 gap-8 lg:gap-12 items-center">
                <div>
                    <span class="text-xs font-medium tracking-[0.2em] uppercase text-brand/60">Hubungi Kami</span>
                    <h2 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800 mt-2 mb-4">Ada Pertanyaan?</h2>
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
                    <img src="https://picsum.photos/seed/contact-support/600/700" alt="Customer Service"
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
                            <p class="text-sm text-slate-600">Tim customer service kami siap membantu Anda kapan saja.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-slate-50">
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
    </section>
@endsection
