<?php
require "db.php";
session_start();
if(!isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'company'){
    $_SESSION['Flash'] == 'Please login to access this page';
    header('Location: /login');
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $_SESSION['Flash'] = "Job deleted successfully.";

    header('Location: /home');
    die();
}
