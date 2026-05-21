@php
    $isAdminArea = request()->is('admin/*');
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IndoApart — Admin</title>

    {{-- Reuse same CDN assets as main layout --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

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
    </style>
</head>

<body class="font-sans text-slate-700 bg-white">
    {{-- Use existing global navbar --}}
    @include('navbar')

    <div class="pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex gap-4">
                <aside class="hidden md:block w-64 shrink-0">
                    @include('admin.partials.sidebar')
                </aside>

                <main class="flex-1 w-full rounded-2xl p-0 md:p-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    @include('footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

</body>

</html>
