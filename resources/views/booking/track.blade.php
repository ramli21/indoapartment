@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-lg mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-brand/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="search" class="w-8 h-8 text-brand"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-slate-800">Lacak Booking</h1>
                <p class="text-slate-500 mt-1">Masukkan kode booking untuk melihat status pemesanan Anda</p>
            </div>

            <!-- Search Form -->
            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm">
                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('booking.search') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kode Booking</label>
                        <input type="text" name="booking_code" placeholder="Contoh: XYZ1234"
                            class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:border-brand outline-none text-lg"
                            value="{{ old('booking_code') }}">
                        <p class="text-xs text-slate-500 mt-1">Masukkan kode booking yang Anda terima setelah melakukan
                            pemesanan</p>
                    </div>

                    <button type="submit"
                        class="w-full bg-brand text-white px-4 py-3 rounded-lg font-medium hover:bg-brand-light transition-colors text-lg">
                        Cari Booking
                    </button>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-6 p-4 bg-amber-50 rounded-xl border border-amber-100">
                <div class="flex gap-3">
                    <i data-lucide="info" class="w-5 h-5 text-amber-500 flex-shrink-0"></i>
                    <div class="text-sm text-amber-800">
                        <p class="font-medium mb-1">Cara Menggunakan:</p>
                        <ol class="list-decimal list-inside space-y-1 text-amber-700">
                            <li>Cek kode booking di email konfirmasi Anda</li>
                            <li>Masukkan kode pada kolom di atas</li>
                            <li>Klik tombol "Cari Booking" untuk melihat status</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="mt-4 text-center">
                <p class="text-sm text-slate-500">
                    Butuh bantuan?
                    <a href="{{ route('inquiry.create') }}" class="text-brand hover:underline">Hubungi Kami</a>
                </p>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
@endsection
