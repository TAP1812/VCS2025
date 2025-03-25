<?php
session_start();

// Kiểm tra session
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Kiểm tra nếu có tham số file
if (!isset($_GET['file']) || empty($_GET['file'])) {
    http_response_code(400); // Bad Request
    exit('No file specified');
}

$file_path = __DIR__  . '/' . $_GET['file'];
$real_path = realpath($file_path);
echo realpath($file_path) . PHP_EOL;
if ($real_path === false || $real_path !== $file_path) {
    http_response_code(403);
    exit('Invalid file path');
}

// Đặt headers để tải file
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $file_name . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file_path));

// Ngăn chặn XSS qua header
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

// Đọc và gửi file
readfile($file_path);
exit;
?>
