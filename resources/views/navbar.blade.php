@php
    $isHome = request()->is('/');
@endphp
<!-- Navbar -->
<nav id="navbar"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 {{ $isHome ? 'navbar-home bg-transparent' : 'bg-white shadow-sm' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('apple-touch-icon.png') }}" />
                </div>
                <span
                    class="text-xl font-semibold nav-logo-text {{ $isHome ? 'text-white' : 'text-brand' }}">IndoApart</span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ url('/') }}"
                    class="nav-link px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $isHome ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-slate-700 hover:text-brand hover:bg-slate-100/80' }}">Home</a>
                <a href="{{ route('rooms.list') }}"
                    class="nav-link px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $isHome ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-slate-700 hover:text-brand hover:bg-slate-100/80' }}">
                    Room Sewa</a>
                <a href="#"
                    class="nav-link px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $isHome ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-slate-700 hover:text-brand hover:bg-slate-100/80' }}">
                    Room Jual</a>
                <a href="{{ route('booking.track') }}"
                    class="nav-link px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $isHome ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-slate-700 hover:text-brand hover:bg-slate-100/80' }}">Lacak
                    Booking</a>
                <a href="{{ route('inquiry.create') }}"
                    class="nav-link px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $isHome ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-slate-700 hover:text-brand hover:bg-slate-100/80' }}">Hubungi
                    Kami</a>
                <a href="{{ route('help') }}"
                    class="nav-link px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $isHome ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-slate-700 hover:text-brand hover:bg-slate-100/80' }}">Bantuan</a>
                {{-- <a href="#"
                    class="nav-link px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $isHome ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-slate-700 hover:text-brand hover:bg-slate-100/80' }}">Resort</a>
                <a href="#"
                    class="nav-link px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $isHome ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-slate-700 hover:text-brand hover:bg-slate-100/80' }}">Penerbangan</a> --}}
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-2">
                <div
                    class="nav-currency-box hidden sm:flex items-center rounded-xl px-3 py-2 gap-2 border transition-all {{ $isHome ? 'bg-white/10 backdrop-blur-sm border-white/20' : 'bg-slate-50/80 backdrop-blur-sm border-slate-200/50' }}">
                    <i data-lucide="globe" class="w-4 h-4 {{ $isHome ? 'text-white/80' : 'text-slate-600' }}"></i>
                    <span class="text-sm font-medium {{ $isHome ? 'text-white/90' : 'text-slate-700' }}">IDR</span>
                    <span class="{{ $isHome ? 'text-white/40' : 'text-slate-400' }}">|</span>
                    <span class="text-sm font-medium {{ $isHome ? 'text-white/90' : 'text-slate-700' }}">ID</span>
                </div>
                @auth
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.apartments.index') }}"
                            class="nav-dashboard-link hidden sm:flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-xl transition-colors border {{ $isHome ? 'bg-white/10 backdrop-blur-sm text-white/90 hover:bg-white/20 border-white/20' : 'bg-slate-50/80 backdrop-blur-sm text-slate-700 hover:bg-white border-slate-200/50' }}">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                            Dashboard
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            Keluar
                        </button>
                    </form>
                @else
                    {{-- <a href="{{ route('login') }}"
                        class="hidden sm:flex items-center gap-2 px-4 py-2 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-colors">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        Masuk
                    </a> --}}
                @endauth
                <button onclick="toggleMobileMenu()"
                    class="nav-mobile-btn lg:hidden w-10 h-10 flex items-center justify-center rounded-xl transition-colors {{ $isHome ? 'text-white/90 hover:bg-white/10' : 'text-slate-700 hover:bg-slate-100' }}">
                    <i data-lucide="menu" class="w-5 h-5" id="menuIcon"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu"
            class="hidden lg:hidden bg-white/95 backdrop-blur-md border-t border-slate-200/50 animate-slideDown rounded-b-2xl shadow-lg">
            <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
                <a href="{{ url('/') }}"
                    class="block px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Home</a>
                <a href="{{ route('rooms.list') }}"
                    class="block px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Room
                    Sewa</a>
                <a href="#"
                    class="block px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Room
                    Jual</a>
                <a href="{{ route('booking.track') }}"
                    class="block px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Lacak
                    Booking</a>
                <a href="{{ route('inquiry.create') }}"
                    class="block px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Hubungi
                    Kami</a>
                <a href="{{ route('help') }}"
                    class="block px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Bantuan</a>
                @auth
                    <div class="pt-2 border-t border-slate-200/50">
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.apartments.index') }}"
                                class="block w-full text-left px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    // Expose globally so onclick="toggleMobileMenu()" works from inline HTML
    window.toggleMobileMenu = function() {
        var menu = document.getElementById('mobileMenu');
        var icon = document.getElementById('menuIcon');
        if (!menu) return;
        menu.classList.toggle('hidden');
        if (icon) {
            var isMenu = icon.getAttribute('data-lucide') === 'menu';
            icon.setAttribute('data-lucide', isMenu ? 'x' : 'menu');
            if (window.lucide && typeof window.lucide.replace === 'function') {
                try {
                    window.lucide.replace();
                } catch (e) {
                    /* ignore */
                }
            }
        }
    };

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        var menu = document.getElementById('mobileMenu');
        var btn = document.querySelector('.nav-mobile-btn');
        if (!menu || !btn) return;
        if (!menu.classList.contains('hidden') && !menu.contains(e.target) && !btn.contains(e.target)) {
            menu.classList.add('hidden');
            var icon = document.getElementById('menuIcon');
            if (icon) {
                icon.setAttribute('data-lucide', 'menu');
                if (window.lucide && typeof window.lucide.replace === 'function') {
                    try {
                        window.lucide.replace();
                    } catch (e) {}
                }
            }
        }
    });
</script>
