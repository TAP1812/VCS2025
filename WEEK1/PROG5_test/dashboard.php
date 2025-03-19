<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
include 'db.php';

$user = $_SESSION['user'];

// Lấy danh sách tin nhắn nhận được
$received_messages = $conn->query("
    SELECT m.*, u.fullname as sender_name 
    FROM messages m 
    JOIN users u ON m.sender_id = u.id 
    WHERE m.receiver_id = {$user['id']} 
    ORDER BY m.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Welcome, <?php echo $user['fullname']; ?></h1>

                <!-- Students List -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Students List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $conn->query("SELECT * FROM users WHERE role = 'student'");
                                while ($row = $result->fetch_assoc()) {
                                    if ($row['id'] != $user['id']) {
                                        echo "<tr>
                                                <td>{$row['username']}</td>
                                                <td>{$row['fullname']}</td>
                                                <td>{$row['email']}</td>
                                                <td>{$row['phone']}</td>
                                                <td>
                                                    <a href='student_detail.php?id={$row['id']}' class='btn btn-primary btn-sm'>View</a>
                                                </td>
                                            </tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if ($user['role'] == 'student'): ?>
                <!-- Received Messages -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Received Messages</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>From</th>
                                    <th>Message</th>
                                    <th>Sent At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $received_messages->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['sender_name']}</td>
                                            <td>{$row['message']}</td>
                                            <td>{$row['created_at']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>