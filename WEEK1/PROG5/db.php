<?php
    $host = 'localhost'; 
    $db = 'student_management';
    $user = 'root';
    $pass = 'kalilinux';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
