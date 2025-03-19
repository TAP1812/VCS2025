<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
include 'db.php';

$user = $_SESSION['user'];

// Giáo viên tải file bài tập lên
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user['role'] == 'teacher') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file = $_FILES['file'];

    $target_dir = "uploads/assignments/";
    $target_file = $target_dir . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $target_file);

    $stmt = $conn->prepare("INSERT INTO assignments (title, description, file_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $target_file);
    $stmt->execute();
    $stmt->close();
}

// Học sinh upload bài làm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user['role'] == 'student') {
    $assignment_id = $_POST['assignment_id'];
    $file = $_FILES['submission'];

    $target_dir = "uploads/submissions/";
    $target_file = $target_dir . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $target_file);

    $stmt = $conn->prepare("INSERT INTO submissions (assignment_id, student_id, file_path) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $assignment_id, $user['id'], $target_file);
    $stmt->execute();
    $stmt->close();
}

// Lấy danh sách bài tập
$assignments = $conn->query("SELECT * FROM assignments ORDER BY created_at DESC");

// Lấy danh sách bài làm (chỉ giáo viên mới được xem)
$submissions = [];
if ($user['role'] == 'teacher') {
    $submissions = $conn->query("
        SELECT s.*, u.fullname as student_name, a.title as assignment_title 
        FROM submissions s 
        JOIN users u ON s.student_id = u.id 
        JOIN assignments a ON s.assignment_id = a.id 
        ORDER BY s.submitted_at DESC
    ");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Student Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assignment.php">Assignments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="challenge.php">Challenges</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Assignments</h1>

                <!-- Giáo viên tạo bài tập -->
                <?php if ($user['role'] == 'teacher'): ?>
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Create Assignment</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter description" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label">File</label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Upload Assignment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Danh sách bài tập -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Assignments List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>File</th>
                                    <?php if ($user['role'] == 'student'): ?>
                                        <th>Action</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $assignments->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['title']}</td>
                                            <td>{$row['description']}</td>
                                            <td><a href='/download.php?file={$row['file_path']}' class='btn btn-primary btn-sm'>Download</a></td>";
                                    if ($user['role'] == 'student') {
                                        echo "<td>
                                                <button class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#submitModal{$row['id']}'>Submit</button>
                                              </td>";
                                    }
                                    echo "</tr>";

                                    // Modal để học sinh upload bài làm
                                    if ($user['role'] == 'student') {
                                        echo "
                                        <div class='modal fade' id='submitModal{$row['id']}' tabindex='-1'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title'>Submit Assignment: {$row['title']}</h5>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <form method='POST' action='' enctype='multipart/form-data'>
                                                            <input type='hidden' name='assignment_id' value='{$row['id']}'>
                                                            <div class='mb-3'>
                                                                <label for='submission' class='form-label'>Upload your file</label>
                                                                <input type='file' class='form-control' id='submission' name='submission' required>
                                                            </div>
                                                            <div class='d-grid'>
                                                                <button type='submit' class='btn btn-primary'>Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Danh sách bài làm (chỉ giáo viên mới được xem) -->
                <?php if ($user['role'] == 'teacher'): ?>
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Submissions List</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Assignment</th>
                                        <th>Student</th>
                                        <th>File</th>
                                        <th>Submitted At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $submissions->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['assignment_title']}</td>
                                                <td>{$row['student_name']}</td>
                                                <td><a href='/download.php?file={$row['file_path']}' class='btn btn-primary btn-sm'>Download</a></td>
                                                <td>{$row['submitted_at']}</td>
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