<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - Church Documentation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h1 {
            color: #00f2c3;
            margin-bottom: 2rem;
        }

        .section {
            margin-bottom: 2rem;
        }

        .section h2 {
            color: #333;
            margin-bottom: 1rem;
        }

        .back-link {
            display: inline-block;
            margin-top: 2rem;
            color: #00f2c3;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Terms of Service</h1>
        
        <div class="section">
            <h2>1. Acceptance of Terms</h2>
            <p>By accessing and using the Church Documentation System, you accept and agree to be bound by the terms and provision of this agreement.</p>
        </div>

        <div class="section">
            <h2>2. Description of Service</h2>
            <p>The Church Documentation System is an electronic document management and archive system designed to help churches manage their documentation efficiently and securely.</p>
        </div>

        <div class="section">
            <h2>3. User Responsibilities</h2>
            <p>Users are responsible for maintaining the confidentiality of their account information and for all activities that occur under their account.</p>
        </div>

        <div class="section">
            <h2>4. Privacy Policy</h2>
            <p>Your use of the Church Documentation System is also governed by our Privacy Policy. Please review our Privacy Policy, which also governs the site and informs users of our data collection practices.</p>
        </div>

        <a href="{{ route('login') }}" class="back-link">← Back to Login</a>
    </div>
</body>
</html> 