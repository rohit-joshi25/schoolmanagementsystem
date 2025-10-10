<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart School - School Management System</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* Custom Styles */
        body {
            font-family: 'Poppins', sans-serif;
            color: #444;
        }

        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://placehold.co/1920x1080/004488/FFFFFF?text=Welcome+to+Smart+School');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Header Section -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="#" class="text-2xl font-bold text-blue-600">
                    <i class="fas fa-school mr-2"></i>SmartSchool
                </a>
                <nav class="hidden lg:flex items-center space-x-1">
                    <a href="#home"
                        class="px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Home</a>
                    <a href="#features"
                        class="px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300">Features</a>
                    <a href="#demo"
                        class="px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300">Demo</a>
                    <a href="#testimonials"
                        class="px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300">Testimonials</a>
                    <a href="#contact"
                        class="px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors duration-300">Contact</a>
                    <a href="#"
                        class="ml-4 px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition-colors duration-300">Buy
                        Now</a>
                    <a href="{{ route('login') }}"
                        class="ml-2 px-4 py-2 text-sm font-semibold text-blue-600 border border-blue-600 rounded-full hover:bg-blue-50 transition-colors duration-300">Login</a>
                </nav>
                <button id="mobile-menu-button" class="lg:hidden text-2xl text-gray-700">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t">
            <a href="#home" class="block px-4 py-3 text-gray-700 hover:bg-gray-100">Home</a>
            <a href="#features" class="block px-4 py-3 text-gray-700 hover:bg-gray-100">Features</a>
            <a href="#demo" class="block px-4 py-3 text-gray-700 hover:bg-gray-100">Demo</a>
            <a href="#testimonials" class="block px-4 py-3 text-gray-700 hover:bg-gray-100">Testimonials</a>
            <a href="#contact" class="block px-4 py-3 text-gray-700 hover:bg-gray-100">Contact</a>
            <div class="p-4 border-t">
                <a href="#"
                    class="block w-full text-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition-colors duration-300">Buy
                    Now</a>
                <a href="{{ route('login') }}"
                    class="block w-full text-center mt-2 px-4 py-2 text-sm font-semibold text-blue-600 border border-blue-600 rounded-full hover:bg-blue-50 transition-colors duration-300">Login</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="home" class="hero-section text-white py-20 md:py-32">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-4">Smart School for K12 Schools, High
                    Schools, & Colleges</h1>
                <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto mb-8">Beautifully Designed and
                    Intelligently Developed School Management System for the Best User Experience.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#demo"
                        class="px-8 py-3 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:bg-gray-200 transition-all duration-300 transform hover:scale-105">Try
                        Demo</a>
                    <a href="#"
                        class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">Buy
                        Now</a>
                    <a href="#"
                        class="px-8 py-3 bg-gray-700 text-white font-semibold rounded-full shadow-lg hover:bg-gray-800 transition-all duration-300 transform hover:scale-105">Help
                        / Docs</a>
                </div>
            </div>
        </section>

        <!-- Demo Links Section -->
        <section id="demo" class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-3">Try Smart School Demo</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mb-12">Experience the system from every perspective. Click on
                    any role to log in to our live demo.</p>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                    <a href="#"
                        class="p-4 border rounded-lg hover:shadow-lg hover:border-blue-500 transition-all duration-300">
                        <i class="fas fa-crown text-3xl text-red-500 mb-2"></i>
                        <span class="font-semibold block">Super Admin</span>
                    </a>
                    <a href="#"
                        class="p-4 border rounded-lg hover:shadow-lg hover:border-blue-500 transition-all duration-300">
                        <i class="fas fa-user-graduate text-3xl text-green-500 mb-2"></i>
                        <span class="font-semibold block">Student</span>
                    </a>
                    <a href="#"
                        class="p-4 border rounded-lg hover:shadow-lg hover:border-blue-500 transition-all duration-300">
                        <i class="fas fa-user-friends text-3xl text-purple-500 mb-2"></i>
                        <span class="font-semibold block">Parent</span>
                    </a>
                    <a href="#"
                        class="p-4 border rounded-lg hover:shadow-lg hover:border-blue-500 transition-all duration-300">
                        <i class="fas fa-chalkboard-teacher text-3xl text-orange-500 mb-2"></i>
                        <span class="font-semibold block">Teacher</span>
                    </a>
                    <a href="#"
                        class="p-4 border rounded-lg hover:shadow-lg hover:border-blue-500 transition-all duration-300">
                        <i class="fas fa-user-shield text-3xl text-blue-500 mb-2"></i>
                        <span class="font-semibold block">Admin</span>
                    </a>
                    <a href="#"
                        class="p-4 border rounded-lg hover:shadow-lg hover:border-blue-500 transition-all duration-300">
                        <i class="fas fa-calculator text-3xl text-teal-500 mb-2"></i>
                        <span class="font-semibold block">Accountant</span>
                    </a>
                    <a href="#"
                        class="p-4 border rounded-lg hover:shadow-lg hover:border-blue-500 transition-all duration-300">
                        <i class="fas fa-concierge-bell text-3xl text-indigo-500 mb-2"></i>
                        <span class="font-semibold block">Receptionist</span>
                    </a>
                    <a href="#"
                        class="p-4 border rounded-lg hover:shadow-lg hover:border-blue-500 transition-all duration-300">
                        <i class="fas fa-book-reader text-3xl text-yellow-500 mb-2"></i>
                        <span class="font-semibold block">Librarian</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 md:py-24">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold">Smart School at a Glance</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto mt-4">A complete School Management System with all the
                        features you need to run your institution smoothly.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div
                        class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                        <i class="fas fa-user-cog text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Student Information</h3>
                        <p class="text-gray-600">Manage all student data from admission to graduation in one
                            centralized place.</p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                        <i class="fas fa-money-check-alt text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Fees Management</h3>
                        <p class="text-gray-600">Automate fee collection, generate invoices, and manage dues with ease.
                        </p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                        <i class="fas fa-calendar-check text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Attendance</h3>
                        <p class="text-gray-600">Track student and staff attendance efficiently with insightful
                            reports.</p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                        <i class="fas fa-poll text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Examination</h3>
                        <p class="text-gray-600">Conduct exams, manage grades, and publish results online seamlessly.
                        </p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                        <i class="fas fa-book-open text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Academics</h3>
                        <p class="text-gray-600">Manage subjects, class timetables, and lesson plans effortlessly.</p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                        <i class="fas fa-comments text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Communication</h3>
                        <p class="text-gray-600">Send notices, alerts, and messages to students, parents, and staff.
                        </p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                        <i class="fas fa-chart-line text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Reports</h3>
                        <p class="text-gray-600">Generate over 100+ comprehensive reports for data-driven decisions.
                        </p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center">
                        <i class="fas fa-mobile-alt text-4xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Mobile App</h3>
                        <p class="text-gray-600">Access Smart School on the go with dedicated mobile apps for all
                            users.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold">What Our Clients Say</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto mt-4">We are trusted by hundreds of educational
                        institutions worldwide.</p>
                </div>
                <div class="grid lg:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm text-center">
                        <img src="https://placehold.co/100x100/E2E8F0/4A5568?text=User" alt="Client 1"
                            class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md">
                        <p class="text-gray-600 italic mb-4">"Smart School has revolutionized how we manage our
                            operations. It's incredibly user-friendly and the support team is fantastic."</p>
                        <h4 class="font-bold text-lg">John Doe</h4>
                        <p class="text-sm text-gray-500">Principal, Bright Future Academy</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm text-center">
                        <img src="https://placehold.co/100x100/E2E8F0/4A5568?text=User" alt="Client 2"
                            class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md">
                        <p class="text-gray-600 italic mb-4">"The fee management module alone has saved us countless
                            hours of administrative work. Highly recommended!"</p>
                        <h4 class="font-bold text-lg">Jane Smith</h4>
                        <p class="text-sm text-gray-500">Administrator, Global Knowledge School</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm text-center">
                        <img src="https://placehold.co/100x100/E2E8F0/4A5568?text=User" alt="Client 3"
                            class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-md">
                        <p class="text-gray-600 italic mb-4">"As a parent, I love the mobile app. I can track my
                            child's progress, attendance, and communicate with teachers easily."</p>
                        <h4 class="font-bold text-lg">Samuel Green</h4>
                        <p class="text-sm text-gray-500">Parent, City Public School</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-800 text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- About -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">About SmartSchool</h4>
                    <p class="text-gray-400 text-sm">SmartSchool is the most complete and versatile School Management
                        System on the market. We provide the best user experience and features.</p>
                    <div class="mt-4 flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><i
                                class="fab fa-facebook-f text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><i
                                class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><i
                                class="fab fa-linkedin-in text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors"><i
                                class="fab fa-youtube text-xl"></i></a>
                    </div>
                </div>
                <!-- Important Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Important Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#"
                                class="text-gray-400 hover:text-white text-sm transition-colors">Documentation</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-white text-sm transition-colors">Articles</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">FAQ</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-white text-sm transition-colors">Support</a></li>
                    </ul>
                </div>
                <!-- More Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Get Started</h4>
                    <ul class="space-y-2">
                        <li><a href="#demo" class="text-gray-400 hover:text-white text-sm transition-colors">Try
                                Demo</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Video
                                Tour</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Request
                                a Quote</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Buy
                                Now</a></li>
                    </ul>
                </div>
                <!-- Contact Us -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                            <span>123 Education Lane, Knowledge City, 456789</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3"></i>
                            <span>+91 123 456 7890</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3"></i>
                            <span>support@smartschool.in</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-6 text-center text-sm text-gray-500">
                <p>&copy; 2025 Smart School. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Mobile Menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                // Toggle icon
                const icon = mobileMenuButton.querySelector('i');
                if (mobileMenu.classList.contains('hidden')) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                } else {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                }
            });
        });
    </script>
</body>

</html>
