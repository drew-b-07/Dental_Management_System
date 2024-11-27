<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../../src/css/calendar.css">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/main.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Admin </h2>
            <ul>
                <li><a href="#" class="nav-link active" data-section="dashboard">Dashboard</a></li>
                <li><a href="#" class="nav-link" data-section="appointments">Manage Appointments</a></li>
                <li><a href="#" class="nav-link" data-section="patients">Patients</a></li>
                <li><a href="#" class="nav-link" data-section="reports">Reports</a></li>
                <li><a href="#" class="nav-link" data-section="settings">Settings</a></li>
            </ul>
        </nav>

        <main class="content">
            
            <section id="dashboard" class="section active">
                <h1>Dashboard</h1>
            </section>

            <section id="appointments" class="section">
                <h1>Manage Appointments</h1>
                <div id="calendar"></div>
            </section>
                       
            <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/index.global.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/index.global.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/index.global.min.js"></script>

            
            <section id="patients" class="section">
                <h1>Patients</h1>
                
            </section>

            
            <section id="reports" class="section">
                <h1>Reports</h1>
                
            </section>

            
            <section id="settings" class="section">
                <h1>Settings</h1>
               
            </section>
        </main>
    </div>

    <script src="../../src/js/app.js"></script>
</body>
</html>