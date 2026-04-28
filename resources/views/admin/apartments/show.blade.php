@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('apartments.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-brand transition-colors mb-4">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Daftar
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                <!-- Hero Image Gallery -->
                <div class="relative h-64 sm:h-80 bg-slate-100">
                    @if ($apartment->gambar && is_array($apartment->gambar) && count($apartment->gambar) > 0)
                        <img src="{{ asset('storage/' . $apartment->gambar[0]) }}" alt="{{ $apartment->judul }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <i data-lucide="image-off" class="w-16 h-16"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span
                            class="px-3 py-1.5 bg-white/90 backdrop-blur-sm text-sm font-medium text-brand rounded-lg shadow-sm">
                            {{ $apartment->tipe }}
                        </span>
                    </div>
                    @php
                        $statusColors = [
                            'Tersedia' => 'bg-emerald-500/90 text-white',
                            'Terisi' => 'bg-amber-500/90 text-white',
                            'Perawatan' => 'bg-red-500/90 text-white',
                        ];
                    @endphp
                    <div class="absolute top-4 right-4">
                        <span
                            class="px-3 py-1.5 backdrop-blur-sm text-sm font-medium rounded-lg shadow-sm {{ $statusColors[$apartment->status] ?? 'bg-slate-500/90 text-white' }}">
                            {{ $apartment->status }}
                        </span>
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if ($apartment->gambar && is_array($apartment->gambar) && count($apartment->gambar) > 1)
                        <div class="flex gap-2 p-4 overflow-x-auto hide-scrollbar">
                            @foreach ($apartment->gambar as $index => $img)
                                <div
                                    class="w-20 h-20 rounded-xl overflow-hidden border border-slate-200 shrink-0 {{ $index === 0 ? 'ring-2 ring-brand' : '' }}">
                                    <img src="{{ asset('storage/' . $img) }}" alt="Gambar {{ $index + 1 }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="p-6 sm:p-8">
                        <!-- Title & Actions -->
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                            <div class="flex-1">
                                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand mb-2">
                                    {{ $apartment->judul }}</h1>
                                <div class="flex items-center gap-1.5 text-slate-500">
                                    <i data-lucide="map-pin" class="w-4 h-4 shrink-0"></i>
                                    <span class="text-sm">{{ $apartment->alamat }}</span>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <a href="{{ route('apartments.edit', $apartment) }}"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-xl transition-colors">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('apartments.destroy', $apartment) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus apartemen ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>

                                @if ($apartment->harga_per_malam)
                                    <div class="flex items-baseline gap-2 mb-6 p-4 bg-brand/5 rounded-xl">
                                        <span class="text-2xl font-bold text-brand">Rp
                                            {{ number_format($apartment->harga_per_malam, 0, ',', '.') }}</span>
                                        <span class="text-sm text-slate-500">/ malam</span>
                                    </div>
                                @endif

                                @if ($apartment->deskripsi)
                                    <div class="mb-6">
                                        <p class="text-sm text-slate-600 leading-relaxed">{{ $apartment->deskripsi }}</p>
                                    </div>
                                @endif

                                <!-- Info Grid -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                                    <div class="p-4 bg-slate-50 rounded-xl text-center">
                                        <i data-lucide="maximize" class="w-5 h-5 text-brand mx-auto mb-2"></i>
                                        <div class="text-xs text-slate-500 mb-0.5">Luas</div>
                                        <div class="text-sm font-semibold text-slate-800">{{ $apartment->luas }} m²</div>
                                        <div class="p-4 bg-slate-50 rounded-xl text-center">
                                            <i data-lucide="building" class="w-5 h-5 text-brand mx-auto mb-2"></i>
                                            <div class="text-xs text-slate-500 mb-0.5">Tower</div>
                                            <div class="text-sm font-semibold text-slate-800">{{ $apartment->nama_tower }}
                                            </div>
                                            <div class="p-4 bg-slate-50 rounded-xl text-center">
                                                <i data-lucide="layers" class="w-5 h-5 text-brand mx-auto mb-2"></i>
                                                <div class="text-xs text-slate-500 mb-0.5">Lantai</div>
                                                <div class="text-sm font-semibold text-slate-800">{{ $apartment->lantai }}
                                                </div>
                                                <div class="p-4 bg-slate-50 rounded-xl text-center">
                                                    <i data-lucide="door-open" class="w-5 h-5 text-brand mx-auto mb-2"></i>
                                                    <div class="text-xs text-slate-500 mb-0.5">Nomor Kamar</div>
                                                    <div class="text-sm font-semibold text-slate-800">
                                                        {{ $apartment->nomor_kamar }}</div>
                                                    <div class="p-4 bg-slate-50 rounded-xl text-center">
                                                        <i data-lucide="bed-double"
                                                            class="w-5 h-5 text-brand mx-auto mb-2"></i>
                                                        <div class="text-xs text-slate-500 mb-0.5">Kamar Tidur</div>
                                                        <div class="text-sm font-semibold text-slate-800">
                                                            {{ $apartment->jumlah_kamar }}</div>
                                                        <div class="p-4 bg-slate-50 rounded-xl text-center">
                                                            <i data-lucide="bath"
                                                                class="w-5 h-5 text-brand mx-auto mb-2"></i>
                                                            <div class="text-xs text-slate-500 mb-0.5">Kamar Mandi</div>
                                                            <div class="text-sm font-semibold text-slate-800">
                                                                {{ $apartment->jumlah_kamar_mandi }}</div>
                                                            <div class="p-4 bg-slate-50 rounded-xl text-center">
                                                                <i data-lucide="users"
                                                                    class="w-5 h-5 text-brand mx-auto mb-2"></i>
                                                                <div class="text-xs text-slate-500 mb-0.5">Kapasitas</div>
                                                                <div class="text-sm font-semibold text-slate-800">
                                                                    {{ $apartment->tamu_dewasa + $apartment->tamu_anak }}
                                                                    Tamu</div>
                                                                <div class="p-4 bg-slate-50 rounded-xl text-center">
                                                                    <i data-lucide="clock"
                                                                        class="w-5 h-5 text-brand mx-auto mb-2"></i>
                                                                    <div class="text-xs text-slate-500 mb-0.5">Check-in/out
                                                                    </div>
                                                                    <div class="text-sm font-semibold text-slate-800">
                                                                        {{ $apartment->check_in }} /
                                                                        {{ $apartment->check_out }}</div>
                                                                </div>

                                                                <!-- Fasilitas -->
                                                                @if ($apartment->fasilitas && count($apartment->fasilitas) > 0)
                                                                    <div class="mb-8">
                                                                        <h3 class="text-sm font-medium text-slate-700 mb-3">
                                                                            Fasilitas</h3>
                                                                        <div class="flex flex-wrap gap-2">
                                                                            @foreach ($apartment->fasilitas as $fasilitas)
                                                                                <span
                                                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-accent/20 text-brand text-sm font-medium rounded-full">
                                                                                    <i data-lucide="check"
                                                                                        class="w-3.5 h-3.5"></i>
                                                                                    {{ $fasilitas }}
                                                                                </span>
                                                                            @endforeach
                                                                        </div>
                                                                @endif

                                                                <!-- Tata Tertib -->
                                                                @if ($apartment->tata_tertib)
                                                                    <div
                                                                        class="mb-8 p-5 bg-slate-50 rounded-xl border border-slate-100">
                                                                        <h3
                                                                            class="text-sm font-medium text-slate-700 mb-3 flex items-center gap-2">
                                                                            <i data-lucide="scroll-text"
                                                                                class="w-4 h-4 text-brand"></i>
                                                                            Tata Tertib
                                                                        </h3>
                                                                        <div
                                                                            class="text-sm text-slate-600 whitespace-pre-line">
                                                                            {{ $apartment->tata_tertib }}</div>
                                                                @endif

                                                                <!-- Owner Info -->
                                                                <div
                                                                    class="mb-8 p-5 bg-brand/5 rounded-xl border border-brand/10">
                                                                    <h3
                                                                        class="text-sm font-semibold text-brand mb-4 flex items-center gap-2">
                                                                        <i data-lucide="user-circle" class="w-4 h-4"></i>
                                                                        Informasi Owner
                                                                    </h3>
                                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                                                        <div class="flex items-center gap-3">
                                                                            <div
                                                                                class="w-9 h-9 rounded-lg bg-white flex items-center justify-center shrink-0">
                                                                                <i data-lucide="user"
                                                                                    class="w-4 h-4 text-brand"></i>
                                                                            </div>
                                                                            <div>
                                                                                <div class="text-xs text-slate-500">Nama
                                                                                    Lengkap</div>
                                                                                <div
                                                                                    class="text-sm font-medium text-slate-800">
                                                                                    {{ $apartment->owner_nama ?? '-' }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="flex items-center gap-3">
                                                                                <div
                                                                                    class="w-9 h-9 rounded-lg bg-white flex items-center justify-center shrink-0">
                                                                                    <i data-lucide="phone"
                                                                                        class="w-4 h-4 text-brand"></i>
                                                                                </div>
                                                                                <div>
                                                                                    <div class="text-xs text-slate-500">
                                                                                        WhatsApp</div>
                                                                                    <div
                                                                                        class="text-sm font-medium text-slate-800">
                                                                                        {{ $apartment->owner_wa ?? '-' }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex items-center gap-3">
                                                                                    <div
                                                                                        class="w-9 h-9 rounded-lg bg-white flex items-center justify-center shrink-0">
                                                                                        <i data-lucide="credit-card"
                                                                                            class="w-4 h-4 text-brand"></i>
                                                                                    </div>
                                                                                    <div>
                                                                                        <div
                                                                                            class="text-xs text-slate-500">
                                                                                            No. Rekening</div>
                                                                                        <div
                                                                                            class="text-sm font-medium text-slate-800">
                                                                                            {{ $apartment->owner_rekening ?? '-' }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Google Maps -->
                                                                                @if ($apartment->alamat_google)
                                                                                    <div>
                                                                                        <h3
                                                                                            class="text-sm font-medium text-slate-700 mb-3">
                                                                                            Lokasi di Google Maps</h3>
                                                                                        <a href="{{ $apartment->alamat_google }}"
                                                                                            target="_blank"
                                                                                            rel="noopener noreferrer"
                                                                                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors">
                                                                                            <i data-lucide="external-link"
                                                                                                class="w-4 h-4"></i>
                                                                                            Buka di Google Maps
                                                                                        </a>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
    </section>
@endsection
