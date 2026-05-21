@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="mb-8">
                <a href="{{ route('admin.apartments.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-brand transition-colors mb-4">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Daftar
                </a>

                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand">{{ $apartment->nama }}</h1>
                <p class="text-slate-500 mt-1">{{ $apartment->alamat }}</p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-sm space-y-6">
                @if ($apartment->gambar)
                    <div>
                        <div class="text-xs text-slate-500 mb-2">Gambar</div>
                        <img src="{{ asset('storage/' . $apartment->gambar) }}" alt="{{ $apartment->nama }}"
                            class="w-full max-h-[420px] object-cover rounded-2xl border border-slate-200" />
                    </div>
                @endif

                <div>
                    <div class="text-xs text-slate-500 mb-2">Google Maps</div>
                    <div class="rounded-2xl border border-slate-200 overflow-hidden bg-slate-50">
                        {!! $apartment->google_maps_embed !!}
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.apartments.edit', $apartment) }}"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors shadow-lg shadow-brand/20">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
