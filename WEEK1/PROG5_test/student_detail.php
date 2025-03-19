<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
include 'db.php';

$user = $_SESSION['user'];
$student_id = $_GET['id'];

// Lấy thông tin chi tiết của sinh viên
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Xử lý cập nhật thông tin sinh viên nếu là teacher
if ($user['role'] == 'teacher' && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_student'])) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, fullname = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $username, $fullname, $email, $phone, $student_id);
    $stmt->execute();
    $stmt->close();

    // Cập nhật lại thông tin student sau khi sửa
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Xử lý gửi tin nhắn
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user['id'], $student_id, $message);
    $stmt->execute();
    $stmt->close();
}

// Lấy danh sách tin nhắn đã gửi
$messages = $conn->query("SELECT * FROM messages WHERE sender_id = {$user['id']} AND receiver_id = $student_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Detail</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Student Detail: <?php echo $student['fullname']; ?></h1>

                <!-- Thông tin chi tiết của sinh viên -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Student Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <!-- Hiển thị avatar -->
                                <img src="<?php echo $student['avatar'] ? $student['avatar'] : 'default-avatar.png'; ?>" 
                                     alt="Avatar" class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                            </div>
                            <div class="col-md-8">
                                <?php if ($user['role'] == 'teacher') { ?>
                                    <!-- Form chỉnh sửa thông tin cho teacher -->
                                    <form method="POST" action="">
                                        <div class="mb-3">
                                            <label for="username" class="form-label"><strong>Username:</strong></label>
                                            <input type="text" class="form-control" name="username" value="<?php echo $student['username']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fullname" class="form-label"><strong>Fullname:</strong></label>
                                            <input type="text" class="form-control" name="fullname" value="<?php echo $student['fullname']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label"><strong>Email:</strong></label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $student['email']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label"><strong>Phone:</strong></label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo $student['phone']; ?>" required>
                                        </div>
                                        <button type="submit" name="update_student" class="btn btn-success">Save Changes</button>
                                    </form>
                                <?php } else { ?>
                                    <!-- Hiển thị thông tin tĩnh cho người dùng không phải teacher -->
                                    <div class="mb-3">
                                        <label for="username" class="form-label"><strong>Username:</strong></label>
                                        <p class="form-control-static"><?php echo $student['username']; ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label"><strong>Fullname:</strong></label>
                                        <p class="form-control-static"><?php echo $student['fullname']; ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label"><strong>Email:</strong></label>
                                        <p class="form-control-static"><?php echo $student['email']; ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label"><strong>Phone:</strong></label>
                                        <p class="form-control-static"><?php echo $student['phone']; ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form gửi tin nhắn -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Send Message</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" placeholder="Enter your message" required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Danh sách tin nhắn đã gửi -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Messages Sent</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Message</th>
                                    <th>Sent At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $messages->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['message']}</td>
                                            <td>{$row['created_at']}</td>
                                            <td>
                                                <a href='edit_message.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                                <a href='delete_message.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                                            </td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
