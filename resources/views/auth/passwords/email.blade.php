<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Church Documentation System</title>
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
        <div class="text-gray-600 text-sm mb-8">Reset your password</div>
        
        @if (session('status'))
            <div class="bg-green-50 border border-green-400 text-green-800 p-3 rounded-lg mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="relative mb-6 @error('email') border-red-500 @enderror">
                <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" required 
                       class="w-full p-3 border border-gray-300 rounded-lg text-sm outline-none transition-all duration-300 focus:border-indigo-800 focus:shadow-sm @error('email') border-red-500 @enderror">
                @error('email')
                    <div class="text-red-600 text-sm mt-1 text-left">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-full p-3 bg-indigo-800 text-white border-none rounded-lg text-sm font-medium cursor-pointer transition-colors duration-300 hover:bg-indigo-900 mb-4">
                Send Password Reset Link
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-gray-600 no-underline text-xs hover:text-indigo-800">Back to login</a>
            </div>
        </form>
    </div>
</body>
</html>
