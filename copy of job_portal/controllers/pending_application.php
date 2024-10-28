<?php
session_start();
require "db.php";
require "vendor/autoload.php"; // Include the Composer autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SESSION['user_type'] != 'company') {
    $_SESSION['Flash'] = "Please login to access this page";
    header("Location: /login");
}

$company_id = $_SESSION['company_id']; 

// Fetch pending applications
$stmt = $conn->prepare("
    SELECT 
        applications.id AS application_id, 
        jobs.title AS job_title, 
        jobs.company_id,  -- Get company ID from jobs table
        users.username AS applicant_username, 
        users.email AS applicant_email,  
        applications.resume_path, 
        applications.status 
    FROM 
        applications 
    JOIN jobs ON applications.job_id = jobs.id 
    JOIN users ON applications.user_id = users.id 
    WHERE jobs.company_id = ? 
    AND applications.status = 'pending'
");

$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();
$pending_applications = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Logic for accepting or rejecting application
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'], $_POST['action'])) {
    $application_id = intval($_POST['application_id']);
    $action = $_POST['action']; // 'accept' or 'reject'

    // Validating the action
    if ($action === 'accept' || $action === 'reject') {
        
        $status = $action === 'accept' ? 'accepted' : 'rejected';

        // Update the application status
        $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $application_id);

        if ($stmt->execute()) {
            // Fetch the applicant's email, job title, and company name to send notification
            $stmt = $conn->prepare("
                SELECT 
                    users.email, 
                    jobs.title AS job_title, 
                    companies.name AS company_name 
                FROM 
                    applications 
                JOIN users ON applications.user_id = users.id 
                JOIN jobs ON applications.job_id = jobs.id 
                JOIN companies ON jobs.company_id = companies.id
                WHERE applications.id = ?
            ");
            $stmt->bind_param("i", $application_id);
            $stmt->execute();
            $stmt->bind_result($applicant_email, $job_title, $company_name);
            $stmt->fetch();
            $stmt->close();

            // Send email notification
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP(); // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = 'your_username'; // SMTP username
                $mail->Password = 'your_pass'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587; // TCP port to connect to

                //Recipients
                $mail->setFrom('your_email@example.com', $company_name); // Set company as the sender
                $mail->addAddress($applicant_email); // Add a recipient

                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Application Status Update';
                $mail->Body    = "Your application for the job role <strong>{$job_title}</strong> at <strong>{$company_name}</strong> has been <strong>{$status}</strong>.";
                $mail->AltBody = "Your application for the job role {$job_title} at {$company_name} has been {$status}.";

                $mail->send();
            } catch (Exception $e) {
                $_SESSION['Flash'] = "Application $status successfully, but failed to send email. Mailer Error: {$mail->ErrorInfo}";
            }

            // Redirect back to the applications page
            $_SESSION['Flash'] = "Application $status successfully.";
            header("Location: /pending_application"); // Redirect to the pending applications page
            exit;
        } else {
            $_SESSION['Flash'] = "An error occurred";
        }
    }
}

require "views/pending_application.view.php"; 
