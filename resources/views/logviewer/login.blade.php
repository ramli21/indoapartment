@extends('layout')

@section('content')
    <section class="py-24 bg-slate-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full px-4">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h2 class="text-xl font-semibold mb-4">Akses Log Viewer</h2>
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600">{{ $errors->first() }}</div>
                @endif
                <form action="{{ url('/log-viewer-login') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm text-slate-600 mb-2">Masukkan password</label>
                        <input type="password" name="password" required
                            class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none" />
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="/" class="text-sm text-slate-500 hover:underline">Kembali ke situs</a>
                        <button type="submit" class="bg-brand text-white px-4 py-2 rounded-xl">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
