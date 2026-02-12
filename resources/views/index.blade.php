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
    <label for="parish-select">Select Parish</label>
    <div class="select-container">
      <select id="parish-select" class="select-input">
        <option value="" disabled selected>Choose a church to view events</option>
        <!-- Parishes will be dynamically loaded from the database -->
      </select>
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
  <script src="{{ asset('js/calendar.js') }}"></script>

</body>
</html>
