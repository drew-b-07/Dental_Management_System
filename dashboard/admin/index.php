<?php
require_once __DIR__."/../../config/settings-configuration.php";
    if (isset($_SESSION['toast_message'])) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.createElement('div');
            toast.textContent = '" . $_SESSION['toast_message'] . "';
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.right = '20px';
            toast.style.background = '#4caf50';
            toast.style.color = '#fff';
            toast.style.padding = '10px 15px';
            toast.style.borderRadius = '5px';
            toast.style.boxShadow = '0px 2px 6px rgba(0, 0, 0, 0.2)';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        });
        </script>";
        unset($_SESSION['toast_message']); // Clear the session message
    }
?>

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
                <!-- Logout Button -->
                    <button onclick="logout()" type="submit">Log Out</button>
            </ul>
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
                <form id="patient-form" action="../../dashboard_admin/admin/authentication/admin-class.php?section=patients" method="POST">
                    <input type="hidden" id="patient-id">
                    <input type="text" id="patient-name" name="patient_name" placeholder="Patient Name" required>
                    <input type="number" id="patient-age" name="patient_age" placeholder="Age" required>
                    <input type="text" id="patient-birthday" name="patient_bday" placeholder="Birthday" required>
                    <select id="patient-gender" name="patient_gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <input type="text" id="patient-email" name="patient_email" placeholder="Email" required>
                    <input type="text" id="patient-address" name="patient_address" placeholder="Address" required>
                    <input type="text" id="patient-condition" name="patient_condition" placeholder="Condition" required>
                    <input type="text" id="patient-contact" name="patient_contactno" placeholder="Contact Number" required>
                    <button type="submit" name="btn-admin-addupdate" >Add/Update Patient</button>
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
                <h1>Settings</h1>

            <!-- Reset Password Form -->
                <form class="reset_form" action="" method="POST">
                    <h2>Reset Password</h2>
                    <input type="password" id="current-password" name="current_password" placeholder="Current Password" required>
                    <input type="password" id="new-password" name="new_password" placeholder="New Password" required>
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" required>
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