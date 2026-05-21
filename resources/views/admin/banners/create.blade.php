@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.banners.index') }}"
                        class="w-10 h-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition-colors">
                        <i data-lucide="arrow-left" class="w-5 h-5 text-slate-600"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Tambah Banner</h1>
                        <p class="text-slate-500 mt-1">Unggah banner baru untuk homepage</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm">
                <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Gambar Banner <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-slate-300 rounded-xl hover:border-brand transition-colors cursor-pointer"
                            id="dropZone">
                            <div class="space-y-1 text-center">
                                <div id="previewContainer" class="hidden mb-4">
                                    <img id="imagePreview" class="mx-auto h-48 object-contain rounded-lg">
                                </div>
                                <div id="uploadIcon">
                                    <i data-lucide="upload" class="mx-auto h-10 w-10 text-slate-300"></i>
                                </div>
                                <div class="flex text-sm text-slate-600 justify-center">
                                    <label for="file-upload"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-brand hover:text-brand-light focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand">
                                        <span>Unggah file</span>
                                        <input id="file-upload" name="image" type="file" class="sr-only"
                                            accept="image/*" required>
                                    </label>
                                    <p class="pl-1">atau drag & drop</p>
                                </div>
                                <p class="text-xs text-slate-500">PNG, JPG, GIF atau WEBP max 2MB</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Judul Banner</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            placeholder="Contoh: Diskon 70% OFF"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Subjudul</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle') }}"
                            placeholder="Contoh: Berlaku hingga 31 Des 2025"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                        @error('subtitle')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Banner <span
                                class="text-red-500">*</span></label>
                        <select name="type" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                            <option value="hero">Hero Banner (Bagian atas homepage)</option>
                            <option value="promo">Promo Banner (Bagian Promo)</option>
                            <option value="promo_small">Promo Small (Kotak kecil)</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Urutan Tampilan</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                        <p class="mt-1 text-xs text-slate-500">Angka kecil akan ditampilkan lebih dulu</p>
                        @error('order')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Link Tujuan</label>
                        <input type="url" name="link" value="{{ old('link') }}" placeholder="https://..."
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all text-sm">
                        <p class="mt-1 text-xs text-slate-500">Kosongkan jika tidak ada link</p>
                        @error('link')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Toggle -->
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-brand/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand">
                            </div>
                            <span class="ml-3 text-sm font-medium text-slate-700">Aktifkan banner</span>
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-slate-100">
                        <button type="submit"
                            class="flex-1 bg-brand text-white px-6 py-2.5 rounded-lg font-medium hover:bg-brand-light transition-colors text-sm">
                            Simpan Banner
                        </button>
                        <a href="{{ route('admin.banners.index') }}"
                            class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-colors text-sm">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // Image preview
            document.getElementById('file-upload').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('imagePreview').src = e.target.result;
                        document.getElementById('previewContainer').classList.remove('hidden');
                        document.getElementById('uploadIcon').classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection
