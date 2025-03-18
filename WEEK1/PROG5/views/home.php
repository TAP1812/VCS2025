<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System - Home</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .home-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 80%; /* Adjust as needed */
            max-width: 800px;
            text-align: center;
        }

        h2.home-title {
            color: #333;
            margin-bottom: 20px;
            font-size: 2.5em; /* Larger title */
            letter-spacing: 1px;
        }

        /* Logged-In Message Styles */
        .logged-in-message {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .logged-in-message p {
            margin-bottom: 10px;
            font-size: 1.1em;
            color: #555;
        }

        .username {
            font-weight: bold;
            color: #007bff; /* Primary color */
        }

        .role {
            font-style: italic;
            color: #6c757d; /* Secondary color */
        }

        /* Button Styles */
        .button {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            text-decoration: none;
            border-radius: 5px;
            color: #fff;
            background-color: #007bff; /* Primary color */
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1.1em;
        }

        .button:hover {
            background-color: #0056b3; /* Darker shade */
        }

        .button.primary {
            background-color: #28a745; /* Success color */
        }

        .button.primary:hover {
            background-color: #1e7e34;
        }

        .button.secondary {
            background-color: #dc3545; /* Danger color */
        }

        .button.secondary:hover {
            background-color: #bb2d3b;
        }


        /* Teacher Actions */
        .teacher-actions {
            margin-top: 20px;
        }

        /* Student Actions */
        .student-actions {
            margin-top: 20px;
        }


        /* Login/Register Prompt Styles */
        .login-register-prompt {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .login-register-prompt p {
            margin-bottom: 15px;
            font-size: 1.2em;
            color: #555;
        }

        .auth-buttons {
            display: flex;
            justify-content: center;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .home-container {
                width: 95%;
                padding: 20px;
            }

            h2.home-title {
                font-size: 2em;
            }

            .button {
                padding: 10px 20px;
                font-size: 1em;
                margin: 5px;
            }

            .auth-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<div class="home-container">
    <h2 class="home-title">Welcome to the Student Management System!</h2>

    <?php if (is_logged_in()): ?>
        <div class="logged-in-message">
            <p>You are logged in as <span class="username"></span> (<span class="role">student</span>).</p>
            <p>Check out the available assignments and messages!</p>

            <?php if (has_role('teacher')): ?>
                <div class="teacher-actions">
                    <a href="index.php?page=create_assignment" class="button">Create Assignment</a>
                    <a href="index.php?page=create_challenge" class="button">Create Challenge</a>
                    <a href="index.php?page=student_list" class="button">Manage Students</a>
                </div>
            <?php endif; ?>

            <div class="student-actions">
                <a href="index.php?page=inbox" class="button">View Messages</a>
                <a href="index.php?page=assignments" class="button">View Assignments</a>

            </div>
        </div>
    <?php else: ?>
        <div class="login-register-prompt">
            <p>Please log in or register to access the system:</p>
            <div class="auth-buttons">
                <a href="index.php?page=login" class="button primary">Login</a>
                <a href="index.php?page=register" class="button secondary">Register</a>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>