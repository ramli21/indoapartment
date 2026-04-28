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
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand">Tambah Apartemen</h1>
                <p class="text-slate-500 mt-1">Isi formulir di bawah untuk menambahkan apartemen baru</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-sm">
                <form action="{{ route('apartments.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-8">
                    @csrf

                    <!-- Informasi Dasar -->
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                            <span
                                class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand text-sm font-bold">1</span>
                            Informasi Dasar
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Judul -->
                            <div class="sm:col-span-2">
                                <label for="judul" class="block text-sm font-medium text-slate-700 mb-2">Judul / Nama
                                    Apartemen <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                    placeholder="Contoh: Apartemen Green View">
                                @error('judul')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipe -->
                            <div>
                                <label for="tipe" class="block text-sm font-medium text-slate-700 mb-2">Tipe <span
                                        class="text-red-500">*</span></label>
                                <select name="tipe" id="tipe" required
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                                    <option value="" disabled {{ old('tipe') ? '' : 'selected' }}>Pilih tipe</option>
                                    <option value="Studio" {{ old('tipe') == 'Studio' ? 'selected' : '' }}>Studio</option>
                                    <option value="1 BR" {{ old('tipe') == '1 BR' ? 'selected' : '' }}>1 BR</option>
                                    <option value="2 BR" {{ old('tipe') == '2 BR' ? 'selected' : '' }}>2 BR</option>
                                    <option value="3 BR" {{ old('tipe') == '3 BR' ? 'selected' : '' }}>3 BR</option>
                                    <option value="Duplex" {{ old('tipe') == 'Duplex' ? 'selected' : '' }}>Duplex</option>
                                    <option value="Penthouse" {{ old('tipe') == 'Penthouse' ? 'selected' : '' }}>Penthouse
                                    </option>
                                </select>
                                @error('tipe')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga per Malam -->
                            <div>
                                <label for="harga_per_malam" class="block text-sm font-medium text-slate-700 mb-2">Harga per
                                    Malam <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400">Rp</span>
                                    <input type="number" name="harga_per_malam" id="harga_per_malam"
                                        value="{{ old('harga_per_malam') }}" required min="0"
                                        class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                        placeholder="500000">
                                </div>
                                @error('harga_per_malam')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status <span
                                        class="text-red-500">*</span></label>
                                <select name="status" id="status" required
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                                    <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia
                                    </option>
                                    <option value="Terisi" {{ old('status') == 'Terisi' ? 'selected' : '' }}>Terisi
                                    </option>
                                    <option value="Perawatan" {{ old('status') == 'Perawatan' ? 'selected' : '' }}>
                                        Perawatan</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gambar Multiple -->
                            <div class="sm:col-span-2">
                                <label for="gambar" class="block text-sm font-medium text-slate-700 mb-2">Gambar Apartemen
                                    <span class="text-xs text-slate-400 font-normal">(Maksimal 5 gambar)</span></label>
                                <div class="relative">
                                    <input type="file" name="gambar[]" id="gambar" accept="image/*" multiple
                                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-brand file:text-white hover:file:bg-brand-light file:transition-colors cursor-pointer bg-slate-50 border border-slate-200 rounded-xl">
                                </div>
                                <p class="mt-1 text-xs text-slate-400">Format: JPG, PNG, WEBP. Maksimal 2MB per gambar. Bisa
                                    pilih lebih dari 1 gambar.</p>
                                @error('gambar')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                @error('gambar.*')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <div id="image-preview" class="flex flex-wrap gap-2 mt-3"></div>

                                <!-- Deskripsi -->
                                <div class="sm:col-span-2">
                                    <label for="deskripsi"
                                        class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" rows="3"
                                        class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400 resize-none"
                                        placeholder="Deskripsi singkat tentang apartemen">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="border-t border-slate-100"></div>

                            <!-- Detail Unit -->
                            <div>
                                <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                                    <span
                                        class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand text-sm font-bold">2</span>
                                    Detail Unit
                                </h2>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <!-- Luas -->
                                    <div>
                                        <label for="luas" class="block text-sm font-medium text-slate-700 mb-2">Luas
                                            (m²) <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="number" name="luas" id="luas"
                                                value="{{ old('luas') }}" required step="0.01" min="0"
                                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                                placeholder="36">
                                            <span
                                                class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400">m²</span>
                                        </div>
                                        @error('luas')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Nama Tower -->
                                    <div>
                                        <label for="nama_tower" class="block text-sm font-medium text-slate-700 mb-2">Nama
                                            Tower <span class="text-red-500">*</span></label>
                                        <input type="text" name="nama_tower" id="nama_tower"
                                            value="{{ old('nama_tower') }}" required
                                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                            placeholder="Contoh: Tower A">
                                        @error('nama_tower')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Lantai -->
                                    <div>
                                        <label for="lantai" class="block text-sm font-medium text-slate-700 mb-2">Lantai
                                            <span class="text-red-500">*</span></label>
                                        <input type="number" name="lantai" id="lantai" value="{{ old('lantai') }}"
                                            required min="1"
                                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                            placeholder="5">
                                        @error('lantai')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Nomor Kamar -->
                                    <div>
                                        <label for="nomor_kamar"
                                            class="block text-sm font-medium text-slate-700 mb-2">Nomor Kamar <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="nomor_kamar" id="nomor_kamar"
                                            value="{{ old('nomor_kamar') }}" required
                                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                            placeholder="Contoh: 502">
                                        @error('nomor_kamar')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Jumlah Kamar -->
                                    <div>
                                        <label for="jumlah_kamar"
                                            class="block text-sm font-medium text-slate-700 mb-2">Jumlah Kamar <span
                                                class="text-red-500">*</span></label>
                                        <input type="number" name="jumlah_kamar" id="jumlah_kamar"
                                            value="{{ old('jumlah_kamar', 1) }}" required min="1"
                                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                            placeholder="1">
                                        @error('jumlah_kamar')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Jumlah Kamar Mandi -->
                                    <div>
                                        <label for="jumlah_kamar_mandi"
                                            class="block text-sm font-medium text-slate-700 mb-2">Jumlah Kamar Mandi <span
                                                class="text-red-500">*</span></label>
                                        <input type="number" name="jumlah_kamar_mandi" id="jumlah_kamar_mandi"
                                            value="{{ old('jumlah_kamar_mandi', 1) }}" required min="1"
                                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                            placeholder="1">
                                        @error('jumlah_kamar_mandi')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="border-t border-slate-100"></div>

                                <!-- Alamat -->
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                                        <span
                                            class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand text-sm font-bold">3</span>
                                        Lokasi
                                    </h2>
                                    <div class="space-y-6">
                                        <div>
                                            <label for="alamat"
                                                class="block text-sm font-medium text-slate-700 mb-2">Alamat <span
                                                    class="text-red-500">*</span></label>
                                            <textarea name="alamat" id="alamat" rows="3" required
                                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400 resize-none"
                                                placeholder="Alamat lengkap apartemen">{{ old('alamat') }}</textarea>
                                            @error('alamat')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="alamat_google"
                                                class="block text-sm font-medium text-slate-700 mb-2">Link Google
                                                Maps</label>
                                            <div class="relative">
                                                <i data-lucide="map"
                                                    class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                                <input type="url" name="alamat_google" id="alamat_google"
                                                    value="{{ old('alamat_google') }}"
                                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                                    placeholder="https://maps.google.com/...">
                                            </div>
                                            @error('alamat_google')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="border-t border-slate-100"></div>

                                    <!-- Fasilitas -->
                                    <div>
                                        <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                                            <span
                                                class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand text-sm font-bold">4</span>
                                            Fasilitas
                                        </h2>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                                            @php
                                                $fasilitasList = [
                                                    'WiFi',
                                                    'AC',
                                                    'TV',
                                                    'Kulkas',
                                                    'Microwave',
                                                    'Water Heater',
                                                    'Kitchen',
                                                    'Balkon',
                                                    'Laundry',
                                                    'Gym',
                                                    'Kolam Renang',
                                                    'Parkir',
                                                    'Keamanan 24 Jam',
                                                    'CCTV',
                                                    'Elevator',
                                                    'Rooftop',
                                                    'Lounge',
                                                    'BBQ Area',
                                                ];
                                                $oldFasilitas = old('fasilitas', []);
                                            @endphp
                                            @foreach ($fasilitasList as $item)
                                                <label
                                                    class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer hover:border-brand/30 hover:bg-brand/5 transition-all">
                                                    <input type="checkbox" name="fasilitas[]"
                                                        value="{{ $item }}"
                                                        {{ in_array($item, $oldFasilitas) ? 'checked' : '' }}
                                                        class="w-4 h-4 rounded border-slate-300 text-brand focus:ring-brand">
                                                    <span class="text-sm text-slate-700">{{ $item }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('fasilitas.*')
                                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="border-t border-slate-100"></div>

                                    <!-- Informasi Tamu -->
                                    <div>
                                        <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                                            <span
                                                class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand text-sm font-bold">5</span>
                                            Informasi Tamu & Check-in
                                        </h2>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                            <div>
                                                <label for="tamu_dewasa"
                                                    class="block text-sm font-medium text-slate-700 mb-2">Tamu Dewasa <span
                                                        class="text-red-500">*</span></label>
                                                <input type="number" name="tamu_dewasa" id="tamu_dewasa"
                                                    value="{{ old('tamu_dewasa', 0) }}" required min="0"
                                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                                    placeholder="0">
                                                @error('tamu_dewasa')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="tamu_anak"
                                                    class="block text-sm font-medium text-slate-700 mb-2">Tamu Anak <span
                                                        class="text-red-500">*</span></label>
                                                <input type="number" name="tamu_anak" id="tamu_anak"
                                                    value="{{ old('tamu_anak', 0) }}" required min="0"
                                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                                    placeholder="0">
                                                @error('tamu_anak')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="check_in"
                                                    class="block text-sm font-medium text-slate-700 mb-2">Check-in <span
                                                        class="text-red-500">*</span></label>
                                                <input type="time" name="check_in" id="check_in"
                                                    value="{{ old('check_in', '14:00') }}" required
                                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                                                @error('check_in')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="check_out"
                                                    class="block text-sm font-medium text-slate-700 mb-2">Check-out <span
                                                        class="text-red-500">*</span></label>
                                                <input type="time" name="check_out" id="check_out"
                                                    value="{{ old('check_out', '12:00') }}" required
                                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all">
                                                @error('check_out')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mt-6">
                                                <label for="tata_tertib"
                                                    class="block text-sm font-medium text-slate-700 mb-2">Tata Tertib
                                                    Apartemen</label>
                                                <textarea name="tata_tertib" id="tata_tertib" rows="4"
                                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400 resize-none"
                                                    placeholder="Contoh:&#10;- Dilarang merokok di dalam unit&#10;- Check-in pukul 14:00, Check-out pukul 12:00&#10;- Tidak boleh membawa hewan peliharaan">{{ old('tata_tertib') }}</textarea>
                                                @error('tata_tertib')
                                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="border-t border-slate-100"></div>

                                            <!-- Informasi Owner -->
                                            <div>
                                                <h2
                                                    class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                                                    <span
                                                        class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand text-sm font-bold">6</span>
                                                    Informasi Owner
                                                </h2>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                                    <div>
                                                        <label for="owner_nama"
                                                            class="block text-sm font-medium text-slate-700 mb-2">Nama
                                                            Lengkap <span class="text-red-500">*</span></label>
                                                        <input type="text" name="owner_nama" id="owner_nama"
                                                            value="{{ old('owner_nama') }}" required
                                                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                                            placeholder="Nama lengkap owner">
                                                        @error('owner_nama')
                                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label for="owner_wa"
                                                            class="block text-sm font-medium text-slate-700 mb-2">No.
                                                            WhatsApp <span class="text-red-500">*</span></label>
                                                        <div class="relative">
                                                            <i data-lucide="phone"
                                                                class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                                            <input type="text" name="owner_wa" id="owner_wa"
                                                                value="{{ old('owner_wa') }}" required
                                                                class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                                                placeholder="0812xxxxxxx">
                                                        </div>
                                                        @error('owner_wa')
                                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div class="sm:col-span-2">
                                                        <label for="owner_rekening"
                                                            class="block text-sm font-medium text-slate-700 mb-2">No.
                                                            Rekening <span class="text-red-500">*</span></label>
                                                        <div class="relative">
                                                            <i data-lucide="credit-card"
                                                                class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                                            <input type="text" name="owner_rekening"
                                                                id="owner_rekening" value="{{ old('owner_rekening') }}"
                                                                required
                                                                class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 transition-all placeholder:text-slate-400"
                                                                placeholder="1234567890 (Bank BCA a.n. Nama)">
                                                        </div>
                                                        @error('owner_rekening')
                                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Buttons -->
                                                <div class="flex items-center gap-3 pt-6 border-t border-slate-100">
                                                    <button type="submit"
                                                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors shadow-lg shadow-brand/20">
                                                        <i data-lucide="save" class="w-4 h-4"></i>
                                                        Simpan Apartemen
                                                    </button>
                                                    <a href="{{ route('apartments.index') }}"
                                                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-8 py-2.5 bg-white text-slate-600 text-sm font-medium rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                                                        Batal
                                                    </a>
                                                </div>
                </form>
            </div>
    </section>

    <script>
        document.getElementById('gambar').addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';
            const files = e.target.files;
            if (files.length > 5) {
                alert('Maksimal 5 gambar!');
                this.value = '';
                return;
            }
            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative w-20 h-20 rounded-lg overflow-hidden border border-slate-200';
                    div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    preview.appendChild(div);
                }
                reader.readAsDataURL(files[i]);
            }
        });
    </script>
@endsection
