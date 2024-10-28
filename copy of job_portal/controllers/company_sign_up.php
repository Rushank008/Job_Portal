<?php
session_start();
require "db.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = htmlspecialchars(trim($_POST['companyName']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $description = htmlspecialchars(trim($_POST['description']));

    $errors = [];
    if (empty($name)) {
        $errors[] = "Company Name is required";
    }
    if(empty($password)){
        $errors[] = "Password is required";
    }
    if(empty($description)){
        $errors[] = "Description is required";
    }
    if (strlen($description) > 100){
        $errors[] = "Description Must be under 100 characters"; 
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Extract the domain from the email
        $domain = substr(strrchr($email, "@"), 1);
    
        // Check if the domain has valid DNS records
        if (checkdnsrr($domain)) {
            
        } else {
            $errors[] = "Invalid domain";
        }
    } else {
        $errors[]= "Invalid email format";
    }
    $stmt = $conn->prepare("SELECT * FROM companies where name = ? and email = ?"); 
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $errors[] = "Company with the same name or email already exists";
    }
    if(empty($errors)){
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO companies (name, email, password, description) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $name, $email, $hashed_password,$description);
        if($stmt->execute()){
            $_SESSION['Flash'] = "Successfully Company registered";
        }
        else{
            $_SESSION['Flash'] = "Failed to register company";
        }
    }

}

require"views/company_sign_up.view.php";