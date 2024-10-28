<?php
session_start();
require "db.php";

$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $email = htmlspecialchars(trim($_POST['email']));

    if(empty($username) || empty($password) || empty($email)){
        $errors[] = "Please fill in all fields";
    }
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT * from users where username = ? and email = ?");
        $stmt->bind_param("ss",$username,$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if(password_verify($password,$user["password"])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = 'employee';
                
                header('Location: /home');
            }
            else{
                $errors [] = "please check Your password";
            }
        }
        else{
            $errors[] = "No user exists with this particular Username or Email";
        }
    }
}


require "views/login.view.php";