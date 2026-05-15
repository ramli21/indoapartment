@extends('layout')

@section('content')
    <section class="pt-24 pb-12 bg-slate-50 min-h-screen">
        <div class="max-w-md mx-auto px-4 sm:px-6 text-center">
            <!-- Success Icon -->
            <div class="mb-6">
                <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto">
                    <i data-lucide="check" class="w-10 h-10 text-emerald-500"></i>
                </div>
            </div>

            <h1 class="text-2xl font-serif font-semibold text-slate-800 mb-2">Pesan Terkirim!</h1>
            <p class="text-slate-500 mb-8">
                Terima kasih telah menghubungi kami. Kami akan merespons pertanyaan Anda dalam 24 jam.
            </p>

            <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm mb-6">
                <h2 class="text-sm font-medium text-slate-500 mb-4">Perlu bantuan lebih cepat?</h2>
                <a href="https://wa.me/{{ $adminInfo->whatsapp }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    Chat WhatsApp
                </a>
            </div>

            <a href="{{ route('home') }}" class="text-brand font-medium hover:underline">
                Kembali ke Beranda
            </a>
        </div>
    </section>

    <script>
        lucide.createIcons();
    </script>
@endsection
