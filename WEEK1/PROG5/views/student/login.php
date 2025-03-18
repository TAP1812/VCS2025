<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css"> <!-- Link to the login-specific CSS -->
</head>
<body>
<div class="login-container">
    <h2 class="login-title">Login</h2>

    <?php if (isset($error_message)): ?>
        <div class="error-message">
            <?php echo sanitize_input($error_message); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=login" method="post" class="login-form">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>