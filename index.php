<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Care Appointment Calendar</title>
    <style>
        /* Same styles as before, with slight modification for edit/cancel buttons */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #488AC7; /* Light blue background for the whole page */
            color: #333;
        }

        #calendar {
            margin: 20px auto;
            width: 110%;
            max-width: 800px;
            background: #ffffff; /* White background for the calendar box */
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin: 0;
            padding: 20px 0;
            color: #333;
        }

        .header img {
            max-width: 200px; /* Limit the logo width */
            height: auto;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .calendar-grid .date {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 5px;
            cursor: pointer;
            position: relative; /* To allow top border */
        }

        .calendar-grid .date:hover {
            background-color: #e6f7ff; /* Slight hover effect for dates */
        }
        
        /* Add a top border inside the date cell */
       .calendar-grid .date::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #007bff; /* Blue color for the top border */
        border-radius: 5px 5px 0 0; /* Rounded top corners */
        }


        .calendar-grid .date p {
            margin: 5px 0 0 0; /* Adjust margin for the text inside date cells */
            font-size: 12px;
            color: #555; /* Darker text color for appointments */
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Dimmed background for the modal */
        }

        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 20px;
            width: 50%;
            max-width: 400px;
            border-radius: 10px;
            text-align: center;
        }

        .modal-content .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        form input, form button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background-color: #1F45FC;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0000FF;
        }

        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .nav-buttons button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .nav-buttons button:hover {
            background-color: #0056b3;
        }

        .modal-content button.cancel-btn {
            background-color: #FF6347; /* Red color for cancel button */
        }

        .modal-content button.cancel-btn:hover {
            background-color: #FF4500;
        }
    </style>
</head>
<body>

<div id="calendar">
    <div class="header">
        <img src="src/img/dental logo.png" alt="Dental Care Logo">
        <h1>Dental Care Appointment Calendar</h1><br>
    </div>

    <div class="nav-buttons">
        <button id="prevMonth">Previous</button>
        <span id="currentMonthYear"></span>
        <button id="nextMonth">Next</button>
    </div>

    <div class="calendar-grid" id="calendarGrid">
        <!-- Dates will be dynamically generated here -->
    </div>
</div>

