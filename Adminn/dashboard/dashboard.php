<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> <!-- Font -->
    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        
        nav {
            background-color: #2c3e50;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        nav ul {
            list-style-type: none;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #3498db;
        }

        
        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
            width: 250px;
            text-align: center;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .card p {
            color: #7f8c8d;
        }

        
        footer {
            text-align: center;
            margin-top: 50px;
            font-size: 14px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <h1>Dental Clinic Admin Dashboard</h1>

        <nav>
            <ul>
                <li><a href="manage_patients.php">Patients</a></li>
                <li><a href="manage_appointments.php">Appointments</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="records.php">Records</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="admin/admin_login.php">Logout</a></li>
            </ul>
        </nav>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Patients</h3>
                <p>Manage patient records and data</p>
            </div>
            <div class="card">
                <h3>Appointments</h3>
                <p>Schedule and manage appointments</p>
            </div>
            <div class="card">
                <h3>Services</h3>
                <p>Manage services</p>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2024 Dental Clinic Admin Dashboard. All Rights Reserved.
    </footer>
</body>
</html>
