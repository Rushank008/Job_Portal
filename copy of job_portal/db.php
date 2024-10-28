<?php 
    $host = 'localhost';
    $db = 'Job_portal';         // Database name
    $user = 'root';            // MySQL user 
    $password = 'Mush3kah6eeng9so';  // MySQL password for root user

    $conn = new mysqli($host, $user, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
