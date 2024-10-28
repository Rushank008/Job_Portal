<?php
session_start();

require "db.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $email = htmlspecialchars(trim($_POST['email']));

    $errors = [];
    if (empty($username)) {
        $errors[] = "Username must not be empty";
    }
    if (empty($password)) {
        $errors[] = "Password must not be empty";
    }
    if(strlen($username) < 3){
        $errors[] = "Username must be at least 3 characters long";
    }
    if(strlen($password) < 5){
        $errors[] = "Password must be at least 5 characters long";
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
    
    $stmt = $conn->prepare("SELECT * from users where username = ? or email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        $errors[] = 'Username or email already exists';
    }

    if(empty($errors)){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        if($stmt->execute()){
            $_SESSION['Flash'] = "User successfully registered";
        }
        else{
            $_SESSION['Flash'] = "Error registering user";
        }
    }
}
require "views/sign_up.view.php";