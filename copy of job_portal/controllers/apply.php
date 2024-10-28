<?php

session_start();
require "db.php";   

$error = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id']) && $_SESSION['user_type'] == 'employee') {
    $job_id = intval($_POST['job_id']);
    
    // Set the job ID in the session or pass it to the upload page
    $_SESSION['job_id'] = $job_id;
}

$user_id = $_SESSION['user_id'];
$job_id = $_SESSION['job_id'];

// Check if the user has already applied for this job
$stmt = $conn->prepare("SELECT * FROM applications WHERE job_id = ? AND user_id = ?");
$stmt->bind_param("ii", $job_id, $user_id);
$stmt->execute();
$existing_application = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['user_type'] == 'employee')  {
    if ($existing_application) {
     // If an existing application is found, show an error message
        $errors[] = "You have already submitted your resume for this job.";
        }
     else {
        if (isset($_FILES['cv'])) {
            if ($_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                // No errors, process the upload
                $file = $_FILES['cv'];
                $upload_dir = 'uploads/';
                $file_path = $upload_dir . basename($file['name']);
                
                // Check if the uploaded file is a PDF
                $file_type = pathinfo($file_path, PATHINFO_EXTENSION);
                if (strtolower($file_type) !== 'pdf') {
                    $errors[] = "The uploaded file must be a PDF.";
                } else {
                    // Move the uploaded file to the uploads directory
                    if (move_uploaded_file($file['tmp_name'], $file_path)) {
                        $_SESSION['Flash'] = "Resume uploaded successfully";
                        $stmt = $conn->prepare("INSERT INTO applications (job_id, user_id, resume_path, status) VALUES (?, ?, ?, 'pending')");
                        $stmt->bind_param("iis", $job_id, $user_id, $file_path);
                        $stmt->execute();
                    } else {
                        $errors[] = "Failed to move uploaded file";
                    }
                }
            } else {
                // Display an error message if there was an issue
                $errors[] = "Errors uploading file";
            }
        } else {
            
        }
    }
} else {
    $errors[] = "Form not submitted";
}

// Render the view (with any errors if they exist)
require "views/apply.view.php";
