<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pemesanan Kendaraan</title>

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

<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen">
        <nav x-data="{ mobileOpen: false, dropdownOpen: false }"
             class="bg-white shadow border-b border-gray-200 sticky top-0 z-50 rounded-b-lg">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('dashboard') }}" class="font-bold text-lg text-gray-800">
                            FleetMaster
                        </a>

                        <!-- Desktop Menu -->
                        <div class="hidden md:flex space-x-6">
                            @auth
                                <a href="{{ route('dashboard') }}"
                                   class="{{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold' : 'text-gray-600' }} hover:text-blue-600 transition">
                                    Dashboard
                                </a>

                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('vehicles.index') }}"
                                       class="{{ request()->routeIs('vehicles.*') ? 'text-blue-600 font-semibold' : 'text-gray-600' }} hover:text-blue-600 transition">
                                        Kendaraan
                                    </a>
                                    <a href="{{ route('drivers.index') }}"
                                       class="{{ request()->routeIs('drivers.*') ? 'text-blue-600 font-semibold' : 'text-gray-600' }} hover:text-blue-600 transition">
                                        Driver
                                    </a>
                                    <a href="{{ route('reports.index') }}"
                                       class="{{ request()->routeIs('reports.*') ? 'text-blue-600 font-semibold' : 'text-gray-600' }} hover:text-blue-600 transition">
                                        Laporan
                                    </a>
                                    <a href="https://docs.google.com/document/d/1cgASuawP9mK0HIEL88C3rQiFqRctaiqaOkt_qrBHOI8/edit?usp=sharing"
                                       class="text-gray-600 hover:text-blue-600 transition">
                                        Diagram
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center space-x-4">
                        <button @click="mobileOpen = !mobileOpen"
                                class="md:hidden text-gray-600 hover:text-gray-800 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        @auth
                            <!-- Dropdown for desktop -->
                            <div x-data="{ open: false }" class="relative hidden md:block">
                                <button @click="open = !open"
                                        class="flex items-center space-x-2 text-gray-600 hover:text-gray-800">
                                    <span>Halo, {{ Auth::user()->name }}</span>
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border">
                                    <span class="block px-4 py-2 text-sm text-gray-500">Manajemen Akun</span>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                    <div class="border-t my-1"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div x-show="mobileOpen" x-transition class="md:hidden">
                    @auth
                        <div class="pt-2 pb-3 space-y-1">
                            <a href="{{ route('dashboard') }}"
                               class="block px-4 py-2 text-sm {{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold' : 'text-gray-700' }} hover:bg-gray-100">Dashboard</a>

                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('vehicles.index') }}"
                                   class="block px-4 py-2 text-sm {{ request()->routeIs('vehicles.*') ? 'text-blue-600 font-semibold' : 'text-gray-700' }} hover:bg-gray-100">Kendaraan</a>
                                <a href="{{ route('drivers.index') }}"
                                   class="block px-4 py-2 text-sm {{ request()->routeIs('drivers.*') ? 'text-blue-600 font-semibold' : 'text-gray-700' }} hover:bg-gray-100">Driver</a>
                                <a href="{{ route('reports.index') }}"
                                   class="block px-4 py-2 text-sm {{ request()->routeIs('reports.*') ? 'text-blue-600 font-semibold' : 'text-gray-700' }} hover:bg-gray-100">Laporan</a>
                                <a href="https://docs.google.com/document/d/1cgASuawP9mK0HIEL88C3rQiFqRctaiqaOkt_qrBHOI8/edit?usp=sharing"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Diagram</a>
                            @endif

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if (session('success') || session('error'))
                <div class="mb-6 p-4 rounded-md text-sm {{ session('success') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                     role="alert">
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
