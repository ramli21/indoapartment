@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="mb-6">
                <a href="{{ route('admin.apartments.index') }}" class="text-sm text-slate-600 hover:underline">&larr; Kembali
                    ke daftar apartemen</a>
                <h1 class="text-3xl font-serif font-semibold text-slate-800 mt-2">{{ $apartment->judul }}</h1>
                <p class="text-slate-500 mt-1">{{ $apartment->nama_tower }} — Lantai {{ $apartment->lantai }} — No.
                    {{ $apartment->nomor_kamar }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Image slider -->
                <div class="lg:col-span-2 bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="prose mb-4">
                        <div class="swiper-container main-swiper">
                            <div class="swiper-wrapper">
                                @php $images = is_array($apartment->gambar) ? $apartment->gambar : (json_decode($apartment->gambar, true) ?: []); @endphp
                                @if (!empty($images))
                                    @foreach ($images as $img)
                                        <div class="swiper-slide flex items-center justify-center bg-slate-100">
                                            <img src="{{ asset('storage/' . $img) }}" alt="{{ $apartment->judul }}"
                                                class="max-h-[560px] object-contain" />
                                        </div>
                                    @endforeach
                                @else
                                    <div class="swiper-slide flex items-center justify-center bg-slate-100">
                                        <img src="{{ asset('images/placeholder.png') }}" alt="no image"
                                            class="max-h-[560px] object-contain" />
                                    </div>
                                @endif
                            </div>

                            <!-- Navigation -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="mb-4">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="text-slate-500 text-sm">Harga per malam</div>
                                <div class="text-2xl font-semibold text-slate-800">Rp
                                    {{ number_format($apartment->harga_per_malam, 0, ',', '.') }}</div>
                            </div>

                        </div>
                    </div>
                    <div class="text-sm text-slate-600 mb-4">
                        <div>Status: <span class="font-medium">{{ $apartment->status }}</span></div>
                        <div>Capacity: <span class="font-medium">{{ $apartment->tamu_dewasa }} dewasa,
                                {{ $apartment->tamu_anak }} anak</span></div>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm text-slate-600 mb-2">Deskripsi</h3>
                        <div class="text-slate-800 text-sm">{!! nl2br(e($apartment->deskripsi)) !!}</div>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm text-slate-600 mb-2">Fasilitas</h3>
                        <div class="flex flex-wrap gap-2">
                            @if (is_array($apartment->fasilitas) && count($apartment->fasilitas))
                                @foreach ($apartment->fasilitas as $f)
                                    <span
                                        class="px-2 py-1 bg-slate-100 text-slate-700 rounded text-sm">{{ $f }}</span>
                                @endforeach
                            @else
                                <span class="text-sm text-slate-500">Tidak ada fasilitas terdaftar.</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm text-slate-600 mb-2">Alamat</h3>
                        <div class="text-sm text-slate-700">{{ $apartment->alamat }}</div>
                        @if ($apartment->alamat_google)
                            <a target="_blank" href="{{ $apartment->alamat_google }}"
                                class="text-sm text-brand hover:underline">Lihat di Google Maps</a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.apartments.edit', $apartment->id) }}"
                            class="inline-block px-4 py-2 bg-brand text-white rounded-lg">Edit Apartemen</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.main-swiper', {
                loop: false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                spaceBetween: 10,
            });
        });
    </script>
@endpush
