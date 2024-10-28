<?php
session_start();
require_once 'db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name= htmlspecialchars(trim($_POST['companyName']));
    $email= htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    $errors = [];

    if(empty($name) || empty($password) || empty($email)){
        $errors[] = "Please fill in all fields";
    }
    if(empty($errors)){
        $stmt = $conn->prepare("SELECT * FROM companies where name = ? and email = ?");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $user = $result->fetch_assoc();
            if(password_verify($password,$user["password"])){
                $_SESSION['companyname'] = $user['name'];
                $_SESSION['company_id']= $user['id'];
                $_SESSION['user_type'] = 'company';

                header('Location: /home');
            }
            else{
                $errors[] = "Invalid password";
            } 
        }
        else{
            $errors[] = "Company not found with specific name or email";
        }

    }

}

require"views/company_login.view.php";