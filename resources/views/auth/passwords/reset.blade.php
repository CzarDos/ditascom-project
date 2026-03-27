<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Church Documentation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #1A237E;
            border-radius: 2px;
        }
    </style>
</head>
<body class="m-0 p-0 min-h-screen flex items-center justify-center bg-gradient-to-br from-cyan-400 to-blue-600 font-['Poppins']">
    
    <div class="bg-white p-10 rounded-3xl shadow-xl w-full max-w-md text-center">
        <div>
            <a href="{{ route('index') }}" class="flex mb-8 text-indigo-800 no-underline hover:underline"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <div class="mb-6 inline-flex items-center justify-center w-12 h-12 bg-indigo-800 rounded-xl">
            <img class="w-28 h-auto" src="{{ asset('images/ditascom-logo.png') }}" alt="Logo"> 
        </div>
        <div class="text-xl font-semibold text-gray-800 mb-1">Church Documentation System</div>
        <div class="text-gray-600 text-sm mb-8">Set your new password</div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="relative mb-4 @error('email') border-red-500 @enderror">
                <input type="email" name="email" placeholder="Email address" value="{{ $email ?? old('email') }}" required 
                       class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-indigo-800 focus:shadow-sm @error('email') border-red-500 @enderror">
                @error('email')
                    <div class="text-red-600 text-sm mt-1 text-left">{{ $message }}</div>
                @enderror
            </div>

            <div class="relative mb-4 @error('password') border-red-500 @enderror">
                <input type="password" name="password" id="password" placeholder="New Password" required minlength="8"
                       class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-indigo-800 focus:shadow-sm @error('password') border-red-500 @enderror">
                @error('password')
                    <div class="text-red-600 text-sm mt-1 text-left">{{ $message }}</div>
                @enderror
                <p class="text-gray-500 text-xs mt-1 text-left">Must be at least 8 characters long</p>
                
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

            <div class="relative mb-6 @error('password_confirmation') border-red-500 @enderror">
                <input type="password" name="password_confirmation" placeholder="Confirm New Password" required minlength="8"
                       class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-indigo-800 focus:shadow-sm @error('password_confirmation') border-red-500 @enderror">
                @error('password_confirmation')
                    <div class="text-red-600 text-sm mt-1 text-left">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-full p-3 bg-indigo-800 text-white border-none rounded-lg text-sm font-medium cursor-pointer transition-colors duration-300 hover:bg-indigo-900 mb-4">
                Reset Password
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-gray-600 no-underline text-xs hover:text-indigo-800">Back to login</a>
            </div>
        </form>
    </div>

<script>
    // Password Strength Checker
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');
        const form = document.querySelector('form[action="{{ route('password.update') }}"]');
        
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
                    errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Please ensure all password requirements are met before resetting your password.';
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
