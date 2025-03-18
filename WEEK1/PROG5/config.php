<?php
    // Database credentials (use the MySQL service name from docker-compose)
    $host     = "db";  // Use the service name "db" instead of "localhost" in Docker
    $username = "student_user";  
    $password = "student_pass";  
    $database = "student_management";  

    // Attempt to connect to the database
    $conn = mysqli_connect($host, $username, $password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Set character set (recommended for UTF-8 support)
    mysqli_set_charset($conn, "utf8");
?>
