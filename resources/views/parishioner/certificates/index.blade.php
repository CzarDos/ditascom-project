<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Certificates - DITASCOM</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-[#1a237e] px-6 py-3 flex justify-between items-center text-white h-[60px]">
        <a href="#" class="flex items-center gap-2 text-white no-underline font-semibold">
            <img class="w-10 h-10 mr-2" src="{{ asset('images/ditascom-logo.png') }}" alt="Logo"> 
            DITASCOM
        </a>
        <div class="flex items-center gap-4">
            <div class="relative group">
                <a href="#" class="text-white no-underline text-lg">
                    <i class="fas fa-user rounded-full border-2 border-white w-[30px] h-[30px] flex items-center justify-center"></i>
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

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="max-w-6xl mx-auto mt-4 sm:mt-8 px-4 pb-8">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('parishioner.dashboard') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium transition">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">
            <i class="fas fa-certificate text-blue-600"></i> My Certificates
        </h1>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($requests->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-8 sm:p-12 text-center">
                <i class="fas fa-inbox text-gray-300 text-5xl sm:text-6xl mb-4"></i>
                <p class="text-gray-600 text-base sm:text-lg mb-4">You don't have any certificate requests yet.</p>
                <a href="{{ route('parishioner.dashboard') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition text-sm sm:text-base">
                    <i class="fas fa-plus"></i> Request a Certificate
                </a>
            </div>
        @else
            <div class="grid gap-4">
                @foreach($requests as $request)
                    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 hover:shadow-md transition">
                        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-3">
                                    <h3 class="text-lg sm:text-xl font-semibold text-gray-800">
                                        {{ $request->certificate_type }}
                                    </h3>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        @if($request->status == 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($request->status == 'approved') bg-blue-100 text-blue-700
                                        @elseif($request->status == 'processing') bg-purple-100 text-purple-700
                                        @elseif($request->status == 'ready') bg-green-100 text-green-700
                                        @elseif($request->status == 'completed') bg-gray-100 text-gray-700
                                        @else bg-red-100 text-red-700
                                        @endif">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-sm text-gray-600">
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-user text-blue-600 mt-0.5"></i>
                                        <div>
                                            <strong>Name:</strong> {{ $request->first_name }} {{ $request->last_name }}
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-calendar text-blue-600 mt-0.5"></i>
                                        <div>
                                            <strong>Requested:</strong> {{ $request->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-clipboard text-blue-600 mt-0.5"></i>
                                        <div>
                                            <strong>Purpose:</strong> {{ $request->purpose }}
                                        </div>
                                    </div>
                                    @if($request->approved_at)
                                        <div class="flex items-start gap-2">
                                            <i class="fas fa-check text-green-600 mt-0.5"></i>
                                            <div>
                                                <strong>Approved:</strong> {{ $request->approved_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if($request->admin_remarks)
                                    <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                                        <p class="text-sm text-gray-700">
                                            <i class="fas fa-comment text-blue-600"></i>
                                            <strong>Admin Note:</strong> {{ $request->admin_remarks }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="lg:ml-6 flex flex-col sm:flex-row lg:flex-col gap-2 w-full lg:w-auto">
                                @if($request->status == 'ready' || $request->status == 'completed')
                                    @if($request->certificate_file_path)
                                        <a href="{{ route('parishioner.certificates.download', $request->id) }}" 
                                           class="bg-green-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-green-700 transition font-semibold text-center text-sm sm:text-base whitespace-nowrap">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        <a href="{{ asset('storage/' . $request->certificate_file_path) }}" 
                                           target="_blank"
                                           class="bg-blue-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-blue-700 transition font-semibold text-center text-sm sm:text-base whitespace-nowrap">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    @endif
                                @elseif($request->status == 'pending')
                                    <div class="text-center text-sm text-gray-500 py-3">
                                        <i class="fas fa-clock text-lg"></i><br>
                                        <span class="text-xs sm:text-sm">Waiting for approval</span>
                                    </div>
                                @elseif($request->status == 'approved' || $request->status == 'processing')
                                    <div class="text-center text-sm text-gray-500 py-3">
                                        <i class="fas fa-cog fa-spin text-lg"></i><br>
                                        <span class="text-xs sm:text-sm">Being processed</span>
                                    </div>
                                @elseif($request->status == 'declined')
                                    <div class="text-center text-sm text-red-600 py-3">
                                        <i class="fas fa-times-circle text-lg"></i><br>
                                        <span class="text-xs sm:text-sm">Request declined</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
