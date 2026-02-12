<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Requests - DOT My Sacrament</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Shepherd.js for Onboarding Tour -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@11.2.0/dist/css/shepherd.css"/>
    <link rel="stylesheet" href="{{ asset('css/onboarding-tour.css') }}">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col" style="font-family: 'Inter', sans-serif;">
    <!-- Navbar -->
    <nav class="bg-[#1a237e] px-6 py-3 flex justify-between items-center text-white h-[60px]">
        <a href="#" class="flex items-center gap-2 text-white no-underline font-semibold">
            <img class="w-10 h-10 mr-2" src="{{ asset('images/ditascom-logo.png') }}" alt="Logo"> 
            DOT My Sacrament
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

    <div class="flex flex-1 flex-col lg:flex-row">
        <aside class="w-full lg:w-64 bg-white p-4 lg:p-6 border-b lg:border-b-0 lg:border-r border-gray-200">
            <div class="mb-6">
                <h3 class="text-sm text-gray-500 uppercase tracking-wider mb-4">Quick Stats</h3>
                <div class="grid grid-cols-3 lg:grid-cols-1 gap-3">
                    <div class="p-3 lg:p-4 rounded-lg bg-sky-100">
                        <div class="text-lg lg:text-2xl font-semibold mb-1 text-blue-900">{{ $requests->count() }}</div>
                        <div class="text-gray-600 text-xs lg:text-sm">Total Requests</div>
                    </div>
                    <div class="p-3 lg:p-4 rounded-lg bg-amber-100">
                        <div class="text-lg lg:text-2xl font-semibold mb-1 text-blue-900">{{ $requests->where('status', 'pending')->count() }}</div>
                        <div class="text-gray-600 text-xs lg:text-sm">Pending</div>
                    </div>
                    <div class="p-3 lg:p-4 rounded-lg bg-emerald-100">
                        <div class="text-lg lg:text-2xl font-semibold mb-1 text-blue-900">{{ $requests->whereIn('status', ['ready', 'completed'])->count() }}</div>
                        <div class="text-gray-600 text-xs lg:text-sm">Ready/Completed</div>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 p-4 lg:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 lg:mb-8 gap-4">
                <h1 class="m-0 text-xl lg:text-2xl font-semibold text-gray-900">My Requests</h1>
                <div class="flex gap-2 w-full sm:w-auto">
                    <a href="{{ route('parishioner.certificates.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md no-underline flex items-center gap-2 text-sm font-medium flex-1 sm:flex-initial justify-center">
                        <i class="fas fa-certificate"></i>
                        My Certificates
                    </a>
                    <a href="/parishioner/request/new" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-md no-underline flex items-center gap-2 text-sm font-medium flex-1 sm:flex-initial justify-center">
                        <i class="fas fa-plus"></i>
                        New Request
                    </a>
                </div>
            </div>

            <!-- Info message about paid requests only -->
            <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                <div class="text-sm text-blue-800">
                    <strong>Note:</strong> Only paid certificate requests are shown here. If you didn't complete the payment, your request won't appear in this list.
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 lg:gap-4 mb-6 lg:mb-8">
                <div class="flex-1 relative">
                    <input type="text" id="searchInput" placeholder="Search requests..." class="w-full py-3 px-4 border border-gray-200 rounded-md text-sm bg-white" />
                </div>
                <div class="relative">
                    <select id="statusFilter" class="w-full sm:w-auto py-3 px-4 pr-10 border border-gray-200 rounded-md text-sm bg-white cursor-pointer appearance-none font-medium">
                        <option value="all" selected>
                            <i class="fas fa-list"></i> All Requests
                        </option>
                        <option value="pending">
                            ⏰ Pending
                        </option>
                        <option value="processing">
                            ⚙️ Processing
                        </option>
                        <option value="ready">
                            📥 Ready
                        </option>
                        <option value="completed">
                            ✅ Completed
                        </option>
                        <option value="declined">
                            ❌ Declined
                        </option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-600">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 lg:gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                @forelse($requests as $req)
                <div class="bg-white rounded-xl p-4 lg:p-6 shadow request-card" data-status="{{ $req->status }}" data-search="{{ strtolower($req->certificate_type . ' ' . $req->id) }}">
                    <div class="flex justify-between items-start mb-4">
                        <span class="font-semibold text-base text-gray-900">{{ $req->certificate_type }}</span>
                        <i class="fas fa-ellipsis-h text-gray-500 cursor-pointer p-1"></i>
                    </div>
                    <div class="text-gray-500 text-sm mb-2">{{ $req->created_at->format('M d, Y') }}</div>
                    <div class="text-gray-500 text-sm mb-2">Request ID: REQ-{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="text-gray-500 text-sm mb-4">Last Updated: {{ $req->updated_at->diffForHumans() }}</div>
                    <div class="text-gray-500 text-sm mb-2">
                        @if($req->status == 'pending')
                            Progress
                        @elseif($req->status == 'approved')
                            Approved - Processing Soon
                        @elseif($req->status == 'processing')
                            Processing Certificate
                        @elseif($req->status == 'ready')
                            Ready for Download
                        @elseif($req->status == 'completed')
                            Completed
                        @elseif($req->status == 'declined')
                            Request Declined
                        @endif
                    </div>
                    <div class="w-full h-1.5 bg-gray-200 rounded overflow-hidden mb-4">
                        <div class="h-full rounded transition-all duration-300 
                            @if($req->status == 'pending') bg-amber-500
                            @elseif($req->status == 'approved') bg-blue-500
                            @elseif($req->status == 'processing') bg-purple-500
                            @elseif($req->status == 'ready') bg-green-500
                            @elseif($req->status == 'completed') bg-gray-500
                            @else bg-rose-500
                            @endif" 
                            style="width: 
                            @if($req->status == 'pending') 20%
                            @elseif($req->status == 'approved') 40%
                            @elseif($req->status == 'processing') 60%
                            @elseif($req->status == 'ready') 80%
                            @elseif($req->status == 'completed') 100%
                            @else 100%
                            @endif"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium 
                            @if($req->status == 'pending') bg-amber-100 text-amber-600
                            @elseif($req->status == 'approved') bg-blue-100 text-blue-600
                            @elseif($req->status == 'processing') bg-purple-100 text-purple-600
                            @elseif($req->status == 'ready') bg-green-100 text-green-600
                            @elseif($req->status == 'completed') bg-gray-100 text-gray-600
                            @else bg-rose-100 text-rose-600
                            @endif">
                            @if($req->status == 'pending')
                                <i class="fas fa-clock"></i> Pending
                            @elseif($req->status == 'approved')
                                <i class="fas fa-check-circle"></i> Approved
                            @elseif($req->status == 'processing')
                                <i class="fas fa-cog fa-spin"></i> Processing
                            @elseif($req->status == 'ready')
                                <i class="fas fa-download"></i> Ready
                            @elseif($req->status == 'completed')
                                <i class="fas fa-check-double"></i> Completed
                            @elseif($req->status == 'declined')
                                <i class="fas fa-times-circle"></i> Declined
                            @endif
                        </span>
                        <a href="{{ route('parishioner.certificate-request.show', $req->id) }}" class="text-blue-900 hover:text-blue-800 text-sm font-medium no-underline">View Details</a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center text-gray-500">No requests found.</div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- Help Tour Button -->
    <button class="help-tour-btn" id="helpTourBtn" title="Start Help Tour">
        <i class="fas fa-question"></i>
    </button>

    <!-- Shepherd.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/shepherd.js@11.2.0/dist/js/shepherd.min.js"></script>
    <script src="{{ asset('js/onboarding-tour.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('statusFilter');
            const requestCards = document.querySelectorAll('.request-card');
            const searchInput = document.getElementById('searchInput');

            // Filter functionality with dropdown
            statusFilter.addEventListener('change', function() {
                const selectedStatus = this.value;
                filterCards(selectedStatus, searchInput.value);
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                const selectedStatus = statusFilter.value;
                filterCards(selectedStatus, this.value);
            });

            function filterCards(status, searchTerm) {
                const searchLower = searchTerm.toLowerCase();
                
                requestCards.forEach(card => {
                    const cardStatus = card.getAttribute('data-status');
                    const cardSearch = card.getAttribute('data-search');
                    
                    const statusMatch = status === 'all' || cardStatus === status;
                    const searchMatch = !searchTerm || cardSearch.includes(searchLower);
                    
                    if (statusMatch && searchMatch) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            }
        });

        // Initialize Onboarding Tour
        const onboardingTour = new OnboardingTour();
        
        // Auto-start tour for new users
        onboardingTour.initDashboardTour(true);

        // Help Tour Button Click Handler
        document.getElementById('helpTourBtn').addEventListener('click', function() {
            onboardingTour.initDashboardTour(false).start();
        });

        // Add pulse animation to help button for first-time users
        if (!onboardingTour.isTourCompleted()) {
            document.getElementById('helpTourBtn').classList.add('first-time');
        }
    </script>
</body>
</html> 