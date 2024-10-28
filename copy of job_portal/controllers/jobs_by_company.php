<?php
session_start();
require "db.php";
if(!isset($_SESSION['user_type'])){
    $_SESSION['Flash'] = "Please login to access this page";
    header('Location: /login');

}
$company_id = isset($_GET['company_id']) ? (int)$_GET['company_id'] : 0;

//fetching jobs for specific company
$stmt = $conn->prepare("SELECT id,title,description,category,location,company_id from jobs where company_id = ?");
$stmt->bind_param("i",$company_id);
$stmt->execute();
$result = $stmt->get_result();
$jobs = $result->fetch_all(MYSQLI_ASSOC);
require "views/jobs_by_company.view.php";