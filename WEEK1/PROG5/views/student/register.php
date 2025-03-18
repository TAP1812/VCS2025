<h2>Register</h2>

<?php if (isset($error_message)): ?>
    <div class="error"><?php echo sanitize_input($error_message); ?></div>
<?php endif; ?>

<form action="index.php?page=register" method="post">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <label for="first_name">First Name:</label><br>
    <input type="text" id="first_name" name="first_name" required><br><br>

    <label for="last_name">Last Name:</label><br>
    <input type="text" id="last_name" name="last_name" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email"><br><br>

    <button type="submit">Register</button>
</form>