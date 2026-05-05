<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IndoApart — Temukan Apartemen & Penginapan Terbaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="{{ asset('js/search.js') }}"></script>
    <script src="{{ asset('js/image-slider.js') }}"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;1,500&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#0F3D2E',
                        'brand-light': '#1a4f3d',
                        'brand-dark': '#0a2e22',
                        accent: '#D2F86D',
                        'accent-hover': '#c2eb5b',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        ::selection {
            background: #D2F86D;
            color: #0F3D2E;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(100%)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        @keyframes toastOut {
            from {
                opacity: 1;
                transform: translateX(0)
            }

            to {
                opacity: 0;
                transform: translateX(100%)
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease;
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease;
        }

        .animate-slideUp {
            animation: slideUp 0.5s ease;
        }

        .toast-enter {
            animation: toastIn 0.4s ease;
        }

        .toast-exit {
            animation: toastOut 0.4s ease forwards;
        }

        .hero-bg {
            transition: transform 20s linear;
        }

        .hero-bg:hover {
            transform: scale(1.05);
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.3);
            cursor: pointer;
        }

        /* Navbar homepage transparent -> scrolled styles */
        .navbar-home .nav-logo-text {
            color: #ffffff !important;
        }

        .navbar-home.navbar-scrolled .nav-logo-text {
            color: #0F3D2E !important;
        }

        .navbar-home .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .navbar-home .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.1) !important;
        }

        .navbar-home.navbar-scrolled .nav-link {
            color: #334155 !important;
        }

        .navbar-home.navbar-scrolled .nav-link:hover {
            color: #0F3D2E !important;
            background: rgba(241, 245, 249, 0.8) !important;
        }

        .navbar-home .nav-currency-box {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        .navbar-home .nav-currency-box i,
        .navbar-home .nav-currency-box span {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .navbar-home .nav-currency-box span.text-white\/40,
        .navbar-home .nav-currency-box span.text-slate-400 {
            color: rgba(255, 255, 255, 0.4) !important;
        }

        .navbar-home.navbar-scrolled .nav-currency-box {
            background: rgba(248, 250, 252, 0.8) !important;
            border-color: rgba(226, 232, 240, 0.5) !important;
        }

        .navbar-home.navbar-scrolled .nav-currency-box i {
            color: #475569 !important;
        }

        .navbar-home.navbar-scrolled .nav-currency-box span {
            color: #334155 !important;
        }

        .navbar-home .nav-dashboard-link {
            background: rgba(255, 255, 255, 0.1) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        .navbar-home .nav-dashboard-link:hover {
            background: rgba(255, 255, 255, 0.2) !important;
        }

        .navbar-home.navbar-scrolled .nav-dashboard-link {
            background: rgba(248, 250, 252, 0.8) !important;
            color: #334155 !important;
            border-color: rgba(226, 232, 240, 0.5) !important;
        }

        .navbar-home.navbar-scrolled .nav-dashboard-link:hover {
            background: #ffffff !important;
        }

        .navbar-home .nav-mobile-btn {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .navbar-home .nav-mobile-btn:hover {
            background: rgba(255, 255, 255, 0.1) !important;
        }

        .navbar-home.navbar-scrolled .nav-mobile-btn {
            color: #334155 !important;
        }

        .navbar-home.navbar-scrolled .nav-mobile-btn:hover {
            background: #f1f5f9 !important;
        }
    </style>
</head>

<body class="font-sans text-slate-700 bg-white">
    @include('navbar')

    @yield('content')

    @include('footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            const navbar = document.getElementById('navbar');
            if (navbar && navbar.classList.contains('navbar-home')) {
                function updateNavbar() {
                    if (window.scrollY > 50) {
                        navbar.classList.add('navbar-scrolled', 'bg-white', 'shadow-sm');
                        navbar.classList.remove('bg-transparent');
                    } else {
                        navbar.classList.remove('navbar-scrolled', 'bg-white', 'shadow-sm');
                        navbar.classList.add('bg-transparent');
                    }
                }
                updateNavbar();
                window.addEventListener('scroll', updateNavbar, {
                    passive: true
                });
            }
        });
    </script>
</body>

</html>
