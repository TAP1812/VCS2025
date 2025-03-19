<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
include 'db.php';

$message_id = $_GET['id'];

// Lấy thông tin tin nhắn để chuyển hướng sau khi xóa
$stmt = $conn->prepare("SELECT receiver_id FROM messages WHERE id = ?");
$stmt->bind_param("i", $message_id);
$stmt->execute();
$result = $stmt->get_result();
$message = $result->fetch_assoc();
$stmt->close();

// Xóa tin nhắn
$stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
$stmt->bind_param("i", $message_id);
$stmt->execute();
$stmt->close();

header("Location: student_detail.php?id={$message['receiver_id']}");
?>