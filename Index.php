<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <!-- External Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/main.min.css" rel="stylesheet">
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
            <form action="../../dashboard_admin/admin/authentication/admin-class.php" method="GET">
                <button type="submit" name="admin-signout">LOG OUT</button>
            </form>
        </nav>

        <!-- Main Content -->
        <main class="content">
            <!-- Dashboard Section -->
            <section id="dashboard" class="section active">
                <h1>Dashboard</h1>
                <div class="dashboard-grid">
                    <div class="card">
                        <h3>Total Patients</h3>
                        <p id="total-patients">0</p>
                    </div>
                    <div class="card">
                        <h3>Upcoming Appointments</h3>
                        <p id="upcoming-appointments">0</p>
                    </div>
                    <div class="card">
                        <h3>Reports Generated</h3>
                        <p id="reports-count">0</p>
                    </div>
                </div>

                <div class="appointments-overview">
                    <h2>Upcoming Appointments</h2>
                    <ul id="appointments-list">
                        <li>No upcoming appointments.</li>
                    </ul>
                </div>

                <div class="recent-activities">
                    <h2>Recent Activities</h2>
                    <ul id="recent-activities-list">
                        <li>No recent activities recorded.</li>
                    </ul>
                </div>
            </section>

            <!-- Appointments Section -->
            <section id="appointments" class="section">
                <h1>Manage Appointments</h1>
                <div id="calendar" class="calendar"></div>
            </section>

            <!-- Patients Section -->
            <section id="patients" class="section">
                <h1>Patients</h1>
                <form id="patient-form">
                    <input type="hidden" id="patient-id">
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
                    <tbody id="patients-table"></tbody>
                </table>
            </section>

            <!-- Reports Section -->
            <section id="reports" class="section">
                <h1>Reports</h1>
                <p>View reports here.</p>
            </section>

            <!-- Settings Section -->
            <section id="settings" class="section">
            </section>
        </main>
    </div>

    <!-- Scripts -->
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

            navLinks.forEach(link => {
                link.addEventListener("click", (e) => {
                    e.preventDefault();
                    navLinks.forEach(nav => nav.classList.remove("active"));
                    link.classList.add("active");
                    sections.forEach(sec => sec.classList.remove("active"));
                    document.getElementById(link.dataset.section).classList.add("active");

                    if (link.dataset.section === "appointments" && !calendarInitialized) {
                        initializeCalendar();
                        calendarInitialized = true;
                    }
                });
            });

            // Initialize patients and calendar
            initializePatientSection();
            initializeDashboard();
            flatpickr("#patient-birthday", { dateFormat: "Y-m-d" });
        });

        function initializeCalendar() {
            const calendarEl = document.getElementById("calendar");
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: "dayGridMonth",
                events: [
                    { title: "John's Checkup", start: "2024-06-10" },
                    { title: "Follow-up Meeting", start: "2024-06-12" }
                ]
            });
            calendar.render();
        }

        let patients = [];
        function initializePatientSection() {
            const form = document.getElementById("patient-form");
            form.addEventListener("submit", (e) => {
                e.preventDefault();
                const patient = {
                    name: form["patient-name"].value,
                    age: form["patient-age"].value,
                    birthday: form["patient-birthday"].value,
                    gender: form["patient-gender"].value,
                    email: form["patient-email"].value,
                    address: form["patient-address"].value,
                    condition: form["patient-condition"].value,
                    contact: form["patient-contact"].value
                };
                patients.push(patient);
                renderPatients();
                form.reset();
            });
        }

        function renderPatients() {
            const tbody = document.getElementById("patients-table");
            tbody.innerHTML = "";
            patients.forEach((p, i) => {
                tbody.innerHTML += `<tr>
                    <td>${p.name}</td><td>${p.age}</td><td>${p.birthday}</td>
                    <td>${p.gender}</td><td>${p.email}</td><td>${p.address}</td>
                    <td>${p.condition}</td><td>${p.contact}</td>
                    <td><button onclick="editPatient(${i})">Edit</button>
                        <button onclick="deletePatient(${i})">Delete</button></td>
                </tr>`;
            });
        }

        function initializeDashboard() {
            document.getElementById("total-patients").innerText = patients.length;
            document.getElementById("upcoming-appointments").innerText = 2;
            document.getElementById("reports-count").innerText = 5;
        }

        function deletePatient(index) {
            patients.splice(index, 1);
            renderPatients();
        }
    </script>
</body>
</html>