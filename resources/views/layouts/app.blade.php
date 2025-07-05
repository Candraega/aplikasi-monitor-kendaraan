<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'FleetMaster') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Styles & Scripts --}}
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @livewireStyles
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div x-data="{ mobileMenuOpen: false, scrolled: false }"
         x-init="scrolled = (window.scrollY > 20)"
         @scroll.window="scrolled = (window.scrollY > 20)"
         class="min-h-screen">
        
        {{-- Navbar --}}
        <nav :class="{ 'rounded-b-xl shadow-lg': scrolled, 'shadow-sm': !scrolled }"
             class="bg-white sticky top-0 z-40 transition-all duration-300">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    {{-- Logo & Navigasi Kiri --}}
                    <div class="flex items-center space-x-8">
                        <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="flex-shrink-0 flex items-center space-x-2">
                            <svg class="h-8 w-auto text-blue-600" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"></path></svg>
                            <span class="font-bold text-lg text-gray-800">FleetMaster</span>
                        </a>

                        <div class="hidden md:flex space-x-6">
                            @auth
                                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' }} py-5 transition-colors duration-200">Dashboard</a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('vehicles.index') }}" class="{{ request()->routeIs('vehicles.*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' }} py-5 transition-colors duration-200">Kendaraan</a>
                                    <a href="{{ route('drivers.index') }}" class="{{ request()->routeIs('drivers.*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' }} py-5 transition-colors duration-200">Driver</a>
                                    <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' }} py-5 transition-colors duration-200">Laporan</a>
                                    <a href="https://docs.google.com/document/d/1cgASuawP9mK0HIEL88C3rQiFqRctaiqaOkt_qrBHOI8/edit?usp=sharing" class="text-gray-600 hover:text-blue-600' }} py-5 transition-colors duration-200">Diagram</a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    {{-- Navigasi Kanan (User & Guest) --}}
                    <div class="flex items-center">
                        @auth
                            {{-- Tampilan untuk pengguna yang sudah login --}}
                            <div x-data="{ dropdownOpen: false }" class="relative">
                                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 text-gray-600 hover:text-gray-800 focus:outline-none">
                                    <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-sm">
                                        {{ Auth::user()->initials() }}
                                    </div>
                                    <span class="hidden sm:inline text-sm font-medium">{{ Auth::user()->name }}</span>
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                                     x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border">
                                    <div class="px-4 py-2 text-xs text-gray-400">Manajemen Akun</div>
                                    <a href="#" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>Profil</a>
                                    <div class="border-t my-1"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            {{-- Tampilan untuk pengguna yang belum login (guest) --}}
                            <div class="hidden md:flex items-center space-x-4">
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600">Login</a>
                            </div>
                        @endguest
                        
                        {{-- Hamburger Menu (Mobile) --}}
                        <div class="md:hidden ml-4">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Mobile Menu Panel --}}
            <div x-show="mobileMenuOpen" x-collapse class="md:hidden border-t border-gray-200">
                @auth
                    {{-- Menu Mobile untuk User Login --}}
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('vehicles.index') }}" class="{{ request()->routeIs('vehicles.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} block px-3 py-2 rounded-md text-base font-medium">Kendaraan</a>
                            <a href="{{ route('drivers.index') }}" class="{{ request()->routeIs('drivers.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} block px-3 py-2 rounded-md text-base font-medium">Driver</a>
                            <a href="https://docs.google.com/document/d/1cgASuawP9mK0HIEL88C3rQiFqRctaiqaOkt_qrBHOI8/edit?usp=sharing" class="{{ request()->routeIs('reports.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} block px-3 py-2 rounded-md text-base font-medium">Diagram</a>
                        @endif
                    </div>
                    <div class="pt-4 pb-3 border-t border-gray-200">
                        <div class="flex items-center px-5">
                            <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">
                                {{ Auth::user()->initials() }}
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="mt-3 px-2 space-y-1">
                            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Profil</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- Menu Mobile untuk Guest --}}
                    <div class="py-3 px-2">
                        <a href="{{ route('login') }}" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 rounded-md">Login</a>
                    </div>
                @endguest
            </div>
        </nav>

        {{-- Konten Utama --}}
        <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
             @if (session('success'))
                <div class="mb-6 p-4 rounded-md flex items-start bg-green-100">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 rounded-md flex items-start bg-red-100">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @livewireScripts
</body>
</html>