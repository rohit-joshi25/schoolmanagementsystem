<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Smart School') }} - Super Admin</title>

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

        /* Smooth transitions for sidebar */
        .sidebar-transition {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom scrollbar for sidebar */
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
    <div class="flex h-screen overflow-hidden">

        <!-- Backdrop overlay for mobile -->
        <div x-show="sidebarOpen" x-cloak @click="if (window.innerWidth < 1024) sidebarOpen = false"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

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

            <!-- Navigation Items -->
            <div class="flex-1 overflow-y-auto py-2 custom-scrollbar">

                <!-- Student Information -->
                <div>
                    <button
                        @click="expandedMenus.includes(0) ? expandedMenus = expandedMenus.filter(i => i !== 0) : expandedMenus = [0]"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(0) }">
                        <i data-lucide="users" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Student Information</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(0) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(0)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Student Details
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Student Admission
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Bulk Delete
                        </a>
                    </div>
                </div>

                <!-- Fees Collection -->
                <div>
                    <button
                        @click="expandedMenus.includes(1) ? expandedMenus = expandedMenus.filter(i => i !== 1) : expandedMenus = [1]"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(1) }">
                        <i data-lucide="book-open" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Fees Collection</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(1) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(1)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Collect Fee
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Create Fee
                        </a>
                    </div>
                </div>

                <!-- Multi Branch -->
                <div>
                    <button
                        @click="expandedMenus.includes(2) ? expandedMenus = expandedMenus.filter(i => i !== 2) : expandedMenus = [2]"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(2) }">
                        <i data-lucide="graduation-cap" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Multi Branch</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(2) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(2)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Overview
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Create Branch
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Manage Branch
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Report
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Setting
                        </a>
                    </div>
                </div>

                <!-- Attendance -->
                <div>
                    <button
                        @click="expandedMenus.includes(3) ? expandedMenus = expandedMenus.filter(i => i !== 3) : expandedMenus = [3]"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(3) }">
                        <i data-lucide="calendar-check" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Attendance</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(3) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(3)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Student Attendance
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Attendance By Date
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Manage Attendance
                        </a>
                    </div>
                </div>

                <!-- Schools Management -->
                <div>
                    <button
                        @click="expandedMenus.includes(5) ? expandedMenus = expandedMenus.filter(i => i !== 5) : expandedMenus = [5]"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(5) }">
                        <i data-lucide="school" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Schools Management</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(5) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(5)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Add New School
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            School List
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            School Login (Impersonate)
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            School Branches
                        </a>
                    </div>
                </div>
                <!-- System Settings -->
                <div>
                    <button
                        @click="expandedMenus.includes(4) ? expandedMenus = expandedMenus.filter(i => i !== 4) : expandedMenus = [4]"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(4) }">
                        <i data-lucide="settings" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">System Settings</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(4) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(4)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            General Setting
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Session Setting
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Roles & Permissions
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Backup
                        </a>
                    </div>
                </div>


            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header -->
            <div class="bg-white border-b border-gray-200 px-4 py-2.5 h-14">
                <div class="flex items-center justify-between gap-4">

                    <!-- Left: Menu and School Name -->
                    <div class="flex items-center gap-3">
                        <!-- Show menu button only on mobile/tablet -->
                        <button @click="if (window.innerWidth < 1024) sidebarOpen = !sidebarOpen"
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-700 lg:hidden">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        <h1 class="text-green-600 text-lg font-semibold">School</h1>
                    </div>

                    <!-- Center: Search -->
                    <div class="flex-1 max-w-md hidden md:block">
                        <div class="relative">
                            <input type="text" placeholder="Search By Student Name..."
                                class="w-full pr-10 bg-gray-50 border border-gray-300 rounded-md h-9 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <button
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-gray-700 hover:bg-gray-800 text-white p-1.5 rounded">
                                <i data-lucide="search" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Right: Action Icons & User -->
                    <div class="flex items-center gap-1">
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <img src="https://placehold.co/20x20/d1d5db/374151?text=EN" alt="Language"
                                class="w-5 h-5 rounded" />
                        </button>
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <i data-lucide="calendar" class="w-5 h-5"></i>
                        </button>
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <i data-lucide="edit" class="w-5 h-5"></i>
                        </button>
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <i data-lucide="message-square" class="w-5 h-5"></i>
                        </button>
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                        </button>
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                        </button>

                        <!-- User Dropdown -->
                        <div x-data="{ userMenuOpen: false }" class="relative">
                            <button @click="userMenuOpen = !userMenuOpen"
                                class="flex items-center gap-2 rounded hover:bg-gray-100 text-gray-600 p-1">
                                <img src="https://placehold.co/32x32/E2E8F0/4A5568?text=SA" alt="User"
                                    class="w-8 h-8 rounded-full" />
                                <div class="text-left hidden md:block">
                                    <div class="text-xs font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-[10px] text-gray-500">Super Admin</div>
                                </div>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                                <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-200">
                                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                                    Profile
                                </a>
                                <hr class="my-1">
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

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>

    @stack('scripts')
    <script>
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                document.querySelector('body').__x.$data.sidebarOpen = true;
            }
        });
    </script>

</body>

</html>
