/**
 * DITASCOM Parish Calendar JavaScript
 * Handles calendar rendering, parish selection, and event display
 */


// Calendar state variables
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();
let selectedParish = '';


// Month names for display
const monthNames = [
  'January', 'February', 'March', 'April', 'May', 'June',
  'July', 'August', 'September', 'October', 'November', 'December'
];


// Sample parish events data
const parishEvents = {
  'sto-nino': {
    name: 'Sto. Niño Parish',
    events: [
      { date: '2025-10-17', title: 'Parish Festival', time: '5:00 PM' },
      { date: '2025-10-18', title: 'Youth Ministry', time: '4:00 PM' },
      { date: '2025-10-21', title: 'Bible Study', time: '7:00 PM' },
      { date: '2025-10-25', title: 'Community Service', time: '9:00 AM' }
    ]
  },
  'gamao': {
    name: 'Gamao Parish',
    events: [
      { date: '2024-10-16', title: 'Choir Practice', time: '6:00 PM' },
      { date: '2024-10-19', title: 'Marriage Prep', time: '7:00 PM' },
      { date: '2024-10-23', title: 'Senior Ministry', time: '2:00 PM' },
      { date: '2024-10-27', title: 'Food Drive', time: '10:00 AM' }
    ]
  },
  'san-agustin': {
    name: 'San Agustin Parish',
    events: [
      { date: '2024-10-15', title: 'Confirmation Class', time: '3:00 PM' },
      { date: '2024-10-20', title: 'Prayer Meeting', time: '6:30 PM' },
      { date: '2024-10-24', title: 'Baptism Prep', time: '8:00 AM' },
      { date: '2024-10-28', title: 'Parish Council', time: '7:30 PM' }
    ]
  }
};


/**
 * Load parishes from database and populate the dropdown
 */
async function loadParishesFromDatabase() {
  try {
    const response = await fetch('/api/parishes');
    const parishes = await response.json();
    
    const parishSelect = document.getElementById('parish-select');
    
    if (!parishSelect) {
      console.error('Parish selector not found');
      return;
    }
    
    // Clear existing options except the first one (placeholder)
    while (parishSelect.options.length > 1) {
      parishSelect.remove(1);
    }
    
    // Add parishes from database
    parishes.forEach(parish => {
      const option = document.createElement('option');
      option.value = parish.value;
      option.textContent = parish.name;
      parishSelect.appendChild(option);
      
      // Initialize parish in parishEvents if not exists
      if (!parishEvents[parish.value]) {
        parishEvents[parish.value] = {
          name: parish.name,
          events: []
        };
      }
    });
    
    console.log('Parishes loaded from database:', parishes);
  } catch (error) {
    console.error('Error loading parishes:', error);
  }
}


/**
 * Initialize the calendar when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', function() {
  initializeCalendar();
  loadParishesFromDatabase();
  initializeParishSelector();
  initializeChatbot();
});


/**
 * Initialize calendar functionality
 */
function initializeCalendar() {
  const calendarGrid = document.getElementById('calendar-grid');
  const monthYearDisplay = document.getElementById('calendar-month-year');
  const prevMonthBtn = document.getElementById('prevMonth');
  const nextMonthBtn = document.getElementById('nextMonth');


  if (!calendarGrid || !monthYearDisplay || !prevMonthBtn || !nextMonthBtn) {
    console.error('Calendar elements not found');
    return;
  }


  // Add event listeners for navigation buttons
  prevMonthBtn.addEventListener('click', navigateToPreviousMonth);
  nextMonthBtn.addEventListener('click', navigateToNextMonth);


  // Render initial calendar
  renderCalendar(currentMonth, currentYear);
}


/**
 * Navigate to previous month
 */
function navigateToPreviousMonth() {
  currentMonth--;
  if (currentMonth < 0) {
    currentMonth = 11;
    currentYear--;
  }
  renderCalendar(currentMonth, currentYear);
}


