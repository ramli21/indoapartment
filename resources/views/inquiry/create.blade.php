@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Hubungi Kami</h1>
                <p class="text-slate-500 mt-1">Kirim pertanyaan atau permintaan informasi</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm">
                <form method="POST" action="{{ route('inquiry.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Apartemen (Opsional)</label>
                        <select name="apartment_id"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm">
                            <option value="">Pilih apartemen...</option>
                            @foreach ($apartments as $apt)
                                <option value="{{ $apt->id }}"
                                    {{ old('apartment_id', $apartment?->id) == $apt->id ? 'selected' : '' }}>
                                    {{ $apt->judul }} ({{ $apt->nama_tower }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="Nama Anda">
                            @error('nama')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">No. WhatsApp <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="no_hp" value="{{ old('no_hp') }}" required
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="0812 3456 7890">
                            @error('no_hp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                            placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Subjek <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="subjek" value="{{ old('subjek') }}" required
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                            placeholder="Pertanyaan tentang apartemen, harga, dll">
                        @error('subjek')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Pesan <span
                                class="text-red-500">*</span></label>
                        <textarea name="pesan" rows="5" required
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm resize-none"
                            placeholder="Tulis pertanyaan atau permintaan Anda...">{{ old('pesan') }}</textarea>
                        @error('pesan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-brand text-white px-4 py-3 rounded-lg font-medium hover:bg-brand-light transition-colors">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="mt-6 text-center text-sm text-slate-500">
                <p>Atau hubungi langsung via WhatsApp: <a href="https://wa.me/{{ $adminInfo->whatsapp }}"
                        class="text-brand font-medium">{{ '+' . $adminInfo->whatsapp }}</a></p>
            </div>
        </div>
    </section>
@endsection
