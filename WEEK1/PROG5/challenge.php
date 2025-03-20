<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
include 'db.php';
include 'utils.php';
$user = $_SESSION['user'];

// Giáo viên tạo challenge
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user['role'] == 'teacher' && isset($_FILES['file'])) {
    $hint = $_POST['hint'];
    $file = $_FILES['file'];

    // Kiểm tra file có phải là .txt không
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($file_ext != 'txt') {
        die("Only .txt files are allowed.");
    }

    // Lưu file vào thư mục uploads/challenges/
    $target_dir = __DIR__ . "/uploads/challenges/";
    $target_file = $target_dir . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $target_file);

    // Lưu thông tin challenge vào database
    $stmt = $conn->prepare("INSERT INTO challenges (hint, file_path) VALUES (?, ?)");
    $stmt->bind_param("ss", $hint, $target_file);
    $stmt->execute();
    $stmt->close();
}

// Sinh viên tham gia giải đố
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer'])) {
    $challenge_id = $_POST['challenge_id'];
    $answer = $_POST['answer'];

    // Lấy thông tin challenge
    $stmt = $conn->prepare("SELECT * FROM challenges WHERE id = ?");
    $stmt->bind_param("i", $challenge_id);
    $stmt->execute();
    $challenge = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Kiểm tra đáp án
    $file_content = file_get_contents($challenge['file_path']);
    if (strtolower($answer) == strtolower($file_content)) {
        $success_message = "Correct! Here is the content:<br><pre>{$file_content}</pre>";
        $stmt = $conn->prepare("
            INSERT INTO challenge_status (student_id, challenge_id, status, solved_at)
            VALUES (?, ?, 'solved', NOW())
            ON DUPLICATE KEY UPDATE status = 'solved', solved_at = NOW()
        ");
        $stmt->bind_param("ii", $user['id'], $challenge_id);
        $stmt->execute();
        $stmt->close();
    } else {
        $error_message = "Incorrect answer. Please try again.";
        $stmt = $conn->prepare("
            INSERT INTO challenge_status (student_id, challenge_id, status, solved_at)
            VALUES (?, ?, 'not solved', NULL)
            ON DUPLICATE KEY UPDATE status = 'not solved', solved_at = NULL
        ");
        $stmt->bind_param("ii", $user['id'], $challenge_id);
        $stmt->execute();
        $stmt->close();
        
    }
}

// Lấy danh sách challenge
$challenges = $conn->query("SELECT * FROM challenges ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenges</title>
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
                <h1 class="mb-4">Challenges</h1>

                <?php if ($user['role'] == 'teacher'): ?>
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Create Challenge</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="hint" class="form-label">Hint</label>
                                    <textarea class="form-control" id="hint" name="hint" placeholder="Enter hint" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label">Upload .txt file</label>
                                    <input type="file" class="form-control" id="file" name="file" accept=".txt" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Create Challenge</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Danh sách challenge -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Challenges List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Hint</th>
                                    <th>Action</th>
                                    <th>State</th> <!-- Thêm cột State -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Lấy ID của học sinh hiện tại
                                $student_id = $_SESSION['user']['id'];

                                while ($row = $challenges->fetch_assoc()) {
                                    // Lấy trạng thái của challenge đối với học sinh hiện tại
                                    $stmt = $conn->prepare("SELECT status FROM challenge_status WHERE student_id = ? AND challenge_id = ?");
                                    $stmt->bind_param("ii", $student_id, $row['id']);
                                    $stmt->execute();
                                    $status_result = $stmt->get_result();
                                    $status = $status_result->fetch_assoc();
                                    $stmt->close();

                                    // Hiển thị trạng thái (solved hoặc not solved)
                                    $state = $status ? $status['status'] : 'not solved';

                                    echo "<tr>
                                            <td>{$row['hint']}</td>
                                            <td>
                                                <button class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#challengeModal{$row['id']}'>Solve</button>
                                            </td>
                                            <td>
                                                <button class='btn btn-sm " . ($state == 'solved' ? 'btn-success' : 'btn-secondary') . "' disabled>
                                                    {$state}
                                                </button>
                                            </td>
                                        </tr>";

                                    // Modal để học sinh giải đố
                                    echo "
                                    <div class='modal fade' id='challengeModal{$row['id']}' tabindex='-1'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title'>Solve Challenge</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    <form method='POST' action='/challenge.php'>
                                                        <input type='hidden' name='challenge_id' value='{$row['id']}'>
                                                        <div class='mb-3'>
                                                            <label for='answer' class='form-label'>Enter your answer</label>
                                                            <input type='text' class='form-control' id='answer' name='answer' required>
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
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Hiển thị kết quả giải đố -->
                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success mt-4">
                        <?php echo $success_message; ?>
                    </div>
                <?php elseif (isset($error_message)): ?>
                    <div class="alert alert-danger mt-4">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