/**
 * Navigate to next month
 */
function navigateToNextMonth() {
  currentMonth++;
  if (currentMonth > 11) {
    currentMonth = 0;
    currentYear++;
  }
  renderCalendar(currentMonth, currentYear);
}


/**
 * Render the calendar for a specific month and year
 * @param {number} month - Month index (0-11)
 * @param {number} year - Full year
 */
function renderCalendar(month, year) {
  const calendarGrid = document.getElementById('calendar-grid');
  const monthYearDisplay = document.getElementById('calendar-month-year');
  const today = new Date();


  // Update month/year display
  monthYearDisplay.textContent = `${monthNames[month]} ${year}`;


  // Clear existing calendar content but keep headers
  calendarGrid.innerHTML = `
    <div class="day-header">Sun</div>
    <div class="day-header">Mon</div>
    <div class="day-header">Tue</div>
    <div class="day-header">Wed</div>
    <div class="day-header">Thu</div>
    <div class="day-header">Fri</div>
    <div class="day-header">Sat</div>
  `;


  // Calculate first day of month and number of days
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();


  // Add empty cells for days before the first day of the month
  for (let i = 0; i < firstDay; i++) {
    const emptyDay = document.createElement('div');
    emptyDay.className = 'day empty';
    calendarGrid.appendChild(emptyDay);
  }


  // Add days of the month
  for (let day = 1; day <= daysInMonth; day++) {
    const dayElement = createDayElement(day, month, year, today);
    calendarGrid.appendChild(dayElement);
  }
}


/**
 * Create a day element for the calendar
 * @param {number} day - Day of the month
 * @param {number} month - Month index
 * @param {number} year - Full year
 * @param {Date} today - Today's date
 * @returns {HTMLElement} Day element
 */
function createDayElement(day, month, year, today) {
  const dayElement = document.createElement('div');
  const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
  
  // Check if this is today
  const isToday = day === today.getDate() && 
                  month === today.getMonth() && 
                  year === today.getFullYear();


  // Base classes
  let dayClasses = 'day';
  if (isToday) {
    dayClasses += ' today';
  }


  // Check for events on this date
  const dayEvents = getEventsForDate(dateString);
  if (dayEvents.length > 0) {
    dayClasses += ' has-events';
  }


  dayElement.className = dayClasses;


  // Create day content
  const dayNumber = document.createElement('div');
  dayNumber.className = 'day-number';
  dayNumber.textContent = day;
  dayElement.appendChild(dayNumber);


  // Add event indicators (will be hidden on mobile via CSS)
  dayEvents.forEach(event => {
    const eventIndicator = document.createElement('div');
    eventIndicator.className = 'event-indicator';
    eventIndicator.textContent = event.title;
    eventIndicator.title = `${event.title} at ${event.time}`;
    dayElement.appendChild(eventIndicator);
  });


  // Add click event listener
  dayElement.addEventListener('click', () => handleDayClick(day, month, year, dayEvents));


  return dayElement;
}


/**
 * Get events for a specific date
 * @param {string} dateString - Date in YYYY-MM-DD format
 * @returns {Array} Array of events for the date
 */
function getEventsForDate(dateString) {
  // Return empty array if no parish is selected
  if (!selectedParish) {
    return [];
  }

  // Get events from localStorage (added by subadmin)
  const storedEvents = JSON.parse(localStorage.getItem('events') || '[]');
  
  // Filter events for this specific date and selected parish (only actual events, not mass schedules)
  const eventsForDate = storedEvents.filter(event => {
    if (!event.isEvent) return false; // Skip mass schedules
    if (event.date !== dateString) return false; // Wrong date
    // Match parish by slug
    const eventParishSlug = generateParishSlug(event.parish_name || '');
    return eventParishSlug === selectedParish;
  });

  // Also check hardcoded parish events if a parish is selected
  if (selectedParish && parishEvents[selectedParish]) {
    const parishEventsForDate = parishEvents[selectedParish].events.filter(event => event.date === dateString);
    return [...eventsForDate, ...parishEventsForDate];
  }

  return eventsForDate;
}

