<?php
session_start(); // Start the session at the beginning of the file

/**
 * Logs in a user.
 *
 * @param string $username The username.
 * @param string $password The password.
 * @param mysqli $conn The database connection.
 * @return bool True on successful login, false otherwise.
 */
function login(string $username, string $password, mysqli $conn): bool
{
    // Sanitize input (basic example - improve this!)
    $username = trim($username);

    // Prepare the SQL statement to prevent SQL injection
    $stmt = mysqli_prepare($conn, "SELECT student_id, username, password, role FROM student WHERE username = ?");
    if (!$stmt) {
        error_log("mysqli_prepare failed: " . mysqli_error($conn));
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $username);  // 's' for string
    if (!mysqli_stmt_execute($stmt)) {
        error_log("mysqli_stmt_execute failed: " . mysqli_stmt_error($stmt));
        return false;
    }

    mysqli_stmt_store_result($stmt);  // Store the result

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $student_id, $db_username, $hashed_password, $role);
        mysqli_stmt_fetch($stmt);

        // Verify the password
        if (md5($password) === $hashed_password) {
            // Authentication successful!
            $_SESSION['loggedin'] = true;
            $_SESSION['student_id'] = $student_id;  // Store the student ID
            $_SESSION['username'] = $db_username;   // Store the username
            $_SESSION['role'] = $role; // Store the role
            mysqli_stmt_close($stmt);
            return true;
        } else {
            // Incorrect password
            mysqli_stmt_close($stmt);
            return false;
        }
    } else {
        // No user found with that username
        mysqli_stmt_close($stmt);
        return false;
    }
}


/**
 * Logs out the current user.
 */
function logout(): void
{
    $_SESSION = array(); // Clear all session variables
    session_destroy();   // Destroy the session
}

/**
 * Checks if a user is logged in.
 *
 * @return bool True if a user is logged in, false otherwise.
 */
function is_logged_in(): bool
{
    return (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true);
}

/**
 * Checks if the current user has a specific role.
 *
 * @param string $role The role to check (e.g., 'student', 'teacher').
 * @return bool True if the user has the specified role, false otherwise.
 */
function has_role(string $role): bool
{
    return (is_logged_in() && isset($_SESSION['role']) && $_SESSION['role'] === $role);
}

/**
 * Redirects to a different page.
 *
 * @param string $url The URL to redirect to.
 */
function redirect(string $url): void
{
    header("Location: " . $url);
    exit; // Ensure that no further code is executed after the redirect
}
?>