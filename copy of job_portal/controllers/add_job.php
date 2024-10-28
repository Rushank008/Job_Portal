<?php
session_start();
require "db.php";

if(($_SESSION['user_type']) != 'company' || !isset($_SESSION['user_type'])){
    $_SESSION['Flash'] = "Please login to access this page";
    header("Location: /login");
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = htmlspecialchars(trim($_POST['job_title']));
    $description = trim($_POST['job_description']);
    $category = htmlspecialchars(trim($_POST['job_category']));
    $location = htmlspecialchars(trim($_POST['job_location']));
    $id = $_SESSION['company_id'];

    $errors = [];

    if(empty($category) || empty($location) || empty($description) || empty($title)){
        $errors[] = "Please fill in all fields";
    }
    if(strlen($description) > 250){
        $errors[] = "Description should be less than 250 characters";
    }
    if(strlen($title) > 20){
        $errors[] = "Title should be less than 20 characters";
    }
    if(strlen($location) > 10){
        $errors[] = "Location should be less than 10 characters";
    }
    if(strlen($category) > 10){
        $errors[] = "Category should be less than 10 characters";
    }

    if(empty($errors)){
        $stmt = $conn->prepare("INSERT INTO jobs (title,description,location,category,company_id) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss",$title,$description,$location,$category,$id);
        if($stmt->execute()){
            $_SESSION['Flash'] = "Job added successfully";
        }
        else{
            $_SESSION['Flash'] = "Failed to add job";
        }
        $stmt->close();
    }
}

require"views/add_job.view.php";