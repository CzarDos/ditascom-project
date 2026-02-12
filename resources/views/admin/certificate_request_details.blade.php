<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Request Details - DOT My Sacrament</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">
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
                <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
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

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <div class="max-w-6xl mx-auto mt-8 px-4 pb-4">
    <a href="{{ route('admin.certificate-requests.index') }}" class="text-blue-900 font-medium text-base ml-10 inline-block mb-4 hover:text-blue-800">
        <i class="fas fa-arrow-left"></i> Back to Requests
    </a>
    
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
            <div class="flex items-center gap-2 mb-2">
                <i class="fas fa-exclamation-circle"></i>
                <span class="font-semibold">Please fix the following errors:</span>
            </div>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <!-- Top Info Card -->
        <div class="bg-white rounded-lg shadow-sm p-7 mb-6 flex flex-col lg:flex-row gap-8 justify-between">
            <div class="flex flex-col gap-5 min-w-48">
                <div>
                    <div class="text-gray-500 text-xs mb-1">Certificate ID</div>
                    <div class="text-sm font-semibold">REQ-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div>
                    <div class="text-gray-500 text-xs mb-1">Status</div>
                    <span class="inline-block px-4 py-1 rounded-full text-xs font-medium mt-1 {{ $request->status == 'pending' ? 'bg-yellow-50 text-yellow-600' : ($request->status == 'approved' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600') }}">{{ ucfirst($request->status) }}</span>
                </div>
                
            </div>
            <div class="flex flex-col gap-5 min-w-48">
                <div>
                    <div class="text-gray-500 text-xs mb-1">Certificate Type</div>
                    <div class="text-sm font-semibold">{{ $request->certificate_type }}</div>
                </div>
                <div>
                    <div class="text-gray-500 text-xs mb-1">Purpose</div>
                    <div class="text-sm font-semibold">{{ $request->purpose ?? 'Not specified' }}</div>
                </div>
            </div>
            <div class="flex flex-col gap-5 min-w-48">
                <div>
                    <div class="text-gray-500 text-xs mb-1">Request Date</div>
                    <div class="text-sm font-semibold">{{ $request->created_at->format('M d, Y') }}</div>
                </div>
                <div>
                    <div class="text-gray-500 text-xs mb-1">Request Type</div>
                    <div class="text-sm font-semibold">
                        @if($request->request_for == 'self')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-user mr-1"></i> Requesting for Self
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                <i class="fas fa-users mr-1"></i> Requesting for Others
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Details and Admin Actions Row -->
        <div class="flex flex-col lg:flex-row gap-6 mb-6">
            <div class="flex-1 lg:flex-[2] flex flex-col gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="font-semibold text-base mb-5">Requester Details</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <div><span class="text-gray-500 text-xs mr-2"><i class="fas fa-user"></i> Full Name:</span> <span class="font-medium">{{ $request->first_name ?? 'N/A' }} {{ $request->last_name ?? '' }}</span></div>
                        <div><span class="text-gray-500 text-xs mr-2"><i class="fas fa-phone"></i> Contact Number:</span> <span class="font-medium">{{ $request->contact_number ?? 'N/A' }}</span></div>
                        <div><span class="text-gray-500 text-xs mr-2"><i class="fas fa-envelope"></i> Email Address:</span> <span class="font-medium">{{ $request->email ?? 'N/A' }}</span></div>
                        <div><span class="text-gray-500 text-xs mr-2"><i class="fas fa-map-marker-alt"></i> Current Address:</span> <span class="font-medium">{{ $request->current_address ?? 'N/A' }}</span></div>
                        @if($request->date_of_birth)
                        <div><span class="text-gray-500 text-xs mr-2"><i class="fas fa-calendar"></i> Date of Birth:</span> <span class="font-medium">{{ $request->date_of_birth }}</span></div>
                        @endif
                        <div><span class="text-gray-500 text-xs mr-2"><i class="fas fa-info-circle"></i> Request Type:</span> 
                            <span class="font-medium">
                                @if($request->request_for == 'self')
                                    Requesting for Self
                                @else
                                    Requesting for Others
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="font-semibold text-base mb-5">Certificate Owner Details</div>
                    @if($request->request_for == 'self')
                        <div class="text-sm p-3 bg-blue-50 rounded-md border border-blue-200">
                            <div class="flex items-center gap-2 text-blue-700">
                                <i class="fas fa-info-circle"></i>
                                <span class="font-medium">Self-Request: Certificate owner is the same as the requester</span>
                            </div>
                            <div class="mt-2 text-blue-600 text-xs">
                                The requester is requesting the certificate for themselves, so owner details are the same as requester details above.
                            </div>
                        </div>
                    @elseif($request->owner_first_name)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <div><span class="text-gray-500 text-xs">Full Name:</span> <span class="font-semibold">{{ $request->owner_first_name }} {{ $request->owner_last_name }}</span></div>
                        <div><span class="text-gray-500 text-xs">Date of Birth:</span> <span class="font-semibold">{{ $request->owner_date_of_birth }}</span></div>
                        @if($request->relationship)
                        <div><span class="text-gray-500 text-xs">Relationship:</span> <span class="font-semibold">{{ $request->relationship }}</span></div>
                        @endif
                        @if($request->father_first_name || $request->father_last_name)
                        <div><span class="text-gray-500 text-xs">Father's Name:</span> <span class="font-semibold">{{ $request->father_first_name }} {{ $request->father_last_name }}</span></div>
                        @endif
                        @if($request->mother_first_name || $request->mother_last_name)
                        <div><span class="text-gray-500 text-xs">Mother's Name:</span> <span class="font-semibold">{{ $request->mother_first_name }} {{ $request->mother_last_name }}</span></div>
                        @endif
                        @if($request->registered_parish)
                        <div><span class="text-gray-500 text-xs"><i class="fas fa-church mr-1"></i>Registered Parish:</span> <span class="font-semibold">{{ $request->registered_parish }}</span></div>
                        @endif
                        @if($request->third_party_reason)
                        <div class="col-span-2"><span class="text-gray-500 text-xs">Third Party Reason:</span> <span class="font-semibold">{{ $request->third_party_reason }}</span></div>
                        @endif
                    </div>
                    @else
                    <div class="text-sm">
                        <div><span class="font-semibold">No owner details available</span></div>
                    </div>
                    @endif
                </div>
                @if($request->id_front_photo || $request->id_back_photo || $request->id_photo_path)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="font-semibold text-base mb-5">Identity Verification</div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Front ID Photo -->
                        @if($request->id_front_photo)
                        <div class="flex flex-col items-start gap-3">
                            <div class="text-sm text-gray-600 font-medium flex items-center gap-2">
                                <i class="fas fa-id-card text-blue-600"></i> Front of Valid ID:
                            </div>
                            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50 w-full">
                                <img src="{{ asset('storage/' . $request->id_front_photo) }}" alt="Front ID Photo" class="max-w-full h-auto max-h-64 rounded-md shadow-sm mx-auto block">
                            </div>
                            <a href="{{ asset('storage/' . $request->id_front_photo) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-2">
                                <i class="fas fa-external-link-alt"></i> View Full Size
                            </a>
                        </div>
                        @endif
                        
                        <!-- Back ID Photo -->
                        @if($request->id_back_photo)
                        <div class="flex flex-col items-start gap-3">
                            <div class="text-sm text-gray-600 font-medium flex items-center gap-2">
                                <i class="fas fa-id-card text-blue-600"></i> Back of Valid ID:
                            </div>
                            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50 w-full">
                                <img src="{{ asset('storage/' . $request->id_back_photo) }}" alt="Back ID Photo" class="max-w-full h-auto max-h-64 rounded-md shadow-sm mx-auto block">
                            </div>
                            <a href="{{ asset('storage/' . $request->id_back_photo) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-2">
                                <i class="fas fa-external-link-alt"></i> View Full Size
                            </a>
                        </div>
                        @endif
                        
                        <!-- Legacy ID Photo (for backward compatibility) -->
                        @if($request->id_photo_path && !$request->id_front_photo && !$request->id_back_photo)
                        <div class="flex flex-col items-start gap-3 md:col-span-2">
                            <div class="text-sm text-gray-600 font-medium flex items-center gap-2">
                                <i class="fas fa-id-card text-blue-600"></i> Uploaded ID Photo:
                            </div>
                            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50 w-full max-w-md">
                                <img src="{{ asset('storage/' . $request->id_photo_path) }}" alt="ID Photo" class="max-w-full h-auto max-h-64 rounded-md shadow-sm mx-auto block">
                            </div>
                            <a href="{{ asset('storage/' . $request->id_photo_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-2">
                                <i class="fas fa-external-link-alt"></i> View Full Size
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- Additional Photos Section -->
                @if($request->additional_photos && is_array($request->additional_photos) && count($request->additional_photos) > 0)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="font-semibold text-base mb-5 flex items-center gap-2">
                        <i class="fas fa-images text-blue-600"></i> Additional Photos
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($request->additional_photos as $index => $photo)
                        <div class="flex flex-col items-start gap-3">
                            <div class="text-sm text-gray-600 font-medium">
                                Additional Photo {{ $index + 1 }}:
                            </div>
                            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50 w-full">
                                <img src="{{ asset('storage/' . $photo) }}" alt="Additional Photo {{ $index + 1 }}" class="max-w-full h-auto max-h-48 rounded-md shadow-sm mx-auto block">
                            </div>
                            <a href="{{ asset('storage/' . $photo) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-2">
                                <i class="fas fa-external-link-alt"></i> View Full Size
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <div class="flex-1 lg:flex-[1] flex flex-col">
                <div class="bg-white rounded-lg shadow-sm p-5 flex flex-col gap-3 h-full">
                    <div class="font-semibold text-base mb-4">Admin Actions</div>
                    
                    <!-- Status Badge -->
                    <div class="mb-3">
                        <div class="text-xs text-gray-500 mb-1">Current Status:</div>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
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

                    <!-- PENDING: Approve or Decline -->
                    @if($request->status === 'pending')
                        <form action="{{ route('admin.certificate-requests.approve', $request->id) }}" method="POST" id="approveForm">
                            @csrf
                            <div class="text-sm text-gray-500 mb-1">Admin Remarks</div>
                            <textarea name="admin_remarks" rows="3" placeholder="Add approval remarks..." class="w-full rounded-md border border-gray-200 p-2 text-sm resize-y min-h-[70px] mb-3"></textarea>
                            <button class="w-full py-2 border-0 rounded-md text-sm font-semibold mb-2 cursor-pointer bg-green-600 text-white hover:bg-green-700 transition" type="submit">
                                <i class="fas fa-check-circle"></i> Approve Request
                            </button>
                        </form>
                        <form action="{{ route('admin.certificate-requests.decline', $request->id) }}" method="POST" id="declineForm">
                            @csrf
                            <textarea name="admin_remarks" rows="2" placeholder="Reason for declining..." class="w-full rounded-md border border-gray-200 p-2 text-sm resize-y min-h-[50px] mb-2"></textarea>
                            <button class="w-full py-2 border-0 rounded-md text-sm font-semibold mb-2 cursor-pointer bg-red-600 text-white hover:bg-red-700 transition" type="submit">
                                <i class="fas fa-times-circle"></i> Decline Request
                            </button>
                        </form>
                    
                    <!-- APPROVED: Mark as Processing -->
                    @elseif($request->status === 'approved')
                        <div class="text-sm text-gray-600 p-3 bg-blue-50 rounded-md mb-3">
                            <i class="fas fa-info-circle"></i> Request approved. Ready to process certificate.
                        </div>
                        <form action="{{ route('admin.certificate-requests.processing', $request->id) }}" method="POST">
                            @csrf
                            <button class="w-full py-2 border-0 rounded-md text-sm font-semibold mb-2 cursor-pointer bg-purple-600 text-white hover:bg-purple-700 transition" type="submit">
                                <i class="fas fa-cog"></i> Start Processing
                            </button>
                        </form>
                        <a href="{{ route('admin.certificates.baptism') }}" class="block text-center w-full py-2 border border-gray-300 rounded-md text-sm font-semibold mb-2 cursor-pointer bg-white text-gray-700 hover:bg-gray-50 transition">
                            <i class="fas fa-search"></i> Search Certificates
                        </a>
                    
                    <!-- PROCESSING: Upload Certificate -->
                    @elseif($request->status === 'processing')
                        <div class="text-sm text-gray-600 p-3 bg-purple-50 rounded-md mb-3">
                            <i class="fas fa-cog fa-spin"></i> Processing certificate...
                        </div>
                        
                        <!-- Auto-Generate Certificate (Recommended) -->
                        <a href="{{ route('admin.certificate-generator.select', $request->id) }}" class="block text-center w-full py-2 border-0 rounded-md text-sm font-semibold mb-3 cursor-pointer bg-blue-600 text-white hover:bg-blue-700 transition">
                            <i class="fas fa-magic"></i> Auto-Generate Certificate
                        </a>
                        
                        <div class="text-center text-xs text-gray-500 mb-2">OR</div>
                        
                        <!-- Manual Upload -->
                        <form action="{{ route('admin.certificate-requests.upload', $request->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="text-sm text-gray-500 mb-1">Upload Certificate PDF (Manual)</div>
                            <input type="file" name="certificate_file" accept=".pdf" required class="w-full text-sm mb-3 p-2 border border-gray-200 rounded-md">
                            <button class="w-full py-2 border-0 rounded-md text-sm font-semibold mb-2 cursor-pointer bg-green-600 text-white hover:bg-green-700 transition" type="submit">
                                <i class="fas fa-upload"></i> Upload & Mark Ready
                            </button>
                        </form>
                    
                    <!-- READY: Mark as Completed -->
                    @elseif($request->status === 'ready')
                        <div class="text-sm text-gray-600 p-3 bg-green-50 rounded-md mb-3">
                            <i class="fas fa-check-circle"></i> Certificate ready for download!
                        </div>
                        @if($request->certificate_file_path)
                            <a href="{{ asset('storage/' . $request->certificate_file_path) }}" target="_blank" class="block text-center w-full py-2 border border-blue-500 rounded-md text-sm font-semibold mb-2 cursor-pointer bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                <i class="fas fa-file-pdf"></i> View Certificate
                            </a>
                        @endif
                        <form action="{{ route('admin.certificate-requests.complete', $request->id) }}" method="POST">
                            @csrf
                            <button class="w-full py-2 border-0 rounded-md text-sm font-semibold mb-2 cursor-pointer bg-gray-600 text-white hover:bg-gray-700 transition" type="submit">
                                <i class="fas fa-check-double"></i> Mark as Completed
                            </button>
                        </form>
                    
                    <!-- COMPLETED or DECLINED -->
                    @else
                        <div class="text-sm text-gray-600 p-3 bg-gray-50 rounded-md">
                            <i class="fas fa-{{ $request->status == 'completed' ? 'check-double' : 'times-circle' }}"></i> 
                            This request has been {{ $request->status }}.
                        </div>
                        @if($request->certificate_file_path && $request->status == 'completed')
                            <a href="{{ asset('storage/' . $request->certificate_file_path) }}" target="_blank" class="block text-center w-full py-2 border border-blue-500 rounded-md text-sm font-semibold mb-2 cursor-pointer bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                <i class="fas fa-file-pdf"></i> View Certificate
                            </a>
                        @endif
                    @endif

                    <!-- Display Admin Remarks if exists -->
                    @if($request->admin_remarks)
                        <div class="mt-3">
                            <div class="text-sm text-gray-500 mb-1">Admin Remarks:</div>
                            <div class="text-sm text-gray-700 p-2 bg-gray-50 rounded-md">{{ $request->admin_remarks }}</div>
                        </div>
                    @endif

                    <!-- Timestamps -->
                    @if($request->approved_at || $request->completed_at)
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <div class="text-xs text-gray-500 space-y-1">
                                @if($request->approved_at)
                                    <div><i class="fas fa-clock"></i> Approved: {{ $request->approved_at->format('M d, Y h:i A') }}</div>
                                @endif
                                @if($request->completed_at)
                                    <div><i class="fas fa-check"></i> Completed: {{ $request->completed_at->format('M d, Y h:i A') }}</div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 flex flex-col lg:flex-row justify-between items-center py-5 px-8 text-gray-500 text-xs mt-6">
        <div>© 2024 DITA.COM. All rights reserved.</div>
        <div class="flex gap-5 mt-2 lg:mt-0">
            <a href="#" class="text-gray-500 underline hover:text-gray-700">Privacy Policy</a>
            <a href="#" class="text-gray-500 underline hover:text-gray-700">Terms of Service</a>
            <a href="#" class="text-gray-500 underline hover:text-gray-700">Contact Us</a>
        </div>
    </div>
    
</body>
</html> 