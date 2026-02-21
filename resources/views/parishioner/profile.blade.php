<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - DOT My Sacrament</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/ditascom-logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/ditascom-logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/ditascom-logo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
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
                    <a href="{{ route('parishioner.profile') }}" class="text-gray-800 px-4 py-3 block text-sm hover:bg-gray-100">
                        <i class="fas fa-user-circle mr-2"></i> Profile
                    </a>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="text-gray-800 px-4 py-3 block text-sm hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto">
            <!-- Profile Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-2">User Profile</h1>
                        <p class="text-gray-600">Manage your personal information and account settings</p>
                    </div>
                    <a href="{{ route('parishioner.dashboard') }}" class="flex items-center px-4 py-2 text-gray-600 hover:text-[#1a237e] no-underline">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <p class="text-gray-900 font-medium">Parishioner</p>
                    </div>
                    @if(auth()->user()->parish_name)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Parish Name</label>
                        <p class="text-gray-900 font-medium">{{ auth()->user()->parish_name }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h2>
                
                @if(session('success'))
                    <div class="bg-green-50 border border-green-400 text-green-800 p-3 rounded-lg mb-4 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-400 text-red-800 p-3 rounded-lg mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('parishioner.change.password') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" name="current_password" required
                                   class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-[#1a237e] focus:shadow-sm @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" name="new_password" id="new_password" required minlength="8"
                                   class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-[#1a237e] focus:shadow-sm @error('new_password') border-red-500 @enderror">
                            @error('new_password')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">Must be at least 8 characters long</p>
                            
                            <!-- Password Strength Indicator -->
                            <div class="mt-3">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2 mr-3">
                                        <div id="strength-bar" class="h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                    <span id="strength-text" class="text-xs font-medium text-gray-600">Weak</span>
                                </div>
                                <div class="space-y-1 text-xs">
                                    <div id="lowercase" class="flex items-center text-gray-500">
                                        <i class="fas fa-times-circle mr-1"></i> Contains lowercase letter
                                    </div>
                                    <div id="uppercase" class="flex items-center text-gray-500">
                                        <i class="fas fa-times-circle mr-1"></i> Contains uppercase letter
                                    </div>
                                    <div id="number" class="flex items-center text-gray-500">
                                        <i class="fas fa-times-circle mr-1"></i> Contains number
                                    </div>
                                    <div id="symbol" class="flex items-center text-gray-500">
                                        <i class="fas fa-times-circle mr-1"></i> Contains special symbol
                                    </div>
                                    <div id="length" class="flex items-center text-gray-500">
                                        <i class="fas fa-times-circle mr-1"></i> At least 8 characters
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" required minlength="8"
                                   class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-[#1a237e] focus:shadow-sm @error('new_password_confirmation') border-red-500 @enderror">
                            @error('new_password_confirmation')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-[#1a237e] text-white border-none rounded-lg text-sm font-medium cursor-pointer transition-colors duration-300 hover:bg-indigo-900">
                                <i class="fas fa-lock mr-2"></i> Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

<script>
    // Password Strength Checker
    const passwordInput = document.getElementById('new_password');
    if (passwordInput) {
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');
        const form = document.querySelector('form[action="{{ route('parishioner.change.password') }}"]');
        
        const requirements = {
            lowercase: { element: document.getElementById('lowercase'), regex: /[a-z]/ },
            uppercase: { element: document.getElementById('uppercase'), regex: /[A-Z]/ },
            number: { element: document.getElementById('number'), regex: /[0-9]/ },
            symbol: { element: document.getElementById('symbol'), regex: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/ },
            length: { element: document.getElementById('length'), regex: /.{8,}/ }
        };

        let allRequirementsMet = false;

        function checkPasswordStrength() {
            const password = passwordInput.value;
            let strength = 0;
            let metRequirements = 0;

            // Check each requirement
            Object.keys(requirements).forEach(key => {
                const req = requirements[key];
                if (req.regex.test(password)) {
                    req.element.classList.remove('text-gray-500');
                    req.element.classList.add('text-green-600');
                    req.element.querySelector('i').classList.remove('fa-times-circle');
                    req.element.querySelector('i').classList.add('fa-check-circle');
                    metRequirements++;
                } else {
                    req.element.classList.remove('text-green-600');
                    req.element.classList.add('text-gray-500');
                    req.element.querySelector('i').classList.remove('fa-check-circle');
                    req.element.querySelector('i').classList.add('fa-times-circle');
                }
            });

            // Calculate strength
            if (metRequirements <= 2) {
                strength = 25;
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-red-500';
                strengthText.textContent = 'Weak';
                strengthText.className = 'text-xs font-medium text-red-500';
            } else if (metRequirements <= 3) {
                strength = 50;
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-yellow-500';
                strengthText.textContent = 'Normal';
                strengthText.className = 'text-xs font-medium text-yellow-600';
            } else if (metRequirements <= 4) {
                strength = 75;
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-blue-500';
                strengthText.textContent = 'Strong';
                strengthText.className = 'text-xs font-medium text-blue-600';
            } else {
                strength = 100;
                strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-green-500';
                strengthText.textContent = 'Very Strong';
                strengthText.className = 'text-xs font-medium text-green-600';
            }

            strengthBar.style.width = strength + '%';
            
            // Check if all requirements are met
            allRequirementsMet = metRequirements === 5;
            
            // Update submit button state
            updateSubmitButton();
        }

        function updateSubmitButton() {
            const submitButton = form.querySelector('button[type="submit"]');
            if (allRequirementsMet && passwordInput.value.length > 0) {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                submitButton.classList.add('hover:bg-indigo-900');
            } else {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                submitButton.classList.remove('hover:bg-indigo-900');
            }
        }

        // Prevent form submission if requirements are not met
        form.addEventListener('submit', function(e) {
            if (!allRequirementsMet || passwordInput.value.length === 0) {
                e.preventDefault();
                
                // Show error message
                let existingError = form.querySelector('.password-requirements-error');
                if (!existingError) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'password-requirements-error bg-red-50 border border-red-400 text-red-800 p-3 rounded-lg mb-4 text-sm';
                    errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Please ensure all password requirements are met before submitting.';
                    form.insertBefore(errorDiv, form.firstChild);
                }
                
                // Scroll to error
                existingError = form.querySelector('.password-requirements-error');
                existingError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        passwordInput.addEventListener('input', checkPasswordStrength);
        checkPasswordStrength(); // Initialize on page load
    }
</script>
</body>
</html>
