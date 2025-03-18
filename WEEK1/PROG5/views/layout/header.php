<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <h1>Student Management System</h1>
    <nav>
        <ul>
            <?php if (is_logged_in()): ?>
                <li><a href="index.php?page=home">Home</a></li>
                <?php if (has_role('teacher')): ?>
                    <li><a href="index.php?page=student_list">Student List</a></li>
                    <li><a href="index.php?page=create_assignment">Create Assignment</a></li>
                    <li><a href="index.php?page=create_challenge">Create Challenge</a></li>
                <?php endif; ?>
                <li><a href="index.php?page=inbox">Messages</a></li>
                <li><a href="index.php?page=logout">Logout</a></li>
            <?php else: ?>
                <li><a href="index.php?page=login">Login</a></li>
                <li><a href="index.php?page=register">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main>