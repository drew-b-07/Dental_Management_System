<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../src/css/admin_landing.css">
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
            <button onclick="logout()" type="button">Log Out</button>
        </nav>

        <div id="edit-patient-modal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeEditPatientModal()">&times;</span>
                    <h2>Edit Patient Details</h2>
                    <form id="edit-patient-form">
                        <input type="hidden" id="edit-patient-id">
                        <label for="edit-patient-name">Name:</label>
                        <input type="text" id="edit-patient-name" required>
                        <label for="edit-patient-age">Age:</label>
                        <input type="number" id="edit-patient-age" required>
                        <label for="edit-patient-birthday">Birthday:</label>
                        <input type="date" id="edit-patient-birthday" required>
                        <label for="edit-patient-gender">Gender:</label>
                        <select id="edit-patient-gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <label for="edit-patient-email">Email:</label>
                        <input type="email" id="edit-patient-email" required>
                        <label for="edit-patient-address">Address:</label>
                        <input type="text" id="edit-patient-address" required>
                        <label for="edit-patient-condition">Condition:</label>
                        <input type="text" id="edit-patient-condition" required>
                        <label for="edit-patient-contact">Contact:</label>
                        <input type="text" id="edit-patient-contact" required>
                        <button type="submit">Update</button>
                    </form>
            </div>
        </div>

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
                </div>
                <div>
                    <h4>Recent Activities</h4>
                    <ul id="recent-activities-list"></ul>
                </div>
                <div>
                    <h4>Upcoming Appointments</h4>
                    <ul id="upcoming-appointments-list"></ul>
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
                <form id="patient-form" action="../admin-class.php" method="POST">
                    <input type="hidden" id="patient-id">
                    <input type="text" id="patient-name" placeholder="Patient Name" required>
                    <input type="number" id="patient-age" placeholder="Age" required>
                    <input type="text" id="patient-birthday" placeholder="Birthday" required>
                    <select id="patient-gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <input type="email" id="patient-email" placeholder="Email" required>
                    <input type="text" id="patient-address" placeholder="Address" required>
                    <input type="text" id="patient-condition" placeholder="Condition" required>
                    <input type="text" id="patient-contact" placeholder="Contact Number" required>
                    <button type="submit" name="btn-admin-addpatient">Add Patient Details</button>
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
                            <th>Contact</th>
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
                <h1>Settings</h1>
                <form class="reset-form">
                    <h2>Reset Password</h2>
                    <input type="password" id="current-password" placeholder="Current Password" required>
                    <input type="password" id="new-password" placeholder="New Password" required>
                    <input type="password" id="confirm-password" placeholder="Confirm Password" required>
                    <button type="submit">Reset Password</button>
                </form>
            </section>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="../../src/js/script.js"></script>
</body>
</html>