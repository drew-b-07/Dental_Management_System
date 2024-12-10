document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll(".nav-link");
    const sections = document.querySelectorAll(".section");
    let calendarInitialized = false; // Ensures calendar only initializes when clicking on the Appointments tab.

    // Handle navigation menu clicks
    navLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();

            // Reset navigation active states
            navLinks.forEach(nav => nav.classList.remove("active"));
            link.classList.add("active");

            // Handle content switching
            sections.forEach(sec => sec.classList.remove("active"));
            const sectionId = link.getAttribute("data-section");
            const targetSection = document.getElementById(sectionId);

            targetSection.classList.add("active");

            // Initialize FullCalendar only when the "appointments" tab is clicked
            if (sectionId === "appointments" && !calendarInitialized) {
                initializeCalendar();
                calendarInitialized = true;
            }
        });
    });

    initializePatientSection();
});

// FullCalendar Initialization
function initializeCalendar() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        events: [
            {
                title: 'Doctor Appointment',
                start: '2024-11-25',
            }
        ],
        editable: true,
        dayMaxEvents: true,
    });
    calendar.render();
}

// Patient Section Logic
let patients = []; // Array to store patient data

function initializePatientSection() {
    const form = document.getElementById("patient-form");
    form.addEventListener("submit", handlePatientFormSubmit);

    renderPatientTable();
}

// Handle Add/Update Patient Form
function handlePatientFormSubmit(e) {
    e.preventDefault();

    const patientIdField = document.getElementById("patient-id");
    const patientId = parseInt(patientIdField.value, 10);

    const name = document.getElementById("patient-name").value.trim();
    const age = parseInt(document.getElementById("patient-age").value.trim());
    const gender = document.getElementById("patient-gender").value.trim();
    
    const condition = document.getElementById("patient-condition").value.trim();
    

    if (!name || isNaN(age) || !condition) {
        alert("Please fill out all fields correctly.");
        return;
    }

    if (isNaN(patientId) || patientIdField.value === "") {
        // Add new patient
        patients.push({ name, age, condition });
    } else {
        // Ensure the index is valid before attempting to update
        if (patientId >= 0 && patientId < patients.length) {
            patients[patientId] = { name, age, condition };
        } else {
            alert("Error: Invalid patient ID.");
            return;
        }
    }

    // Clear the form and reset the patient ID
    document.getElementById("patient-form").reset();
    document.getElementById("patient-id").value = "";
    renderPatientTable();
}

// Render the Patients Table Dynamically
function renderPatientTable() {
    const tbody = document.getElementById("patients-table");
    tbody.innerHTML = ""; // Clear existing rows

    patients.forEach((patient, index) => {
        const row = document.createElement("tr");
        row.classList.add("table-row");
        row.innerHTML = `
            <td>${patient.name}</td>
            <td>${patient.age}</td>
            <td>${patient.birthday}</td>
            <td>${patient.gender}</td>
            <td>${patient.email}</td>
            <td>${patient.address}</td>
            <td>${patient.contact-number}</td>
            <td>${patient.condition}</td>
            <td>
                <button class="edit-btn" onclick="editPatient(${index})">✏️ Edit</button>
                <button class="delete-btn" onclick="deletePatient(${index})">🗑️ Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });

    // Highlight the row being edited
    const patientIdField = document.getElementById("patient-id").value;
    if (patientIdField) {
        const indexToHighlight = parseInt(patientIdField, 10);
        if (indexToHighlight >= 0 && indexToHighlight < patients.length) {
            const rowToHighlight = tbody.children[indexToHighlight];
            if (rowToHighlight) rowToHighlight.classList.add("highlight");
        }
    }
}



// Edit patient
function editPatient(index) {
    const patient = patients[index];
    document.getElementById("patient-name").value = patient.name;
    document.getElementById("patient-age").value = patient.age;
    document.getElementById("patient-condition").value = patient.condition;
    document.getElementById("patient-id").value = index;
}

// Delete patient
function deletePatient(index) {
    if (confirm("Are you sure you want to delete this patient?")) {
        patients.splice(index, 1);
        renderPatientTable();
    }
}


