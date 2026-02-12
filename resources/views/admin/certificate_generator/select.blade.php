<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Certificate - DOT My Sacrament</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-900 text-white py-4 px-8 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-3">
            <i class="fas fa-church text-2xl"></i>
            <span class="text-xl font-bold">DOT My Sacrament</span>
        </div>
        <div class="flex items-center gap-6">
            <span>{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="hover:text-blue-200">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto mt-8 px-4 pb-8">
        <a href="{{ route('admin.certificate-requests.show', $certRequest->id) }}" class="text-blue-900 font-medium text-base inline-block mb-4 hover:text-blue-800">
            <i class="fas fa-arrow-left"></i> Back to Request
        </a>

        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                <i class="fas fa-search text-blue-600"></i> Select Certificate to Generate
            </h2>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                    <div class="flex-1">
                        <p class="font-semibold text-blue-900 mb-3">Request Information:</p>
                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                            <div>
                                <strong class="text-blue-900">Requestee:</strong><br>
                                {{ $certRequest->first_name }} {{ $certRequest->last_name }}
                            </div>
                            <div>
                                <strong class="text-blue-900">Contact:</strong><br>
                                {{ $certRequest->contact_number }}<br>
                                {{ $certRequest->email }}
                            </div>
                            <div>
                                <strong class="text-blue-900">Certificate Type:</strong><br>
                                {{ $certRequest->certificate_type }}
                            </div>
                            <div>
                                <strong class="text-blue-900">Purpose:</strong><br>
                                {{ $certRequest->purpose }}
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-blue-300">
                            <p class="font-semibold text-blue-900 mb-2">Certificate Owner's Information:</p>
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                                <div>
                                    <strong class="text-blue-900">Owner Name:</strong><br>
                                    @if($certRequest->request_for == 'self')
                                        {{ $certRequest->first_name }} {{ $certRequest->last_name }} <span class="text-blue-600 text-xs">(Self-Request)</span>
                                    @else
                                        {{ $certRequest->owner_first_name }} {{ $certRequest->owner_last_name }}
                                    @endif
                                </div>
                                <div>
                                    <strong class="text-blue-900">Date of Birth:</strong><br>
                                    @if($certRequest->request_for == 'self')
                                        {{ \Carbon\Carbon::parse($certRequest->date_of_birth)->format('F d, Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($certRequest->owner_date_of_birth)->format('F d, Y') }}
                                    @endif
                                </div>
                                @if($certRequest->registered_parish)
                                    <div>
                                        <strong class="text-blue-900"><i class="fas fa-church mr-1"></i>Registered Parish:</strong><br>
                                        {{ $certRequest->registered_parish }}
                                    </div>
                                @endif
                                @if($certRequest->relationship && $certRequest->request_for != 'self')
                                    <div>
                                        <strong class="text-blue-900">Relationship:</strong><br>
                                        {{ $certRequest->relationship }}
                                    </div>
                                @endif
                                @if($certRequest->father_first_name || $certRequest->father_last_name)
                                    <div>
                                        <strong class="text-blue-900"><i class="fas fa-male mr-1"></i>Father's Name:</strong><br>
                                        {{ $certRequest->father_first_name }} {{ $certRequest->father_last_name }}
                                    </div>
                                @endif
                                @if($certRequest->mother_first_name || $certRequest->mother_last_name)
                                    <div>
                                        <strong class="text-blue-900"><i class="fas fa-female mr-1"></i>Mother's Name:</strong><br>
                                        {{ $certRequest->mother_first_name }} {{ $certRequest->mother_last_name }}
                                    </div>
                                @endif
                                @if($certRequest->third_party_reason)
                                    <div class="col-span-2">
                                        <strong class="text-blue-900">Reason for Third-Party:</strong><br>
                                        {{ $certRequest->third_party_reason }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-300 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Important:</strong> Please verify that the certificate owner's information matches the certificate you're about to generate. Double-check the name and date of birth before proceeding.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($certificates->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-600 text-lg mb-4">No matching certificates found in the database.</p>
                    <p class="text-gray-500 text-sm mb-6">Try searching manually in the certificates page.</p>
                    <a href="{{ route('admin.certificates.baptism') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-search"></i> Search Certificates
                    </a>
                </div>
            @else
                <div class="mb-4">
                    <p class="text-gray-600">Found <strong>{{ $certificates->count() }}</strong> matching certificate(s). Select one to generate:</p>
                </div>

                <div class="space-y-4">
                    @foreach($certificates as $cert)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-400 hover:shadow-md transition">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg text-gray-800 mb-2">
                                        {{ $cert->full_name }}
                                    </h3>
                                    <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm text-gray-600">
                                        <div>
                                            <i class="fas fa-birthday-cake text-blue-600"></i>
                                            <strong>Born:</strong> {{ \Carbon\Carbon::parse($cert->date_of_birth)->format('M d, Y') }}
                                        </div>
                                        @if(isset($cert->date_of_baptism))
                                            <div>
                                                <i class="fas fa-water text-blue-600"></i>
                                                <strong>Baptized:</strong> {{ \Carbon\Carbon::parse($cert->date_of_baptism)->format('M d, Y') }}
                                            </div>
                                        @endif
                                        @if(isset($cert->fathers_full_name))
                                            <div>
                                                <i class="fas fa-male text-blue-600"></i>
                                                <strong>Father:</strong> {{ $cert->fathers_full_name }}
                                            </div>
                                        @endif
                                        @if(isset($cert->mothers_full_name))
                                            <div>
                                                <i class="fas fa-female text-blue-600"></i>
                                                <strong>Mother:</strong> {{ $cert->mothers_full_name }}
                                            </div>
                                        @endif
                                        @if(isset($cert->parish))
                                            <div>
                                                <i class="fas fa-church text-blue-600"></i>
                                                <strong>Parish:</strong> {{ $cert->parish }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4 flex flex-col gap-2">
                                    <button onclick="viewCertificateDetails({{ $cert->id }})" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                                        <i class="fas fa-eye"></i> View Details
                                    </button>
                                    <form action="{{ route('admin.certificate-generator.generate', $certRequest->id) }}" method="POST" onsubmit="return confirmGenerate('{{ $cert->full_name }}', '{{ \Carbon\Carbon::parse($cert->date_of_birth)->format('M d, Y') }}')">
                                        @csrf
                                        <input type="hidden" name="certificate_id" value="{{ $cert->id }}">
                                        <button type="submit" class="w-full bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                                            <i class="fas fa-file-pdf"></i> Generate Certificate
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Certificate Details Modal -->
    <div id="certificateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-certificate text-blue-600"></i> Certificate Details
                </h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="modalContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        const certificates = @json($certificates);
        
        function viewCertificateDetails(certId) {
            const cert = certificates.find(c => c.id === certId);
            if (!cert) return;
            
            const modal = document.getElementById('certificateModal');
            const content = document.getElementById('modalContent');
            
            // Build detailed view
            let html = `
                <div class="space-y-6">
                    <!-- Personal Information -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-900 mb-3 flex items-center gap-2">
                            <i class="fas fa-user"></i> Personal Information
                        </h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Full Name:</span>
                                <div class="font-semibold text-gray-900">${cert.full_name}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Date of Birth:</span>
                                <div class="font-semibold text-gray-900">${new Date(cert.date_of_birth).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</div>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-600">Place of Birth:</span>
                                <div class="font-semibold text-gray-900">${cert.place_of_birth}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Parents Information -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h4 class="font-semibold text-green-900 mb-3 flex items-center gap-2">
                            <i class="fas fa-users"></i> Parents Information
                        </h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Father's Name:</span>
                                <div class="font-semibold text-gray-900">${cert.fathers_full_name}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Mother's Name:</span>
                                <div class="font-semibold text-gray-900">${cert.mothers_full_name}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Baptism Details -->
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <h4 class="font-semibold text-purple-900 mb-3 flex items-center gap-2">
                            <i class="fas fa-water"></i> Baptism Details
                        </h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Date of Baptism:</span>
                                <div class="font-semibold text-gray-900">${new Date(cert.date_of_baptism).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Officiant:</span>
                                <div class="font-semibold text-gray-900">${cert.officiant || 'N/A'}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Sponsor 1:</span>
                                <div class="font-semibold text-gray-900">${cert.sponsor1 || 'N/A'}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Sponsor 2:</span>
                                <div class="font-semibold text-gray-900">${cert.sponsor2 || 'N/A'}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Parish Information -->
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                        <h4 class="font-semibold text-amber-900 mb-3 flex items-center gap-2">
                            <i class="fas fa-church"></i> Parish Information
                        </h4>
                        <div class="grid grid-cols-1 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Parish:</span>
                                <div class="font-semibold text-gray-900">${cert.parish}</div>
                            </div>
                            ${cert.parish_address ? `
                            <div>
                                <span class="text-gray-600">Address:</span>
                                <div class="font-semibold text-gray-900">${cert.parish_address}</div>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                    
                    <!-- Certificate ID -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <i class="fas fa-barcode"></i> Certificate Reference
                        </h4>
                        <div class="text-sm">
                            <span class="text-gray-600">Certificate ID:</span>
                            <div class="font-mono font-semibold text-gray-900">${cert.cert_id}</div>
                        </div>
                    </div>
                    
                    <!-- Verification Notice -->
                    <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4">
                        <p class="text-sm text-yellow-800 flex items-start gap-2">
                            <i class="fas fa-exclamation-triangle mt-1"></i>
                            <span><strong>Verification Required:</strong> Please ensure all details above match the request information before generating the certificate.</span>
                        </p>
                    </div>
                </div>
            `;
            
            content.innerHTML = html;
            modal.classList.remove('hidden');
        }
        
        function closeModal() {
            document.getElementById('certificateModal').classList.add('hidden');
        }
        
        // Close modal when clicking outside
        document.getElementById('certificateModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        function confirmGenerate(certName, certDob) {
            const requestOwner = '{{ $certRequest->owner_first_name }} {{ $certRequest->owner_last_name }}';
            const requestDob = '{{ \Carbon\Carbon::parse($certRequest->owner_date_of_birth)->format('M d, Y') }}';
            
            const message = `⚠️ VERIFICATION REQUIRED\n\n` +
                `You are about to generate a certificate for:\n\n` +
                `Certificate Name: ${certName}\n` +
                `Certificate DOB: ${certDob}\n\n` +
                `Requested for:\n` +
                `Owner Name: ${requestOwner}\n` +
                `Owner DOB: ${requestDob}\n\n` +
                `Please verify that these details match before proceeding.\n\n` +
                `Do you want to continue?`;
            
            return confirm(message);
        }
    </script>
</body>
</html>
