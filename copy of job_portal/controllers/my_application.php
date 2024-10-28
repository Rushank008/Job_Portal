<?php
session_start();
require "db.php";
if($_SESSION['user_type'] != 'employee'){
    $_SESSION['Flash'] = "Please login to access this page";
    header("Location: /login");
}
$user_id = $_SESSION['user_id'];

// Fetch all the applications made by the logged-in user
$stmt = $conn->prepare("
    SELECT a.job_id, a.resume_path, a.status, j.title AS job_title, c.name AS company_name 
    FROM applications a
    JOIN jobs j ON a.job_id = j.id
    JOIN companies c ON j.company_id = c.id
    WHERE a.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$applications = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


require "views/my_application.view.php";