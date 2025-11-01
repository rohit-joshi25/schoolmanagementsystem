<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(Auth::user()->school->name ?? 'School Dashboard'); ?> - School Admin</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Collapse Plugin -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

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

        .sidebar-link-active {
            background-color: #16181e;
            color: #facc15;
        }
    </style>
</head>

<body class="bg-gray-50" x-data="{ sidebarOpen: window.innerWidth > 1024, expandedMenus: [] }" x-init="expandedMenus = <?php echo e(json_encode($activeMenus ?? [])); ?>">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="bg-[#2a2d3a] text-white w-64 flex flex-col h-screen fixed lg:relative z-50 transition-transform duration-300 ease-in-out">
            <div class="bg-[#1f2229] p-3 flex items-center justify-center gap-2 h-14">
                <?php if(Auth::user()->school && Auth::user()->school->logo_path): ?>
                    <img src="<?php echo e(asset('storage/' . Auth::user()->school->logo_path)); ?>" alt="School Logo"
                        class="h-10 object-contain">
                <?php else: ?>
                    <div class="bg-yellow-400 px-2 py-1 rounded flex items-center justify-center">
                        <span
                            class="text-[10px] text-black uppercase tracking-wide font-semibold"><?php echo e(Auth::user()->school->name ?? 'School'); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="bg-[#1f2229] px-3 py-2 text-xs border-t border-gray-700">
                <div>Current Session: 2025-26</div>
            </div>
            <!-- Navigation Items -->
            <div class="flex-1 overflow-y-auto py-2 custom-scrollbar">
                <?php
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
                                ['title' => 'Classes & Sections', 'route' => 'school-superadmin.classes.index'],
                                ['title' => 'Subjects', 'route' => 'school-superadmin.subjects.index'],
                                ['title' => 'Assign Teachers', 'route' => 'school-superadmin.assign-teachers.index'],
                                ['title' => 'Timetable', 'route' => 'school-superadmin.timetable.index'],
                                ['title' => 'Syllabus', 'route' => 'school-superadmin.syllabus.index'],
                            ],
                        ],
                        [
                            'id' => 3,
                            'title' => 'Students',
                            'icon' => 'users',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Admission', 'route' => 'school-superadmin.students.create'],
                                ['title' => 'Student List', 'route' => 'school-superadmin.students.index'],
                                ['title' => 'Promotion', 'route' => 'school-superadmin.students.promotion.index'],
                                ['title' => 'Attendance', 'route' => 'school-superadmin.students.attendance.index'],
                                ['title' => 'Leave Requests', 'route' => 'school-superadmin.leave-requests.index'],
                                ['title' => 'Certificates', 'route' => 'school-superadmin.certificates.index'],
                            ],
                        ],
                        [
                            'id' => 4,
                            'title' => 'Teachers',
                            'icon' => 'user-check',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Add Teacher', 'route' => 'school-superadmin.staff.create'],
                                [
                                    'title' => 'Teacher Attendance',
                                    'route' => 'school-superadmin.teachers.attendance.index',
                                ],
                                ['title' => 'Assign Subjects', 'route' => 'school-superadmin.assign-teachers.index'],
                                ['title' => 'Payroll', 'route' => 'school-superadmin.payroll.index'],
                                ['title' => 'Performance', 'route' => 'school-superadmin.performance.index'],
                            ],
                        ],
                        [
                            'id' => 5,
                            'title' => 'Parents',
                            'icon' => 'heart-handshake',
                            'route' => null,
                            'active' => 'school-superadmin.parents.*',
                            'sub' => [
                                [
                                    'title' => 'Parent List',
                                    'route' => 'school-superadmin.parents.index',
                                    'active' => 'school-superadmin.parents.index',
                                ],
                                [
                                    'title' => 'Linked Students',
                                    'route' => 'school-superadmin.parents.index',
                                    'active' => 'school-superadmin.parents.index',
                                ],
                                [
                                    'title' => 'Communication',
                                    'route' => 'school-superadmin.parents.index',
                                    'active' => 'school-superadmin.parents.index',
                                ],
                            ],
                        ],
                        [
                            'id' => 6,
                            'title' => 'Fees Management',
                            'icon' => 'dollar-sign',
                            'route' => null,
                            'sub' => [
                                [
                                    'title' => 'Fee Groups',
                                    'route' => 'school-superadmin.fee-groups.index',
                                    'active' => 'school-superadmin.fee-groups.*',
                                ],
                                [
                                    'title' => 'Fee Types',
                                    'route' => 'school-superadmin.fee-types.index',
                                    'active' => 'school-superadmin.fee-types.*',
                                ],
                                [
                                    'title' => 'Fee Allocation',
                                    'route' => 'school-superadmin.fee-allocations.index',
                                    'active' => 'school-superadmin.fee-allocations.*',
                                ],
                                [
                                    'title' => 'Payment Collection',
                                    'route' => 'school-superadmin.payment-collection.index',
                                    'active' => 'school-superadmin.payment-collection.*',
                                ],
                                [
                                    'title' => 'Discounts/Fines',
                                    'route' => 'school-superadmin.fee-adjustments.index',
                                    'active' => 'school-superadmin.fee-adjustments.*',
                                ],
                                [
                                    'title' => 'Reports',
                                    'route' => 'school-superadmin.fee-reports.index',
                                    'active' => 'school-superadmin.fee-reports.*',
                                ],
                            ],
                        ],
                        [
                            'id' => 7,
                            'title' => 'Income/Expense',
                            'icon' => 'arrow-left-right',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Add Income', 'route' => 'school-superadmin.transactions.create_income'],
                                ['title' => 'Add Expense', 'route' => 'school-superadmin.transactions.create_expense'],
                                ['title' => 'Categories', 'route' => 'school-superadmin.categories.index'],
                                ['title' => 'Reports', 'route' => 'school-superadmin.transactions.index'],
                            ],
                        ],
                        [
                            'id' => 8,
                            'title' => 'Library',
                            'icon' => 'library',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Books', 'route' => 'school-superadmin.books.index'],
                                ['title' => 'Issue/Return', 'route' => 'school-superadmin.book-issues.index'],
                                ['title' => 'Fine', 'route' => 'school-superadmin.library-fines.index'],
                                ['title' => 'Stock Report', 'route' => 'school-superadmin.books.report'],
                            ],
                        ],
                        [
                            'id' => 9,
                            'title' => 'Examinations',
                            'icon' => 'file-text',
                            'route' => null,
                            'sub' => [
                                ['title' => 'Exam Setup', 'route' => 'school-superadmin.exams.index'],
                                ['title' => 'Grade System', 'route' => 'school-superadmin.grade-systems.index'],
                                ['title' => 'Marks Entry', 'route' => 'school-superadmin.marks-entry.index'],
                                ['title' => 'Report Cards', 'route' => 'school-superadmin.report-cards.index'],
                                ['title' => 'Analytics', 'route' => 'school-superadmin.exam-analytics.index'],
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
                                ['title' => 'Notice Board', 'route' => 'school-superadmin.notices.index'],
                                ['title' => 'Email/SMS', 'route' => 'school-superadmin.communication.index'],
                                ['title' => 'Communication Settings', 'route' => 'school-superadmin.communication-settings.index'],
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
                                ['title' => 'Transfer Certificate', 'route' => 'school-superadmin.certificates.transfer.index'],
                                ['title' => 'ID Card', 'route' => 'school-superadmin.certificates.id-card'],
                                ['title' => 'Custom Certificates', 'route' => 'school-superadmin.certificates.custom-certificate'],
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
                ?>

                <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <?php if(count($menu['sub']) > 0): ?>
                            <button
                                @click="expandedMenus.includes(<?php echo e($menu['id']); ?>) ? expandedMenus = expandedMenus.filter(i => i !== <?php echo e($menu['id']); ?>) : expandedMenus.push(<?php echo e($menu['id']); ?>)"
                                class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] transition-all duration-200"
                                :class="{ 'bg-[#1f2229]': expandedMenus.includes(<?php echo e($menu['id']); ?>) }">
                                <i data-lucide="<?php echo e($menu['icon']); ?>" class="w-4 h-4 flex-shrink-0"></i>
                                <span class="text-sm truncate flex-1 text-left"><?php echo e($menu['title']); ?></span>
                                <i data-lucide="chevron-right"
                                    :class="expandedMenus.includes(<?php echo e($menu['id']); ?>) ? 'rotate-90' : ''"
                                    class="w-4 h-4 flex-shrink-0 transition-transform duration-300"></i>
                            </button>
                            <div x-show="expandedMenus.includes(<?php echo e($menu['id']); ?>)" x-collapse
                                class="bg-[#1f2229] overflow-hidden">
                                <?php $__currentLoopData = $menu['sub']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($submenu['route'] != '#' ? route($submenu['route']) : '#'); ?>"
                                        class="block w-full px-3 py-2 pl-11 text-sm hover:bg-[#16181e] transition-colors text-gray-300 text-left <?php echo e(request()->routeIs($submenu['route']) ? 'sidebar-link-active' : ''); ?>">
                                        <?php echo e($submenu['title']); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo e(route($menu['route'])); ?>"
                                class="w-full px-3 py-2.5 flex items-center gap-3 hover:bg-[#1f2229] <?php echo e(request()->routeIs($menu['route']) ? 'sidebar-link-active' : ''); ?>">
                                <i data-lucide="<?php echo e($menu['icon']); ?>" class="w-4 h-4"></i>
                                <span class="text-sm"><?php echo e($menu['title']); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <?php echo e(Auth::user()->school->name ?? 'School'); ?>

                        </h1>
                    </div>
                    
                    <div x-data="{ userMenuOpen: false }" class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 p-1">
                            <img src="https://placehold.co/32x32/E2E8F0/4A5568?text=SA" alt="User"
                                class="w-8 h-8 rounded-full" />
                            <div class="text-left hidden md:block">
                                <div class="text-xs font-semibold"><?php echo e(Auth::user()->name); ?></div>
                                <div class="text-[10px] text-gray-500">School Superadmin</div>
                            </div>
                        </button>
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak
                            class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                            <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                <div class="font-semibold"><?php echo e(Auth::user()->name); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e(Auth::user()->email); ?></div>
                            </div>

                            
                            
                            <?php if(session('impersonating_by_superadmin')): ?>
                                <a href="<?php echo e(route('impersonate.stop')); ?>"
                                    class="block px-4 py-2 text-sm text-blue-700 font-semibold hover:bg-gray-100">
                                    <i data-lucide="arrow-left-circle" class="w-4 h-4 inline mr-2"></i>
                                    Back to Superadmin
                                </a>
                            <?php endif; ?>

                            <a href="<?php echo e(route('logout')); ?>"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                <i data-lucide="log-out" class="w-4 h-4 inline mr-2"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden">
                                <?php echo csrf_field(); ?>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-auto bg-gray-50">
                <div class="p-4 md:p-6">
                    <?php echo $__env->yieldContent('content'); ?>
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
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\sms\resources\views/layouts/school-superadmin.blade.php ENDPATH**/ ?>