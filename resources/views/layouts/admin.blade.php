<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - DOT My Sacrament</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-[#1a237e] text-white h-16 px-6 flex items-center justify-between sticky top-0 z-40">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-semibold text-lg hover:opacity-90 transition">
            <img class="h-10 w-10" src="{{ asset('images/ditascom-logo.png') }}" alt="Logo"> 
            DOT My Sacrament
        </a>
        <div class="flex items-center gap-4">
            <div class="relative group">
                <button class="w-8 h-8 rounded-full border-2 border-white flex items-center justify-center hover:bg-white/10 transition">
                    <i class="fas fa-user text-sm"></i>
                </button>
                <div class="hidden group-hover:block absolute right-0 bg-white min-w-[160px] shadow-lg z-10 rounded-md">
                    <div class="px-4 py-2 border-b border-gray-200">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>


    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <div class="flex min-h-[calc(100vh-4rem)]">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 sticky top-16 h-[calc(100vh-4rem)] overflow-y-auto">
            <ul class="py-4">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-[#1a237e] transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-[#1a237e] font-medium' : '' }}">
                        <i class="fas fa-th-large w-5"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.subadmins.index') }}" 
                       class="flex items-center gap-3 px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-[#1a237e] transition {{ request()->routeIs('admin.subadmins.*') ? 'bg-indigo-50 text-[#1a237e] font-medium' : '' }}">
                        <i class="fas fa-church w-5"></i>
                        <span>Parish Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.ministers.index') }}" 
                       class="flex items-center gap-3 px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-[#1a237e] transition {{ request()->routeIs('admin.ministers.*') ? 'bg-indigo-50 text-[#1a237e] font-medium' : '' }}">
                        <i class="fas fa-user-tie w-5"></i>
                        <span>Minister Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.certificate-requests.index') }}" 
                       class="flex items-center gap-3 px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-[#1a237e] transition {{ request()->routeIs('admin.certificate-requests.*') ? 'bg-indigo-50 text-[#1a237e] font-medium' : '' }}">
                        <i class="fas fa-file-alt w-5"></i>
                        <span>Certificate Requests</span>
                    </a>
                </li>
                <li>
                    <button onclick="toggleCertificatesDropdown()" 
                            class="w-full flex items-center justify-between gap-3 px-6 py-3 text-gray-700 hover:bg-indigo-50 hover:text-[#1a237e] transition {{ request()->routeIs('admin.certificates.*') ? 'bg-indigo-50 text-[#1a237e] font-medium' : '' }}">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-certificate w-5"></i>
                            <span>Certificates</span>
                        </div>
                        <i class="fas fa-caret-down transition-transform" id="certificatesDropdownIcon"></i>
                    </button>
                    <ul id="certificatesDropdown" class="bg-gray-50 {{ request()->routeIs('admin.certificates.*') ? '' : 'hidden' }}">
                        <li>
                            <a href="{{ route('admin.certificates.baptism') }}" 
                               class="flex items-center gap-3 px-6 py-2 pl-14 text-gray-700 hover:bg-indigo-50 hover:text-[#1a237e] transition {{ request()->routeIs('admin.certificates.baptism') ? 'bg-indigo-100 text-[#1a237e] font-medium' : '' }}">
                                <i class="fas fa-chevron-right text-xs"></i>
                                <span>Baptism</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.certificates.confirmation') }}" 
                               class="flex items-center gap-3 px-6 py-2 pl-14 text-gray-700 hover:bg-indigo-50 hover:text-[#1a237e] transition {{ request()->routeIs('admin.certificates.confirmation') ? 'bg-indigo-100 text-[#1a237e] font-medium' : '' }}">
                                <i class="fas fa-chevron-right text-xs"></i>
                                <span>Confirmation</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.certificates.death') }}" 
                               class="flex items-center gap-3 px-6 py-2 pl-14 text-gray-700 hover:bg-indigo-50 hover:text-[#1a237e] transition {{ request()->routeIs('admin.certificates.death') ? 'bg-indigo-100 text-[#1a237e] font-medium' : '' }}">
                                <i class="fas fa-chevron-right text-xs"></i>
                                <span>Death</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleCertificatesDropdown() {
            const dropdown = document.getElementById('certificatesDropdown');
            const icon = document.getElementById('certificatesDropdownIcon');
            dropdown.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>
    @stack('scripts')
</body>
</html>
