@extends('layouts.admin')

@section('title', 'Death Certificates')

@section('content')
    <h2 class="text-2xl font-semibold text-[#1a237e] mb-6">Death Certificates from All Parishes</h2>
                
                <!-- Search Form --> 
                <div class="mb-6"> 
                    <form action="{{ route('admin.certificates.death') }}" method="GET" class="flex gap-3"> 
                        <input type="text" name="search" placeholder="Search by name, parish, or certificate ID..." value="{{ request('search') }}" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"> 
                        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-indigo-900 transition-colors">Search</button>
                        @if(request('search')) 
                            <a href="{{ route('admin.certificates.death') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">Clear</a> 
                        @endif 
                    </form> 
                </div>

                <!-- Table Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-primary">Cert ID</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-primary">Full Name</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-primary">Date of Death</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-primary">Parish</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-primary">Added By</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-primary">Date Added</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-primary">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($certificates as $certificate)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $certificate->cert_id }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $certificate->full_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $certificate->date_of_death ? \Carbon\Carbon::parse($certificate->date_of_death)->format('M d, Y') : 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $certificate->parish ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                                {{ $certificate->subadmin->name ?? 'Unknown' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $certificate->created_at ? $certificate->created_at->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick='viewDetails(@json($certificate))' class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded transition-colors" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                            <p>No death certificates found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
    <script>
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
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-gray-900 mb-2">Deceased Information</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="text-gray-600">Full Name:</span> <span class="font-medium">${certificate.full_name}</span></div>
                            <div><span class="text-gray-600">Date of Death:</span> <span class="font-medium">${formatDate(certificate.date_of_death)}</span></div>
                            <div class="col-span-2"><span class="text-gray-600">Place of Death:</span> <span class="font-medium">${certificate.place_of_death || 'N/A'}</span></div>
                            <div class="col-span-2"><span class="text-gray-600">Parents' Names:</span> <span class="font-medium">${certificate.parents || 'N/A'}</span></div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-blue-900 mb-2">Additional Information</h3>
                        <div class="text-sm">
                            <div><span class="text-gray-600">Remarks:</span> <span class="font-medium">${certificate.remarks || 'N/A'}</span></div>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-green-900 mb-2">Parish Information</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="text-gray-600">Parish:</span> <span class="font-medium">${certificate.parish || 'N/A'}</span></div>
                            <div><span class="text-gray-600">Priest Name:</span> <span class="font-medium">${certificate.priest_name || 'N/A'}</span></div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-gray-900 mb-2">Administrative Information</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="text-gray-600">Certificate ID:</span> <span class="font-medium">${certificate.cert_id || 'N/A'}</span></div>
                            <div><span class="text-gray-600">Added By:</span> <span class="font-medium">${certificate.subadmin?.name || 'Unknown'}</span></div>
                            <div><span class="text-gray-600">Date Added:</span> <span class="font-medium">${formatDate(certificate.created_at)}</span></div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="/admin/certificates/death/${certificate.id}/download" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <i class="fas fa-download"></i>
                            Download Certificate PDF
                        </a>
                    </div>
                </div>
            `;
            
            document.getElementById('viewContent').innerHTML = content;
            document.getElementById('viewModal').classList.remove('hidden');
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('viewModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeViewModal();
        });
    </script>
@endsection