/**
 * Generate a URL-friendly slug from parish name
 * @param {string} parishName - Parish name
 * @returns {string} Slug
 */
function generateParishSlug(parishName) {
  return parishName.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-');
}


/**
 * Get mass schedules for a specific day of the week
 * @param {number} dayOfWeek - Day of week (0-6, Sunday-Saturday)
 * @returns {Array} Array of mass schedules for the day
 */
function getMassSchedulesForDay(dayOfWeek) {
  // Return empty array if no parish is selected
  if (!selectedParish) {
    return [];
  }

  const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  const dayName = dayNames[dayOfWeek];
  
  // Get mass schedules from localStorage
  const storedEvents = JSON.parse(localStorage.getItem('events') || '[]');
  
  // Filter mass schedules for this day and selected parish
  return storedEvents.filter(event => {
    if (event.isEvent) return false; // Skip events
    if (event.day !== dayName) return false; // Wrong day
    // Match parish by slug
    const eventParishSlug = generateParishSlug(event.parish_name || '');
    return eventParishSlug === selectedParish;
  });
}

/**
 * Handle day click event
 * @param {number} day - Day of the month
 * @param {number} month - Month index
 * @param {number} year - Full year
 * @param {Array} events - Events for this day
 */
function handleDayClick(day, month, year, events) {
  const dateString = `${monthNames[month]} ${day}, ${year}`;
  const date = new Date(year, month, day);
  const dayOfWeek = date.getDay();
  
  // Get mass schedules for this day of the week
  const massSchedules = getMassSchedulesForDay(dayOfWeek);
  
   // Create modal content
  let modalContent = `<div style="
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    padding: 20px;
  " onclick="this.remove()">
    <div style="
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      width: 100%;
      max-width: 600px;
      max-height: 85vh;
      overflow-y: auto;
      box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    " onclick="event.stopPropagation()">
      <h3 style="
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #1a237e;
        border-bottom: 3px solid #1a237e;
        padding-bottom: 0.75rem;
      ">${dateString}</h3>`;

  // Show mass schedules if any
  if (massSchedules.length > 0) {
    modalContent += `<div style="margin-bottom: 1.5rem;">
      <h4 style="font-size: 1.125rem; font-weight: 700; color: #1a237e; margin-bottom: 1rem; display: flex; align-items: center;">
        <i class="fas fa-church" style="margin-right: 0.75rem; font-size: 1.25rem;"></i>Mass Schedule
      </h4>`;
    massSchedules.forEach(mass => {
      const [hours, minutes] = mass.time.split(':');
      const hour = parseInt(hours);
      const ampm = hour >= 12 ? 'PM' : 'AM';
      const hour12 = hour % 12 || 12;
      const formattedTime = `${hour12}:${minutes} ${ampm}`;
      
      modalContent += `
        <div style="
          padding: 1rem 1.25rem;
          margin-bottom: 0.75rem;
          background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
          border-radius: 0.75rem;
          border-left: 5px solid #f59e0b;
          box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
        ">
          <div style="font-weight: 600; color: #92400e; font-size: 1.125rem; margin-bottom: 0.5rem;">${mass.type} Mass</div>
          <div style="font-size: 1rem; color: #78350f; display: flex; align-items: center;">
            <i class="fas fa-clock" style="margin-right: 0.5rem; font-size: 1rem;"></i>
            <span style="font-weight: 500;">${formattedTime}</span>
          </div>
        </div>`;
    });
    modalContent += `</div>`;
  }

  // Show events if any
  if (events.length > 0) {
    modalContent += `<div style="margin-bottom: 1.5rem;">
      <h4 style="font-size: 1.125rem; font-weight: 700; color: #1a237e; margin-bottom: 1rem; display: flex; align-items: center;">
        <i class="fas fa-calendar-alt" style="margin-right: 0.75rem; font-size: 1.25rem;"></i>Events
      </h4>`;
    events.forEach(event => {
      modalContent += `
        <div style="
          padding: 1rem 1.25rem;
          margin-bottom: 0.75rem;
          background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
          border-radius: 0.75rem;
          border-left: 5px solid #1a237e;
          box-shadow: 0 2px 8px rgba(26, 35, 126, 0.2);
        ">
          <div style="font-weight: 600; color: #1e3a8a; font-size: 1.125rem; margin-bottom: 0.5rem;">${event.title}</div>
          <div style="font-size: 1rem; color: #1e40af; display: flex; align-items: center;">
            <i class="fas fa-clock" style="margin-right: 0.5rem; font-size: 1rem;"></i>
            <span style="font-weight: 500;">${event.time}</span>
          </div>
        </div>`;
    });
    modalContent += `</div>`;
  }
  
  // Show message if no events or mass schedules
  if (events.length === 0 && massSchedules.length === 0) {
    modalContent += `
      <div style="
        text-align: center;
        padding: 3rem 2rem;
        color: #9ca3af;
        background: #f9fafb;
        border-radius: 0.75rem;
        margin: 1rem 0;
      ">
        <i class="fas fa-calendar-times" style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.4; color: #d1d5db;"></i>
        <p style="font-size: 1.125rem; font-weight: 500; margin: 0;">No events or mass schedules for this day.</p>
      </div>`;
  }


  modalContent += `
      <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 2px solid #e5e7eb;">
        <button class="modal-close-btn" style="
          background: #1a237e;
          color: white;
          border: none;
          padding: 0.75rem 2rem;
          border-radius: 0.75rem;
          cursor: pointer;
          font-size: 1rem;
          font-weight: 600;
          transition: all 0.3s ease;
          box-shadow: 0 4px 12px rgba(26, 35, 126, 0.3);
        " onmouseover="this.style.background='#0d1642'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(26, 35, 126, 0.4)';" onmouseout="this.style.background='#1a237e'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(26, 35, 126, 0.3)';">Close</button>
      </div>
    </div>
  </div>`;



  // Add modal to page
  document.body.insertAdjacentHTML('beforeend', modalContent);
  
  // Add event listener to close button
  const modalElement = document.body.lastElementChild;
  const closeBtn = modalElement.querySelector('.modal-close-btn');
  closeBtn.addEventListener('click', () => {
    modalElement.remove();
  });
  
  // Also allow clicking outside to close
  modalElement.addEventListener('click', (e) => {
    if (e.target === modalElement) {
      modalElement.remove();
    }
  });
}


