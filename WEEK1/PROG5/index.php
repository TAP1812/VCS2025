<?php
session_start();

// Include configuration and functions
include 'config.php';
include 'functions.php';
include 'auth.php';

// Get the requested page from the URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Default to 'home'

// --- Routing Logic ---
switch ($page) {
    case 'home':
        include 'views/home.php';
        break;

    case 'login':
        // Check if the form has been submitted (POST request)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve username and password from the form
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            // Sanitize the username and password (important!)
            $username = sanitize_input($username);

            // Call the login function
            if (login($username, $password, $conn)) {
                // Login successful! Redirect to the home page
                redirect("index.php?page=home");
            } else {
                // Login failed
                $error_message = "Invalid username or password."; // Set error message
                include 'views/student/login.php'; // Include the login view
            }
        } else {
            // If it's not a POST request (e.g., initial page load), just show the login form
            include 'views/student/login.php'; // Include the login view
        }
        break;

    case 'logout':
        logout();
        redirect("index.php?page=login"); // Redirect after logout
        break;

    case 'register':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve registration data from the form
            $username   = isset($_POST['username']) ? $_POST['username'] : '';
            $password   = isset($_POST['password']) ? $_POST['password'] : '';
            $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
            $last_name  = isset($_POST['last_name']) ? $_POST['last_name'] : '';
            $email      = isset($_POST['email']) ? $_POST['email'] : '';
            $role = "student"; //Force role student

            // Sanitize the input data
            $username   = sanitize_input($username);
            $first_name = sanitize_input($first_name);
            $last_name  = sanitize_input($last_name);
            $email      = sanitize_input($email);

            // Validate the data (add more validation as needed)
            if (empty($username) || empty($password) || empty($first_name) || empty($last_name)) {
                $error_message = "All fields are required.";
                include 'views/student/register.php';
                break;
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            include 'student_functions.php';

            if (create_student($conn, $username, $hashed_password, $first_name, $last_name, $email, $role)) {
                // Registration successful - redirect
                redirect("index.php?page=login");
            } else {
                $error_message = "Registration failed. Username may already exist.";
                include 'views/student/register.php';
            }


        } else {
            // Display the registration form
            include 'views/student/register.php';
        }
        break;

    case 'student_list':
        // Example of requiring login for a page
        if (!is_logged_in() || !has_role('teacher')) {
            display_error("You must be logged in as a teacher to view this page.");
            include 'views/student/login.php'; // Or redirect
            break;  // Important: Stop further execution
        }

        include 'student_functions.php';
        $students = get_all_students($conn); // Example function (implement in student_functions.php)
        include 'views/student/list.php';
        break;

    // Add more cases for other pages (assignments, messages, etc.)

    default:
        // Handle invalid pages (e.g., 404 error)
        echo "Page not found.";
        break;
}

// Close the database connection (important to free up resources)
mysqli_close($conn);
?>