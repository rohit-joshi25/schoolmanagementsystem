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
                <!-- Dashboard -->
                <div>
                    <button
                        @click="expandedMenus.includes(0) ? expandedMenus = expandedMenus.filter(i => i !== 0) : expandedMenus.push(0)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(0) }">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Dashboard</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(0) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(0)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="{{ route('superadmin.dashboard') }}"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left {{ request()->routeIs('superadmin.dashboard') ? 'bg-[#16181e]' : '' }}">
                            Overview cards, charts
                        </a>
                    </div>
                </div>

                <!-- Schools Management -->
                @php $isSchoolMenuOpen = Str::startsWith(Route::currentRouteName(), 'superadmin.schools'); @endphp
                <div>
                    <button
                        @click="expandedMenus.includes(1) ? expandedMenus = expandedMenus.filter(i => i !== 1) : expandedMenus.push(1)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(1) }">
                        <i data-lucide="school" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Schools Management</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(1) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(1)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="{{ route('superadmin.schools.create') }}"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left {{ request()->routeIs('superadmin.schools.create') ? 'bg-[#16181e]' : '' }}">
                            Add New School
                        </a>
                        <a href="{{ route('superadmin.schools.index') }}"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left {{ request()->routeIs('superadmin.schools.index') ? 'bg-[#16181e]' : '' }}">
                            School List
                        </a>
                        <a href="{{ route('superadmin.schools.index') }}"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left {{ Route::is('superadmin.schools.index') ? 'sidebar-link-active' : '' }}">
                            School Login (Impersonate)
                        </a>
                        <a href="{{ route('superadmin.schools.index') }}"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left {{ Route::is('superadmin.schools.index') ? 'sidebar-link-active' : '' }}">
                            School Branches
                        </a>
                    </div>
                </div>

                <!-- Subscription Plans -->
                <div>
                    <button
                        @click="expandedMenus.includes(2) ? expandedMenus = expandedMenus.filter(i => i !== 2) : expandedMenus.push(2)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(2) }">
                        <i data-lucide="gem" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Subscription Plans</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(2) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(2)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="{{ route('superadmin.plans.index') }}"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left {{ request()->routeIs('superadmin.plans.*') ? 'bg-[#16181e]' : '' }}">
                            Create/Edit/Delete Plan
                        </a>
                        <a href="{{ route('superadmin.subscriptions.create') }}"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Assign Plan to School
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Upgrade/Downgrade
                        </a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Renewal History
                        </a>
                    </div>
                </div>

                <!-- Payments & Billing -->
                <div>
                    <button
                        @click="expandedMenus.includes(3) ? expandedMenus = expandedMenus.filter(i => i !== 3) : expandedMenus.push(3)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(3) }">
                        <i data-lucide="dollar-sign" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Payments & Billing</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(3) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(3)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Invoices</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Payment
                            Gateways</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Commission
                            & Earnings</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Payment
                            Logs</a>
                    </div>
                </div>

                <!-- Modules Control -->
                <div>
                    <button
                        @click="expandedMenus.includes(4) ? expandedMenus = expandedMenus.filter(i => i !== 4) : expandedMenus.push(4)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(4) }">
                        <i data-lucide="sliders-horizontal" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Modules Control</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(4) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(4)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">
                            Enable/Disable modules per plan</a>
                    </div>
                </div>

                <!-- Analytics -->
                <div>
                    <button
                        @click="expandedMenus.includes(5) ? expandedMenus = expandedMenus.filter(i => i !== 5) : expandedMenus.push(5)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(5) }">
                        <i data-lucide="bar-chart-2" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Analytics</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(5) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(5)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Revenue
                            Report</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Tenant
                            Growth</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Storage
                            Usage</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">API
                            usage</a>
                    </div>
                </div>

                <!-- Communication -->
                <div>
                    <button
                        @click="expandedMenus.includes(6) ? expandedMenus = expandedMenus.filter(i => i !== 6) : expandedMenus.push(6)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(6) }">
                        <i data-lucide="message-square" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Communication</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(6) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(6)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Send
                            Global Notice</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Send
                            Email/SMS to All Tenants</a>
                    </div>
                </div>

                <!-- Support Tickets -->
                <div>
                    <button
                        @click="expandedMenus.includes(7) ? expandedMenus = expandedMenus.filter(i => i !== 7) : expandedMenus.push(7)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(7) }">
                        <i data-lucide="life-buoy" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Support Tickets</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(7) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(7)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">All
                            Tickets</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Assign
                            Staff</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Close/Reply</a>
                    </div>
                </div>

                <!-- System Settings -->
                <div>
                    <button
                        @click="expandedMenus.includes(8) ? expandedMenus = expandedMenus.filter(i => i !== 8) : expandedMenus.push(8)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(8) }">
                        <i data-lucide="settings" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">System Settings</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(8) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(8)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">SMTP,
                            SMS, Payment Gateways</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Backup
                            Configuration</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Branding</a>
                    </div>
                </div>

                <!-- Admin Management -->
                <div>
                    <button
                        @click="expandedMenus.includes(9) ? expandedMenus = expandedMenus.filter(i => i !== 9) : expandedMenus.push(9)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(9) }">
                        <i data-lucide="user-cog" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Admin Management</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(9) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(9)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Add
                            Staff</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Roles
                            & Permissions</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Audit
                            Logs</a>
                    </div>
                </div>

                <!-- Backups -->
                <div>
                    <button
                        @click="expandedMenus.includes(10) ? expandedMenus = expandedMenus.filter(i => i !== 10) : expandedMenus.push(10)"
                        class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                        :class="{ 'bg-[#1f2229]': expandedMenus.includes(10) }">
                        <i data-lucide="database-backup" class="w-4 h-4 flex-shrink-0"></i>
                        <span class="text-sm truncate flex-1 text-left">Backups</span>
                        <i data-lucide="chevron-right" :class="expandedMenus.includes(10) ? 'rotate-90' : ''"
                            class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                    </button>
                    <div x-show="expandedMenus.includes(10)" x-collapse class="bg-[#1f2229] overflow-hidden">
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Manual
                            Backup</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">View
                            Schedule</a>
                        <a href="#"
                            class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left">Restore
                            Points</a>
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
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="hidden">
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
