@php
    $route = request()->route();
    $routeName = $route ? $route->getName() : '';

    $isActive = function (string $prefix) use ($routeName) {
        return $routeName === $prefix || str_starts_with($routeName, $prefix . '.');
    };
@endphp

<div class="sticky md:top-24">
    <div class="bg-white rounded-2xl md:border md:border-slate-100 md:shadow-sm md:p-4">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center">
                <i data-lucide="layout-dashboard" class="w-5 h-5 text-brand"></i>
            </div>
            <div>
                <div class="font-semibold text-slate-800 text-sm">Admin Panel</div>
                <div class="text-xs text-slate-500">IndoApart</div>
            </div>
        </div>

        <nav class="space-y-1">
            <a href="{{ route('admin.index') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $routeName === 'admin.index' ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    Dashboard
                </span>
            </a>

            <a href="{{ route('admin.apartments.index') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $isActive('admin.apartments') ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="building-2" class="w-4 h-4"></i>
                    Apartemen
                </span>
            </a>

            <a href="{{ route('admin.all.rooms') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $isActive('admin.all.rooms') ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="building" class="w-4 h-4"></i>
                    Rooms Sewa
                </span>
            </a>


            <a href="{{ route('admin.bookings.index') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $isActive('admin.bookings') ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                    Booking
                </span>
            </a>

            {{-- <a href="{{ route('admin.bookings.calendar') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $routeName === 'admin.bookings.calendar' ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="calendar-days" class="w-4 h-4"></i>
                    Kalender Booking
                </span>
            </a> --}}

            <a href="{{ route('admin.inquiries.index') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $isActive('admin.inquiries') ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="inbox" class="w-4 h-4"></i>
                    Pesan Masuk
                </span>
            </a>

            {{-- <a href="{{ route('admin.banners.index') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $isActive('admin.banners') ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="image" class="w-4 h-4"></i>
                    Banner
                </span>
            </a> --}}

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $isActive('admin.users') ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="users" class="w-4 h-4"></i>
                    Users
                </span>
            </a>

            <a href="{{ route('admin.info.edit') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $isActive('admin.info.edit') ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    Setting Admin
                </span>
            </a>

            <a href="{{ route('admin.fonnte.edit') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $isActive('admin.fonnte') ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                    Setting Fonnte WA
                </span>
            </a>

            <a href="{{ route('admin.payment-configs.index') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $isActive('admin.payment-configs') ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                    Payment Config
                </span>
            </a>

            <a href="{{ route('admin.help') }}"
                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors border {{ $routeName === 'admin.help' ? 'bg-brand text-white border-brand' : 'bg-transparent border-transparent hover:bg-slate-50 hover:border-slate-100 text-slate-700' }}">
                <span class="inline-flex items-center gap-2 text-sm font-medium">
                    <i data-lucide="help-circle" class="w-4 h-4"></i>
                    Panduan
                </span>
            </a>
        </nav>
    </div>
</div>
