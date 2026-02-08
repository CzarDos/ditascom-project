<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Church Documentation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
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
            <a href="{{ route('login') }}" class="p-2 text-gray-600 no-underline text-sm font-medium">Login</a>
            <a href="#" class="tab active p-2 text-indigo-800 no-underline text-sm font-semibold relative">Register</a>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-400 text-red-800 p-3 rounded-lg mb-4 text-sm">
            <ul class="m-0 p-0 list-none">
                @foreach($errors->all() as $error)
                    <li class="m-0 p-0">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="relative mb-2">
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Full name" required 
                       class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-indigo-800 focus:shadow-sm">
            </div>

            <div class="relative mb-2">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email address" required 
                       class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-indigo-800 focus:shadow-sm">
            </div>

            <div class="relative mb-2">
                <input type="password" name="password" placeholder="Password" required 
                       class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-indigo-800 focus:shadow-sm">
                <i class="fas fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
            </div>

            <div class="relative mb-2">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required 
                       class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-indigo-800 focus:shadow-sm">
                <i class="fas fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
            </div>

            <button type="submit" class="w-full p-3 bg-indigo-800 text-white border-none rounded-lg text-sm font-medium cursor-pointer transition-colors duration-300 hover:bg-indigo-900 mt-4">Register</button>

            <div class="mt-6 text-xs text-gray-600 leading-relaxed">
                By continuing, you agree to our <a href="{{ route('terms') }}" class="text-indigo-800 no-underline hover:underline">Terms of Service</a> and
                <a href="{{ route('privacy') }}" class="text-indigo-800 no-underline hover:underline">Privacy Policy</a>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('.fa-eye').forEach(function(eye) {
            eye.addEventListener('click', function() {
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
        });
    </script>
</body>
</html>
