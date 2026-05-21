@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="mb-8">
                <a href="{{ route('admin.apartments.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-brand transition-colors mb-4">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Daftar
                </a>
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand">Tambah Apartemen</h1>
                <p class="text-slate-500 mt-1">Isi formulir di bawah untuk menambahkan apartemen baru</p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-4 sm:p-8 shadow-sm">
                <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div>
                        <label for="nama" class="block text-sm font-medium text-slate-700 mb-2">Nama Apartemen <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400" />
                        @error('nama')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gambar" class="block text-sm font-medium text-slate-700 mb-2">Gambar (1 file) <span
                                class="text-xs text-slate-500">(opsional)</span></label>
                        <input type="file" name="gambar" id="gambar" accept="image/*"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-brand file:text-white hover:file:bg-brand-light file:transition-colors cursor-pointer bg-slate-50 border border-slate-200 rounded-xl" />
                        @error('gambar')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-slate-700 mb-2">Alamat <span
                                class="text-red-500">*</span></label>
                        <textarea name="alamat" id="alamat" rows="3" required
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400 resize-none">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="google_maps_embed" class="block text-sm font-medium text-slate-700 mb-2">Google Maps
                            Embed (iframe code) <span class="text-red-500">*</span></label>
                        <textarea name="google_maps_embed" id="google_maps_embed" rows="6" required
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400 resize-none"
                            placeholder="<iframe ...>...</iframe>">{{ old('google_maps_embed') }}</textarea>
                        @error('google_maps_embed')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <button type="submit"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors shadow-lg shadow-brand/20">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Simpan Apartemen
                        </button>
                        <a href="{{ route('admin.apartments.index') }}"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-2.5 bg-white text-slate-600 text-sm font-medium rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
