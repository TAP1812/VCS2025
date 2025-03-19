<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
include 'db.php';

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $avatar_url = $_POST['avatar_url'];
    $avatar_file = $_FILES['avatar'];

    // Xử lý avatar
    if (!empty($avatar_url)) {
        // Nếu có URL, sử dụng URL làm avatar
        $avatar_path = $avatar_url;
    } elseif (!empty($avatar_file['name'])) {
        // Nếu upload file
        $target_dir = "uploads/avatars/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($avatar_file['name']);
        move_uploaded_file($avatar_file['tmp_name'], $target_file);
        $avatar_path = $target_file;
    } else {
        // Giữ nguyên avatar cũ nếu không có thay đổi
        $avatar_path = $user['avatar'];
    }

    $stmt = $conn->prepare("UPDATE users SET email = ?, phone = ?, avatar = ? WHERE id = ?");
    $stmt->bind_param("sssi", $email, $phone, $avatar_path, $user['id']);
    $stmt->execute();
    $stmt->close();
    
    // Cập nhật session
    $_SESSION['user'] = $conn->query("SELECT * FROM users WHERE id = {$user['id']}")->fetch_assoc();
    header('Location: profile.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .avatar-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 3px solid #007bff;
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .form-control-static {
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Profile Settings</h3>
                    </div>
                    <div class="card-body">
                        <!-- Hiển thị avatar -->
                        <div class="text-center mb-4">
                            <img src="<?php echo $user['avatar'] ?: 'https://via.placeholder.com/150'; ?>" 
                                 class="avatar-preview" 
                                 alt="Avatar"
                                 id="avatarPreview">
                        </div>

                        <!-- Form cập nhật -->
                        <form method="POST" action="" enctype="multipart/form-data">
                            <!-- Full Name và Role -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <div class="form-control-static"><?php echo $user['fullname']; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <div class="form-control-static"><?php echo ucfirst($user['role']); ?></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Email và Phone -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" 
                                               value="<?php echo $user['email']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="phone" 
                                               value="<?php echo $user['phone']; ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Avatar URL và Upload -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="avatar_url" class="form-label">Avatar URL</label>
                                        <input type="url" class="form-control" name="avatar_url" 
                                               placeholder="Enter image URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="avatar" class="form-label">Or upload avatar</label>
                                        <input type="file" class="form-control" name="avatar" 
                                               accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <!-- Nút cập nhật -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Preview avatar khi nhập URL -->
    <script>
        document.querySelector('[name="avatar_url"]').addEventListener('input', function(e) {
            document.getElementById('avatarPreview').src = e.target.value || 'https://via.placeholder.com/150';
        });
    </script>
</body>
</html>
