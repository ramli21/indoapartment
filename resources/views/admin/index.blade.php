@extends('admin.layout')

@section('content')
    <section class="pt-8 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-serif font-semibold text-brand">Dashboard Admin</h1>
                    <p class="text-slate-500 mt-1">Ringkasan data sistem IndoApart</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.bookings.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors">
                        <i data-lucide="calendar-days" class="w-4 h-4"></i>
                        Lihat Booking
                    </a>
                    <a href="{{ route('admin.apartments.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition-colors">
                        <i data-lucide="building-2" class="w-4 h-4"></i>
                        Kelola Apartemen
                    </a>
                </div>
            </div>

            @php
                $totalApartments = \App\Models\Apartment::count();
                $availableApartments = \App\Models\Apartment::where('status', 'Tersedia')->count();
                $occupiedApartments = \App\Models\Apartment::where('status', 'Terisi')->count();
                $maintenanceApartments = \App\Models\Apartment::where('status', 'Perawatan')->count();

                $totalBookings = \App\Models\Booking::count();
                $pendingBookings = \App\Models\Booking::where('status', 'pending')->count();
                $confirmedBookings = \App\Models\Booking::where('status', 'confirmed')->count();
                $completedBookings = \App\Models\Booking::where('status', 'completed')->count();
                $cancelledBookings = \App\Models\Booking::where('status', 'cancelled')->count();

                $activeBanners = \App\Models\Banner::where('is_active', true)->count();
                $totalBanners = \App\Models\Banner::count();

                $totalInquiries = \App\Models\Inquiry::count();
            @endphp

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center">
                            <i data-lucide="building-2" class="w-5 h-5 text-brand"></i>
                        </div>
                        <span class="text-xs font-medium text-slate-400">Total Apartemen</span>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $totalApartments }}</div>
                    <div class="text-xs text-slate-500 mt-1">Semua unit terdaftar</div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600"></i>
                        </div>
                        <span class="text-xs font-medium text-emerald-600">Tersedia</span>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $availableApartments }}</div>
                    <div class="text-xs text-slate-500 mt-1">Siap dihuni</div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                            <i data-lucide="clock" class="w-5 h-5 text-amber-600"></i>
                        </div>
                        <span class="text-xs font-medium text-amber-600">Pending Booking</span>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $pendingBookings }}</div>
                    <div class="text-xs text-slate-500 mt-1">Menunggu konfirmasi</div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center">
                            <i data-lucide="image" class="w-5 h-5 text-brand"></i>
                        </div>
                        <span class="text-xs font-medium text-slate-400">Active Banners</span>
                    </div>
                    <div class="text-2xl font-bold text-slate-800">{{ $activeBanners }}</div>
                    <div class="text-xs text-slate-500 mt-1">Dari {{ $totalBanners }} banner</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center">
                            <i data-lucide="calendar" class="w-5 h-5 text-brand"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-800">Ringkasan Booking</h2>
                            <p class="text-sm text-slate-500">Status pemesanan terbaru</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @php
                            $bookingSummary = [
                                'pending' => [
                                    'label' => 'Pending',
                                    'value' => $pendingBookings,
                                    'bg' => 'bg-amber-100',
                                    'text' => 'text-amber-700',
                                    'icon' => 'clock',
                                ],
                                'confirmed' => [
                                    'label' => 'Confirmed',
                                    'value' => $confirmedBookings,
                                    'bg' => 'bg-emerald-100',
                                    'text' => 'text-emerald-700',
                                    'icon' => 'check-circle-2',
                                ],
                                'completed' => [
                                    'label' => 'Completed',
                                    'value' => $completedBookings,
                                    'bg' => 'bg-brand/10',
                                    'text' => 'text-brand',
                                    'icon' => 'check',
                                ],
                                'cancelled' => [
                                    'label' => 'Cancelled',
                                    'value' => $cancelledBookings,
                                    'bg' => 'bg-slate-100',
                                    'text' => 'text-slate-600',
                                    'icon' => 'x-circle',
                                ],
                            ];
                        @endphp

                        @foreach ($bookingSummary as $key => $item)
                            <div class="flex items-center justify-between rounded-xl px-3 py-2 bg-slate-50">
                                <div class="flex items-center gap-2">
                                    <span class="w-9 h-9 rounded-lg {{ $item['bg'] }} flex items-center justify-center">
                                        <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4 {{ $item['text'] }}"></i>
                                    </span>
                                    <span class="text-sm font-medium text-slate-700">{{ $item['label'] }}</span>
                                </div>
                                <span class="text-sm font-bold text-slate-800">{{ $item['value'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.bookings.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-brand text-white text-sm font-medium hover:bg-brand-light transition-colors">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            Detail Booking
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center">
                            <i data-lucide="sparkles" class="w-5 h-5 text-brand"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-800">Kondisi Apartemen</h2>
                            <p class="text-sm text-slate-500">Status unit saat ini</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between rounded-xl px-3 py-2 bg-slate-50">
                            <span class="text-sm text-slate-700">Terisi</span>
                            <span class="text-sm font-bold text-slate-800">{{ $occupiedApartments }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-xl px-3 py-2 bg-slate-50">
                            <span class="text-sm text-slate-700">Perawatan</span>
                            <span class="text-sm font-bold text-slate-800">{{ $maintenanceApartments }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-xl px-3 py-2 bg-slate-50">
                            <span class="text-sm text-slate-700">Tersedia</span>
                            <span class="text-sm font-bold text-slate-800">{{ $availableApartments }}</span>
                        </div>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('admin.apartments.index') }}"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200 transition-colors">
                            <i data-lucide="building-2" class="w-4 h-4"></i>
                            Kelola Apartemen
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center">
                            <i data-lucide="inbox" class="w-5 h-5 text-brand"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-800">Info Cepat</h2>
                            <p class="text-sm text-slate-500">Bacaan & aksi cepat</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="rounded-xl bg-slate-50 p-3">
                            <div class="text-xs text-slate-500">Jumlah Pesan Masuk (Inquiries)</div>
                            <div class="text-2xl font-bold text-slate-800 mt-1">{{ $totalInquiries }}</div>
                            <div class="text-xs text-slate-500 mt-1">Butuh penanganan dari admin</div>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-3">
                            <div class="text-xs text-slate-500">Total Banner</div>
                            <div class="text-2xl font-bold text-slate-800 mt-1">{{ $totalBanners }}</div>
                            <div class="text-xs text-slate-500 mt-1">Aktif: {{ $activeBanners }}</div>
                        </div>
                    </div>

                    <div class="mt-4 space-y-2">
                        <a href="{{ route('admin.banners.index') }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-brand text-white text-sm font-medium hover:bg-brand-light transition-colors">
                            <i data-lucide="image" class="w-4 h-4"></i>
                            Kelola Banner
                        </a>
                        <a href="{{ route('admin.help') }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200 transition-colors">
                            <i data-lucide="help-circle" class="w-4 h-4"></i>
                            Panduan Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
