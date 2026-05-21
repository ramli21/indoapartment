@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="mb-6">
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-brand transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke daftar admin
                </a>
            </div>

            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                            placeholder="Nama admin" />
                        @error('name')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                            placeholder="admin@indoapart.com" />
                        @error('email')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="border-t border-slate-100 pt-6">
                        <h3 class="text-sm font-medium text-slate-700 mb-4 flex items-center gap-2">
                            <i data-lucide="key-round" class="w-4 h-4 text-brand"></i>
                            Ganti Password
                        </h3>
                        <p class="text-xs text-slate-500 mb-4">Kosongkan jika tidak ingin mengubah password.</p>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                            <input type="password" name="password"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="Minimal 8 karakter" />
                            @error('password')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                                placeholder="Ulangi password baru" />
                        </div>
                    </div>

                    <div class="pt-4 flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-brand text-white rounded-lg font-medium">
                            Simpan
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                            class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            @if (session('success'))
                <div
                    class="mt-6 mb-2 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>
@endsection
