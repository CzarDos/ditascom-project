<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - DOT My Sacrament</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-['Inter'] bg-gray-100 flex flex-col h-screen overflow-hidden">
    <!-- Navbar -->
    <nav class="bg-[#1a237e] px-6 py-3 flex justify-between items-center text-white h-[60px]">
        <a href="#" class="flex items-center gap-2 text-white no-underline font-semibold">
            <img class="w-10 h-10 mr-2" src="{{ asset('images/ditascom-logo.png') }}" alt="Logo"> 
            DOT My Sacrament
        </a>
        <div class="flex items-center gap-4">
            <div class="relative group">
                <a href="#" class="text-white text-lg">
                    <i class="fas fa-user rounded-full border-2 border-white w-8 h-8 flex items-center justify-center"></i>
                </a>
                <div class="hidden group-hover:block absolute right-0 bg-white min-w-[160px] shadow-lg z-10 rounded-md">
                    <a href="{{ route('subadmin.profile') }}" class="text-gray-800 px-4 py-3 block text-sm hover:bg-gray-100">
                        <i class="fas fa-user-circle mr-2"></i> Profile
                    </a>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="text-gray-800 px-4 py-3 block text-sm hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Main Container -->
    <div class="flex h-[calc(100vh-60px)] overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-[250px] bg-white h-full border-r border-gray-300 overflow-y-auto">
            <ul class="list-none pt-6">
                <li>
                    <a href="{{ route('subadmin.dashboard') }}" 
                       class="flex items-center px-6 py-3 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-[#1a237e]">
                        <i class="fas fa-th-large mr-3 w-5"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('subadmin.events') }}" 
                       class="flex items-center px-6 py-3 text-gray-800 no-underline text-sm transition-all bg-indigo-50 text-[#1a237e]">
                        <i class="fas fa-calendar-alt mr-3 w-5"></i>
                        <span>Events</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-6 py-3 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-[#1a237e]">
                        <i class="fas fa-file-alt mr-3 w-5"></i>
                        Certificates
                    </a>
                    <ul class="list-none ml-6">
                        <li>
                            <a href="{{ route('subadmin.certificates.add', ['type' => 'baptismal']) }}" 
                               class="flex items-center px-6 py-2 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-[#1a237e]">
                                <i class="fas fa-chevron-right mr-3 w-5"></i> Add Baptismal
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('subadmin.certificates.add', ['type' => 'death']) }}" 
                               class="flex items-center px-6 py-2 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-[#1a237e]">
                                <i class="fas fa-chevron-right mr-3 w-5"></i> Add Death
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('subadmin.certificates.add', ['type' => 'confirmation']) }}" 
                               class="flex items-center px-6 py-2 text-gray-800 no-underline text-sm transition-all hover:bg-indigo-50 hover:text-[#1a237e]">
                                <i class="fas fa-chevron-right mr-3 w-5"></i> Add Confirmation
                            </a>
                        </li>
                        
                    </ul>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto h-full">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Events & Mass Schedule</h1>
                <div class="flex gap-3">
                    <a href="#" onclick="openEventModal()" 
                       class="bg-[#1a237e] text-white border-none px-4 py-2 rounded-md cursor-pointer flex items-center gap-2 text-sm no-underline hover:bg-[#0d1642]">
                        <i class="fas fa-plus"></i>
                        Add Event
                    </a>
                    <a href="#" onclick="openMassModal()" 
                       class="bg-[#1a237e] text-white border-none px-4 py-2 rounded-md cursor-pointer flex items-center gap-2 text-sm no-underline hover:bg-[#0d1642]">
                        <i class="fas fa-plus"></i>
                        Add Mass Schedule
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-[calc(100%-80px)]">
                <!-- Mass Schedule Section -->
                <div class="bg-white rounded-xl p-6 shadow-sm h-full overflow-y-auto">
                    <h2 class="mb-4 text-gray-800">Mass Schedule</h2>
                    <table class="w-full border-collapse mt-4">
                        <thead>
                            <tr>
                                <th class="px-3 py-3 text-left border-b border-gray-300 font-semibold text-gray-800 bg-gray-50">Day</th>
                                <th class="px-3 py-3 text-left border-b border-gray-300 font-semibold text-gray-800 bg-gray-50">Time</th>
                                <th class="px-3 py-3 text-left border-b border-gray-300 font-semibold text-gray-800 bg-gray-50">Type</th>
                                <th class="px-3 py-3 text-left border-b border-gray-300 font-semibold text-gray-800 bg-gray-50">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="massScheduleBody">
                            <!-- Mass schedule will be dynamically populated -->
                        </tbody>
                    </table>
                </div>

                <!-- Events Section -->
                <div class="bg-white rounded-xl p-6 shadow-sm h-full overflow-y-auto">
                    <h2 class="mb-4 text-gray-800">Upcoming Events</h2>
                    <div class="flex flex-col gap-3" id="eventList">
                        <!-- Events will be dynamically populated -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add/Edit Event Modal -->
    <div id="eventModal" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-[1000]">
        <div class="relative bg-white w-[90%] max-w-[500px] mx-auto my-12 p-6 rounded-xl">
            <div class="flex justify-between items-center mb-4">
                <h2 id="eventModalTitle" class="text-xl font-semibold text-gray-800">Add Event</h2>
                <button onclick="closeEventModal()" class="bg-transparent border-none text-2xl cursor-pointer text-gray-600 hover:text-gray-800">&times;</button>
            </div>
            <form id="eventForm" onsubmit="handleEventSubmit(event)">
                <input type="hidden" id="eventId">
                <div class="mb-4">
                    <label for="eventTitle" class="block mb-2 text-gray-800 font-medium">Event Title</label>
                    <input type="text" id="eventTitle" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-[#1a237e]">
                </div>
                <div class="mb-4">
                    <label for="eventDate" class="block mb-2 text-gray-800 font-medium">Date</label>
                    <input type="date" id="eventDate" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-[#1a237e]">
                </div>
                <div class="mb-4">
                    <label for="eventTime" class="block mb-2 text-gray-800 font-medium">Time</label>
                    <input type="time" id="eventTime" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-[#1a237e]">
                </div>
                <div class="mb-4">
                    <label for="eventType" class="block mb-2 text-gray-800 font-medium">Event Type</label>
                    <select id="eventType" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-[#1a237e]"
                            onchange="handleEventTypeChange()">
                        <option value="mass">Mass</option>
                        <option value="wedding">Wedding</option>
                        <option value="baptism">Baptism</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-4 hidden" id="otherEventTypeDiv">
                    <label for="otherEventType" class="block mb-2 text-gray-800 font-medium">Specify Event Type</label>
                    <input type="text" id="otherEventType" 
                           placeholder="Enter custom event type..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-[#1a237e]">
                </div>
                <button type="submit" class="bg-[#1a237e] text-white border-none px-4 py-2 rounded-md cursor-pointer flex items-center gap-2 text-sm hover:bg-[#0d1642]">Save Event</button>
            </form>
        </div>
    </div>

    <!-- Add/Edit Mass Schedule Modal -->
    <div id="massModal" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-[1000]">
        <div class="relative bg-white w-[90%] max-w-[500px] mx-auto my-12 p-6 rounded-xl">
            <div class="flex justify-between items-center mb-4">
                <h2 id="massModalTitle" class="text-xl font-semibold text-gray-800">Add Mass Schedule</h2>
                <button onclick="closeMassModal()" class="bg-transparent border-none text-2xl cursor-pointer text-gray-600 hover:text-gray-800">&times;</button>
            </div>
            <form id="massForm" onsubmit="handleMassSubmit(event)">
                <input type="hidden" id="massId">
                <div class="mb-4">
                    <label for="massDay" class="block mb-2 text-gray-800 font-medium">Day</label>
                    <select id="massDay" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-[#1a237e]">
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="massTime" class="block mb-2 text-gray-800 font-medium">Time</label>
                    <input type="time" id="massTime" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-[#1a237e]">
                </div>
                <div class="mb-4">
                    <label for="massType" class="block mb-2 text-gray-800 font-medium">Type</label>
                    <select id="massType" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-[#1a237e]">
                        <option value="Regular">Regular</option>
                        <option value="Special">Special</option>
                    </select>
                </div>
                <button type="submit" class="bg-[#1a237e] text-white border-none px-4 py-2 rounded-md cursor-pointer flex items-center gap-2 text-sm hover:bg-[#0d1642]">Save Mass Schedule</button>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-[1000]">
        <div class="relative bg-white max-w-[300px] mx-auto my-12 p-6 rounded-xl text-center">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Success!</h2>
                <button onclick="closeSuccessModal()" class="bg-transparent border-none text-2xl cursor-pointer text-gray-600 hover:text-gray-800">&times;</button>
            </div>
            <div class="py-5">
                <i class="fas fa-check-circle text-5xl text-green-500 mb-4"></i>
                <p id="successMessage">Event has been saved successfully!</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="px-6 py-4 bg-white border-t border-gray-300 text-xs text-gray-600 flex justify-center h-[50px] " >
        <div>© 2024 DOT My Sacrament. All rights reserved.</div>
    </footer>

    <script>
        // Parish name from the authenticated user
        const PARISH_NAME = @json($parishName ?? '');

        // Toggle submenu visibility
        document.querySelectorAll('.nav-item').forEach(item => {
            const submenu = item.querySelector('.submenu');
            if (submenu) {
                item.querySelector('a').addEventListener('click', (e) => {
                    e.preventDefault();
                    submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
                });
            }
        });

        // Event handling functions
        function handleEventTypeChange() {
            const eventType = document.getElementById('eventType').value;
            const otherEventTypeDiv = document.getElementById('otherEventTypeDiv');
            const otherEventTypeInput = document.getElementById('otherEventType');
            
            if (eventType === 'other') {
                otherEventTypeDiv.classList.remove('hidden');
                otherEventTypeInput.required = true;
            } else {
                otherEventTypeDiv.classList.add('hidden');
                otherEventTypeInput.required = false;
                otherEventTypeInput.value = '';
            }
        }

        function openEventModal(eventId = null) {
            const modal = document.getElementById('eventModal');
            const title = document.getElementById('eventModalTitle');
            const form = document.getElementById('eventForm');
            
            // Load events from localStorage
            const events = JSON.parse(localStorage.getItem('events') || '[]');

            if (eventId) {
                const event = events.find(e => e.id === eventId);
                if (!event) {
                    console.error('Event not found:', eventId);
                    return;
                }
                
                title.textContent = 'Edit Event';
                document.getElementById('eventId').value = event.id;
                document.getElementById('eventTitle').value = event.title;
                document.getElementById('eventDate').value = event.date;
                document.getElementById('eventTime').value = event.time;
                document.getElementById('eventType').value = event.type;
                
                // Handle "other" event type
                if (event.type === 'other' && event.customType) {
                    document.getElementById('otherEventType').value = event.customType;
                    document.getElementById('otherEventTypeDiv').classList.remove('hidden');
                    document.getElementById('otherEventType').required = true;
                } else {
                    document.getElementById('otherEventTypeDiv').classList.add('hidden');
                    document.getElementById('otherEventType').required = false;
                    document.getElementById('otherEventType').value = '';
                }
            } else {
                title.textContent = 'Add Event';
                form.reset();
                document.getElementById('eventId').value = '';
                document.getElementById('otherEventTypeDiv').classList.add('hidden');
                document.getElementById('otherEventType').required = false;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex', 'items-center', 'justify-center');
        }

        function closeEventModal() {
            const modal = document.getElementById('eventModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'items-center', 'justify-center');
        }

        function openMassModal(massId = null) {
            const modal = document.getElementById('massModal');
            const title = document.getElementById('massModalTitle');
            const form = document.getElementById('massForm');
            
            // Load events from localStorage
            const events = JSON.parse(localStorage.getItem('events') || '[]');

            if (massId) {
                const mass = events.find(m => m.id === massId);
                if (!mass) {
                    console.error('Mass schedule not found:', massId);
                    return;
                }
                
                title.textContent = 'Edit Mass Schedule';
                document.getElementById('massId').value = mass.id;
                document.getElementById('massDay').value = mass.day;
                document.getElementById('massTime').value = mass.time;
                document.getElementById('massType').value = mass.type;
            } else {
                title.textContent = 'Add Mass Schedule';
                form.reset();
                document.getElementById('massId').value = '';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex', 'items-center', 'justify-center');
        }

        function closeMassModal() {
            const modal = document.getElementById('massModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'items-center', 'justify-center');
        }

        function showSuccessModal(message) {
            const modal = document.getElementById('successModal');
            const messageElement = document.getElementById('successMessage');
            messageElement.textContent = message;
            modal.classList.remove('hidden');
            modal.classList.add('flex', 'items-center', 'justify-center');
            
            setTimeout(() => {
                closeSuccessModal();
            }, 2000);
        }

        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'items-center', 'justify-center');
        }

        function handleEventSubmit(e) {
            e.preventDefault();
            const form = e.target;
            const eventId = document.getElementById('eventId').value;
            const eventType = document.getElementById('eventType').value;
            
            const eventData = {
                id: eventId || Date.now().toString(),
                title: document.getElementById('eventTitle').value,
                date: document.getElementById('eventDate').value,
                time: document.getElementById('eventTime').value,
                type: eventType,
                parish_name: PARISH_NAME,
                isEvent: true
            };

            // Add custom type if "other" is selected
            if (eventType === 'other') {
                const customType = document.getElementById('otherEventType').value.trim();
                if (!customType) {
                    alert('Please specify the event type.');
                    return;
                }
                eventData.customType = customType;
            }

            let events = JSON.parse(localStorage.getItem('events') || '[]');
            
            if (eventId) {
                events = events.map(e => e.id === eventId ? eventData : e);
                showSuccessModal('Event has been updated successfully!');
            } else {
                events.push(eventData);
                showSuccessModal('Event has been added successfully!');
            }

            localStorage.setItem('events', JSON.stringify(events));

            events.sort((a, b) => {
                const dateA = new Date(`${a.date}T${a.time}`);
                const dateB = new Date(`${b.date}T${b.time}`);
                return dateA - dateB;
            });

            renderEvents();
            renderMassSchedules();
            closeEventModal();
        }

        function handleMassSubmit(e) {
            e.preventDefault();
            const form = e.target;
            const massId = document.getElementById('massId').value;
            
            const massData = {
                id: massId || Date.now().toString(),
                day: document.getElementById('massDay').value,
                time: document.getElementById('massTime').value,
                type: document.getElementById('massType').value,
                parish_name: PARISH_NAME,
                isEvent: false
            };

            let events = JSON.parse(localStorage.getItem('events') || '[]');

            if (massId) {
                events = events.map(m => m.id === massId ? massData : m);
                showSuccessModal('Mass schedule has been updated successfully!');
            } else {
                events.push(massData);
                showSuccessModal('Mass schedule has been added successfully!');
            }

            localStorage.setItem('events', JSON.stringify(events));

            renderMassSchedules();
            renderEvents();
            closeMassModal();
        }

        function deleteEvent(eventId) {
            if (confirm('Are you sure you want to delete this event?')) {
                let events = JSON.parse(localStorage.getItem('events') || '[]');
                events = events.filter(e => e.id !== eventId);
                localStorage.setItem('events', JSON.stringify(events));
                renderEvents();
                renderMassSchedules();
                showSuccessModal('Event has been deleted successfully!');
            }
        }

        function deleteMassSchedule(massId) {
            if (confirm('Are you sure you want to delete this mass schedule?')) {
                let events = JSON.parse(localStorage.getItem('events') || '[]');
                events = events.filter(m => m.id !== massId);
                localStorage.setItem('events', JSON.stringify(events));
                renderMassSchedules();
                renderEvents();
                showSuccessModal('Mass schedule has been deleted successfully!');
            }
        }

        function renderEvents() {
            const eventList = document.getElementById('eventList');
            const today = new Date();
            
            const events = JSON.parse(localStorage.getItem('events') || '[]');
            
            const upcomingEvents = events
                .filter(event => {
                    if (!event.isEvent) return false;
                    if (event.parish_name !== PARISH_NAME) return false;
                    const eventDate = new Date(`${event.date}T${event.time}`);
                    return eventDate >= today;
                })
                .sort((a, b) => {
                    const dateA = new Date(`${a.date}T${a.time}`);
                    const dateB = new Date(`${b.date}T${b.time}`);
                    return dateA - dateB;
                });

            eventList.innerHTML = upcomingEvents.map(event => {
                const displayType = event.type === 'other' && event.customType ? event.customType : event.type;
                return `
                <div class="flex gap-3 p-4 bg-gray-50 rounded-lg transition-all hover:-translate-y-0.5 hover:shadow-md">
                    <div class="w-10 h-10 bg-[#1a237e] text-white rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas ${getEventIcon(event.type, event.customType)}"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="m-0 mb-1 text-gray-800">${event.title}</h4>
                        <p class="m-0 text-gray-600 text-sm">${displayType} • ${formatDate(event.date)} • ${formatTimeHourly(event.time)}</p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="openEventModal('${event.id}')" 
                                class="bg-transparent border-none cursor-pointer text-gray-800 text-sm p-1 rounded hover:bg-indigo-50">
                            <i class="fas fa-edit text-blue-500"></i>
                        </button>
                        <button onclick="deleteEvent('${event.id}')" 
                                class="bg-transparent border-none cursor-pointer text-gray-800 text-sm p-1 rounded hover:bg-indigo-50">
                            <i class="fas fa-trash text-red-500"></i>
                        </button>
                    </div>
                </div>
            `;
        }).join('');
        }

        function renderMassSchedules() {
            const scheduleBody = document.getElementById('massScheduleBody');
            
            const events = JSON.parse(localStorage.getItem('events') || '[]');
            
            const massSchedules = events
                .filter(event => !event.isEvent && event.parish_name === PARISH_NAME)
                .sort((a, b) => {
                    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    const dayDiff = days.indexOf(a.day) - days.indexOf(b.day);
                    if (dayDiff !== 0) return dayDiff;
                    return a.time.localeCompare(b.time);
                });

            scheduleBody.innerHTML = massSchedules.map(mass => `
                <tr>
                    <td class="px-3 py-3 text-left border-b border-gray-300">${mass.day}</td>
                    <td class="px-3 py-3 text-left border-b border-gray-300">${formatTimeHourly(mass.time)}</td>
                    <td class="px-3 py-3 text-left border-b border-gray-300">${mass.type}</td>
                    <td class="px-3 py-3 text-left border-b border-gray-300">
                        <div class="flex gap-2">
                            <button onclick="openMassModal('${mass.id}')" 
                                    class="bg-transparent border-none cursor-pointer text-gray-800 text-sm p-1 rounded hover:bg-indigo-50">
                                <i class="fas fa-edit text-blue-500"></i>
                            </button>
                            <button onclick="deleteMassSchedule('${mass.id}')" 
                                    class="bg-transparent border-none cursor-pointer text-gray-800 text-sm p-1 rounded hover:bg-indigo-50">
                                <i class="fas fa-trash text-red-500"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function getEventIcon(type, customType = null) {
            switch (type) {
                case 'mass': return 'fa-church';
                case 'wedding': return 'fa-ring';
                case 'baptism': return 'fa-child';
                case 'other': return 'fa-calendar-day';
                default: return 'fa-calendar-day';
            }
        }

        function formatDate(date) {
            return new Date(date).toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
        }

        function formatTimeHourly(time) {
            const [hours, minutes] = time.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            return `${hour12}:00 ${ampm}`;
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderEvents();
            renderMassSchedules();
        });
    </script>
</body>
</html>
