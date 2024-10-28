<?php
session_start();
require "db.php";
if(!isset($_SESSION['user_type'])){
    $_SESSION['Flash'] = "Please login to access this page";
    header("Location: /login");
}

//Get all connections first 
$stmt = $conn->prepare("SELECT id,name,description,email FROM companies order by name");
$stmt->execute();
$result = $stmt->get_result();
$companies = $result->fetch_all(MYSQLI_ASSOC);
 

//check if the search query exists
if(isset($_GET['search_query'])){
    $search_query = htmlspecialchars(trim($_GET['search_query']));

    $stmt = $conn->prepare("SELECT * FROM companies where name LIKE ?");
    $like_query = "%" . $search_query . "%";
    $stmt->bind_param("s",$like_query);
    $stmt->execute();
    $result = $stmt->get_result();
    $companies = $result->fetch_all(MYSQLI_ASSOC);
}

require"views/home.view.php";