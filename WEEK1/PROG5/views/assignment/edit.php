<h2>Edit Student</h2>

<?php if (isset($error_message)): ?>
    <div class="error"><?php echo sanitize_input($error_message); ?></div>
<?php endif; ?>

<?php if (isset($student)): ?>
    <form action="index.php?page=student_edit&id=<?php echo (int)$student['student_id']; ?>" method="post">
        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" value="<?php echo escape_html_attr($student['first_name']); ?>" required><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" value="<?php echo escape_html_attr($student['last_name']); ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo escape_html_attr($student['email']); ?>"><br><br>

        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo escape_html_attr($student['phone']); ?>"><br><br>

        <button type="submit">Update</button>
    </form>
<?php else: ?>
    <p>Student not found.</p>
<?php endif; ?>