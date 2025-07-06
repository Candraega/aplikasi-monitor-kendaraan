<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'FleetMaster') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen">
        {{-- Navbar --}}
        <nav x-data="{ scrolled: false }" x-init="scrolled = window.scrollY > 20" @scroll.window="scrolled = window.scrollY > 20"
             :class="{ 'rounded-b-xl shadow-lg': scrolled }"
             class="bg-white sticky top-0 z-40 shadow-sm border-b border-gray-200 transition-all duration-300">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('dashboard') }}" class="font-bold text-lg text-gray-800">
                            FleetMaster
                        </a>
                        <div class="hidden md:flex space-x-6">
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('vehicles.index') }}" class="text-gray-600 hover:text-blue-600">Kendaraan</a>
                                    <a href="{{ route('drivers.index') }}" class="text-gray-600 hover:text-blue-600">Driver</a>
                                    <a href="{{ route('reports.index') }}" class="text-gray-600 hover:text-blue-600">Laporan</a>
                                    <a href="https://docs.google.com/document/d/1cgASuawP9mK0HIEL88C3rQiFqRctaiqaOkt_qrBHOI8/edit?usp=sharing" class="text-gray-600 hover:text-blue-600">Diagram</a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    {{-- User Dropdown --}}
                    <div class="flex items-center">
                        @auth
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center space-x-2 text-gray-600 hover:text-gray-800">
                                    <span>Halo, {{ Auth::user()->name }}</span>
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border"
                                     style="display: none;">
                                    <span class="block px-4 py-2 text-sm text-gray-500">Manajemen Akun</span>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                    <div class="border-t my-1"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        {{-- Konten Utama --}}
        <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if (session('success') || session('error'))
                <div class="mb-6 p-4 rounded-md text-sm {{ session('success') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}" role="alert">
                    <p class="font-bold">{{ session('success') ? 'Berhasil!' : 'Terjadi Kesalahan!' }}</p>
                    <span>{{ session('success') ?? session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @livewireScripts
</body>
</html>
