<?php
    $host = 'sql105.infinityfree.com'; 
    $db = 'if0_38630209_student_management';
    $user = 'if0_38630209';
    $pass = 'dzl8hBmONu';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
