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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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

        /* Dropdown animations */
        .dropdown-enter {
            transition: all 0.3s ease-in-out;
        }

        /* Rotate chevron */
        .rotate-0 {
            transform: rotate(0deg);
            transition: transform 0.3s ease-in-out;
        }

        .rotate-180 {
            transform: rotate(180deg);
            transition: transform 0.3s ease-in-out;
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

<body class="bg-gray-50" x-data="{ sidebarOpen: true, expandedMenus: [0] }">
    <div class="flex h-screen overflow-hidden">

        <!-- Backdrop overlay for mobile -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="bg-[#2a2d3a] text-white w-56 flex flex-col h-screen fixed lg:relative z-50 sidebar-transition">
            <!-- Logo Section -->
            <div class="bg-[#1f2229] p-3 flex items-center justify-between gap-2">
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
                        @click="expandedMenus.includes(0) ? expandedMenus = expandedMenus.filter(i => i !== 0) : expandedMenus.push(0)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200 bg-[#1f2229]">
                        <i data-lucide="users" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Student Information</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(0) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
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
                            Disabled Students
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Bulk Delete
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Student Categories
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Student House
                        </a>
                    </div>
                </div>

                <!-- Online Course -->
                <div>
                    <button
                        @click="expandedMenus.includes(1) ? expandedMenus = expandedMenus.filter(i => i !== 1) : expandedMenus.push(1)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="book-open" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Online Course</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(1) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(1)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Course List
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Course Categories
                        </a>
                    </div>
                </div>

                <!-- Multi Branch -->
                <div>
                    <button
                        @click="expandedMenus.includes(2) ? expandedMenus = expandedMenus.filter(i => i !== 2) : expandedMenus.push(2)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="git-branch" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Multi Branch</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(2) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(2)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Branch List
                        </a>
                    </div>
                </div>

                <!-- Gmeet Live Classes -->
                <div>
                    <button
                        @click="expandedMenus.includes(3) ? expandedMenus = expandedMenus.filter(i => i !== 3) : expandedMenus.push(3)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="video" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Gmeet Live Classes</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(3) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(3)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Live Classes
                        </a>
                    </div>
                </div>

                <!-- Zoom Live Classes -->
                <div>
                    <button
                        @click="expandedMenus.includes(4) ? expandedMenus = expandedMenus.filter(i => i !== 4) : expandedMenus.push(4)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="video" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Zoom Live Classes</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(4) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(4)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Live Classes
                        </a>
                    </div>
                </div>

                <!-- Behaviour Records -->
                <div>
                    <button
                        @click="expandedMenus.includes(5) ? expandedMenus = expandedMenus.filter(i => i !== 5) : expandedMenus.push(5)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="file-text" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Behaviour Records</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(5) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(5)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Records List
                        </a>
                    </div>
                </div>

                <!-- CBSE Examination -->
                <div>
                    <button
                        @click="expandedMenus.includes(6) ? expandedMenus = expandedMenus.filter(i => i !== 6) : expandedMenus.push(6)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="clipboard-check" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">CBSE Examination</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(6) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(6)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Exam List
                        </a>
                    </div>
                </div>

                <!-- Examinations -->
                <div>
                    <button
                        @click="expandedMenus.includes(7) ? expandedMenus = expandedMenus.filter(i => i !== 7) : expandedMenus.push(7)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="file-text" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Examinations</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(7) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(7)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Exam Schedule
                        </a>
                    </div>
                </div>

                <!-- Attendance -->
                <div>
                    <button
                        @click="expandedMenus.includes(8) ? expandedMenus = expandedMenus.filter(i => i !== 8) : expandedMenus.push(8)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="calendar" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Attendance</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(8) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(8)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Student Attendance
                        </a>
                    </div>
                </div>

                <!-- QR Code Attendance -->
                <div>
                    <button
                        @click="expandedMenus.includes(9) ? expandedMenus = expandedMenus.filter(i => i !== 9) : expandedMenus.push(9)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="qr-code" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">QR Code Attendance</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(9) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(9)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            QR Attendance
                        </a>
                    </div>
                </div>

                <!-- Online Examinations -->
                <div>
                    <button
                        @click="expandedMenus.includes(10) ? expandedMenus = expandedMenus.filter(i => i !== 10) : expandedMenus.push(10)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="file-text" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Online Examinations</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(10) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(10)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Online Exams
                        </a>
                    </div>
                </div>

                <!-- Academics -->
                <div>
                    <button
                        @click="expandedMenus.includes(11) ? expandedMenus = expandedMenus.filter(i => i !== 11) : expandedMenus.push(11)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="graduation-cap" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Academics</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(11) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(11)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Class Timetable
                        </a>
                    </div>
                </div>

                <!-- Lesson Plan -->
                <div>
                    <button
                        @click="expandedMenus.includes(12) ? expandedMenus = expandedMenus.filter(i => i !== 12) : expandedMenus.push(12)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200">
                        <i data-lucide="book-marked" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Lesson Plan</span>
                        <i data-lucide="chevron-down" :class="expandedMenus.includes(12) ? '' : 'rotate-180'"
                            class="w-3 h-3 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(12)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Manage Lesson
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header -->
            <div class="bg-white border-b border-gray-200 px-4 py-2.5">
                <div class="flex items-center justify-between gap-4">

                    <!-- Left: Menu and School Name -->
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-700">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        <h1 class="text-green-600 text-lg font-semibold">Mount Carmel School</h1>
                    </div>

                    <!-- Center: Search -->
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" placeholder="Search By Student Name..."
                                class="w-full pr-10 bg-gray-50 border border-gray-300 rounded-md h-9 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <button
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-gray-700 hover:bg-gray-800 text-white p-1.5 rounded">
                                <i data-lucide="search" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Right: Action Icons -->
                    <div class="flex items-center gap-1">
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <img src="https://flagcdn.com/w40/us.png" alt="Language" class="w-5 h-5 rounded" />
                        </button>
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </button>
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </button>
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <i data-lucide="message-square" class="w-4 h-4"></i>
                        </button>
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </button>
                        <button
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                            <i data-lucide="bell" class="w-4 h-4"></i>
                        </button>

                        <!-- User Dropdown -->
                        <div x-data="{ userMenuOpen: false }" class="relative">
                            <button @click="userMenuOpen = !userMenuOpen"
                                class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-600">
                                <i data-lucide="user" class="w-4 h-4"></i>
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
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i data-lucide="settings" class="w-4 h-4 inline mr-2"></i>
                                    Settings
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
            <div class="flex-1 overflow-auto bg-gray-50">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });

        // Re-initialize icons after Alpine updates
        document.addEventListener('alpine:initialized', () => {
            setInterval(() => {
                lucide.createIcons();
            }, 100);
        });
    </script>

    @stack('scripts')
</body>

</html>
