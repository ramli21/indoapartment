@extends('layout')

@section('content')
    <!-- Breadcrumb -->
    <section class="bg-slate-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-slate-500 hover:text-brand transition-colors">Beranda</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
                <span class="text-brand font-medium">Daftar Apartemen</span>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-14 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <!-- Title -->
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Daftar Apartemen</h1>
                <p class="text-slate-500 mt-1">Temukan apartemen impian Anda</p>
            </div>

            <div class="grid lg:grid-cols-4 gap-6">
                <!-- Filters Sidebar -->
                <div class="lg:col-span-1">
                    <form method="GET" id="filterForm">
                        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm sticky top-24">
                            <div class="flex items-center justify-between mb-5">
                                <h2 class="font-semibold text-slate-800">Filter</h2>
                                @if (request()->hasAny(['search', 'tower', 'tipe', 'harga_min', 'harga_max', 'tamu']))
                                    <a href="{{ route('apartments.list') }}" class="text-xs text-brand hover:underline">
                                        Reset
                                    </a>
                                @endif
                            </div>

                            <!-- Search -->
                            <div class="mb-5">
                                <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                    Cari
                                </label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Nama apartemen..."
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                                    <i data-lucide="search"
                                        class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                                </div>
                            </div>

                            <!-- Tower -->
                            <div class="mb-5">
                                <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                    Tower
                                </label>
                                <select name="tower"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                                    <option value="">Semua Tower</option>
                                    @foreach ($towers as $tower)
                                        <option value="{{ $tower }}"
                                            {{ request('tower') == $tower ? 'selected' : '' }}>
                                            {{ $tower }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tipe -->
                            <div class="mb-5">
                                <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                    Tipe
                                </label>
                                <select name="tipe"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                                    <option value="">Semua Tipe</option>
                                    @foreach ($tipes as $tipe)
                                        <option value="{{ $tipe }}"
                                            {{ request('tipe') == $tipe ? 'selected' : '' }}>
                                            {{ $tipe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price Range -->
                            <div class="mb-5">
                                <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                    Harga per Malam
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="relative">
                                        <input type="number" name="harga_min" value="{{ request('harga_min') }}"
                                            placeholder="Min"
                                            class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                                        <span
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400">Rp</span>
                                    </div>
                                    <div class="relative">
                                        <input type="number" name="harga_max" value="{{ request('harga_max') }}"
                                            placeholder="Max"
                                            class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                                        <span
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400">Rp</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Guests -->
                            <div class="mb-5">
                                <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                    Jumlah Tamu
                                </label>
                                <select name="tamu"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                                    <option value="">Semua Jumlah Tamu</option>
                                    <option value="1" {{ request('tamu') == '1' ? 'selected' : '' }}>1+ Tamu</option>
                                    <option value="2" {{ request('tamu') == '2' ? 'selected' : '' }}>2+ Tamu</option>
                                    <option value="3" {{ request('tamu') == '3' ? 'selected' : '' }}>3+ Tamu</option>
                                    <option value="4" {{ request('tamu') == '4' ? 'selected' : '' }}>4+ Tamu</option>
                                    <option value="5" {{ request('tamu') == '5' ? 'selected' : '' }}>5+ Tamu</option>
                                </select>
                            </div>

                            <!-- Sort -->
                            <div class="mb-5">
                                <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">
                                    Urutkan
                                </label>
                                <select name="sort"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                                    <option value="terbaru"
                                        {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>
                                        Terbaru
                                    </option>
                                    <option value="harga_rendah" {{ request('sort') == 'harga_rendah' ? 'selected' : '' }}>
                                        Harga: Rendah ke Tinggi
                                    </option>
                                    <option value="harga_tinggi" {{ request('sort') == 'harga_tinggi' ? 'selected' : '' }}>
                                        Harga: Tinggi ke Rendah
                                    </option>
                                    <option value="luas_besar" {{ request('sort') == 'luas_besar' ? 'selected' : '' }}>
                                        Luas: Terbesar
                                    </option>
                                </select>
                            </div>

                            <!-- Apply Button -->
                            <button type="submit"
                                class="w-full bg-brand text-white py-3 rounded-xl font-medium hover:bg-brand-light transition-colors">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Results -->
                <div class="lg:col-span-3">
                    <!-- Results Count -->
                    <div class="flex items-center justify-between mb-5">
                        <p class="text-sm text-slate-500">
                            Ditemukan <span class="font-semibold text-slate-700">{{ $apartments->total() }}</span>
                            apartemen
                        </p>
                    </div>

                    @if ($apartments->count() > 0)
                        <!-- Apartment Grid -->
                        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5">
                            @foreach ($apartments as $apartment)
                                @php
                                    $img =
                                        is_array($apartment->gambar) && count($apartment->gambar) > 0
                                            ? asset('storage/' . $apartment->gambar[0])
                                            : 'https://picsum.photos/seed/apartment' . $loop->index . '/600/450';
                                @endphp
                                <a href="{{ route('booking.create', $apartment) }}"
                                    class="group block bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                                    <div class="relative overflow-hidden aspect-[4/3]">
                                        <img src="{{ $img }}" loading="lazy"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                            alt="{{ $apartment->judul }}">
                                        <div class="absolute top-3 left-3">
                                            <span
                                                class="px-2.5 py-1 bg-emerald-500 text-white text-[10px] font-semibold rounded-lg uppercase">
                                                {{ $apartment->status }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs text-slate-400">{{ $apartment->nama_tower }}</span>
                                            <span class="text-xs text-slate-500">Rp
                                                {{ number_format((float) $apartment->harga_per_malam, 0, ',', '.') }}</span>
                                        </div>
                                        <h3 class="font-semibold text-slate-800 line-clamp-1 group-hover:text-brand">
                                            {{ $apartment->judul }}</h3>
                                        <p class="text-sm text-slate-500 mt-1 line-clamp-1">
                                            {{ $apartment->alamat }}
                                        </p>
                                        <div class="flex items-center gap-3 mt-3 pt-3 border-t border-slate-50">
                                            <div class="flex items-center gap-1 text-xs text-slate-500">
                                                <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                                {{ $apartment->tamu_dewasa + $apartment->tamu_anak }}
                                            </div>
                                            <div class="flex items-center gap-1 text-xs text-slate-500">
                                                <i data-lucide="door-open" class="w-3.5 h-3.5"></i>
                                                {{ $apartment->jumlah_kamar }} KT
                                            </div>
                                            <div class="flex items-center gap-1 text-xs text-slate-500">
                                                <i data-lucide="bath" class="w-3.5 h-3.5"></i>
                                                {{ $apartment->jumlah_kamar_mandi }} KM
                                            </div>
                                            <div class="flex items-center gap-1 text-xs text-slate-500">
                                                <i data-lucide="maximize" class="w-3.5 h-3.5"></i>
                                                {{ $apartment->luas }} m²
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if ($apartments->hasPages())
                            <div class="mt-8">
                                {{ $apartments->links('pagination::tailwind') }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16 bg-white rounded-2xl border border-slate-100">
                            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="search" class="w-8 h-8 text-slate-300"></i>
                            </div>
                            <h3 class="text-lg font-medium text-slate-700 mb-1">Tidak ada apartemen</h3>
                            <p class="text-sm text-slate-500 mb-6">Coba sesuaikan filter Anda</p>
                            <a href="{{ route('apartments.list') }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors">
                                <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                                Reset Filter
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-white">
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