<!-- Modal for Appointment Form -->
<div id="appointmentModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Schedule Appointment</h2>
        <form id="appointmentForm">
            <input type="hidden" id="selectedDate">
            <label for="patientName">Patient's Name:</label>
            <input type="text" id="patientName" placeholder="Enter patient's name" required>
            <label for="appointmentType">Appointment Type:</label>
            <input type="text" id="appointmentType" placeholder="e.g., Teeth Cleaning" required>
            <label for="appointmentTime">Preferred Time:</label>
            <input type="time" id="appointmentTime" required>
            <button type="submit">Save Appointment</button>
            <button type="button" class="cancel-btn" id="cancelAppointmentBtn" style="display:none;">Cancel Appointment</button>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const calendarGrid = document.getElementById("calendarGrid");
    const modal = document.getElementById("appointmentModal");
    const closeModal = document.getElementById("closeModal");
    const form = document.getElementById("appointmentForm");
    const selectedDateInput = document.getElementById("selectedDate");
    const currentMonthYear = document.getElementById("currentMonthYear");
    const prevMonthButton = document.getElementById("prevMonth");
    const nextMonthButton = document.getElementById("nextMonth");
    const cancelAppointmentBtn = document.getElementById("cancelAppointmentBtn");

    let currentDate = new Date(); // Starting with the current month and year
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    let selectedAppointmentElement = null; // This will hold the selected appointment for editing
    let selectedDateElement = null; // This will track the selected date element

    // Function to update the displayed month and year
    function updateMonthYearDisplay() {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        currentMonthYear.textContent = `${monthNames[currentMonth]} ${currentYear}`;
    }

    // Function to generate the calendar grid for the current month and year
    function generateCalendar() {
        calendarGrid.innerHTML = ""; // Clear existing grid

        // Get the first day of the month and the number of days in the month
        const firstDay = new Date(currentYear, currentMonth, 1);
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        const startingDay = firstDay.getDay();

        // Add empty cells for days before the 1st
        for (let i = 0; i < startingDay; i++) {
            const emptyCell = document.createElement("div");
            calendarGrid.appendChild(emptyCell);
        }

        // Add the actual dates
        for (let day = 1; day <= daysInMonth; day++) {
            const dateElement = document.createElement("div");
            dateElement.classList.add("date");
            dateElement.textContent = day;

            // Create a hidden div to hold the appointments for this date
            const appointmentDiv = document.createElement("div");
            appointmentDiv.classList.add("appointments");
            dateElement.appendChild(appointmentDiv);

            dateElement.addEventListener("click", () => openModal(day, dateElement));

            calendarGrid.appendChild(dateElement);
        }
    }

    // Open modal and set the selected date
    function openModal(day, dateElement) {
        selectedDateInput.value = day;
        modal.style.display = "block";
        cancelAppointmentBtn.style.display = "none"; // Hide cancel button by default
        selectedAppointmentElement = null; // Reset previous selection
        selectedDateElement = dateElement; // Set the selected date element for appointment

        // Check if there is an existing appointment on this day
        const appointmentDiv = dateElement.querySelector(".appointments");
        if (appointmentDiv && appointmentDiv.children.length > 0) {
            const appointmentDetails = appointmentDiv.children[0]; // Take the first appointment
            document.getElementById("patientName").value = appointmentDetails.querySelector(".patient-name").textContent;
            document.getElementById("appointmentType").value = appointmentDetails.querySelector(".appointment-type").textContent;
            document.getElementById("appointmentTime").value = appointmentDetails.querySelector(".appointment-time").textContent;

            selectedAppointmentElement = appointmentDetails; // Set the selected appointment for editing
            cancelAppointmentBtn.style.display = "inline-block"; // Show cancel button
        } else {
            // Reset the form for creating a new appointment
            form.reset();
        }
    }

    // Close modal
    closeModal.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Handle form submission
    form.addEventListener("submit", (event) => {
        event.preventDefault();
        const selectedDate = selectedDateInput.value;
        const patientName = document.getElementById("patientName").value;
        const appointmentType = document.getElementById("appointmentType").value;
        const appointmentTime = document.getElementById("appointmentTime").value;

        const appointmentDiv = selectedDateElement.querySelector(".appointments");

        if (selectedAppointmentElement) {
            // Editing existing appointment
            selectedAppointmentElement.innerHTML = `
                <strong class="patient-name">${patientName}</strong>: 
                <span class="appointment-type">${appointmentType}</span> at 
                <span class="appointment-time">${appointmentTime}</span>
            `;
        } else {
            // New appointment
            const newAppointment = document.createElement("p");
            newAppointment.innerHTML = `
                <strong class="patient-name">${patientName}</strong>: 
                <span class="appointment-type">${appointmentType}</span> at 
                <span class="appointment-time">${appointmentTime}</span>
            `;
            appointmentDiv.appendChild(newAppointment);
        }

        form.reset();
        modal.style.display = "none";
    });

    // Handle cancel button to remove appointment
    cancelAppointmentBtn.addEventListener("click", () => {
        if (selectedAppointmentElement) {
            selectedAppointmentElement.remove(); // Remove the existing appointment
            form.reset();
            modal.style.display = "none";
        }
    });

    // Event listeners for the navigation buttons
    prevMonthButton.addEventListener("click", () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateMonthYearDisplay();
        generateCalendar();
    });

    nextMonthButton.addEventListener("click", () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateMonthYearDisplay();
        generateCalendar();
    });

    // Initialize calendar
    updateMonthYearDisplay();
    generateCalendar();
});


</script>

</body>
</html>

