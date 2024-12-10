<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../src/css/admin_landing.css">
    <link rel="icon" type="image/png" href="../../src/img/icon.png">
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
                    <button onclick="logout()" type="submit" name="admin-signout">LOG OUT</button>
                </form>
            </section>
        </main>
    </div>
    <!-- External JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Custom JavaScript -->
    <script src="../../src/js/admin_functions.js"></script>
</body>
</html>