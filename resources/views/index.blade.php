<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title>DOT My Sacrament - Parish Calendar</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/ditascom-logo.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/ditascom-logo.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/ditascom-logo.png') }}">

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

  <link rel="stylesheet" href="{{ asset('css/calendar.css') }}?v={{ time() }}">
</head>

<body class="bg-gray-50">

  <!-- Header -->
  <div class="bg-[#1a237e] px-6 py-4 flex justify-between items-center shadow-md">
    <div class="flex items-center gap-3">
      <img class="w-12 h-12" src="{{ asset('images/ditascom-logo.png') }}" alt="DOT My Sacrament Logo">
      <span class="text-white text-xl font-semibold">DOT My Sacrament</span>
    </div>
    <div class="flex gap-4 items-center">
      <a href="{{ route('certificate.verification') }}"
        class="text-white hover:text-gray-200 transition flex items-center gap-2">
        <i class="fas fa-certificate"></i>
        <span class="hidden sm:inline">Verify Certificate</span>
      </a>
      <a href="{{ route('faq') }}" class="text-white hover:text-gray-200 transition flex items-center gap-2">
        <i class="fas fa-question-circle"></i>
        <span class="hidden sm:inline">FAQ</span>
      </a>
      <a href="{{ route('login') }}"
        class="bg-white text-[#1a237e] px-5 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
        Login
      </a>
    </div>
  </div>

  <!-- Parish Selection -->
  <div class="select-parish">
    <label for="parish-search">Select Parish</label>
    <div class="select-container">
      <div class="parish-dropdown-wrapper">
        <input type="text" id="parish-search" placeholder="Search for a parish..." class="parish-search-input"
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

  <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-12">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
      <div>
        <h2 class="text-[#312e81] text-xl font-medium mb-1">Liturgical Calendar</h2>
        <p class="text-gray-500 text-sm">Explore upcoming masses, community gatherings, and parish services.</p>
      </div>
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
        <!-- Navigation arrows -->
        <div class="flex bg-white rounded-lg shadow-sm border border-gray-200 h-[40px]">
          <button id="prevMonth" class="px-3 text-gray-500 hover:text-gray-800 border-r border-gray-200">
            <i class="fas fa-chevron-left text-sm"></i>
          </button>
          <div class="px-4 font-medium text-gray-700 text-sm min-w-[140px] flex items-center justify-center"
            id="calendar-month-year"></div>
          <button id="nextMonth" class="px-3 text-gray-500 hover:text-gray-800 border-l border-gray-200">
            <i class="fas fa-chevron-right text-sm"></i>
          </button>
        </div>


      </div>
    </div>

    <!-- Calendar Grid Wrapper -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
      <!-- Days of week -->
      <div class="grid grid-cols-7 border-b border-gray-200">
        <div class="py-4 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">SUN</div>
        <div
          class="py-4 text-center text-sm font-medium text-gray-500 uppercase tracking-wider border-l border-gray-200">
          MON</div>
        <div
          class="py-4 text-center text-sm font-medium text-gray-500 uppercase tracking-wider border-l border-gray-200">
          TUE</div>
        <div
          class="py-4 text-center text-sm font-medium text-gray-500 uppercase tracking-wider border-l border-gray-200">
          WED</div>
        <div
          class="py-4 text-center text-sm font-medium text-gray-500 uppercase tracking-wider border-l border-gray-200">
          THU</div>
        <div
          class="py-4 text-center text-sm font-medium text-gray-500 uppercase tracking-wider border-l border-gray-200">
          FRI</div>
        <div
          class="py-4 text-center text-sm font-medium text-gray-500 uppercase tracking-wider border-l border-gray-200">
          SAT</div>
      </div>
      <!-- Days grid -->
      <div class="grid grid-cols-7 bg-gray-100 gap-[1px]" id="calendar-grid">
        <!-- Calendar will be rendered here by JavaScript -->
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <div>© 2024 DOT My Sacrament. All rights reserved</div>
  </div>
  <script src='https://cdn.jotfor.ms/agent/embedjs/019a3f6363b270f9bb21ce6bed14513d2400/embed.js'>
  </script>

  <!-- JavaScript -->
  <script src="{{ asset('js/parish-dropdown.js') }}?v={{ time() }}"></script>
  <script src="{{ asset('js/calendar.js') }}?v={{ time() }}"></script>

</body>

</html>