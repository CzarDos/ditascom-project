<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Church Documentation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Include Font Awesome for icons -->
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
<body class="m-0 p-0 min-h-screen flex items-center justify-center bg-gradient-to-br from-cyan-400 to-blue-600 font-['Inter']">
    
    <div class="bg-white p-10 rounded-3xl shadow-xl w-full max-w-md text-center">
        <div>
            <a href="{{ route('index') }}" class="flex mb-8 text-indigo-800 no-underline hover:underline"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <div class="mb-6 inline-flex items-center justify-center w-12 h-12 bg-indigo-800 rounded-xl">
            <img class="w-28 h-auto" src="{{ asset('images/ditascom-logo.png') }}" alt="Logo"> 
        </div>
        <div class="text-xl font-semibold text-gray-800 mb-1">Church Documentation System</div>
        <div class="text-gray-600 text-sm mb-8">Electronic document management and archive system</div>
        
        <div class="flex justify-center gap-12 mb-8 relative">
            <a href="#" class="tab active p-2 text-indigo-800 no-underline text-sm font-semibold relative">Login</a>
            <a href="{{ route('register') }}" class="p-2 text-gray-600 no-underline text-sm font-medium">Register</a>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-400 text-red-800 p-3 rounded-lg mb-4 text-sm">
                <ul class="m-0 p-0 list-none">
                    <li class="m-0 p-0">{{ session('error') }}</li>
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="relative mb-4 @error('email') border-red-500 @enderror">
                <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" required 
                       class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-indigo-800 focus:shadow-sm @error('email') border-red-500 @enderror">
                @error('email')
                    <div class="text-red-600 text-sm mt-1 text-left">{{ $message }}</div>
                @enderror
            </div>

            <div class="relative mb-4 @error('password') border-red-500 @enderror">
                <input type="password" name="password" placeholder="Password" required 
                       class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-indigo-800 focus:shadow-sm @error('password') border-red-500 @enderror">
                <i class="fas fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
                @error('password')
                    <div class="text-red-600 text-sm mt-1 text-left">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-right my-2 mb-6">
                <a href="{{ route('password.request') }}" class="text-gray-600 no-underline text-xs">Forgot password?</a>
            </div>

            <button type="submit" class="w-full p-3 bg-indigo-800 text-white border-none rounded-lg text-sm font-medium cursor-pointer transition-colors duration-300 hover:bg-indigo-900">Login</button>

            <div class="mt-6 text-xs text-gray-600 leading-relaxed">
                By continuing, you agree to our <a href="{{ route('terms') }}" class="text-indigo-800 no-underline hover:underline">Terms of Service</a> and
                <a href="{{ route('privacy') }}" class="text-indigo-800 no-underline hover:underline">Privacy Policy</a>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('.fa-eye').addEventListener('click', function() {
            const passwordInput = this.parentElement.querySelector('input');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
