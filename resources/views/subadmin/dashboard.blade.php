<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DITASCOM</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1a237e',
                        secondary: '#f5f6f8',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-['Inter'] bg-gray-100 flex flex-col h-screen overflow-hidden">
    <!-- Navbar -->
    <nav class="bg-primary px-6 py-3 flex justify-between items-center text-white h-[60px]">
        <a href="#" class="flex items-center gap-2 text-white no-underline font-semibold">
            <img class="w-10 h-10 mr-2" src="{{ asset('images/ditascom-logo.png') }}" alt="Logo"> 
            DITASCOM
        </a>
        <div class="flex items-center gap-4">
            <div class="relative group">
                <a href="#" class="text-white text-lg">
                    <i class="fas fa-user rounded-full border-2 border-white w-8 h-8 flex items-center justify-center"></i>
                </a>
                <div class="hidden group-hover:block absolute right-0 bg-white min-w-[160px] shadow-lg z-10 rounded-md">
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="text-gray-800 px-4 py-3 block text-sm hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Main Container -->
    <div class="flex h-[calc(100vh-60px)] overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white h-full border-r border-gray-300 overflow-y-auto">
            <div class="my-6 mx-4">
                <input type="text" placeholder="Search for requests, parishes, or users..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm">
            </div>
            
            <ul class="list-none">
                <li>
                    <a href="{{ route('subadmin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-800 no-underline text-sm transition-all bg-indigo-50 text-primary">
                        <i class="fas fa-th-large mr-3 w-5"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('subadmin.events') }}" class="flex items-center px-6 py-3 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-primary">
                        <i class="fas fa-calendar-alt mr-3 w-5"></i>
                        Events
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-6 py-3 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-primary">
                        <i class="fas fa-file-alt mr-3 w-5"></i>
                        Certificates
                    </a>
                    <ul class="list-none ml-6">
                        <li>
                            <a href="{{ route('subadmin.certificates.add', ['type' => 'baptismal']) }}" 
                               class="flex items-center px-6 py-2 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-primary">
                                <i class="fas fa-chevron-right mr-3 w-5"></i> Add Baptismal
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('subadmin.certificates.add', ['type' => 'death']) }}" 
                               class="flex items-center px-6 py-2 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-primary">
                                <i class="fas fa-chevron-right mr-3 w-5"></i> Add Death
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('subadmin.certificates.add', ['type' => 'confirmation']) }}" 
                               class="flex items-center px-6 py-2 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-primary">
                                <i class="fas fa-chevron-right mr-3 w-5"></i> Add Confirmation
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto h-full">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">Welcome back, {{ Auth::user()->name }}</h1>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Baptismal Certificate Card -->
                <div class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-3xl text-blue-500 mb-4">
                        <i class="fas fa-child"></i>
                    </div>
                    <div class="text-4xl font-semibold text-gray-800 mb-2">{{ $baptismalCount }}</div>
                    <div class="text-gray-600 text-sm">Baptismal Certificates</div>
                </div>

                <!-- Death Certificate Card -->
                <div class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-3xl text-gray-700 mb-4">
                        <i class="fas fa-cross"></i>
                    </div>
                    <div class="text-4xl font-semibold text-gray-800 mb-2">{{ $deathCount }}</div>
                    <div class="text-gray-600 text-sm">Death Certificates</div>
                </div>

                <!-- Confirmation Certificate Card -->
                <div class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-3xl text-purple-600 mb-4">
                        <i class="fas fa-dove"></i>
                    </div>
                    <div class="text-4xl font-semibold text-gray-800 mb-2">{{ $confirmationCount }}</div>
                    <div class="text-gray-600 text-sm">Confirmation Certificates</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="{{ route('subadmin.certificates.add', ['type' => 'baptismal']) }}" 
                       class="flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg transition-colors no-underline">
                        <i class="fas fa-plus"></i>
                        <span>Add Baptismal</span>
                    </a>
                    <a href="{{ route('subadmin.certificates.add', ['type' => 'death']) }}" 
                       class="flex items-center justify-center gap-2 bg-gray-700 hover:bg-gray-800 text-white px-4 py-3 rounded-lg transition-colors no-underline">
                        <i class="fas fa-plus"></i>
                        <span>Add Death</span>
                    </a>
                    <a href="{{ route('subadmin.certificates.add', ['type' => 'confirmation']) }}" 
                       class="flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg transition-colors no-underline">
                        <i class="fas fa-plus"></i>
                        <span>Add Confirmation</span>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="px-6 py-4 bg-white border-t border-gray-300 text-xs text-gray-600 flex justify-center h-[50px] " >
        <div>© 2024 DITASCOM. All rights reserved.</div>
    </footer>

    <script>
        // Toggle submenu visibility
        document.querySelectorAll('.nav-item').forEach(item => {
            const submenu = item.querySelector('.submenu');
            if (submenu) {
                item.querySelector('a').addEventListener('click', (e) => {
                    e.preventDefault();
                    submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
                });
            }
        });
    </script>
</body>
</html>
