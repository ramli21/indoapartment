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
                <a href="#"
                    class="nav-link px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $isHome ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-slate-700 hover:text-brand hover:bg-slate-100/80' }}">Home</a>
                <a href="{{ route('apartments.index') }}"
                    class="nav-link px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $isHome ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-slate-700 hover:text-brand hover:bg-slate-100/80' }}">Apartemen</a>
                <a href="#"
                    class="nav-link px-4 py-2 text-sm font-medium rounded-lg transition-all {{ $isHome ? 'text-white/90 hover:text-white hover:bg-white/10' : 'text-slate-700 hover:text-brand hover:bg-slate-100/80' }}">Tentang
                    Kami</a>
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
                        <a href="{{ route('apartments.index') }}"
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
                <a href="#"
                    class="block px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Hotel</a>
                <a href="{{ route('apartments.index') }}"
                    class="block px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Apartemen</a>
                <a href="#"
                    class="block px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Villa</a>
                <a href="#"
                    class="block px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Resort</a>
                <a href="#"
                    class="block px-4 py-3 text-slate-700 hover:text-brand hover:bg-slate-50 rounded-xl transition-all text-sm font-medium">Penerbangan</a>
                <div class="pt-2 border-t border-slate-200/50">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light">
                            <i data-lucide="user" class="w-4 h-4"></i> Masuk / Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
