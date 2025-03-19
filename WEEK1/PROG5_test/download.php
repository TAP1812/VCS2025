<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
// Kiểm tra nếu có tham số file
if (isset($_GET['file'])) {
    $file_path = $_GET['file'];
    
    // Đặt header để tải file
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
    exit;
}
?>
