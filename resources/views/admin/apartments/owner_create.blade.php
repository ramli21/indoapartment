@extends('admin.layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="mb-8">
                <a href="{{ route('admin.apartments.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-brand transition-colors mb-4">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Daftar
                </a>
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand">Pendaftaran Apartemen (Owner)</h1>
                <p class="text-slate-500 mt-1">Form placeholder (jika digunakan dari alur owner registration)</p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-sm">
                <div class="text-sm text-slate-600">
                    Endpoint owner registration saat ini menggunakan form di halaman publik <span
                        class="font-medium">/daftarkan-apartemen</span>.
                    CRUD admin bisa memakai menu utama <b>Apartemen</b>.
                </div>
            </div>
        </div>
    </section>
@endsection
