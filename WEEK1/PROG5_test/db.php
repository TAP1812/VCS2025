<?php
    $host = 'db'; 
    $db = 'student_management';
    $user = 'user';
    $pass = 'password';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>