<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <title>DOT My Sacrament - Parish Calendar</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    /* Parish Dropdown Styles */
    .parish-dropdown-wrapper {
      position: relative;
      width: 100%;
    }

    .parish-search-input {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #e5e7eb;
      border-radius: 8px;
      font-size: 16px;
      outline: none;
      transition: all 0.3s ease;
      background: white;
    }

    .parish-search-input:focus {
      border-color: #1a237e;
      box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.1);
    }

    .parish-dropdown {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: white;
      border: 2px solid #e5e7eb;
      border-top: none;
      border-radius: 0 0 8px 8px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      max-height: 300px;
      overflow-y: auto;
    }

    .parish-option {
      padding: 12px 16px;
      cursor: pointer;
      border-bottom: 1px solid #f3f4f6;
      transition: background-color 0.2s ease;
    }

    .parish-option:hover {
      background-color: #f8fafc;
    }

    .parish-option.selected {
      background-color: #1a237e;
      color: white;
    }

    .parish-option:last-child {
      border-bottom: none;
    }

    .parish-option-name {
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 2px;
    }

    .parish-option-address {
      font-size: 12px;
      color: #6b7280;
    }

    .parish-option.selected .parish-option-address {
      color: #e5e7eb;
    }

    .parish-pagination {
      padding: 12px 16px;
      border-top: 1px solid #e5e7eb;
      background-color: #f9fafb;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .parish-pagination-info {
      font-size: 12px;
      color: #6b7280;
    }

    .parish-pagination-controls {
      display: flex;
      gap: 8px;
    }

    .parish-pagination-btn {
      padding: 4px 8px;
      border: 1px solid #d1d5db;
      background: white;
      color: #374151;
      border-radius: 4px;
      cursor: pointer;
      font-size: 12px;
      transition: all 0.2s ease;
    }

    .parish-pagination-btn:hover:not(:disabled) {
      background-color: #f3f4f6;
      border-color: #9ca3af;
    }

    .parish-pagination-btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .no-parishes {
      padding: 20px 16px;
      text-align: center;
      color: #6b7280;
      font-size: 14px;
    }

    .loading-parishes {
      padding: 20px 16px;
      text-align: center;
      color: #6b7280;
      font-size: 14px;
    }
  </style>

  <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
</head>
<body class="bg-gray-50">

  <!-- Header -->
  <div class="bg-[#1a237e] px-6 py-4 flex justify-between items-center shadow-md">
    <div class="flex items-center gap-3">
      <img class="w-12 h-12" src="{{ asset('images/ditascom-logo.png') }}" alt="DOT My Sacrament Logo">
      <span class="text-white text-xl font-semibold">DOT My Sacrament</span>
    </div>
    <div class="flex gap-4 items-center">
      <a href="{{ route('certificate.verification') }}" class="text-white hover:text-gray-200 transition flex items-center gap-2">
        <i class="fas fa-certificate"></i>
        <span class="hidden sm:inline">Verify Certificate</span>
      </a>
      <a href="{{ route('faq') }}" class="text-white hover:text-gray-200 transition flex items-center gap-2">
        <i class="fas fa-question-circle"></i>
        <span class="hidden sm:inline">FAQ</span>
      </a>
      <a href="{{ route('login') }}" class="bg-white text-[#1a237e] px-5 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
        Login
      </a>
    </div>
  </div>

  <!-- Parish Selection -->
  <div class="select-parish">
    <label for="parish-search">Select Parish</label>
    <div class="select-container">
      <div class="parish-dropdown-wrapper">
        <input type="text" 
               id="parish-search" 
               placeholder="Search for a parish..." 
               class="parish-search-input"
               autocomplete="off">
        <input type="hidden" id="parish-select" value="">
        
        <!-- Dropdown options -->
        <div id="parish-dropdown" class="parish-dropdown hidden">
          <div class="parish-options" id="parish-options">
            <!-- Parishes will be dynamically loaded -->
          </div>
          
          <!-- Pagination controls -->
          <div class="parish-pagination" id="parish-pagination">
            <!-- Pagination will be dynamically added -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="calendar-card">
    <div class="text-xl font-semibold text-black mb-5">Calendar</div>
    <div class="calendar-header">
      <button id="prevMonth" class="nav-button">
        <i class="fas fa-chevron-left"></i>
        <span class="ml-2 hidden sm:inline">Previous</span>
      </button>
      <span id="calendar-month-year" class="text-lg font-medium text-center">October 2025</span>
      <button id="nextMonth" class="nav-button">
        <span class="mr-2 hidden sm:inline">Next</span>
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
    <div class="calendar-grid" id="calendar-grid">
      <!-- Calendar will be rendered here by JavaScript -->
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <div>© 2024 DOT My Sacrament. All rights reserved</div>
  </div>
<script src='https://cdn.jotfor.ms/agent/embedjs/019a3f6363b270f9bb21ce6bed14513d2400/embed.js'>
</script>

  <!-- JavaScript -->
  <script src="{{ asset('js/parish-dropdown.js') }}"></script>
  <script src="{{ asset('js/calendar.js') }}"></script>

</body>
</html>
