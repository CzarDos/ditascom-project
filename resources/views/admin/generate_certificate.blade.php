<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Certificate - DITASCOM</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a237e;
            --secondary-color: #f5f6f8;
            --text-color: #333;
            --border-color: #e0e0e0;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f6f8;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: var(--primary-color);
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            height: 40px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            font-weight: 600;
        }

        .navbar-brand i {
            font-size: 20px;
        }

        .logo-inner {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar-right a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            z-index: 1;
            border-radius: 6px;
        }

        .dropdown-content a {
            color: var(--text-color) !important;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px !important;
        }

        .dropdown-content a:hover {
            background-color: #f5f6f8;
        }

        .user-dropdown:hover .dropdown-content {
            display: block;
        }
        .main-wrapper {
            display: flex;
            min-height: calc(100vh - 60px);
            background: #f5f6f8;
        }
        .sidebar {
            width: 260px;
            background: #fff;
            border-right: 1px solid #e0e0e0;
            padding: 32px 24px;
            min-height: calc(100vh - 60px);
        }
        .sidebar-title {
            font-size: 15px;
            font-weight: 600;
            color: #1a237e;
            margin-bottom: 18px;
        }
        .sidebar-info {
            font-size: 14px;
            margin-bottom: 18px;
        }
        .sidebar-label {
            color: #888;
            font-size: 13px;
        }
        .sidebar-value {
            font-weight: 500;
            margin-bottom: 6px;
        }
        .sidebar-status {
            color: #43a047;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 6px;
        }
        .content {
            flex: 1;
            padding: 40px 48px 24px 48px;
            background: #f5f6f8;
        }
        .content-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #222;
        }
        .content-desc {
            color: #666;
            font-size: 15px;
            margin-bottom: 32px;
        }
        .form-row {
            display: flex;
            gap: 24px;
            margin-bottom: 24px;
        }
        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .form-label {
            font-size: 14px;
            color: #222;
            font-weight: 500;
            margin-bottom: 6px;
        }
        .form-input, .form-textarea {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 15px;
            background: #fafbfc;
            margin-bottom: 0;
            outline: none;
            transition: border 0.2s;
        }
        .form-input:focus, .form-textarea:focus {
            border: 1.5px solid #1a237e;
        }
        .form-textarea {
            min-height: 70px;
            resize: vertical;
        }
        .form-upload-row {
            display: flex;
            gap: 24px;
            margin-bottom: 24px;
        }
        .upload-box {
            flex: 1;
            border: 2px dashed #cfd8dc;
            border-radius: 8px;
            background: #fafbfc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 28px 0 22px 0;
            color: #888;
            font-size: 15px;
            cursor: pointer;
            transition: border 0.2s;
        }
        .upload-box:hover {
            border: 2px solid #1a237e;
            color: #1a237e;
        }
        .upload-box i {
            font-size: 28px;
            margin-bottom: 8px;
            color: #b0bec5;
        }
        .form-actions {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-top: 18px;
        }
        .btn {
            padding: 10px 24px;
            border-radius: 6px;
            border: none;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        .btn-cancel {
            background: none;
            color: #444;
        }
        .btn-preview {
            background: #fff;
            color: #1a237e;
            border: 1.5px solid #1a237e;
        }
        .btn-preview:hover {
            background: #e8eaf6;
        }
        .btn-generate {
            background: #43a047;
            color: #fff;
        }
        .btn-generate:hover {
            background: #388e3c;
        }
        .footer {
            background: #f5f6f8;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 32px 0 32px;
            color: #888;
            font-size: 13px;
            margin-top: 24px;
        }
        .footer-links a {
            color: #888;
            text-decoration: underline;
            margin-left: 18px;
        }
        @media (max-width: 1100px) {
            .main-container { padding: 0 4px; }
            .content { padding: 32px 8px 24px 8px; }
        }
        @media (max-width: 900px) {
            .main-wrapper { flex-direction: column; }
            .sidebar { width: 100%; border-right: none; border-bottom: 1px solid #e0e0e0; min-height: unset; }
            .content { padding: 32px 8px 24px 8px; }
        }
        @media (max-width: 600px) {
            .navbar { padding: 0 8px; }
            .sidebar { padding: 18px 6px; }
            .content { padding: 18px 2px 12px 2px; }
            .form-row, .form-upload-row { flex-direction: column; gap: 12px; }
            .footer { flex-direction: column; gap: 8px; padding: 12px 4px 0 4px; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-[#1a237e] text-white h-16 px-6 flex items-center justify-between sticky top-0 z-40">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-semibold text-lg hover:opacity-90 transition">
            <img class="h-10 w-10" src="{{ asset('images/ditascom-logo.png') }}" alt="Logo"> 
            DITASCOM
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
    <div class="main-wrapper">
        <aside class="sidebar">
            <div class="sidebar-title">Certificate Information</div>
            <div class="sidebar-info">
                <div class="sidebar-label">Certificate ID</div>
                <div class="sidebar-value">BCG001</div>
            </div>
            <div class="sidebar-info">
                <div class="sidebar-label">Certificate Type</div>
                <div class="sidebar-value">Baptismal Certificate</div>
            </div>
            <div class="sidebar-info">
                <div class="sidebar-label">Requester</div>
                <div class="sidebar-value">John Michael Smith</div>
            </div>
            <div class="sidebar-info">
                <div class="sidebar-label">Status</div>
                <div class="sidebar-status">Approved</div>
            </div>
            <div class="sidebar-info">
                <div class="sidebar-label">Request Date</div>
                <div class="sidebar-value">2024-01-15</div>
            </div>
        </aside>
        <main class="content">
            <div class="content-title">Generate Certificate</div>
            <div class="content-desc">Create official certificate for approved request</div>
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Certificate Number*</label>
                        <input type="text" class="form-input" placeholder="Enter certificate number" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Issue Date*</label>
                        <input type="date" class="form-input" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Expiry Date*</label>
                        <input type="date" class="form-input" required>
                    </div>
                </div>
                <div class="form-upload-row">
                    <div class="upload-box">
                        <i class="fas fa-signature"></i>
                        <div>Drop signature image or click to upload</div>
                        <input type="file" accept="image/*" style="display:none;">
                    </div>
                    <div class="upload-box">
                        <i class="fas fa-stamp"></i>
                        <div>Drop official seal or click to upload</div>
                        <input type="file" accept="image/*" style="display:none;">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Additional Notes</label>
                    <textarea class="form-textarea" placeholder="Enter any additional notes"></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel">Cancel</button>
                    <button type="button" class="btn btn-preview">Preview Certificate</button>
                    <button type="submit" class="btn btn-generate">Generate & Save</button>
                </div>
            </form>
        </main>
    </div>
    <div class="footer">
        <div>© 2024 DITASCOM. All rights reserved.</div>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Contact Us</a>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" style="display:none;position:fixed;z-index:9999;left:0;top:0;width:100vw;height:100vh;background:rgba(30,42,120,0.10);align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(30,42,120,0.10);padding:40px 32px 32px 32px;min-width:320px;max-width:90vw;display:flex;flex-direction:column;align-items:center;position:relative;">
            <button onclick="closeSuccessModal()" style="position:absolute;top:18px;right:18px;background:none;border:none;font-size:1.3rem;color:#888;cursor:pointer;">&times;</button>
            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="32" cy="32" r="30" stroke="#43a047" stroke-width="4" fill="#e8f5e9"/>
                <path id="checkmarkPath" d="M20 34L29 43L44 25" stroke="#43a047" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="36" stroke-dashoffset="36"/>
            </svg>
            <div style="font-size:1.3rem;font-weight:600;color:#222;margin-top:18px;margin-bottom:6px;">Certificate Generated Successfully!</div>
            <div style="color:#666;font-size:1rem;margin-bottom:18px;text-align:center;">The certificate has been generated and saved.</div>
            <button onclick="closeSuccessModal()" style="background:#43a047;color:#fff;padding:10px 32px;border:none;border-radius:6px;font-size:1rem;font-weight:600;cursor:pointer;">Close</button>
        </div>
    </div>
    <script>
        // Animate checkmark
        function animateCheckmark() {
            var path = document.getElementById('checkmarkPath');
            path.style.transition = 'none';
            path.setAttribute('stroke-dashoffset', 36);
            setTimeout(function() {
                path.style.transition = 'stroke-dashoffset 0.6s ease';
                path.setAttribute('stroke-dashoffset', 0);
            }, 100);
        }
        // Modal logic
        function closeSuccessModal() {
            document.getElementById('successModal').style.display = 'none';
            window.location.href = "{{ route('admin.certificate-requests.index') }}";
        }
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('successModal').style.display = 'flex';
            animateCheckmark();
        });
        // Cancel button logic
        document.querySelector('.btn-cancel').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = "{{ url('admin/certificate_request_details') }}";
        });
    </script>
</body>
</html> 