<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FAQ - DITASCOM</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .faq-item {
      transition: all 0.3s ease;
    }
    .faq-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .faq-question {
      cursor: pointer;
      user-select: none;
    }
    .faq-answer {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }
    .faq-answer.active {
      max-height: 500px;
    }
    .faq-icon {
      transition: transform 0.3s ease;
    }
    .faq-icon.active {
      transform: rotate(180deg);
    }
  </style>
</head>
<body class="bg-gray-50">

  <!-- Header -->
  <div class="bg-[#1a237e] px-6 py-4 flex justify-between items-center shadow-md">
    <div class="flex items-center gap-3">
      <img class="w-12 h-12" src="{{ asset('images/ditascom-logo.png') }}" alt="DITASCOM Logo">
      <span class="text-white text-xl font-semibold">DITASCOM</span>
    </div>
    <div class="flex gap-4 items-center">
      <a href="{{ route('index') }}" class="text-white hover:text-gray-200 transition flex items-center gap-2">
        <i class="fas fa-home"></i>
        <span class="hidden sm:inline">Home</span>
      </a>
      <a href="{{ route('login') }}" class="bg-white text-[#1a237e] px-5 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
        Login
      </a>
    </div>
  </div>

  <!-- FAQ Content -->
  <div class="max-w-5xl mx-auto px-4 py-12">
    <!-- Page Title -->
    <div class="text-center mb-12">
      <h1 class="text-4xl font-bold text-gray-900 mb-3">Frequently Asked Questions</h1>
      <p class="text-gray-600 text-lg">Find answers to common questions about DITASCOM</p>
    </div>

    <!-- FAQ Items -->
    <div class="space-y-4">
      
      <!-- FAQ 1 -->
      <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="faq-question flex justify-between items-center p-5 hover:bg-gray-50" onclick="toggleFaq(this)">
          <div class="flex items-start gap-3">
            <i class="fas fa-question-circle text-[#1a237e] text-xl mt-1"></i>
            <h3 class="text-lg font-semibold text-gray-900">What is DITASCOM?</h3>
          </div>
          <i class="fas fa-chevron-down faq-icon text-[#1a237e]"></i>
        </div>
        <div class="faq-answer px-5 pb-5">
          <div class="pl-9 text-gray-700 leading-relaxed">
            DITASCOM is a web-based church documentation system that helps parishioners and staff easily request, track, and manage church records such as baptismal, confirmation, and marriage certificates. It aims to improve accessibility while ensuring the privacy and security of church data.
          </div>
        </div>
      </div>

      <!-- FAQ 2 -->
      <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="faq-question flex justify-between items-center p-5 hover:bg-gray-50" onclick="toggleFaq(this)">
          <div class="flex items-start gap-3">
            <i class="fas fa-question-circle text-[#1a237e] text-xl mt-1"></i>
            <h3 class="text-lg font-semibold text-gray-900">Who can use DITASCOM?</h3>
          </div>
          <i class="fas fa-chevron-down faq-icon text-[#1a237e]"></i>
        </div>
        <div class="faq-answer px-5 pb-5">
          <div class="pl-9 text-gray-700 leading-relaxed">
            DITASCOM can be accessed by parish staff who manage records and by parishioners who need to request or verify their church documents online.
          </div>
        </div>
      </div>

      <!-- FAQ 3 -->
      <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="faq-question flex justify-between items-center p-5 hover:bg-gray-50" onclick="toggleFaq(this)">
          <div class="flex items-start gap-3">
            <i class="fas fa-question-circle text-[#1a237e] text-xl mt-1"></i>
            <h3 class="text-lg font-semibold text-gray-900">How can I request a baptismal certificate?</h3>
          </div>
          <i class="fas fa-chevron-down faq-icon text-[#1a237e]"></i>
        </div>
        <div class="faq-answer px-5 pb-5">
          <div class="pl-9 text-gray-700 leading-relaxed">
            Log in to your DITASCOM account, go to the "Document Requests" section, and select "Baptismal Certificate." Fill out the required details and submit your request. A confirmation message will appear once your request is received.
          </div>
        </div>
      </div>

      <!-- FAQ 4 -->
      <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="faq-question flex justify-between items-center p-5 hover:bg-gray-50" onclick="toggleFaq(this)">
          <div class="flex items-start gap-3">
            <i class="fas fa-question-circle text-[#1a237e] text-xl mt-1"></i>
            <h3 class="text-lg font-semibold text-gray-900">What documents do I need to request a marriage certificate?</h3>
          </div>
          <i class="fas fa-chevron-down faq-icon text-[#1a237e]"></i>
        </div>
        <div class="faq-answer px-5 pb-5">
          <div class="pl-9 text-gray-700 leading-relaxed">
            You'll need valid identification and details of the marriage such as date, parish, and full names of the couple. You can also check the complete list of requirements under the "Marriage Certificate" section in DITASCOM before submitting your request.
          </div>
        </div>
      </div>

      <!-- FAQ 5 -->
      <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="faq-question flex justify-between items-center p-5 hover:bg-gray-50" onclick="toggleFaq(this)">
          <div class="flex items-start gap-3">
            <i class="fas fa-question-circle text-[#1a237e] text-xl mt-1"></i>
            <h3 class="text-lg font-semibold text-gray-900">How long does it take to process a document request?</h3>
          </div>
          <i class="fas fa-chevron-down faq-icon text-[#1a237e]"></i>
        </div>
        <div class="faq-answer px-5 pb-5">
          <div class="pl-9 text-gray-700 leading-relaxed">
            Processing time varies by parish, but it generally takes 3 to 5 working days. You'll receive an email or system notification once your document is ready for pickup or delivery.
          </div>
        </div>
      </div>

      <!-- FAQ 6 -->
      <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="faq-question flex justify-between items-center p-5 hover:bg-gray-50" onclick="toggleFaq(this)">
          <div class="flex items-start gap-3">
            <i class="fas fa-question-circle text-[#1a237e] text-xl mt-1"></i>
            <h3 class="text-lg font-semibold text-gray-900">Can I cancel or modify my request after submission?</h3>
          </div>
          <i class="fas fa-chevron-down faq-icon text-[#1a237e]"></i>
        </div>
        <div class="faq-answer px-5 pb-5">
          <div class="pl-9 text-gray-700 leading-relaxed">
            Yes. You can cancel or edit a pending request by going to "My Requests" in your DITASCOM account and selecting "Cancel" or "Edit Request," as long as it hasn't been approved or processed yet.
          </div>
        </div>
      </div>

      <!-- FAQ 7 -->
      <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="faq-question flex justify-between items-center p-5 hover:bg-gray-50" onclick="toggleFaq(this)">
          <div class="flex items-start gap-3">
            <i class="fas fa-question-circle text-[#1a237e] text-xl mt-1"></i>
            <h3 class="text-lg font-semibold text-gray-900">How will I know if my document is ready?</h3>
          </div>
          <i class="fas fa-chevron-down faq-icon text-[#1a237e]"></i>
        </div>
        <div class="faq-answer px-5 pb-5">
          <div class="pl-9 text-gray-700 leading-relaxed">
            DITASCOM will send you a notification once your document is processed and available. You can also check your document status by logging into your DITASCOM dashboard.
          </div>
        </div>
      </div>

      <!-- FAQ 8 -->
      <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="faq-question flex justify-between items-center p-5 hover:bg-gray-50" onclick="toggleFaq(this)">
          <div class="flex items-start gap-3">
            <i class="fas fa-question-circle text-[#1a237e] text-xl mt-1"></i>
            <h3 class="text-lg font-semibold text-gray-900">How can I create a DITASCOM account?</h3>
          </div>
          <i class="fas fa-chevron-down faq-icon text-[#1a237e]"></i>
        </div>
        <div class="faq-answer px-5 pb-5">
          <div class="pl-9 text-gray-700 leading-relaxed">
            Visit the official DITASCOM website and click "Sign Up." Fill in your personal information, create a password, and verify your email address. Once your account is confirmed, you can start submitting document requests.
          </div>
        </div>
      </div>

      <!-- FAQ 9 -->
      <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="faq-question flex justify-between items-center p-5 hover:bg-gray-50" onclick="toggleFaq(this)">
          <div class="flex items-start gap-3">
            <i class="fas fa-question-circle text-[#1a237e] text-xl mt-1"></i>
            <h3 class="text-lg font-semibold text-gray-900">What should I do if I forget my DITASCOM password?</h3>
          </div>
          <i class="fas fa-chevron-down faq-icon text-[#1a237e]"></i>
        </div>
        <div class="faq-answer px-5 pb-5">
          <div class="pl-9 text-gray-700 leading-relaxed">
            Click "Forgot Password" on the login page. Enter your registered email address, and a reset link will be sent to you. Follow the instructions in the email to set a new password.
          </div>
        </div>
      </div>

      <!-- FAQ 10 -->
      <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="faq-question flex justify-between items-center p-5 hover:bg-gray-50" onclick="toggleFaq(this)">
          <div class="flex items-start gap-3">
            <i class="fas fa-question-circle text-[#1a237e] text-xl mt-1"></i>
            <h3 class="text-lg font-semibold text-gray-900">Is my personal information safe in DITASCOM?</h3>
          </div>
          <i class="fas fa-chevron-down faq-icon text-[#1a237e]"></i>
        </div>
        <div class="faq-answer px-5 pb-5">
          <div class="pl-9 text-gray-700 leading-relaxed">
            Yes. DITASCOM uses secure encryption and authentication systems to ensure that all personal and church records are protected from unauthorized access.
          </div>
        </div>
      </div>

      <!-- FAQ 11 -->
      <div class="faq-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="faq-question flex justify-between items-center p-5 hover:bg-gray-50" onclick="toggleFaq(this)">
          <div class="flex items-start gap-3">
            <i class="fas fa-question-circle text-[#1a237e] text-xl mt-1"></i>
            <h3 class="text-lg font-semibold text-gray-900">Who do I contact if I encounter technical issues?</h3>
          </div>
          <i class="fas fa-chevron-down faq-icon text-[#1a237e]"></i>
        </div>
        <div class="faq-answer px-5 pb-5">
          <div class="pl-9 text-gray-700 leading-relaxed">
            You can contact the DITASCOM Support Team through the "Help & Support" section in your account or by emailing the parish office linked to your DITASCOM profile. Provide your full name, parish, and a short description of the issue for faster assistance.
          </div>
        </div>
      </div>

    </div>

    <!-- Contact Section -->
    <div class="mt-12 bg-[#1a237e] rounded-xl p-8 text-white text-center">
      <h2 class="text-2xl font-bold mb-3">Still have questions?</h2>
      <p class="text-gray-200 mb-6">Can't find the answer you're looking for? You can go to our AI Chatbot for more assistance. You can see it in the bottom right corner of the screen.</p>
      <a href="{{ route('index') }}" class="inline-block bg-white text-[#1a237e] px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
        <i class="fas fa-home mr-2"></i>
        Back to Home
      </a>
    </div>
  </div>

  <!-- Footer -->
  <div class="bg-gray-800 text-white text-center py-6 mt-12">
    <div>© 2024 DITASCOM. All rights reserved</div>
  </div>

  <script>
    function toggleFaq(element) {
      const answer = element.nextElementSibling;
      const icon = element.querySelector('.faq-icon');
      
      // Close all other FAQs
      document.querySelectorAll('.faq-answer').forEach(item => {
        if (item !== answer) {
          item.classList.remove('active');
        }
      });
      
      document.querySelectorAll('.faq-icon').forEach(item => {
        if (item !== icon) {
          item.classList.remove('active');
        }
      });
      
      // Toggle current FAQ
      answer.classList.toggle('active');
      icon.classList.toggle('active');
    }
  </script>
  <script src='https://cdn.jotfor.ms/agent/embedjs/019a3f6363b270f9bb21ce6bed14513d2400/embed.js'>
</script>

</body>
</html>
