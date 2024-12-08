<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <h2>Admin</h2>
            <ul>
                <li><a href="#" class="nav-link active" data-section="dashboard">Dashboard</a></li>
                <li><a href="#" class="nav-link" data-section="appointments">Manage Appointments</a></li>
                <li><a href="#" class="nav-link" data-section="patients">Patients</a></li>
                <li><a href="#" class="nav-link" data-section="reports">Reports</a></li>
                <li><a href="#" class="nav-link" data-section="settings">Settings</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="content">
            <!-- Dashboard Section -->
            <section id="dashboard" class="section active">
                <h1>Dashboard</h1>
                <p>Welcome to the admin dashboard.</p>
            </section>

            <!-- Appointments Section with Calendar -->
            <section id="appointments" class="section">
                <h1>Manage Appointments</h1>
                <div id="calendar" class="calendar"></div>
            </section>

            <!-- Patients Section with Form and Dynamic Table -->
            <section id="patients" class="section">
                <h1>Patients</h1>
                <!-- Patient Form for Input -->
                <form id="patient-form">
                    <input type="hidden" id="patient-id"> <!-- Hidden field for edit functionality -->
                    <input type="text" id="patient-name" placeholder="Patient Name" required>
                    <input type="number" id="patient-age" placeholder="Age" required>
                    <input type="text" id="patient-birthday" placeholder="Birthday" required>
                    <select id="patient-gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <input type="text" id="patient-email" placeholder="Email" required>
                    <input type="text" id="patient-address" placeholder="Address" required>
                    <input type="text" id="patient-condition" placeholder="Condition" required>
                    <input type="text" id="patient-contact" placeholder="Contact Number" required>
                    <button type="submit">Add/Update Patient</button>
                    
                </form>

                <!-- Patients Table to Display Records Dynamically -->
                <table border="1" style="width: 100%; margin-top: 10px;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Birthday</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Condition</th>
                            <th>Contact Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="patients-table">
                        <!-- Rows will dynamically populate here -->
                    </tbody>
                </table>
            </section>

            <!-- Reports Section -->
            <section id="reports" class="section">
                <h1>Reports</h1>
                <p>View reports here.</p>
            </section>

            <!-- Settings Section -->
            <section id="settings" class="section">
                <h1>Settings</h1>
                <form action="../../dashboard_admin/admin/authentication/admin-class.php" method="GET">
                    <button type="submit" name="admin-signout">LOG OUT</button>
                </form>
            </section>
        </main>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const navLinks = document.querySelectorAll(".nav-link");
            const sections = document.querySelectorAll(".section");
            let calendarInitialized = false;

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

            // Initialize Flatpickr for Birthday
            flatpickr("#patient-birthday", {
                dateFormat: "Y-m-d",
            });
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
    const birthday = document.getElementById("patient-birthday").value.trim();
    const gender = document.getElementById("patient-gender").value.trim();
    const email = document.getElementById("patient-email").value.trim();
    const address = document.getElementById("patient-address").value.trim();
    const condition = document.getElementById("patient-condition").value.trim();
    const contact = document.getElementById("patient-contact").value.trim();

    if (!name || isNaN(age) || !birthday || !gender || !email || !address || !condition || !contact) {
        alert("Please fill out all fields correctly.");
        return;
    }
    const patientData = { name, age, birthday, gender, email, address, condition, contact };

    if (isNaN(patientId) || patientIdField.value === "") {
        // Add new patient
        patients.push(patientData);
    } else {
        // Update existing patient
        patients[patientId] = patientData;
    }

     // Clear the form
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
            <td>${patient.condition}</td>
            <td>${patient.contact}</td>
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
        const rowToHighlight = tbody.children[parseInt(patientIdField, 10)];
        if (rowToHighlight) rowToHighlight.classList.add("highlight");
    }
}

// Edit patient
function editPatient(index) {
    const patient = patients[index];
    document.getElementById("patient-name").value = patient.name;
    document.getElementById("patient-age").value = patient.age;
    document.getElementById("patient-birthday").value = patient.birthday;
    document.getElementById("patient-gender").value = patient.gender;
    document.getElementById("patient-email").value = patient.email;
    document.getElementById("patient-address").value = patient.address;
    document.getElementById("patient-condition").value = patient.condition;
    document.getElementById("patient-contact").value = patient.contact;
    document.getElementById("patient-id").value = index;
}

// Delete patient
function deletePatient(index) {
    if (confirm("Are you sure you want to delete this patient?")) {
        patients.splice(index, 1);
        renderPatientTable();
    }
}

    </script>
    
</body>
</html>