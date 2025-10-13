<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Smart School') }} - Admin</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-transition {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1f2229;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4a4d5a;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #5a5d6a;
        }
    </style>
</head>

<body class="bg-gray-50" x-data="{ sidebarOpen: window.innerWidth > 1024, expandedMenus: [] }">

    {{-- THIS IS THE NEW IMPERSONATION BANNER --}}
    @if (session('impersonating_by_superadmin'))
        <div class="bg-yellow-400 text-black text-center py-2 font-semibold z-50 relative">
            You are currently impersonating an admin.
            <a href="{{ route('impersonate.stop') }}" class="font-bold underline hover:text-gray-800">Return to your
                Super Admin account</a>.
        </div>
    @endif

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="bg-[#2a2d3a] text-white w-64 flex flex-col h-screen fixed lg:relative z-50 sidebar-transition">
            <!-- Logo Section -->
            <div class="bg-[#1f2229] p-3 flex items-center justify-between gap-2 h-14">
                <div class="bg-yellow-400 px-2 py-1 rounded flex items-center justify-center">
                    <span class="text-[10px] text-black uppercase tracking-wide font-semibold">Smart School</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden p-1 hover:bg-[#2a2d3a] rounded transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Session Info -->
            <div class="bg-[#1f2229] px-3 py-2 text-xs border-t border-gray-700">
                <div>Current Session: 2025-26</div>
                <div class="text-gray-400 mt-1">Quick Links</div>
            </div>

            <!-- Navigation Items (This would be the ADMIN's menu) -->
            <div class="flex-1 overflow-y-auto py-2 custom-scrollbar">
                <!-- Dashboard -->
                <div>
                    <a href="#"
                        class="w-full px-3 py-2.5 flex items-center gap-3 bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Dashboard</span>
                    </a>
                </div>

                <!-- Academics -->
                <div>
                    <button
                        @click="expandedMenus.includes(2) ? expandedMenus = expandedMenus.filter(i => i !== 2) : expandedMenus = [2]"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(2) }">
                        <i data-lucide="book-open" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Academics</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(2) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(2)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Classes & Sections
                        </a>
                    </div>
                </div>

                <!-- Students -->
                <div>
                    <button
                        @click="expandedMenus.includes(3) ? expandedMenus = expandedMenus.filter(i => i !== 3) : expandedMenus = [3]"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(3) }">
                        <i data-lucide="users" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Students</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(3) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(3)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Student
                            List</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <div class="bg-white border-b border-gray-200 px-4 py-2.5 h-14">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <button @click="if (window.innerWidth < 1024) sidebarOpen = !sidebarOpen"
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-700 lg:hidden">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        <h1 class="text-green-600 text-lg font-semibold">School</h1>
                    </div>
                    <div class="flex items-center gap-1">
                        <!-- User Dropdown -->
                        <div x-data="{ userMenuOpen: false }" class="relative">
                            <button @click="userMenuOpen = !userMenuOpen"
                                class="flex items-center gap-2 rounded hover:bg-gray-100 text-gray-600 p-1">
                                <img src="https://placehold.co/32x32/E2E8F0/4A5568?text=AD" alt="User"
                                    class="w-8 h-8 rounded-full" />
                                <div class="text-left hidden md:block">
                                    <div class="text-xs font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-[10px] text-gray-500">Admin</div>
                                </div>
                            </button>
                            <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak x-transition
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i data-lucide="log-out" class="w-4 h-4 inline mr-2"></i>
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content Area -->
            <main class="flex-1 overflow-auto bg-gray-50">
                <div class="p-4 md:p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>

</html>
