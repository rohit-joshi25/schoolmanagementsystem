<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Auth::user()->school->name ?? 'School Dashboard' }} - School Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-link-active {
            background-color: #16181e;
            color: #facc15;
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

        /* Add other styles from your superadmin layout */
    </style>
</head>

<body class="bg-gray-50" x-data="{ sidebarOpen: window.innerWidth > 1024, expandedMenus: [] }" x-init="expandedMenus = {{ json_encode($activeMenus ?? []) }}">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="bg-[#2a2d3a] text-white w-64 flex flex-col h-screen fixed lg:relative z-50 transition-transform duration-300 ease-in-out">
            <div class="bg-[#1f2229] p-3 flex items-center justify-center gap-2 h-14">
                @if (Auth::user()->school && Auth::user()->school->logo_path)
                    <img src="{{ asset('storage/' . Auth::user()->school->logo_path) }}" alt="School Logo"
                        class="h-10 object-contain">
                @else
                    <div class="bg-yellow-400 px-2 py-1 rounded flex items-center justify-center">
                        <span
                            class="text-[10px] text-black uppercase tracking-wide font-semibold">{{ Auth::user()->school->name ?? 'School' }}</span>
                    </div>
                @endif
            </div>
            <div class="bg-[#1f2229] px-3 py-2 text-xs border-t border-gray-700">
                <div>Current Session: 2025-26</div>
            </div>
            <!-- Navigation Items -->
            <div class="flex-1 overflow-y-auto py-2 custom-scrollbar">
                @php
                    $menuItems = [
                        [
                            'id' => 0,
                            'title' => 'Dashboard',
                            'icon' => 'layout-dashboard',
                            'route' => 'school-superadmin.dashboard',
                            'sub' => [
                                ['title' => 'Overview Cards', 'route' => '#'],
                                ['title' => 'Fee Collection Graph', 'route' => '#'],
                                ['title' => 'Attendance Trend', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 1,
                            'title' => 'Branches (Standard Plan)',
                            'icon' => 'git-branch',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Add/Edit Branch', 'route' => 'school-superadmin.branches.create'],
                                ['title' => 'Branch List', 'route' => 'school-superadmin.branches.index'],
                                ['title' => 'Assign Staff', 'route' => 'school-superadmin.staff.index'],
                                ['title' => 'Branch-wise Settings', 'route' => 'school-superadmin.branches.settings'],
                            ],
                        ],
                        [
                            'id' => 2,
                            'title' => 'Academics',
                            'icon' => 'book-open',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Classes & Sections', 'route' => '#'],
                                ['title' => 'Subjects', 'route' => '#'],
                                ['title' => 'Assign Teachers', 'route' => '#'],
                                ['title' => 'Timetable', 'route' => '#'],
                                ['title' => 'Syllabus', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 3,
                            'title' => 'Students',
                            'icon' => 'users',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Admission', 'route' => '#'],
                                ['title' => 'Student List', 'route' => '#'],
                                ['title' => 'Promotion', 'route' => '#'],
                                ['title' => 'Attendance', 'route' => '#'],
                                ['title' => 'Leave Requests', 'route' => '#'],
                                ['title' => 'Certificates', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 4,
                            'title' => 'Teachers',
                            'icon' => 'user-check',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Add Teacher', 'route' => '#'],
                                ['title' => 'Teacher Attendance', 'route' => '#'],
                                ['title' => 'Assign Subjects', 'route' => '#'],
                                ['title' => 'Payroll', 'route' => '#'],
                                ['title' => 'Performance', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 5,
                            'title' => 'Parents',
                            'icon' => 'heart-handshake',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Parent List', 'route' => '#'],
                                ['title' => 'Linked Students', 'route' => '#'],
                                ['title' => 'Communication', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 6,
                            'title' => 'Fees Management',
                            'icon' => 'dollar-sign',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Fee Groups', 'route' => '#'],
                                ['title' => 'Fee Types', 'route' => '#'],
                                ['title' => 'Fee Allocation', 'route' => '#'],
                                ['title' => 'Payment Collection', 'route' => '#'],
                                ['title' => 'Discounts/Fines', 'route' => '#'],
                                ['title' => 'Reports', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 7,
                            'title' => 'Income/Expense',
                            'icon' => 'arrow-left-right',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Add Income', 'route' => '#'],
                                ['title' => 'Add Expense', 'route' => '#'],
                                ['title' => 'Categories', 'route' => '#'],
                                ['title' => 'Reports', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 8,
                            'title' => 'Library',
                            'icon' => 'library',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Books', 'route' => '#'],
                                ['title' => 'Issue/Return', 'route' => '#'],
                                ['title' => 'Fine', 'route' => '#'],
                                ['title' => 'Stock Report', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 9,
                            'title' => 'Examinations',
                            'icon' => 'file-text',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Exam Setup', 'route' => '#'],
                                ['title' => 'Grade System', 'route' => '#'],
                                ['title' => 'Marks Entry', 'route' => '#'],
                                ['title' => 'Report Cards', 'route' => '#'],
                                ['title' => 'Analytics', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 10,
                            'title' => 'Homework & Study Material',
                            'icon' => 'book',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Upload Homework', 'route' => '#'],
                                ['title' => 'Submission Tracking', 'route' => '#'],
                                ['title' => 'Shared Notes', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 11,
                            'title' => 'Transport',
                            'icon' => 'bus',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Vehicles', 'route' => '#'],
                                ['title' => 'Routes', 'route' => '#'],
                                ['title' => 'Drivers', 'route' => '#'],
                                ['title' => 'Fees', 'route' => '#'],
                                ['title' => 'Tracking', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 12,
                            'title' => 'Hostel',
                            'icon' => 'home',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Hostel Rooms', 'route' => '#'],
                                ['title' => 'Bed Allocation', 'route' => '#'],
                                ['title' => 'Fees', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 13,
                            'title' => 'Human Resource',
                            'icon' => 'users-2',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Staff Directory', 'route' => '#'],
                                ['title' => 'Payroll', 'route' => '#'],
                                ['title' => 'Attendance', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 14,
                            'title' => 'Communication',
                            'icon' => 'message-square',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Notice Board', 'route' => '#'],
                                ['title' => 'Email/SMS', 'route' => '#'],
                                ['title' => 'Push Notifications', 'route' => '#'],
                                ['title' => 'WhatsApp', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 15,
                            'title' => 'Certificates',
                            'icon' => 'award',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Transfer Certificate', 'route' => '#'],
                                ['title' => 'ID Card', 'route' => '#'],
                                ['title' => 'Custom Certificates', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 16,
                            'title' => 'Reports & Analytics',
                            'icon' => 'bar-chart-2',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Attendance Reports', 'route' => '#'],
                                ['title' => 'Fee Reports', 'route' => '#'],
                                ['title' => 'Exam Analytics', 'route' => '#'],
                                ['title' => 'Teacher Performance', 'route' => '#'],
                                ['title' => 'Income/Expense', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 17,
                            'title' => 'Settings',
                            'icon' => 'settings',
                            'route' => 'school-superadmin.settings.index',
                            'sub' => [
                                ['title' => 'School Profile', 'route' => 'school-superadmin.settings.index'],
                                ['title' => 'Logo & Branding', 'route' => '#'],
                                ['title' => 'Payment Gateways', 'route' => '#'],
                                ['title' => 'SMS/Email Config', 'route' => '#'],
                                ['title' => 'Backup', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 18,
                            'title' => 'Subscription',
                            'icon' => 'gem',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Current Plan Details', 'route' => '#'],
                                ['title' => 'Upgrade/Renew Plan', 'route' => '#'],
                                ['title' => 'Payment History', 'route' => '#'],
                            ],
                        ],
                        [
                            'id' => 19,
                            'title' => 'Support',
                            'icon' => 'life-buoy',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Raise Ticket', 'route' => '#'],
                                ['title' => 'Chat with Support', 'route' => '#'],
                            ],
                        ],
                    ];
                @endphp

                @foreach ($menuItems as $menu)
                    <div>
                        @if (count($menu['sub']) > 0)
                            <button
                                @click="expandedMenus.includes({{ $menu['id'] }}) ? expandedMenus = expandedMenus.filter(i => i !== {{ $menu['id'] }}) : expandedMenus.push({{ $menu['id'] }})"
                                class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                                :class="{ 'bg-[#1f2229]': expandedMenus.includes({{ $menu['id'] }}) }">
                                <i data-lucide="{{ $menu['icon'] }}" class="w-4 h-4 flex-shrink-0"></i>
                                <span class="text-sm truncate flex-1 text-left">{{ $menu['title'] }}</span>
                                <i data-lucide="chevron-right"
                                    :class="expandedMenus.includes({{ $menu['id'] }}) ? 'rotate-90' : ''"
                                    class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                            </button>
                            <div x-show="expandedMenus.includes({{ $menu['id'] }})" x-collapse
                                class="bg-[#1f2229] overflow-hidden">
                                @foreach ($menu['sub'] as $submenu)
                                    <a href="{{ $submenu['route'] != '#' ? route($submenu['route']) : '#' }}"
                                        class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left {{ request()->routeIs($submenu['route']) ? 'sidebar-link-active' : '' }}">
                                        {{ $submenu['title'] }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <a href="{{ route($menu['route']) }}"
                                class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] {{ request()->routeIs($menu['route']) ? 'sidebar-link-active' : '' }}">
                                <i data-lucide="{{ $menu['icon'] }}" class="w-4 h-4"></i>
                                <span class="text-sm">{{ $menu['title'] }}</span>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white border-b px-4 py-2.5 h-14">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="h-8 w-8 inline-flex items-center justify-center rounded hover:bg-gray-100 text-gray-700">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        <h1 class="text-green-600 text-lg font-semibold">
                            {{ Auth::user()->school->name ?? 'School' }}
                        </h1>
                    </div>
                    {{-- User Dropdown --}}
                    <div x-data="{ userMenuOpen: false }" class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 p-1">
                            <img src="https://placehold.co/32x32/E2E8F0/4A5568?text=SA" alt="User"
                                class="w-8 h-8 rounded-full" />
                            <div class="text-left hidden md:block">
                                <div class="text-xs font-semibold">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-gray-500">School Superadmin</div>
                            </div>
                        </button>
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak
                            class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                            <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                            </div>

                            {{-- ** THIS IS THE FIX ** --}}
                            {{-- This link only shows if an impersonation session is active --}}
                            @if (session('impersonating_by_superadmin'))
                                <a href="{{ route('impersonate.stop') }}"
                                    class="block px-4 py-2 text-sm text-blue-700 font-semibold hover:bg-gray-100">
                                    <i data-lucide="arrow-left-circle" class="w-4 h-4 inline mr-2"></i>
                                    Back to Superadmin
                                </a>
                            @endif

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
            </header>
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
    <script>
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                // Use Alpine's global store or direct data manipulation
                document.querySelector('[x-data]').__x.data.sidebarOpen = true;
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
