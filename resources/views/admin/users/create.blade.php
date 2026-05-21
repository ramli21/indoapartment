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
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                            placeholder="Nama admin" />
                        @error('name')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand outline-none text-sm"
                            placeholder="admin@indoapart.com" />
                        @error('email')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
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
                            placeholder="Ulangi password" />
                    </div>

                    @if ($errors->any())
                        <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pt-4 flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-brand text-white rounded-lg font-medium">
                            Buat Admin
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                            class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg font-medium hover:bg-slate-200 transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
