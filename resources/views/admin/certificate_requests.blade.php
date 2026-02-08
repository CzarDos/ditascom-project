@extends('layouts.admin')

@section('title', 'Certificate Requests')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Certificate Requests</h1>
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 text-blue-600 mb-4">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="text-2xl font-semibold mb-1">{{ $stats['total'] }}</div>
            <div class="text-gray-600 text-sm">Total Requests</div>
        </div>
        
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-orange-100 text-orange-600 mb-4">
                <i class="fas fa-clock"></i>
            </div>
            <div class="text-2xl font-semibold mb-1">{{ $stats['pending'] }}</div>
            <div class="text-gray-600 text-sm">Pending Requests</div>
        </div>
        
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 text-green-600 mb-4">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="text-2xl font-semibold mb-1">{{ $stats['approved'] }}</div>
            <div class="text-gray-600 text-sm">Approved Requests</div>
        </div>
        
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-100 text-red-600 mb-4">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="text-2xl font-semibold mb-1">{{ $stats['declined'] }}</div>
            <div class="text-gray-600 text-sm">Declined Requests</div>
        </div>
    </div>
    
    <!-- Requests Table -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Certificate Requests</h2>
            
            <!-- Search and Filter Controls -->
            <form action="{{ route('admin.certificate-requests.index') }}" method="GET" class="flex gap-4 items-center">
                <input type="text" 
                       name="search" 
                       placeholder="Search by name or certificate type..." 
                       value="{{ request('search') }}"
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                
                <select name="status" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        onchange="this.form.submit()">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="declined" {{ request('status') === 'declined' ? 'selected' : '' }}>Declined</option>
                </select>
                
                <button type="submit" 
                        class="px-4 py-2 bg-[#1a237e] text-white rounded-lg hover:bg-indigo-900 transition flex items-center gap-2">
                    <i class="fas fa-search"></i> Search
                </button>
                
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.certificate-requests.index') }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Clear
                    </a>
                @endif
            </form>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Certificate Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">REQ{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $request->certificate_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $request->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($request->status === 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Pending</span>
                            @elseif($request->status === 'approved')
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                            @elseif($request->status === 'declined')
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Declined</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($request->status) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $request->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.certificate-requests.show', $request->id) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium">View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                            <p>No certificate requests found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
