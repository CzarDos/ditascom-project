<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification - DOT My Sacrament</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .verification-result {
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-[#1a237e] px-6 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-3">
            <img class="w-12 h-12" src="{{ asset('images/ditascom-logo.png') }}" alt="DOT My Sacrament Logo">
            <span class="text-white text-xl font-semibold">DOT My Sacrament</span>
        </div>
        <div class="flex gap-4 items-center">
            <a href="{{ route('faq') }}" class="text-white hover:text-gray-200 transition flex items-center gap-2">
                <i class="fas fa-question-circle"></i>
                <span class="hidden sm:inline">FAQ</span>
            </a>
            <a href="{{ route('login') }}" class="bg-white text-[#1a237e] px-5 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                Login
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('index') }}" class="inline-flex items-center gap-2 text-[#1a237e] hover:text-[#283593] transition font-medium">
                    <i class="fas fa-arrow-left"></i>
                    Back to Home
                </a>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <i class="fas fa-certificate text-5xl text-[#1a237e] mb-4"></i>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Certificate Verification</h1>
                    <p class="text-gray-600">Verify the authenticity of parish certificates</p>
                </div>

                <!-- Verification Form -->
                <div class="space-y-6">
                    <!-- Manual Input Section -->
                    <div class="border rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                            <i class="fas fa-keyboard text-[#1a237e]"></i>
                            Certificate Verification
                        </h3>
                        <form id="verificationForm" class="space-y-4">
                            @csrf
                            <div>
                                <label for="certificate_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Certificate ID
                                </label>
                                <input 
                                    type="text" 
                                    id="certificate_id" 
                                    name="certificate_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent"
                                    placeholder="Enter certificate ID (e.g., CERT-2024-001)"
                                    required
                                >
                            </div>
                            <button 
                                type="submit" 
                                class="w-full bg-[#1a237e] text-white py-2 px-4 rounded-lg hover:bg-[#283593] transition font-medium"
                            >
                                <i class="fas fa-search mr-2"></i>
                                Verify Certificate
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="hidden text-center py-4">
                    <i class="fas fa-spinner fa-spin text-2xl text-[#1a237e]"></i>
                    <p class="mt-2 text-gray-600">Verifying certificate...</p>
                </div>

                <!-- Verification Result -->
                <div id="verificationResult" class="mt-6 hidden"></div>
            </div>

            <!-- Instructions -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-800 mb-3">
                    <i class="fas fa-info-circle mr-2"></i>
                    How to Verify
                </h3>
                <ul class="space-y-2 text-blue-700">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-1"></i>
                        <span>Enter the Certificate ID from the certificate you want to verify</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-1"></i>
                        <span>The Certificate ID is typically found in the registry information section</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-1"></i>
                        <span>Legitimate certificates will show verification details and status</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-1"></i>
                        <span>If not found, the certificate may be fake or invalid</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-800 text-white text-center py-6 mt-12">
    <div>© 2026 Powered by DiTaSCoM. All rights reserved</div>
  </div>

    <script>
        // Manual form submission
        document.getElementById('verificationForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const certificateId = document.getElementById('certificate_id').value.trim();
            if (!certificateId) {
                showResult(false, 'Please enter a certificate ID');
                return;
            }

            await verifyCertificate(certificateId);
        });

        async function verifyCertificate(certificateId) {
            // Show loading
            document.getElementById('loadingIndicator').classList.remove('hidden');
            document.getElementById('verificationResult').classList.add('hidden');

            try {
                const response = await fetch('{{ route("certificate.verify") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        certificate_id: certificateId
                    })
                });

                const data = await response.json();
                showResult(data.success, data.message, data.certificate);
                
                // Update the input field with the verified ID
                if (certificateId) {
                    document.getElementById('certificate_id').value = certificateId;
                }
                
            } catch (error) {
                console.error('Verification error:', error);
                showResult(false, 'An error occurred during verification. Please try again.');
            } finally {
                document.getElementById('loadingIndicator').classList.add('hidden');
            }
        }

        function showResult(success, message, certificate = null) {
            const resultDiv = document.getElementById('verificationResult');
            resultDiv.classList.remove('hidden');
            
            if (success) {
                resultDiv.innerHTML = `
                    <div class="verification-result bg-green-50 border border-green-200 rounded-lg p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <i class="fas fa-check-circle text-3xl text-green-600"></i>
                            <h3 class="text-xl font-semibold text-green-800">Certificate Verified</h3>
                        </div>
                        <p class="text-green-700 mb-4">${message}</p>
                        ${certificate ? `
                            <div class="bg-white rounded-lg p-4 border border-green-200">
                                <h4 class="font-semibold text-gray-800 mb-3">Certificate Details:</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                    <div><strong>Certificate ID:</strong> ${certificate.id}</div>
                                    <div><strong>Type:</strong> ${certificate.type}</div>
                                    <div><strong>Name:</strong> ${certificate.full_name}</div>
                                    <div><strong>Parish:</strong> ${certificate.parish}</div>
                                    <div><strong>Status:</strong> <span class="bg-green-100 text-green-800 px-2 py-1 rounded">${certificate.status}</span></div>
                                    <div><strong>Issued:</strong> ${certificate.created_at}</div>
                                </div>
                            </div>
                        ` : ''}
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="verification-result bg-red-50 border border-red-200 rounded-lg p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <i class="fas fa-times-circle text-3xl text-red-600"></i>
                            <h3 class="text-xl font-semibold text-red-800">Verification Failed</h3>
                        </div>
                        <p class="text-red-700">${message}</p>
                    </div>
                `;
            }
        }
    </script>
</body>
</html>
