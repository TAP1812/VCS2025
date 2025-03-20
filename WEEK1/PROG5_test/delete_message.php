<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
include 'db.php';

$message_id = $_GET['id'];
$user_id = $_SESSION['user']['id']; // Lấy ID của người dùng hiện tại

// Lấy thông tin tin nhắn để kiểm tra quyền và chuyển hướng sau khi xóa
$stmt = $conn->prepare("SELECT sender_id, receiver_id FROM messages WHERE id = ?");
$stmt->bind_param("i", $message_id);
$stmt->execute();
$result = $stmt->get_result();
$message = $result->fetch_assoc();
$stmt->close();

// Kiểm tra xem người dùng hiện tại có phải là người gửi tin nhắn không
if ($message && $message['sender_id'] == $user_id) {
    // Nếu đúng, xóa tin nhắn
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $message_id);
    $stmt->execute();
    $stmt->close();

    // Chuyển hướng về trang chi tiết của người nhận
    header("Location: student_detail.php?id={$message['receiver_id']}");
} else {
    // Nếu không có quyền, hiển thị thông báo lỗi hoặc chuyển hướng
    die("You do not have permission to delete this message.");
}
?>
