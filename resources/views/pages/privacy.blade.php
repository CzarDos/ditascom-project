<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Church Documentation System</title>
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
        <h1>Privacy Policy</h1>
        
        <div class="section">
            <h2>1. Information We Collect</h2>
            <p>We collect information that you provide directly to us, including but not limited to your name, email address, and any documents you upload to our system.</p>
        </div>

        <div class="section">
            <h2>2. How We Use Your Information</h2>
            <p>We use the information we collect to provide, maintain, and improve our services, to communicate with you, and to protect our users and services.</p>
        </div>

        <div class="section">
            <h2>3. Information Security</h2>
            <p>We implement appropriate technical and organizational measures to protect the security of your personal information against unauthorized access, disclosure, alteration, or destruction.</p>
        </div>

        <div class="section">
            <h2>4. Data Retention</h2>
            <p>We retain your information for as long as necessary to provide our services and fulfill the purposes outlined in this Privacy Policy.</p>
        </div>

        <a href="{{ route('login') }}" class="back-link">← Back to Login</a>
    </div>
</body>
</html> 