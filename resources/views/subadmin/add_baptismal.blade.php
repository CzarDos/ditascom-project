<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Baptismal Certificate - DITASCOM</title>
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
<body class="font-['Inter'] bg-gray-100 flex flex-col h-screen">
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
                    <a href="{{ route('subadmin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-primary">
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
                               class="flex items-center px-6 py-2 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-primary bg-indigo-50 text-primary">
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
            <div class="container mx-auto max-w-7xl">
                <!-- Header with Add Button and Search -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Baptismal Certificates</h1>
                    <button onclick="openAddModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <i class="fas fa-plus"></i>
                        Add Baptismal Certificate
                    </button>
                </div>

                <!-- Search Bar -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('subadmin.certificates.add', ['type' => 'baptismal']) }}" class="flex items-center gap-3">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, certificate ID, parish, or parent names..." 
                                   class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button type="submit" class="px-4 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('subadmin.certificates.add', ['type' => 'baptismal']) }}" class="px-4 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Search Results Indicator -->
                @if(request('search'))
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-blue-800">
                                <i class="fas fa-search mr-2"></i>
                                Search results for: <strong>"{{ request('search') }}"</strong>
                                @if($certificates->total() > 0)
                                    ({{ $certificates->total() }} {{ Str::plural('result', $certificates->total()) }} found)
                                @else
                                    (No results found)
                                @endif
                            </span>
                        </div>
                    </div>
                @endif
                
                <!-- Table Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
                    <div class="overflow-x-auto">
                        <table id="certificatesTable" class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-primary">ID</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-primary">Full Name</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-primary">Parish</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-primary">Date Added</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-primary">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($certificates as $certificate)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $certificate->cert_id }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $certificate->full_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $certificate->parish ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $certificate->created_at ? $certificate->created_at->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick='viewDetails(@json($certificate))' class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded transition-colors" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button onclick='editCertificate(@json($certificate))' class="text-green-600 hover:text-green-800 p-2 hover:bg-green-50 rounded transition-colors" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick='openGenerateModal(@json($certificate))' class="text-purple-600 hover:text-purple-800 p-2 hover:bg-purple-50 rounded transition-colors" title="Generate Certificate">
                                                    <i class="fas fa-file-pdf"></i>
                                                </button>
                                                <button onclick="deleteCertificate({{ $certificate->id }}, '{{ $certificate->full_name }}')" class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded transition-colors" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                            <p>No baptismal certificates found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($certificates->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-700">
                                    Showing {{ $certificates->firstItem() }} to {{ $certificates->lastItem() }} of {{ $certificates->total() }} results
                                </div>
                                <div class="flex items-center space-x-2">
                                    {{-- Previous Page Link --}}
                                    @if ($certificates->onFirstPage())
                                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                            <i class="fas fa-chevron-left"></i> Previous
                                        </span>
                                    @else
                                        <a href="{{ $certificates->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-chevron-left"></i> Previous
                                        </a>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @foreach ($certificates->getUrlRange(1, $certificates->lastPage()) as $page => $url)
                                        @if ($page == $certificates->currentPage())
                                            <span class="px-3 py-2 text-sm text-white bg-blue-600 rounded-lg">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">{{ $page }}</a>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($certificates->hasMorePages())
                                        <a href="{{ $certificates->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                            Next <i class="fas fa-chevron-right"></i>
                                        </a>
                                    @else
                                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                            Next <i class="fas fa-chevron-right"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
    
    <!-- Footer -->
    <footer class="px-6 py-4 bg-white border-t border-gray-300 text-xs text-gray-600 flex justify-center h-[50px]">
        <div>© 2024 DITASCOM. All rights reserved.</div>
    </footer>

    <!-- Add/Edit Certificate Modal -->
    <div id="certificateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h2 id="modalTitle" class="text-xl font-semibold text-gray-800">Add Baptismal Certificate</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="certificateForm" method="POST" action="{{ route('subadmin.certificates.store', ['type' => 'baptismal']) }}" class="p-6">
                @csrf
                <input type="hidden" id="certificateId" name="certificate_id">
                <input type="hidden" id="formMethod" name="_method" value="POST">
                
                <!-- Personal Information Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-primary mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" id="full_name" name="full_name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth *</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="md:col-span-2">
                            <label for="place_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Place of Birth *</label>
                            <input type="text" id="place_of_birth" name="place_of_birth" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="mothers_full_name" class="block text-sm font-medium text-gray-700 mb-1">Mother's Full Name *</label>
                            <input type="text" id="mothers_full_name" name="mothers_full_name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="fathers_full_name" class="block text-sm font-medium text-gray-700 mb-1">Father's Full Name *</label>
                            <input type="text" id="fathers_full_name" name="fathers_full_name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Baptismal Information Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-primary mb-4">Baptismal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="date_of_baptism" class="block text-sm font-medium text-gray-700 mb-1">Date of Baptism *</label>
                            <input type="date" id="date_of_baptism" name="date_of_baptism" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="officiant" class="block text-sm font-medium text-gray-700 mb-1">Minister of Baptism</label>
                            <select id="officiant" name="officiant"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select Minister</option>
                                @foreach($ministers ?? [] as $minister)
                                    <option value="{{ $minister->full_name }}" {{ old('officiant') == $minister->full_name ? 'selected' : '' }}>
                                        {{ $minister->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="sponsor1" class="block text-sm font-medium text-gray-700 mb-1">Sponsor 1</label>
                            <input type="text" id="sponsor1" name="sponsor1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="sponsor2" class="block text-sm font-medium text-gray-700 mb-1">Sponsor 2</label>
                            <input type="text" id="sponsor2" name="sponsor2"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Church/Parish</label>
                            <div class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-800">
                                {{ auth()->user()->parish_name ?? 'No parish assigned' }}
                            </div>
                            <input type="hidden" id="parish" name="parish" value="{{ auth()->user()->parish_name }}">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Parish Address</label>
                            <div class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-800">
                                {{ auth()->user()->parish_address ?? 'No address assigned' }}
                            </div>
                            <input type="hidden" id="parish_address" name="parish_address" value="{{ auth()->user()->parish_address }}">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeModal()" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Save Certificate
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Details Modal -->
    <div id="viewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Certificate Details</h2>
                <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div id="viewContent" class="p-6">
                <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Generate Certificate Modal -->
    <div id="generateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full">
            <div class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center rounded-t-2xl">
                <h2 class="text-xl font-semibold text-gray-800">Generate Certificate</h2>
                <button onclick="closeGenerateModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="generateForm" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-blue-900 mb-2">Certificate Information</h3>
                        <div class="text-sm text-gray-700">
                            <p><span class="font-medium">Name:</span> <span id="gen_full_name"></span></p>
                            <p><span class="font-medium">Certificate ID:</span> <span id="gen_cert_id"></span></p>
                        </div>
                    </div>
                    
                    <div>
                        <label for="purpose_select" class="block text-sm font-medium text-gray-700 mb-2">
                            Purpose of Certificate <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="purpose_select" 
                            onchange="togglePurposeInput()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent mb-2">
                            <option value="Employment">Employment</option>
                            <option value="School Requirements">School Requirements</option>
                            <option value="Government ID">Government ID</option>
                            <option value="Marriage">Marriage</option>
                            <option value="Legal Matters">Legal Matters</option>
                            <option value="Personal Records">Personal Records</option>
                            <option value="Other">Other</option>
                        </select>
                        <input 
                            type="text" 
                            id="purpose_other" 
                            name="purpose"
                            placeholder="Please specify the purpose"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent hidden"
                            required>
                        <input type="hidden" id="purpose" name="purpose" value="Employment">
                        <p class="text-xs text-gray-500 mt-1">This will appear on the certificate</p>
                    </div>
                </div>
                
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeGenerateModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-download mr-2"></i>Generate & Download
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed z-[9999] left-0 top-0 w-screen h-screen bg-black/30 flex items-center justify-center">
        <div class="bg-white rounded-xl px-10 py-8 shadow-lg text-center min-w-[300px]">
            <div class="text-3xl text-green-600 mb-3">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="text-xl font-semibold mb-2">Success!</div>
            <div id="successModalMessage" class="text-gray-800 mb-4"></div>
            <button onclick="closeSuccessModal()" class="bg-green-600 text-white border-none rounded-md px-6 py-2 text-base cursor-pointer hover:bg-green-700">
                Close
            </button>
        </div>
    </div>

    <script>
        // Modal Functions
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add Baptismal Certificate';
            document.getElementById('certificateForm').reset();
            document.getElementById('certificateId').value = '';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('certificateForm').action = "{{ route('subadmin.certificates.store', ['type' => 'baptismal']) }}";
            document.getElementById('certificateModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('certificateModal').classList.add('hidden');
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
        }

        // Search is now handled server-side through form submission

        // Helper function to format date
        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return dateString;
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        // View Details Function
        function viewDetails(certificate) {
            const content = `
                <div class="space-y-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-blue-900 mb-2">Personal Information</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="text-gray-600">Full Name:</span> <span class="font-medium">${certificate.full_name}</span></div>
                            <div><span class="text-gray-600">Date of Birth:</span> <span class="font-medium">${formatDate(certificate.date_of_birth)}</span></div>
                            <div class="col-span-2"><span class="text-gray-600">Place of Birth:</span> <span class="font-medium">${certificate.place_of_birth || 'N/A'}</span></div>
                            <div><span class="text-gray-600">Mother's Name:</span> <span class="font-medium">${certificate.mothers_full_name || 'N/A'}</span></div>
                            <div><span class="text-gray-600">Father's Name:</span> <span class="font-medium">${certificate.fathers_full_name || 'N/A'}</span></div>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-green-900 mb-2">Baptismal Information</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="text-gray-600">Date of Baptism:</span> <span class="font-medium">${formatDate(certificate.date_of_baptism)}</span></div>
                            <div><span class="text-gray-600">Minister:</span> <span class="font-medium">${certificate.officiant || 'N/A'}</span></div>
                            <div><span class="text-gray-600">Sponsor 1:</span> <span class="font-medium">${certificate.sponsor1 || 'N/A'}</span></div>
                            <div><span class="text-gray-600">Sponsor 2:</span> <span class="font-medium">${certificate.sponsor2 || 'N/A'}</span></div>
                            <div class="col-span-2"><span class="text-gray-600">Parish:</span> <span class="font-medium">${certificate.parish || 'N/A'}</span></div>
                            <div class="col-span-2"><span class="text-gray-600">Parish Address:</span> <span class="font-medium">${certificate.parish_address || 'N/A'}</span></div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-gray-900 mb-2">Certificate Information</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="text-gray-600">Certificate ID:</span> <span class="font-medium">${certificate.cert_id || 'N/A'}</span></div>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('viewContent').innerHTML = content;
            document.getElementById('viewModal').classList.remove('hidden');
        }

        // Edit Function
        function editCertificate(certificate) {
            document.getElementById('modalTitle').textContent = 'Edit Baptismal Certificate';
            document.getElementById('certificateId').value = certificate.id;
            document.getElementById('full_name').value = certificate.full_name || '';
            document.getElementById('date_of_birth').value = certificate.date_of_birth || '';
            document.getElementById('place_of_birth').value = certificate.place_of_birth || '';
            document.getElementById('mothers_full_name').value = certificate.mothers_full_name || '';
            document.getElementById('fathers_full_name').value = certificate.fathers_full_name || '';
            document.getElementById('date_of_baptism').value = certificate.date_of_baptism || '';
            document.getElementById('officiant').value = certificate.officiant || '';
            document.getElementById('sponsor1').value = certificate.sponsor1 || '';
            document.getElementById('sponsor2').value = certificate.sponsor2 || '';
            // Parish information is automatically populated from authenticated user
            // No need to set parish values as they are read-only from auth()->user()
            
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('certificateForm').action = `/subadmin/certificates/update/${certificate.id}`;
            document.getElementById('certificateModal').classList.remove('hidden');
        }

        // Delete Function
        function deleteCertificate(id, name) {
            if (confirm(`Are you sure you want to delete the certificate for "${name}"? This action cannot be undone.`)) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/subadmin/certificates/delete/${id}`;
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]') || document.querySelector('input[name="_token"]');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken ? csrfToken.content || csrfToken.value : '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Show success message if exists
        @if(session('success'))
            window.onload = function() {
                document.getElementById('successModalMessage').innerText = @json(session('success'));
                document.getElementById('successModal').classList.remove('hidden');
            }
        @endif

        // Toggle purpose input based on selection
        function togglePurposeInput() {
            const select = document.getElementById('purpose_select');
            const otherInput = document.getElementById('purpose_other');
            const hiddenInput = document.getElementById('purpose');
            
            if (select.value === 'Other') {
                otherInput.classList.remove('hidden');
                otherInput.required = true;
                hiddenInput.value = '';
                otherInput.addEventListener('input', function() {
                    hiddenInput.value = this.value;
                });
            } else {
                otherInput.classList.add('hidden');
                otherInput.required = false;
                otherInput.value = '';
                hiddenInput.value = select.value;
            }
        }

        // Open Generate Certificate Modal
        function openGenerateModal(certificate) {
            document.getElementById('gen_full_name').textContent = certificate.full_name;
            document.getElementById('gen_cert_id').textContent = certificate.cert_id;
            document.getElementById('generateForm').action = `/subadmin/certificates/baptism/${certificate.id}/download`;
            document.getElementById('purpose_select').value = 'Employment';
            document.getElementById('purpose').value = 'Employment';
            document.getElementById('purpose_other').classList.add('hidden');
            document.getElementById('purpose_other').value = '';
            document.getElementById('generateModal').classList.remove('hidden');
        }

        // Close Generate Certificate Modal
        function closeGenerateModal() {
            document.getElementById('generateModal').classList.add('hidden');
            document.getElementById('purpose_select').value = 'Employment';
            document.getElementById('purpose').value = 'Employment';
            document.getElementById('purpose_other').classList.add('hidden');
            document.getElementById('purpose_other').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('certificateModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        
        document.getElementById('viewModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeViewModal();
        });
        
        document.getElementById('generateModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeGenerateModal();
        });
    </script>
</body>
</html>
