<?php
    require_once '../admin-class.php';
    require_once '../main.php';
    require_once '../user-class.php';

    if(!isset($_SESSION["adminSession"])) {
        echo "<script>alert('admin is not logged in yet.'); window.location.href = '../../';</script>";
        exit;
    }

    $admin = new ADMIN();
    $main = new MAIN();

    $patientsData = $admin->getPatients();
    $patients = $patientsData['patients'];
    $totalPatients = $patientsData['total'];

    $pendingData = $main->getPatients();
    $pendingPatients = $pendingData['pendingPatients'];
    $totalpendingPatients = $pendingData['total'];

    $appointmentData = $main->getAppoinments();
    $acceptedAppointments = $appointmentData['acceptedAppointments'];
    $totalAcceptedAppointments = $appointmentData['total'];

    $logsData = $main->getAppointmentLogs();
    $logs = $logsData['logs'];
    $totalLogs = $logsData['total'];

    $pendingAppointmentData = $main->getPendingAppointments();
    $pendingAppointment = $pendingAppointmentData['pendingAppointments'];
    $totalpendingAppointment = $pendingAppointmentData['total'];   

    $userData = $admin->getUsersList();
    $users = $userData['users'];
    $totalUsers = $userData['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="../../src/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../src/css/admin_landing.css">
    <link rel="stylesheet" href="../../src/css/patient_table.css">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="../../src/js/script2.js"></script>
</head>
<body>
    
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <h2>Admin</h2>
            <ul>
                <li><a href="#" class="nav-link active" data-section="dashboard">Dashboard</a></li>
                <li><a href="#" class="nav-link" data-section="pending_appointment">Pending Appoinment</a></li>
                <li><a href="#" class="nav-link" data-section="appointment_logs">Logs</a></li>
                <li><a href="#" class="nav-link" data-section="appointments">Appointments</a></li>
                <li><a href="#" class="nav-link" data-section="patients">Patients</a></li>
                <li><a href="#" class="nav-link" data-section="settings">Users</a></li>
            </ul>
            <button onclick="logout()" type="button">Log Out</button>
        </nav>

        <div id="edit-patient-modal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeEditPatientModal()">&times;</span>
                <h2>Edit Patient Details</h2>
                <form id="edit-patient-form" action="../admin-class.php" method="POST">
                    <input type="hidden" id="edit-patient-id" name="update_id"> <!-- Ensure this is named 'update_id' -->
                    <label for="edit-patient-name">Name:</label>
                    <input type="text" name="update_name" id="edit-patient-name" required>
                    <label for="edit-patient-age">Age:</label>
                    <input type="number" name="update_age" id="edit-patient-age" required>
                    <label for="edit-patient-bday">Birthday:</label>
                    <input type="date" name="update_bday" id="edit-patient-birthday" required>
                    <label for="edit-patient-gender">Gender:</label>
                    <select name="update_gender" id="edit-patient-gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <label for="edit-patient-email">Email:</label>
                    <input type="email" name="update_email" id="edit-patient-email" required>
                    <label for="edit-patient-address">Address:</label>
                    <input type="text" name="update_address" id="edit-patient-address" required>
                    <label for="edit-patient-condition">Condition:</label>
                    <input type="text" name="update_condition" id="edit-patient-condition" required>
                    <label for="edit-patient-contact">Contact:</label>
                    <input type="text" name="update_contact" id="edit-patient-contact" required>
                    <button type="submit" name="submit">Update</button>
                </form>
            </div>
        </div>


        <!-- Appointment Details Modal -->
        <div id="appointmentModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Appointment Details</h2>
                    </div>
                    <div class="modal-body" id="appointmentDetails"></div>
                    <div class="modal-footer">
                        <button type="button" id="markDoneBtn" class="btn btn-success">Mark as Done</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>              
                    </div>
                </div>
            </div>
        </div>


        <!-- User Edit Modal -->
        <div id="edit-user-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                <span class="close-btn" onclick="closeEditUserModal()">&times;</span>
                    <div class="modal-header">
                        <h2 class="modal-title">Edit User</h2>
                    </div>
                    <div class="modal-body">
                        <form id="edit-user-form" action="../admin-class.php" method="POST">
                            <input type="hidden" id="edit-user-id" name="user_id">
                            
                            <div class="mb-3">
                                <label for="edit-user-name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="edit-user-name" name="fullname" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit-user-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit-user-email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit-user-username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="edit-user-username" name="username" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-user-password">Password</label>
                                <input type="text" id="edit-user-password" name="password" class="form-control" placeholder="Enter new password or leave empty">
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit-user-verify-status" class="form-label">Verify Status</label>
                                <select class="form-select" id="edit-user-verify-status" name="verify_status">
                                    <option value="verified">Verified</option>
                                    <option value="verifying">Unverified</option>
                                </select>
                            </div>
                            
                            <button type="submit" name="submit" class="btn btn-primary">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!-- Main Content -->
        <main class="content">
            <section id="dashboard" class="section active">
                <h1>Dashboard</h1>
                <div class="dashboard-grid">
                    <div class="card">
                        <h3>Total Patients</h3>
                        <p id="total-patients"><?= $totalPatients ?></p>
                    </div>
                    <div class="card">
                        <h3>Pending Appointments</h3>
                        <p id="upcoming-appointments"><?= $totalpendingAppointment ?></p>
                    </div>
                    <div class="card">
                        <h3>Current Appointments</h3>
                        <p id="upcoming-appointments"><?= $totalAcceptedAppointments ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Users</h3>
                        <p id="upcoming-appointments"><?= $totalUsers ?></p>
                    </div>
                </div>
            </section>

            <!-- Pending Appointments Section -->
            <section id="pending_appointment" class="section">
                <h1>Pending Appointments</h1>
                <div id="patients-table-wrapper">
                    <table id="patients-table" border="1">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Birthday</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                                <th>Preferred Appointment</th>
                                <th>Information</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pendingPatients)): ?>
                                <?php foreach ($pendingPatients as $pendingPatient): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($pendingPatient['fullname']) ?></td>
                                        <td><?= htmlspecialchars($pendingPatient['age']) ?></td>
                                        <td><?= htmlspecialchars($pendingPatient['birthday']) ?></td>
                                        <td><?= htmlspecialchars($pendingPatient['address']) ?></td>
                                        <td><?= htmlspecialchars($pendingPatient['phone_number']) ?></td>
                                        <td><?= htmlspecialchars($pendingPatient['pref_appointment']) ?></td>
                                        <td><?= htmlspecialchars($pendingPatient['additional_info']) ?></td>
                                        <td>
                                            <?= ucfirst($pendingPatient['status']) ?>
                                        </td>
                                        <td>
                                            <a href="../main.php?action=accept&id=<?= $pendingPatient['id'] ?>" 
                                                class="btn-accept <?= $pendingPatient['status'] == 'accepted' ? 'disabled' : '' ?>">
                                                Accept
                                            </a>
                                            <a href="../main.php?action=deny&id=<?= $pendingPatient['id'] ?>" 
                                                class="btn-deny <?= $pendingPatient['status'] == 'denied' ? 'disabled' : '' ?>">
                                                Deny
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9">No patients found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Appointment Logs Section -->
            <section id="appointment_logs" class="section">
                <h1>Appointment Logs</h1>
                <div id="logs-table-wrapper">
                    <table id="logs-table" border="1">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Birthday</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                                <th>Preferred Appointment</th>
                                <th>Status</th>
                                <th>Log Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($logs)): ?>
                                <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($log['fullname']) ?></td>
                                        <td><?= htmlspecialchars($log['age']) ?></td>
                                        <td><?= htmlspecialchars($log['birthday']) ?></td>
                                        <td><?= htmlspecialchars($log['address']) ?></td>
                                        <td><?= htmlspecialchars($log['phone_number']) ?></td>
                                        <td><?= htmlspecialchars($log['pref_appointment']) ?></td>
                                        <td><?= ucfirst(htmlspecialchars($log['status'])) ?></td>
                                        <td><?= htmlspecialchars($log['log_timestamp']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">No logs found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Appointments Section -->
            <section id="appointments" class="section">
                <h1>Appointments</h1>
                <div id="calendar"></div>
                    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="appointmentLabel">Appointment Details</h3>
                            </div>
                            <div class="modal-body" id="appointmentDetails">
                                <!-- Appointment details will be displayed here -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Patients Section -->
            <section id="patients" class="section">
                <h1>Add Patients</h1>
                <form id="patient-form" action="../admin-class.php" method="POST">
                    <input type="hidden" id="patient-id">
                    <input type="text" name="patient_name" id="patient-name" placeholder="Patient Name" required>
                    <input type="number" name="patient_age" id="patient-age" placeholder="Age" required>
                    <input type="text" name="patient_bday" id="patient-birthday" placeholder="Select Birthday" required>
                    <select name="patient_gender" id="patient-gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <input type="email" name="patient_email" id="patient-email" placeholder="Email" required>
                    <input type="text" name="patient_address" id="patient-address" placeholder="Address" required>
                    <input type="text" name="patient_condition" id="patient-condition" placeholder="Condition" required>
                    <input type="text" name="patient_contact" id="patient-contact" placeholder="Contact Number" required>
                    <button type="submit" name="btn-admin-addpatient">Add Patient Details</button>
                </form>
                    <h1>Patients Table</h1>
                    <div id="patients-table-wrapper">
                        <table id="patients-table" border="1">
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
                            <tbody>
                                <?php if (!empty($patients)): ?>
                                    <?php foreach ($patients as $patient): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($patient['patient_name']) ?></td>
                                            <td><?= htmlspecialchars($patient['patient_age']) ?></td>
                                            <td><?= htmlspecialchars($patient['patient_bday']) ?></td>
                                            <td><?= htmlspecialchars($patient['patient_gender']) ?></td>
                                            <td><?= htmlspecialchars($patient['patient_email']) ?></td>
                                            <td><?= htmlspecialchars($patient['patient_address']) ?></td>
                                            <td><?= htmlspecialchars($patient['patient_condition']) ?></td>
                                            <td><?= htmlspecialchars($patient['patient_contact']) ?></td>
                                            <td>
                                                <button class="edit-btn1" data-id="<?= $patient['id'] ?>">Edit</button>
                                                <button class="delete-btn1" data-id="<?= $patient['id'] ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9">No patients found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                    </table>
                </div>
            </section>
            
            <!-- User Section -->
            <section id="settings" class="section">
                <h1>Users Table</h1>
                    <div id="patients-table-wrapper">
                        <table id="patients-table" border="1">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>User Status</th>
                                    <th>Verify Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($user['fullname']) ?></td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td><?= htmlspecialchars($user['username']) ?></td>
                                            <td><?= htmlspecialchars($user['password']) ?></td>
                                            <td><?= htmlspecialchars($user['user_status']) ?></td>
                                            <td><?= htmlspecialchars($user['verify_status']) ?></td>
                                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                                            <td>
                                                <button class="edit-btn" data-id="<?= $user['id'] ?>">Edit</button>
                                                <button class="delete-btn" data-id="<?= $user['id'] ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9">No patients found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </section>


        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.5/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="../../src/js/script.js"></script>
    <script src="../../src/js/script3.js"></script>
</body>
</html>