/**
 * Initialize parish selector functionality
 */
function initializeParishSelector() {
  const parishSelect = document.getElementById('parish-select');
  
  if (!parishSelect) {
    console.error('Parish selector not found');
    return;
  }


  // Add event listener for parish selection
  parishSelect.addEventListener('change', handleParishChange);
}


/**
 * Handle parish selection change
 * @param {Event} event - Change event
 */
function handleParishChange(event) {
  selectedParish = event.target.value;
  
  // Re-render calendar to show events for selected parish
  renderCalendar(currentMonth, currentYear);
  
  // Update chatbot context
  updateChatbotContext();
}


/**
 * Update chatbot context based on selected parish
 */
function updateChatbotContext() {
  if (selectedParish && parishEvents[selectedParish]) {
    console.log(`Parish context updated to: ${parishEvents[selectedParish].name}`);
  }
}


/**
 * Initialize chatbot functionality
 */
function initializeChatbot() {
  const chatButton = document.getElementById('chatButton');
  const chatContainer = document.getElementById('chatContainer');
  const closeChat = document.getElementById('closeChat');
  const sendMessage = document.getElementById('sendMessage');
  const userInput = document.getElementById('userInput');


  if (!chatButton || !chatContainer || !closeChat || !sendMessage || !userInput) {
    console.error('Chatbot elements not found');
    return;
  }


  // Chatbot event listeners
  chatButton.addEventListener('click', openChatbot);
  closeChat.addEventListener('click', closeChatbot);
  sendMessage.addEventListener('click', handleSendMessage);
  userInput.addEventListener('keypress', handleUserInputKeypress);
}


/**
 * Open chatbot interface
 */
function openChatbot() {
  const chatContainer = document.getElementById('chatContainer');
  chatContainer.style.display = 'flex';
}


/**
 * Close chatbot interface
 */
function closeChatbot() {
  const chatContainer = document.getElementById('chatContainer');
  chatContainer.style.display = 'none';
}


/**
 * Handle send message button click
 */
function handleSendMessage() {
  const userInput = document.getElementById('userInput');
  const message = userInput.value.trim();
  
  if (message) {
    processUserMessage(message);
    userInput.value = '';
  }
}


/**
 * Handle user input keypress events
 * @param {KeyboardEvent} event - Keypress event
 */
function handleUserInputKeypress(event) {
  if (event.key === 'Enter') {
    handleSendMessage();
  }
}


/**
 * Process user message and generate response
 * @param {string} message - User message
 */
function processUserMessage(message) {
  addMessageToChat(message, true);
  
  // Generate bot response
  const response = generateBotResponse(message.toLowerCase());
  
  // Add bot response with delay
  setTimeout(() => {
    addMessageToChat(response, false);
  }, 500);
}


/**
 * Add message to chat interface
 * @param {string} message - Message text
 * @param {boolean} isUser - Whether message is from user
 */
function addMessageToChat(message, isUser = false) {
  const chatMessages = document.getElementById('chatMessages');
  const messageDiv = document.createElement('div');
  messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;
  
  const messageContent = document.createElement('div');
  messageContent.className = 'message-content';
  messageContent.textContent = message;
  
  messageDiv.appendChild(messageContent);
  chatMessages.appendChild(messageDiv);
  
  // Scroll to bottom
  chatMessages.scrollTop = chatMessages.scrollHeight;
}


/**
 * Generate bot response based on user message
 * @param {string} message - User message in lowercase
 * @returns {string} Bot response
 */
function generateBotResponse(message) {
  // Parish-specific responses
  if (selectedParish && parishEvents[selectedParish]) {
    const parishName = parishEvents[selectedParish].name;
    
    if (message.includes('events') || message.includes('schedule')) {
      const upcomingEvents = parishEvents[selectedParish].events
        .slice(0, 3)
        .map(event => `${event.title} on ${event.date} at ${event.time}`)
        .join(', ');
      return `Upcoming events at ${parishName}: ${upcomingEvents}`;
    }
  }


  // General responses
  const responses = {
    'mass schedule': 'Our regular mass schedule is: Sunday (6:00 AM, 8:00 AM, 5:00 PM), Monday-Friday (6:00 AM), Saturday (6:00 AM, 5:00 PM anticipated)',
    'contact': 'You can reach us through our parish office during office hours or email us at info@ditascom.com',
    'events': 'Please select a parish from the dropdown to view specific events in the calendar.',
    'donation': 'We accept donations through various channels. Please visit our parish office for more information.',
    'baptism': 'For baptism inquiries, please visit our parish office to schedule an appointment and get the requirements.',
    'hello': 'Hello! How can I help you with parish information today?',
    'help': 'I can help you with mass schedules, events, contact information, and general parish inquiries. What would you like to know?'
  };


  // Find matching response
  for (const [key, response] of Object.entries(responses)) {
    if (message.includes(key)) {
      return response;
    }
  }


  return "I'm sorry, I don't have information about that. Please contact our parish office for more details or try asking about mass schedules, events, or contact information.";
}
